<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitsResource\Pages;
use App\Filament\Resources\VisitsResource\RelationManagers;
use App\Models\Visits;
use App\Tables\Columns\JsonColumn;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Shetabit\Visitor\Models\Visit;

class VisitsResource extends Resource
{
    protected static ?string $model = Visit::class;

    protected static ?string $navigationIcon = 'heroicon-s-tv';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('method'),
                //JsonColumn::make('request'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('referer'),
                JsonColumn::make('languages'),
                Tables\Columns\TextColumn::make('useragent'),
                //JsonColumn::make('headers'),
                Tables\Columns\TextColumn::make('device'),
                Tables\Columns\TextColumn::make('platform'),
                Tables\Columns\TextColumn::make('browser'),
                Tables\Columns\TextColumn::make('ip'),
                Tables\Columns\TextColumn::make('visitable_type'),
                Tables\Columns\TextColumn::make('visitable_id'),
                Tables\Columns\TextColumn::make('visitor_type'),
                Tables\Columns\TextColumn::make('visitor_id'),
                Tables\Columns\TextColumn::make('created_at'),
                Tables\Columns\TextColumn::make('updated_at')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisits::route('/'),
            'create' => Pages\CreateVisits::route('/create'),
            'edit' => Pages\EditVisits::route('/{record}/edit'),
        ];
    }
}
