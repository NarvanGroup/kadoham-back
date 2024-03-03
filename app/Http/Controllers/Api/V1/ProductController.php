<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Product\ProductResource;
use App\Models\Api\V1\Product;
use App\Repositories\Api\V1\Product\ProductRepository;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(ProductResource::collection($this->productRepository->all()));
    }

    public function store(Request $request): JsonResponse
    {
        return $this->responseCreated($this->productRepository->create($request->all()));
    }

    public function show(Product $product): JsonResponse
    {
        return $this->responseShow(new ProductResource($this->productRepository->find($product->id)));
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        $this->productRepository->update($request->all(), $product->id);
        return $this->responseUpdated('');
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->productRepository->delete($product->id);
        return $this->responseDestroyed();
    }
}
