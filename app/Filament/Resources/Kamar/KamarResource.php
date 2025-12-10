<?php

namespace App\Filament\Resources\Kamar;

use App\Filament\Resources\Kamar\Pages\CreateKamar;
use App\Filament\Resources\Kamar\Pages\EditKamar;
use App\Filament\Resources\Kamar\Pages\ListKamar;
use App\Filament\Resources\Kamar\Schemas\KamarForm;
use App\Filament\Resources\Kamar\Tables\KamarTable;
use App\Models\Kamar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KamarResource extends Resource
{
    protected static ?string $model = Kamar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice;
    protected static ?string $navigationLabel = 'Kamar';
    public static function getModelLabel(): string
{
    return 'Kamar';
}
public static function getPluralModelLabel(): string
{
    return 'Kamar'; 
}

    public static function form(Schema $schema): Schema
    {
        return KamarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KamarTable::configure($table);
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
            'index' => ListKamar::route('/'),
            'create' => CreateKamar::route('/create'),
            'edit' => EditKamar::route('/{record}/edit'),
        ];
    }
}
