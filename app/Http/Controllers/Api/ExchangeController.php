<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\Product;
use Dotenv\Validator;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    //

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
