<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Items\StoreItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Api\V1\Item;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    use ResponderTrait;

    public function __construct()
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(auth()->user()->item()->with('wishList')->get());
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        return $this->responseCreated(new ItemResource(auth()->user()->item()->create($request->validated())));
    }

    public function show(Item $item): JsonResponse
    {
        $this->authorize('show', $item);
        return $this->responseShow($item->load('wishList'));
    }

    public function update(StoreItemRequest $request, Item $item): JsonResponse
    {
        $this->authorize('update', $item);
        $item->update($request->validated());
        return $this->responseUpdated($item->fresh());
    }

    public function destroy(Item $item): JsonResponse
    {
        $this->authorize('destroy', $item);
        $item->delete();
        return $this->responseDestroyed();
    }
}
