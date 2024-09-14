<?php

namespace App\Filament\Resources\ItemBuyerResource\Pages;

use App\Filament\Resources\ItemBuyerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListItemBuyers extends ListRecords
{
    protected static string $resource = ItemBuyerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
