<?php

namespace App\Http\Controllers\Api;

use App\Events\AcceptOffer;
use App\Events\AddOffer;
use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Offer;
use App\Models\OfferImage;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offers = Offer::with('user', 'product')->get();
        $offers = $offers->map(function ($offer) {
            return [
                'id' => $offer->id,
                'product_id' => $offer->product_id,
                'itemOfferedDescription' => $offer->description,
                'itemOfferedLocation' => $offer->location,
                'itemOfferedImageUrls' => $offer->images()->pluck('path')->toArray(),
                'status' => $offer->status,
                'createdAt' => $offer->created_at,
                'user' => $offer->user,
            ];
        });
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        if (!$validator->fails()) {
            $user = $request->user();
            $offer = $user->offers()->create([
                'description' => $request->input('description'),
                'location' => $request->input('location'),
                'product_id' => $request->input('product_id'),
            ]);
            if ($request->file('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store("offer_images/{$offer->id}", 'public');
                    $offerImage = new offerImage();
                    $offerImage->offer_id = $offer->id;
                    $offerImage->path = $path;
                    $offerImage->save();
                    // $imagePaths[] = url('storage/' . $path);
                }
            }
            broadcast(new AddOffer($offer))->toOthers();
            $offer->load(['product', 'user', 'images']);
            $offerData = [
                'id' => $offer->id,
                'product_id' => $offer->product_id,
                'itemOfferedDescription' => $offer->description,
                'itemOfferedLocation' => $offer->location,
                'itemOfferedImageUrls' => $offer->images()->pluck('path')->toArray(),
                'status' => $offer->status,
                'createdAt' => $offer->created_at,
                'user' => $offer->user,
            ];
            return response()->json([
                'status' => $offer ? true : false,
                'message' => $offer ? 'تم انشاء العرض بنجاح' : 'فشل انشاء العرض',
                'offer' => [$offerData],
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
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        if (!$validator->fails()) {
            $user = auth()->user();
            if ($user->id === $offer->user_id) {
                $offer->description = $request->input('description');
                $offer->location = $request->input('location');
                $isUpdated = $offer->update();
                if ($request->hasFile('images')) {
                    foreach ($offer->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage->path)) {
                            Storage::disk('public')->delete($oldImage->path);
                        }
                        $oldImage->delete();
                    }
                    foreach ($request->file('images') as $imageFile) {
                        $path = $imageFile->store("offer_images/{$offer->id}", 'public');
                        $offerImage = new OfferImage();
                        $offerImage->offer_id = $offer->id;
                        $offerImage->path = $path;
                        $offerImage->save();
                    }
                }
                $offer->load(['user', 'product', 'images']);
                $offerData = [
                    'id' => $offer->id,
                    'product_id' => $offer->product_id,
                    'itemOfferedDescription' => $offer->description,
                    'itemOfferedLocation' => $offer->location,
                    'itemOfferedImageUrls' => $offer->images()->pluck('path')->toArray(),
                    'status' => $offer->status,
                    'createdAt' => $offer->created_at,
                    'user' => $offer->user,
                ];
                return response()->json([
                    'status' => $isUpdated,
                    'message' => $isUpdated ? 'تم تعديل العرض بنجاح' : 'فشل تعديل العرض',
                    'offer' => [$offerData],
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
            if ($offer->images) {
                foreach ($offer->images as $image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }
                    $image->delete();
                }
            }
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
        $offers = $offers->map(function ($offer) {
            return [
                'id' => $offer->id,
                'product_id' => $offer->product_id,
                'itemOfferedDescription' => $offer->description,
                'itemOfferedLocation' => $offer->location,
                'itemOfferedImageUrls' => $offer->images()->pluck('path')->toArray(),
                'status' => $offer->status,
                'createdAt' => $offer->created_at,
                'user' => $offer->user,
            ];
        });
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
                    broadcast(new AcceptOffer($offer))->toOthers();
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
