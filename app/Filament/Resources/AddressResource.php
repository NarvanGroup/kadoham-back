<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddressResource\Pages;
use App\Filament\Resources\AddressResource\RelationManagers;
use App\Models\Api\V1\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-s-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('user_id'),
                Forms\Components\TextInput::make('province_id'),
                Forms\Components\TextInput::make('city_id'),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('unit'),
                Forms\Components\TextInput::make('number'),
                Forms\Components\TextInput::make('postal_code'),
                Forms\Components\TextInput::make('isReceiver'),
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('mobile'),
                Forms\Components\TextInput::make('created_at'),
                Forms\Components\TextInput::make('updated_at')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('province_id'),
                Tables\Columns\TextColumn::make('city_id'),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('unit'),
                Tables\Columns\TextColumn::make('number'),
                Tables\Columns\TextColumn::make('postal_code'),
                Tables\Columns\TextColumn::make('isReceiver'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('mobile'),
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
