<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Items\StoreItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Api\V1\Blog;
use App\Models\Api\V1\Item;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ResponderTrait;
    public function index(): JsonResponse
    {
        return $this->responseIndex(ItemResource::collection(auth()->user()->items()->with(['wishList', 'buyers'])->get()));
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = UploadHelper::upload($request,'image','items');
        return $this->responseCreated(new ItemResource(auth()->user()->items()->create($data)));
    }

    public function show(Item $item): JsonResponse
    {
        $this->authorize('show', $item);
        return $this->responseShow(new ItemResource($item->load('wishList', 'buyers')));
    }

    public function update(StoreItemRequest $request, Item $item): JsonResponse
    {
        $data = $request->validated();
        $data['image'] = UploadHelper::upload($request,'image','items');
        $this->authorize('update', $item);
        $item->update($data);
        return $this->responseUpdated(new ItemResource($item->fresh()));
    }

    public function destroy(Item $item): JsonResponse
    {
        $this->authorize('destroy', $item);
        $item->delete();
        return $this->responseDestroyed();
    }
}
