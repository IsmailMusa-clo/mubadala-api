<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Offer;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offers = Offer::with('user', 'product')->get();
        return response()->json([
            'status' => true,
            'offers' => $offers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'description' => 'required|string|min:3',
            'location' => 'required|string|min:3',
            'product_id' => 'required|integer|exists:products,id',
        ]);
        if (!$validator->fails()) {
            $user = $request->user();
            $offer = $user->offers()->create([
                'description' => $request->input('description'),
                'location' => $request->input('location'),
                'product_id' => $request->input('product_id'),
            ]);
            return response()->json([
                'status' => $offer ? true : false,
                'message' => $offer ? 'تم انشاء العرض بنجاح' : 'فشل انشاء العرض',
                'offer' => $offer->load(['product', 'user']),
            ], $offer ? 201 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Offer $offer)
    {
        //
        $validator = Validator($request->all(), [
            'description' => 'required|string|min:3',
            'location' => 'required|string|min:3',
        ]);
        if (!$validator->fails()) {
            $user = auth()->user();
            if ($user->id === $offer->user_id) {
                $offer->description = $request->input('description');
                $offer->location = $request->input('location');
                $isUpdated = $offer->update();
                return response()->json([
                    'status' => $isUpdated,
                    'message' => $isUpdated ? 'تم تعديل العرض بنجاح' : 'فشل تعديل العرض',
                    'offer' => $offer->load(['user', 'product']),
                ], $isUpdated ? 200 : 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'عذرا غير مصرح لك بتعديل العرض لانك لست مالكه'
                ], 401);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Offer $offer)
    {
        //
        $user = $request->user();
        if ($user->id === $offer->user_id) {
            $isDeleted = $offer->delete();
            return response()->json([
                'status' => $isDeleted,
                'message' => $isDeleted ? 'تم حذف العرض بنجاح' : 'فشل حذف العرض'
            ], $isDeleted ? 200 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عذرا غير مصرح لك بحذف العرض لانك لست مالكه'
            ], 401);
        }
    }

    public function myOffers()
    {
        $user = auth()->user();
        $offers = $user->offers()->with('user', 'product')->latest()->get();
        return response()->json([
            'status' => true,
            'offers' => $offers
        ], 200);
    }

    public function acceptOffer(Offer $offer)
    {
        $user = auth()->user();
        $product = $offer->product;
        if ($user->id === $product->user_id) {
            if ($offer->status !== 'accepted') {
                $offer->status = 'accepted';
                $isSavedOffer = $offer->save();
                $product->status = 'reserved';
                $isSavedProduct = $product->save();

                $rejectedOffersCount = Offer::where('product_id', $product->id)
                    ->where('id', '!=', $offer->id)
                    ->update(['status' => 'rejected']);

                if ($isSavedOffer && $isSavedProduct) {
                    $exchange = new Exchange();
                    $exchange->product_id = $offer->product_id;
                    $exchange->offer_id = $offer->id;
                    $exchange->save();
                }

                return response()->json([
                    'status' => $isSavedOffer && $isSavedProduct,
                    'message' => $isSavedOffer && $isSavedProduct ? 'تم قبول العرض و حجز المنتج بنجاح' : 'فشل قبول العرض',
                    'offer' => $offer->load('product.user')
                ], $isSavedOffer && $isSavedProduct ? 200 : 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'عذرا لقد تم قبول العرض و حجز المنتج من قبل'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عذرا غير مصرح لك بقبول العرض لانك لست مالك للمنتج'
            ], 400);
        }
    }
}
