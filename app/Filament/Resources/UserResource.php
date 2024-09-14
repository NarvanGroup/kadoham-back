<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Api\V1\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('last_name'),
                Forms\Components\TextInput::make('father_name'),
                Forms\Components\TextInput::make('username'),
                Forms\Components\TextInput::make('nid'),
                Forms\Components\DatePicker::make('dob')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\Select::make('gender')->options(
                    [
                        'male'   => 'آقا',
                        'female' => 'خانم'
                    ]
                ),
                Forms\Components\TextInput::make('mobile')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email_verified_at'),
                Forms\Components\TextInput::make('password'),
                Forms\Components\TextInput::make('otp'),
                Forms\Components\TextInput::make('image')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('father_name'),
                Tables\Columns\TextColumn::make('username'),
                Tables\Columns\TextColumn::make('nid'),
                Tables\Columns\TextColumn::make('dob'),
                Tables\Columns\TextColumn::make('gender'),
                Tables\Columns\TextColumn::make('mobile'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('email_verified_at'),
                Tables\Columns\TextColumn::make('password'),
                Tables\Columns\TextColumn::make('otp'),
                Tables\Columns\TextColumn::make('image')
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
