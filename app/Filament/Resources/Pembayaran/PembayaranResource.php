<?php

namespace App\Filament\Resources\Pembayaran;

use App\Filament\Resources\Pembayaran\Pages\CreatePembayaran;
use App\Filament\Resources\Pembayaran\Pages\EditPembayaran;
use App\Filament\Resources\Pembayaran\Pages\ListPembayaran;
use App\Filament\Resources\Pembayaran\Schemas\PembayaranForm;
use App\Filament\Resources\Pembayaran\Tables\PembayaranTable;
use App\Models\Pembayaran;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CreditCard;
    protected static ?string $navigationLabel = 'Pembayaran';

    public static function getModelLabel(): string
    {
        return 'Pembayaran';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pembayaran';
    }

    public static function form(Schema $schema): Schema
    {
        return PembayaranForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PembayaranTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPembayaran::route('/'),
            'create' => CreatePembayaran::route('/create'),
            'edit' => EditPembayaran::route('/{record}/edit'),
        ];
    }
}
