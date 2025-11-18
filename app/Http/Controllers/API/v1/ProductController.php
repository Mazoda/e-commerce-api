<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::simplePaginate(10));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:5',
            'price' => 'required|numeric|min:0',
            'category_id' => 'exists:categories,id',
            'brand_id' => 'exists:brands,id'

        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['price'] = (int) round($validated['price'] * 100);

        return ProductResource::make(Product::create($validated));

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return ProductResource::make($product->load(['category', 'brand']));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'string|min:3',
            'description' => 'string|min:5',
            'price' => 'numeric|min:0',
            'category_id' => 'exists:categories,id',
        ]);
        return ProductResource::make($product->update($validated));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::destroy($id);
    }


}
