<?php

namespace App\Filament\Resources\Reservasi\Schemas;

use App\Models\Kamar;
use Filament\Forms;
use Filament\Schemas\Schema;
use Carbon\Carbon;

class ReservasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            Forms\Components\Select::make('id_penyewa')
                ->relationship('penyewa', 'nama_penyewa')
                ->required(),

            // =========================
            // TANGGAL (WAJIB reactive)
            // =========================
            Forms\Components\DatePicker::make('tgl_checkin')
                ->label('Check-in')
                ->reactive()
                ->afterStateUpdated(fn ($get, $set) =>
                    self::hitungTotal($get, $set)
                )
                ->required(),

            Forms\Components\DatePicker::make('tgl_checkout')
                ->label('Check-out')
                ->reactive()
                ->afterStateUpdated(fn ($get, $set) =>
                    self::hitungTotal($get, $set)
                )
                ->required(),

            // =========================
            // KAMAR (WAJIB reactive)
            // =========================
            Forms\Components\MultiSelect::make('kamar_list')
                ->label('Pilih Kamar')
                ->options(Kamar::pluck('nomor_kamar', 'id'))
                ->reactive()
                ->afterStateUpdated(fn ($get, $set) =>
                    self::hitungTotal($get, $set)
                ),

            // =========================
            // TOTAL (AUTO)
            // =========================
            Forms\Components\TextInput::make('total_harga')
                ->label('Total Harga')
                ->numeric()
                ->readOnly()
                ->dehydrated(),

            Forms\Components\Select::make('status_reservasi')
                ->options([
                    'pending' => 'Pending',
                    'checkin' => 'Check-in',
                    'checkout' => 'Check-out',
                    'selesai' => 'Selesai',
                ])
                ->default('pending'),

            Forms\Components\TextInput::make('dp')
                ->numeric()
                ->default(0),

            Forms\Components\Textarea::make('catatan')
                ->columnSpanFull(),
        ]);
    }

    // =========================
    // FUNGSI HITUNG TOTAL (SATU)
    // =========================
    protected static function hitungTotal(callable $get, callable $set): void
    {
        $kamar = $get('kamar_list');
        $checkin = $get('tgl_checkin');
        $checkout = $get('tgl_checkout');

        if (empty($kamar) || ! $checkin || ! $checkout) {
            $set('total_harga', 0);
            return;
        }

        $malam = max(
            Carbon::parse($checkout)->diffInDays(Carbon::parse($checkin)),
            1
        );

        $harga = Kamar::whereIn('id', $kamar)->sum('harga_per_malam');

        $set('total_harga', $harga * $malam);
    }
}
