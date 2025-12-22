<?php

namespace App\Filament\Resources\FotoKamar\Schemas;

use App\Models\Kamar;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FotoKamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('url')
                    ->label('Foto Kamar')
                    ->image()
                    ->directory('foto-kamar')
                    ->disk('public')
                    ->maxSize(5120)
                    ->required()
                    ->afterStateUpdated(function ($state) {                       
                    })
                    ->helperText('Ukuran maksimal 5MB. Format: JPEG, PNG, GIF'),

                Select::make('id_kamar')
                    ->label('Kamar')
                    ->options(function () {
                        return Kamar::query()
                            ->whereNotNull('nomor_kamar')
                            ->pluck('nomor_kamar', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->helperText('Pilih kamar yang terkait dengan foto ini (opsional)'),

                Textarea::make('caption')
                    ->label('Deskripsi / Caption')
                    ->rows(3)
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Misal: View dari depan, Kamar mandi, Balkon, dll'),

                Toggle::make('is_cover')
                    ->label('Jadikan Foto Sampul')
                    ->helperText('Foto ini akan ditampilkan sebagai sampul utama kamar')
                    ->default(false),
            ]);
    }
}


