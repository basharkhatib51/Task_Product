<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $products = new Product();
        if (isset($request->filterCode)) {
            $products = $products->where('code', 'like', $request->filterCode . '%')->get();
            return $this->Data(['products' => ProductResource::collection($products)]);
        }
        return $this->Data(['products' => ProductResource::collection(Product::all())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $product = new Product();
        $product->code = $validated['code'];
        $product->description = $validated['description'];
        $product->cost = $validated['cost'];
        $product->quantity_available = $validated['quantity_available'];
        $product->save();
        return $this->Success('product has been created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product)
    {
        return $this->Data(['product' => new ProductResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $validated = $request->validated();
        $product->code = $validated['code'];
        $product->description = $validated['description'];
        $product->cost = $validated['cost'];
        $product->quantity_available = $validated['quantity_available'];
        $product->save();
        return $this->Success('product has been Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->Success('product has been Deleted successfully');
    }
}
