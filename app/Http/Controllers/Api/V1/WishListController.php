<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WishLists\StoreWishListRequest;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use App\Models\WishList;
use App\Repositories\Api\V1\WishList\WishListRepository;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class WishListController extends Controller
{
    use ResponderTrait;

    public function __construct(private readonly WishListRepository $wishListRepository)
    {
    }

    public function index(): JsonResponse
    {
        return $this->responseIndex(WishListResource::collection($this->wishListRepository->all()));
    }

    public function store(StoreWishListRequest $request): JsonResponse
    {
        return $this->responseCreated(new WishListResource($this->wishListRepository->create($request->validated())));
    }

    public function show(WishList $wishList): JsonResponse
    {
        $this->authorize('show', $wishList);
        return $this->responseShow($this->wishListRepository->find($wishList->id)->with('items')->get());
    }

    public function update(StoreWishListRequest $request, WishList $wishList): JsonResponse
    {
        $this->authorize('update', $wishList);
        $this->wishListRepository->update($request->validated(), $wishList->id);
        return $this->responseUpdated($wishList->fresh());
    }

    public function destroy(WishList $wishList): JsonResponse
    {
        $this->authorize('destroy', $wishList);
        $this->wishListRepository->delete($wishList->id);
        return $this->responseDestroyed();
    }
}
