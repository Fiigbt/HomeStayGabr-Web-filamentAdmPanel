<?php

namespace App\Filament\Resources\Reservasi\Schemas;

use App\Models\Kamar;
use App\Models\Penyewa;
use Filament\Forms;
use Filament\Schemas\Schema;

class ReservasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Forms\Components\Select::make('id_penyewa')
                ->label('Penyewa')
                ->options(Penyewa::pluck('nama_penyewa', 'id_penyewa'))
                ->searchable()
                ->required(),

            Forms\Components\DatePicker::make('tgl_checkin')
                ->label('Tanggal Check-in')
                ->required(),

            Forms\Components\DatePicker::make('tgl_checkout')
                ->label('Tanggal Check-out')
                ->required(),

            Forms\Components\TextInput::make('jumlah_tamu')
                ->label('Jumlah Tamu')
                ->numeric()
                ->default(1)
                ->required(),

            Forms\Components\Select::make('status_reservasi')
                ->label('Status Reservasi')
                ->options([
                    'pending' => 'Pending',
                    'checkin' => 'Check-in',
                    'checkout' => 'Check-out',
                    'selesai' => 'Selesai',
                ])
                ->required(),

            // MULTIPLE KAMAR
            Forms\Components\MultiSelect::make('kamar_list')
                ->label('Pilih Kamar')
                ->options(
                    Kamar::pluck('nomor_kamar', 'id')
                )
                ->searchable()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state || count($state) === 0) {
                        $set('total_harga', 0);
                        return;
                    }

                    $sum = Kamar::whereIn('id', $state)->sum('harga_per_malam');
                    $set('total_harga', $sum);
                }),
            // TOTAL HARGA OTOMATIS
            Forms\Components\TextInput::make('total_harga')
                ->label('Total Harga')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            Forms\Components\TextInput::make('dp')
                ->label('DP (Down Payment)')
                ->numeric()
                ->default(0),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }
}
