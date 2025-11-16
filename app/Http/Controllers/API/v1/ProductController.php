<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();

        return response()->json([
            'data' => ProductResource::collection($products)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return ['product' => "product created successfuly"];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'data' => ProductResource::collection($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return ['product' => "$id product updated successfuly"];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return ['product' => "$id product deleted successfuly"];
    }


}
