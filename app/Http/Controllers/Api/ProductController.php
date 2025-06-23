<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    //     $products = Product::with('user', 'category', 'images')->latest()->get();
    //     return response()->json([
    //         'status' => true,
    //         'products' => $products
    //     ], 200);
    // }

    public function index(Request $request)
    {
        $query = Product::with('user', 'category', 'images', 'tags');

        if ($request->filled('category_id')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->input('category_id'));
            });
        }

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('name', 'like', "%{$keyword}%");
        }

        if ($request->filled('location')) {
            $location = $request->input('location');
            $query->where('location', $location);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->input('created_from'));
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->input('created_to'));
        }

        $products = $query->latest()->get();

        return response()->json([
            'status' => true,
            'products' => $products,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'category_id' => 'nullable|integer',
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|min:3|max:500',
            'location' => 'required|string|min:3|max:50',
            'tags' => 'required|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        if (!$validator->fails()) {
            $user = auth()->user();
            $product = new Product();
            $product->user_id = $user->id;
            $product->category_id = $request->input('category_id');
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->location = $request->input('location');
            $isSaved = $product->save();

            if ($request->has('tags')) {
                $tagIds = [];
                foreach ($request->input('tags', []) as $tagName) {
                    $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                    $tagIds[] = $tag->id;
                }
                $product->tags()->attach($tagIds);
            }

            // $imagePaths = [];
            if ($request->file('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store("product_images/{$product->id}", 'public');
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = $path;
                    $productImage->save();
                    // $imagePaths[] = url('storage/' . $path);
                }
            }
            $product->load('user', 'category', 'images', 'tags');
            $product->makeHidden('category');
            $product->category_name = $product->category->name;
            return response()->json([
                'status' => $isSaved,
                'message' => $isSaved ? 'تم انشاء منتج بنجاح' : 'فشل انشاء منتج',
                'product' => $product
            ],  $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
        $product->load(['user', 'offers', 'tags', 'images', 'category']);
        $product->makeHidden('category');
        $product->offers_count = $product->offers()->count();
        $product->category_name = $product->category->name;
        return response()->json([
            'status' => true,
            'product' => $product->load('user')
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator = Validator($request->all(), [
            'category_id' => 'nullable|integer',
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|min:3|max:500',
            'location' => 'required|string|min:3|max:50',
            'tags' => 'required|array',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        if (!$validator->fails()) {
            $user = $request->user();
            if ($user->id === $product->user_id) {
                $product->category_id = $request->input('category_id');
                $product->name = $request->input('name');
                $product->description = $request->input('description');
                $product->location = $request->input('location');
                $isUpdated = $product->update();
                if ($request->has('tags')) {
                    $tagIds = [];
                    foreach ($request->input('tags', []) as $tagName) {
                        $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                        $tagIds[] = $tag->id;
                    }
                    $product->tags()->sync($tagIds);
                }
                if ($request->hasFile('images')) {
                    foreach ($product->images as $oldImage) {
                        if (Storage::disk('public')->exists($oldImage->image)) {
                            Storage::disk('public')->delete($oldImage->image);
                        }
                        $oldImage->delete();
                    }

                    foreach ($request->file('images') as $imageFile) {
                        $path = $imageFile->store("product_images/{$product->id}", 'public');
                        $productImage = new ProductImage();
                        $productImage->product_id = $product->id;
                        $productImage->image = $path;
                        $productImage->save();
                    }
                }
                $product->load('user', 'category', 'images', 'tags');
                $product->makeHidden('category');
                $product->category_name = $product->category->name;
                return response()->json([
                    'status' => $isUpdated,
                    'message' => $isUpdated ? 'تم تعديل المنتج بنجاح' : 'فشل تعديل المنتج',
                    'product' => $product
                ],  $isUpdated ? 200 : 400);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'عذرا غير مصرح لك بتعديل المنتج لانك لست مالكه'
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
    public function destroy(Product $product)
    {
        //
        $user = auth()->user();
        if ($user->id === $product->user_id) {
            if ($product->images) {
                foreach ($product->images as $image) {
                    if (Storage::disk('public')->exists($image->image)) {
                        Storage::disk('public')->delete($image->image);
                    }
                    $image->delete();
                }
            }
            $isDeleted = $product->delete();
            return response()->json([
                'status' => $isDeleted,
                'message' => $isDeleted ? 'تم حذف المنتج بنجاح' : 'فشل حذف المنتج',
            ], $isDeleted ? 200 : 400);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عذرا غير مصرح لك بحذف المنتج لانك لست مالكه'
            ], 401);
        }
    }

    public function myProducts()
    {
        $userId = auth()->id();
        $products = Product::where('user_id', $userId)->with('images', 'tags')->get();
        return response()->json([
            'status' => true,
            'products' => $products,
        ], 200);
    }

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
}
