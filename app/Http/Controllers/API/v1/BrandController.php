<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return BrandResource::collection(Brand::simplePaginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $brand = $request->validate([
            'title' => 'required|string|min:3',
            'image_url' => 'string|active_url',
        ]);
        $brand['slug'] = Str::slug($brand['title']);
        return BrandResource::make(Brand::create($brand));

    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return BrandResource::make($brand);
    }
    public function products(Brand $brand)
    {
        return BrandResource::collection($brand->products()->simplePaginate());
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'title' => 'string|min:3',
            'image_url' => 'string|active_url',
        ]);
        $validated['slug'] = Str::slug($brand['title']);
        return BrandResource::make($brand->update($validated));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Brand::destroy($id);
        return response()->noContent();
    }
}
