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

            // =========================
            // PILIH RESERVASI
            // =========================
            Select::make('id_reservasi')
                ->label('Reservasi')
                ->relationship('reservasi', 'id')
                ->searchable()
                ->preload()
                ->reactive() // ⬅️ WAJIB
                ->getOptionLabelUsing(fn ($value) =>
                    'R' . $value . ' - ' . Reservasi::find($value)?->penyewa?->nama_penyewa
                )
                ->afterStateUpdated(function ($state, callable $set) {

                    if (! $state) {
                        $set('jumlah', 0);
                        return;
                    }

                    $reservasi = Reservasi::find($state);

                    $set('jumlah', $reservasi?->total_harga ?? 0);
                })
                ->required(),

            // =========================
            // TANGGAL BAYAR
            // =========================
            DateTimePicker::make('tgl_bayar')
                ->label('Tanggal Pembayaran')
                ->default(now())
                ->required(),

            // =========================
            // JUMLAH BAYAR (AUTO)
            // =========================
            TextInput::make('jumlah')
                ->label('Jumlah Dibayar')
                ->numeric()
                ->readOnly()     // ⬅️ otomatis
                ->dehydrated()   // ⬅️ disimpan ke DB
                ->required(),

            // =========================
            // METODE BAYAR
            // =========================
            Select::make('metode_bayar')
                ->label('Metode Pembayaran')
                ->options([
                    'cash'     => 'Cash',
                    'transfer' => 'Transfer Bank',
                    'ewallet'  => 'E-Wallet',
                ])
                ->required(),

            // =========================
            // STATUS BAYAR
            // =========================
            Select::make('status_bayar')
                ->label('Status Pembayaran')
                ->options([
                    'pending' => 'Pending',
                    'lunas'   => 'Lunas',
                ])
                ->default('pending')
                ->required(),

            // =========================
            // CATATAN
            // =========================
            Textarea::make('catatan')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }
}