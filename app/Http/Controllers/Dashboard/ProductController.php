<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::with('user')->get();
        return view('products.index', compact('products'));
    }

    public function destroy(Product $product)
    {
        $isDeleted = $product->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف المنتج بنجاح' : 'فشل حذف المنتج',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400,);
    }
}
