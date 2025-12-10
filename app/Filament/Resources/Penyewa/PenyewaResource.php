<?php

namespace App\Filament\Resources\Penyewa;

use App\Filament\Resources\Penyewa\Pages;
use App\Filament\Resources\Penyewa\Schemas\PenyewaForm;
use App\Filament\Resources\Penyewa\Tables\PenyewaTable;
use App\Models\Penyewa;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use BackedEnum;

class PenyewaResource extends Resource
{
    protected static ?string $model = Penyewa::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Penyewa';

    public static function form(Schema $schema): Schema
    {
        return PenyewaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PenyewaTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPenyewa::route('/'),
            'create' => Pages\CreatePenyewa::route('/create'),
            'edit'   => Pages\EditPenyewa::route('/{record}/edit'),
        ];
    }
}
