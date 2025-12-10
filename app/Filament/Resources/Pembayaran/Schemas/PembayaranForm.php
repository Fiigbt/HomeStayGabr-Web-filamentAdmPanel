<?php

namespace App\Filament\Resources\Pembayaran\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use App\Models\Reservasi;

class PembayaranForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('id_reservasi')
                ->label('Reservasi')
                ->relationship('reservasi', 'id')
                ->preload()
                ->searchable()
                ->required()
                ->getOptionLabelUsing(fn ($value) =>
                    "R{$value} - " . Reservasi::find($value)?->penyewa?->nama_penyewa
                ),

            DateTimePicker::make('tgl_bayar')
                ->label('Tanggal Pembayaran')
                ->default(now())
                ->required(),

            TextInput::make('jumlah')
                ->label('Jumlah Dibayar')
                ->numeric()
                ->required(),

            Select::make('metode_bayar')
                ->label('Metode Pembayaran')
                ->options([
                    'cash' => 'Cash',
                    'transfer' => 'Transfer Bank',
                    'ewallet' => 'E-Wallet',
                ])
                ->required(),

            Select::make('status_bayar')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'lunas' => 'Lunas',
                ])
                ->required(),

            Textarea::make('catatan')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }
}
