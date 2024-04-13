<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ItemStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Items\CancelPurchaseItemRequest;
use App\Http\Requests\Api\V1\Items\PurchaseItemRequest;
use App\Http\Requests\Api\V1\Items\StoreItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Api\V1\Item;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(auth()->user()->items()->with('wishList')->get());
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        return $this->responseCreated(new ItemResource(auth()->user()->items()->create($request->validated())));
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

    public function purchaseItem(PurchaseItemRequest $request): JsonResponse
    {
        $itemBuyer = auth()->user()->itemBuyer()->create($request->validated());
        $itemBuyer->item()->update(['status' => ItemStatusEnum::COMPLETED]);
        return $this->responseUpdated($itemBuyer->item);
    }

    public function cancelPurchaseItem(CancelPurchaseItemRequest $request): JsonResponse
    {
        $itemBuyer = auth()->user()->itemBuyer()->where($request->validated())->first();
        $itemBuyer->item()->update(['status' => ItemStatusEnum::PENDING]);
        $itemBuyer->delete();
        return $this->responseUpdated($itemBuyer->item);
    }
}
