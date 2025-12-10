<?php

namespace App\Filament\Resources\FotoKamar;

use App\Filament\Resources\FotoKamar\Pages\CreateFotoKamar;
use App\Filament\Resources\FotoKamar\Pages\EditFotoKamar;
use App\Filament\Resources\FotoKamar\Pages\ListFotoKamar;
use App\Filament\Resources\FotoKamar\Schemas\FotoKamarForm;
use App\Filament\Resources\FotoKamar\Tables\FotoKamarTable;
use App\Models\FotoKamar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FotoKamarResource extends Resource
{
    protected static ?string $model = FotoKamar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Camera;
    protected static ?string $navigationLabel = 'Foto Kamar';
    public static function getModelLabel(): string
{
    return 'Foto Kamar';
}
public static function getPluralModelLabel(): string
{
    return 'Foto Kamar'; 
}

    public static function form(Schema $schema): Schema
    {
        return FotoKamarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FotoKamarTable::configure($table);
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
            'index' => ListFotoKamar::route('/'),
            'create' => CreateFotoKamar::route('/create'),
            'edit' => EditFotoKamar::route('/{record}/edit'),
        ];
    }
}
