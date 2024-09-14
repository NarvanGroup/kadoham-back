<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InterestResource\Pages;
use App\Filament\Resources\InterestResource\RelationManagers;
use App\Models\Api\V1\Interest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InterestResource extends Resource
{
    protected static ?string $model = Interest::class;

    protected static ?string $navigationIcon = 'heroicon-s-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id'),
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('upper_body_size'),
                Forms\Components\TextInput::make('lower_body_size'),
                Forms\Components\TextInput::make('shoe_size'),
                Forms\Components\TextInput::make('favorite_color'),
                Forms\Components\TextInput::make('favorite_food'),
                Forms\Components\TextInput::make('interests'),
                Forms\Components\TextInput::make('personality'),
                Forms\Components\TextInput::make('fashion_style'),
                Forms\Components\TextInput::make('gift_type'),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('user_id'),
                Forms\Components\TextInput::make('created_at'),
                Forms\Components\TextInput::make('updated_at')
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('upper_body_size'),
                Tables\Columns\TextColumn::make('lower_body_size'),
                Tables\Columns\TextColumn::make('shoe_size'),
                Tables\Columns\TextColumn::make('favorite_color'),
                Tables\Columns\TextColumn::make('favorite_food'),
                Tables\Columns\TextColumn::make('interests'),
                Tables\Columns\TextColumn::make('personality'),
                Tables\Columns\TextColumn::make('fashion_style'),
                Tables\Columns\TextColumn::make('gift_type'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('user_id'),
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
            'index' => Pages\ListInterests::route('/'),
            'create' => Pages\CreateInterest::route('/create'),
            'edit' => Pages\EditInterest::route('/{record}/edit'),
        ];
    }
}
