<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use DB;


class ProductController extends Controller
{
    
    /**
     * Get Products List.
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtering
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->with('variations.options')->paginate(25);

        return ProductResource::collection($products);
    }


    /**
     * Save new product
     * @param StoreProductRequest $request
     * @return array
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create($request->validated());

            if ($product->type === 'variable' && $request->variations) {
                foreach ($request->variations as $variationData) {
                    $variation = $product->variations()->create([
                        'name' => $variationData['name']
                    ]);

                    foreach ($variationData['options'] as $optionData) {
                        $variation->options()->create($optionData);
                    }
                }
            }

            DB::commit();
            return new ProductResource($product->load('variations.options'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create product'], 500);
        }
    }


    /**
     * Get product by id
     * @param Product $request
     * @return array
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load('variations.options'));
    }


    /**
     * Update product details.
     * @param UpdateProductRequest $request, Product $product
     * @return array
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try {
            $product->update($request->validated());

            // Handle variations update if needed

            DB::commit();
            return new ProductResource($product->load('variations.options'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update product'], 500);
        }
    }


    /**
     * Delete product by id.
     * @param Product $product
     * @return 'mssg'
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}
