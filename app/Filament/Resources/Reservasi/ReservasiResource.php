<?php

namespace App\Filament\Resources\Reservasi;

use App\Filament\Resources\Reservasi\Pages\CreateReservasi;
use App\Filament\Resources\Reservasi\Pages\EditReservasi;
use App\Filament\Resources\Reservasi\Pages\ListReservasi;
use App\Filament\Resources\Reservasi\Schemas\ReservasiForm;
use App\Filament\Resources\Reservasi\Tables\ReservasiTable;
use App\Models\Reservasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReservasiResource extends Resource
{
    protected static ?string $model = Reservasi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;
    protected static ?string $navigationLabel = 'Reservasi';
    public static function getModelLabel(): string
{
    return 'Reservasi';
}
public static function getPluralModelLabel(): string
{
    return 'Reservasi'; 
}


    public static function form(Schema $schema): Schema
    {
        return ReservasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReservasiTable::configure($table);
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
            'index' => ListReservasi::route('/'),
            'create' => CreateReservasi::route('/create'),
            'edit' => EditReservasi::route('/{record}/edit'),
        ];
    }
}
