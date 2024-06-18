<?php

namespace App\Helper;

use App\Enums\ItemStatusEnum;
use App\Enums\WishlistStatusEnum;
use App\Models\Api\V1\ItemBuyer;
use http\Exception\RuntimeException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class PurchaseHelper
{
    /**
     * @param Request $request
     * @return mixed
     */
    public static function purchase(Request $request): ItemBuyer
    {
        try {
            DB::beginTransaction();
            $itemBuyer = auth()->user()->itemBuyer()->create($request->validated());
            $itemBuyer->item()->update(['status' => ItemStatusEnum::COMPLETED]);
            if ($itemBuyer->item->wishList->progress === 100) {
                $itemBuyer->item->wishList->update(['status' => WishlistStatusEnum::COMPLETED]);
            }
            DB::commit();
            return $itemBuyer->fresh();
        } catch (Exception $exception) {
            DB::rollback();
            throw new RuntimeException($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return ItemBuyer
     */
    public static function cancelPurchase(Request $request): ItemBuyer
    {
        try {
            DB::beginTransaction();
            $itemBuyer = auth()->user()->itemBuyer()->where($request->validated())->first();
            $itemBuyer->item()->update(['status' => ItemStatusEnum::PENDING]);
            if ($itemBuyer->item->wishList->progress < 100) {
                $itemBuyer->item->wishList->update(['status' => WishlistStatusEnum::PENDING]);
            }
            DB::commit();
            return $itemBuyer->delete();

        } catch (Exception $exception) {
            DB::rollback();
            throw new RuntimeException($exception->getMessage());
        }
    }

    private function checkIfItemIsAlreadyPurchased(Request $request)
    {
        try {
            DB::beginTransaction();
            $itemBuyer = auth()->user()->itemBuyer()->where($request->validated())->first();
            $itemBuyerCounts = auth()->user()->itemBuyer()->count();
            if($itemBuyerCounts >= $itemBuyer->item->quantity){
                throw new RuntimeException('Item is already been purchased');
            }
            $itemBuyer->item()->update(['status' => ItemStatusEnum::COMPLETED]);
            if ($itemBuyer->item->wishList->progress === 100) {
                $itemBuyer->item->wishList->update(['status' => WishlistStatusEnum::COMPLETED]);
            }
            DB::commit();
            return $itemBuyer->fresh();
        } catch (Exception $exception) {
            DB::rollback();
            throw new RuntimeException($exception->getMessage());
        }
    }
}
