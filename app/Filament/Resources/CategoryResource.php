<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Api\V1\Category;
use App\Traits\Api\V1\ReplicationTrait;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    use ReplicationTrait;

    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name_en')->unique(ignoreRecord: true)->required()->maxLength(255),
            TextInput::make('name_fa')->unique(ignoreRecord: true)->required()->maxLength(255)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name_en')->searchable(),
            TextColumn::make('name_fa')->searchable(),
            TextColumn::make('slug')
        ])->filters([//
        ])->actions([
            Tables\Actions\EditAction::make(),
            ReplicateAction::make()
                ->beforeReplicaSaved(static function (Model $replica): void {
                    static::replicate($replica);
                }),
            DeleteAction::make(),
        ])->bulkActions([
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
