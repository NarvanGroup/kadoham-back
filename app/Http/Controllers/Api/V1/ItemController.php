<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Items\StoreItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Item;
use App\Repositories\Api\V1\Item\ItemRepository;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class ItemController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly ItemRepository $itemRepository)
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(ItemResource::collection(Item::with('wishList')->get()));
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        return $this->responseCreated(new ItemResource($this->itemRepository->create($request->validated())));
    }

    public function show(Item $item): JsonResponse
    {
        $this->authorize('show', $item);
        return $this->responseShow($this->itemRepository->find($item->id)->with('wish-list')->first());
    }

    public function update(StoreItemRequest $request, Item $item): JsonResponse
    {
        $this->authorize('update', $item);
        $this->itemRepository->update($request->validated(), $item->id);
        return $this->responseUpdated($item->fresh());
    }

    public function destroy(Item $item): JsonResponse
    {
        $this->authorize('destroy', $item);
        $this->itemRepository->delete($item->id);
        return $this->responseDestroyed();
    }
}
