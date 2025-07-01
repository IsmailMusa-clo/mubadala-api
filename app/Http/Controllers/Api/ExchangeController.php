<?php

namespace App\Http\Controllers\Api;

use App\Events\CompleteExchange;
use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Offer;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    //


    public function exchangedProduct(Product $product)
    {
        $user = auth()->user();
        $offer = Offer::where('status', 'accepted')
            ->where('product_id', $product->id)
            ->first();

        if ($user->id === $product->user_id) {
            if ($offer) {
                $offer->status = 'completed';
                $isSavedOffer = $offer->save();
                $product->status = 'exchanged';
                $isSavedProduct = $product->save();
                if ($isSavedOffer && $isSavedProduct) {
                    $exchange = $product->exchange;
                    $exchange->status = 'completed';
                    $exchange->save();
                    broadcast(new CompleteExchange($product, $offer))->toOthers();
                }
                return response()->json([
                    'status' => $isSavedOffer && $isSavedProduct,
                    'message' => $isSavedOffer && $isSavedProduct ? 'تمت عملية التبادل بنجاح' : 'فشلت عملية التبادل',
                    'offer' => $offer->load('product.user', 'exchange')
                ], $isSavedOffer && $isSavedProduct ? 200 : 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'عذرا لم يتم قبول العروض بعد'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عذرا غير مصرح لك بتحديد ك تم التبادل لانك لست مالك للمنتج'
            ], 400);
        }
    }


    public function addContact(Request $request, Product $product)
    {
        $validator = Validator($request->all(), [
            'meeting_location' => 'required|string',
            'contact_method' =>  'required|string'
        ]);
        if (! $validator->fails()) {
            $exchange = Exchange::where('product_id', $product->id)
                ->whereHas('product', function ($q) {
                    $q->where('status', 'reserved');
                })
                ->whereHas('offer', function ($q) {
                    $q->where('status', 'accepted');
                })
                ->with('product.user', 'offer.user')
                ->first();
            $exchange->meeting_location = $request->input('meeting_location');
            $exchange->contact_method = $request->input('contact_method');
            $exchange->status = 'scheduled';
            $isSaved = $exchange->save();
            return response()->json([
                'status' =>  $isSaved,
                'message' => $isSaved ? 'تم تحديد مكان اللقاء و التواصل بنجاح' : 'فشل تحديد مكان اللقاء و التواصل',
                'exchange' => $exchange
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => $validator->getMessageBag()->first(),
            ], 400);
        }
    }
}
