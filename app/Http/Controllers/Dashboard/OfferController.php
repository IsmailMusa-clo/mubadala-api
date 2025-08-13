<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    //
    public function index()
    {
        $this->authorize('viewAny', Offer::class);

        $offers = Offer::with('images', 'product')->get();
        return view('offers.index', compact('offers'));
    }

    public function destroy(Offer $offer)
    {
        $this->authorize('delete', $offer);

        $isDeleted = $offer->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف العرض بنجاح' : 'فشل حذف العرض',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
