<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ItemStatusEnum;
use App\Enums\WishlistStatusEnum;
use App\Helper\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Items\CancelPurchaseItemRequest;
use App\Http\Requests\Api\V1\Items\PurchaseItemRequest;
use App\Http\Requests\Api\V1\Items\StoreItemRequest;
use App\Http\Resources\Api\V1\Item\ItemResource;
use App\Models\Api\V1\Item;
use App\Traits\Api\V1\ResponderTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class ItemController extends Controller
{
    use ResponderTrait;

    public function index(): JsonResponse
    {
        return $this->responseIndex(ItemResource::collection(auth()->user()->items()->with(['wishList', 'buyer'])->get()));
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
        return $this->responseShow(new ItemResource($item->load('wishList', 'buyer')));
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

    public function purchaseItem(PurchaseItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $itemBuyer = auth()->user()->itemBuyer()->create($request->validated());
            $itemBuyer->item()->update(['status' => ItemStatusEnum::COMPLETED]);
            if ($itemBuyer->item->wishList->progress === 100) {
                $itemBuyer->item->wishList->update(['status' => WishlistStatusEnum::COMPLETED]);
            }
            DB::commit();
            return $this->responseUpdated(new ItemResource($itemBuyer->item));
        } catch (Exception) {
            DB::rollback();
            return $this->response('Something went wrong', 'Server error', 500);
        }
    }

    public function cancelPurchaseItem(CancelPurchaseItemRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $itemBuyer = auth()->user()->itemBuyer()->where($request->validated())->first();
            $itemBuyer->item()->update(['status' => ItemStatusEnum::PENDING]);
            if ($itemBuyer->item->wishList->progress < 100) {
                $itemBuyer->item->wishList->update(['status' => WishlistStatusEnum::PENDING]);
            }
            $itemBuyer->delete();
            DB::commit();
            return $this->responseUpdated(new ItemResource($itemBuyer->item));
        } catch (Exception) {
            DB::rollback();
            return $this->response('Something went wrong', 'Server error', 500);
        }
    }
}
