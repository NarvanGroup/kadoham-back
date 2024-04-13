<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\UniqueCodeGenerator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\WishLists\StoreWishListRequest;
use App\Http\Resources\Api\V1\User\UserResource;
use App\Http\Resources\Api\V1\WishList\WishListResource;
use App\Models\Api\V1\WishList;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;

class WishListController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(WishListResource::collection(auth()->user()->wishLists()->get()));
    }

    public function store(StoreWishListRequest $request): JsonResponse
    {
        return $this->responseCreated(new WishListResource(auth()->user()->wishLists()->create($request->validated())));
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

    public function storeShare(WishList $wishList): JsonResponse
    {
        $this->authorize('update', $wishList);
        $code = UniqueCodeGenerator::generateUniqueCode(new WishList(), 'share');
        if ($wishList->share === null) {
            $wishList->update(['share' => $code]);
        }
        return $this->responseUpdated($wishList->fresh());
    }

    public function showShare(string $share): JsonResponse
    {
        $wishList = WishList::where('share', $share)->firstOrFail();
        return $this->response(new UserResource($wishList->user->load([
            'wishLists' => static function ($query) use ($share) {
                $query->where('share', $share)->with('items');
            }
        ])));
    }

    public function destroyShare(WishList $wishList): JsonResponse
    {
        $this->authorize('update', $wishList);
        $wishList->update(['share' => null]);
        return $this->responseUpdated($wishList->fresh());
    }
}
