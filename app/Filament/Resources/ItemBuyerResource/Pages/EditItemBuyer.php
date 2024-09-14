<?php

namespace App\Filament\Resources\ItemBuyerResource\Pages;

use App\Filament\Resources\ItemBuyerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemBuyer extends EditRecord
{
    protected static string $resource = ItemBuyerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
