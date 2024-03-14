<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WishLists\StoreWishListRequest;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use App\Models\Api\V1\WishList;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class WishListController extends Controller
{
    use ResponderTrait;

    public function __construct()
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(WishListResource::collection(auth()->user()->wishList()->get()));
    }

    public function store(StoreWishListRequest $request): JsonResponse
    {
        return $this->responseCreated(new WishListResource(auth()->user()->wishList()->create($request->validated())));
    }

    public function show(WishList $wishList): JsonResponse
    {
        $this->authorize('show', $wishList);
        return $this->responseShow(new WishListResource($wishList->load('items')));
    }

    public function update(StoreWishListRequest $request, WishList $wishList): JsonResponse
    {
        $this->authorize('update', $wishList);
        $wishList->update($request->validated());
        return $this->responseUpdated($wishList->fresh());
    }

    public function destroy(WishList $wishList): JsonResponse
    {
        $this->authorize('destroy', $wishList);
        $wishList->delete();
        return $this->responseDestroyed();
    }
}
