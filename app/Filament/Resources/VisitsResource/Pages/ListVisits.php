<?php

namespace App\Filament\Resources\VisitsResource\Pages;

use App\Filament\Resources\VisitsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisits extends ListRecords
{
    protected static string $resource = VisitsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
