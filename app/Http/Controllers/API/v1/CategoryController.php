<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return CategoryResource::collection(Category::get());

    }
    public function products(Category $category)
    {
        $products = $category->products()->simplePaginate();
        return ProductResource::collection($products);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|min:3'
        ]);
        $data['slug'] = Str::slug($request->title);
        return CategoryResource::make(Category::create($data));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:3'
        ]);
        $validated['slug'] = Str::slug($validated['title']);
        return CategoryResource::make($category->update($validated));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::destroy($id);
        return response()->noContent();
    }
}
