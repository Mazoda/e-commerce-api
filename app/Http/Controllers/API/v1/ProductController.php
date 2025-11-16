<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['category', 'brand'])->simplePaginate(10);

        return response()->json([
            'error' => null,
            'status' => 200,
            'data' => ProductResource::collection($products),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
            ]
        ], 200);
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

        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['price'] = (int) round($validated['price'] * 100);
        Product::create($validated);
        return response()->json([
            "data" => $validated
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return response()->json([
            'error' => null,
            'status' => 200,
            'data' => ProductResource::make($product)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validated = $request->validate([
        //     'title' => 'string|min:3',
        //     'description' => 'string|min:5',
        //     'price' => 'numeric|min:0',

        // ]);
        // Product::update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }


}
