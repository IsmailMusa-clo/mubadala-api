<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Dotenv\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name' => "required|string",
            'description' => "nullable|string",
        ]);
        if (! $validator->fails()) {
            $category = new Category();
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $isSaved = $category->save();
            return response()->json([
                'message' => $isSaved ? 'تم انشاء التصنيف بنجاح' : 'فشل انشاء التصنيف',
                'icon' => $isSaved ? 'success' : 'error',
            ], $isSaved ? 201 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator($request->all(), [
            'name' => "required|string",
            'description' => "nullable|string",
        ]);
        if (! $validator->fails()) {
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $isSaved = $category->save();
            return response()->json([
                'message' => $isSaved ? 'تم تعديل التصنيف بنجاح' : 'فشل تعديل التصنيف',
                'icon' => $isSaved ? 'success' : 'error',
            ], $isSaved ? 200 : 400);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $isDeleted = $category->delete();
        return response()->json([
            'message' => $isDeleted ? 'تم حذف التصنيف بنجاح' : 'فشل حذف التصنيف',
            'icon' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 400);
    }
}
