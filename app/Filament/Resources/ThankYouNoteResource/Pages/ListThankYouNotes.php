<?php

namespace App\Filament\Resources\ThankYouNoteResource\Pages;

use App\Filament\Resources\ThankYouNoteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListThankYouNotes extends ListRecords
{
    protected static string $resource = ThankYouNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
