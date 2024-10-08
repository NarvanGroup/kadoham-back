<?php

namespace App\Helper;

use App\Enums\ItemStatusEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\WishlistStatusEnum;
use App\Http\Resources\Api\V1\Item\ItemBuyersResource;
use App\Models\Api\V1\Item;
use App\Models\Api\V1\ItemBuyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use RuntimeException;

class PurchaseHelper
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public static function purchase(Request $request): ItemBuyer
    {
        try {
            DB::beginTransaction();
            $item = Item::findOrFail($request->item_id);
            self::checkProductAvailability($item);
            $itemBuyer = self::purchaseItem($request);
            self::proccesWalletTransaction($itemBuyer, $item->fresh());
            self::processItemCompletion($item->fresh());
            self::processWishListCompletion($item->fresh());

            DB::commit();
            return $itemBuyer->fresh();
        } catch (Exception $exception) {
            DB::rollback();
            throw new RuntimeException($exception->getMessage());
        }
    }

    private static function checkProductAvailability(Item $item): void
    {
        if ($item->status !== ItemStatusEnum::PENDING->value) {
            throw new RuntimeException("Item is already : {$item->status}");
        }

        $isProduct = $item->type === ItemTypeEnum::PRODUCT->value;
        $isCashOrCharity = in_array($item->type, [ItemTypeEnum::CASH->value, ItemTypeEnum::CHARITY->value], true);

        if (($isProduct && $item->filled >= $item->quantity) || (($isCashOrCharity && $item->amount !== null) && $item->filled >= $item->amount)) {
            throw new RuntimeException('Item already purchased!');
        }
    }

    private static function purchaseItem(Request $request)
    {
        return auth()->user()->itemBuyer()->create($request->validated());
    }

    private static function proccesWalletTransaction(ItemBuyer $itemBuyer, Item $item)
    {
        if ($item->type === ItemTypeEnum::PRODUCT->value) {
            return;
        }

        $item->user->deposit($itemBuyer->amount, ItemBuyersResource::make($itemBuyer->load(['user','item']))->jsonSerialize());
    }

    private static function processItemCompletion(Item $item)
    {
        $status = ItemStatusEnum::PENDING;

        switch ($item->type) {
            case ItemTypeEnum::EXPERIENCE->value:
            case ItemTypeEnum::DIY->value:
                $isCompleted = true;
                break;
            case ItemTypeEnum::PRODUCT->value:
                $isCompleted = $item->filled >= $item->quantity;
                break;

            case ItemTypeEnum::CASH->value:
            case ItemTypeEnum::CHARITY->value:
                $isCompleted = $item->amount !== null && $item->filled >= $item->amount;
                break;

            default:
                return; // Exit if the item type is not recognized
        }

        if ($isCompleted) {
            $status = ItemStatusEnum::COMPLETED;
        }

        $item->update(compact('status'));
    }

    private static function processWishListCompletion(Item $item)
    {
        if ($item->wishList->progress >= 100) {
            $item->wishList->update(['status' => WishlistStatusEnum::COMPLETED]);
        } else {
            $item->wishList->update(['status' => WishlistStatusEnum::PENDING]);
        }
    }

    /**
     * @param  Request  $request
     * @return ItemBuyer
     */
    public static function cancelPurchase(Request $request): ItemBuyer
    {

        try {
            DB::beginTransaction();
            $data = $request->validated();
            $itemBuyer = auth()->user()->itemBuyer()->where('id', $data['item_buyer_id'])->first();
            $item = $itemBuyer->item;
            self::checkItemType($item);
            $itemBuyer->delete();
            self::processItemCompletion($item->fresh());
            self::processWishListCompletion($item->fresh());
            DB::commit();
            return $itemBuyer->fresh();

        } catch (Exception $exception) {
            DB::rollback();
            throw new RuntimeException($exception->getMessage());
        }
    }

    private static function checkItemType(Item $item)
    {
        $isCashOrCharity = in_array($item->type, [ItemTypeEnum::CASH->value, ItemTypeEnum::CHARITY->value], true);

        if ($isCashOrCharity) {
            throw new RuntimeException("Cash or Charity purchases can't be canceled!");
        }
    }
}
