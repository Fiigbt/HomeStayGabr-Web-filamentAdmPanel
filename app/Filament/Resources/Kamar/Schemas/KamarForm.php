<?php

namespace App\Filament\Resources\Kamar\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class KamarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('nomor_kamar')
                ->label('Nomor Kamar')
                ->required()
                ->unique(ignoreRecord: true),

            TextInput::make('lantai')
                ->label('Lantai')
                ->required(),

            TextInput::make('kapasitas')
                ->numeric()
                ->required(),

            TextInput::make('harga_per_malam')
                ->numeric()
                ->required(),

            Select::make('status_kamar')
                ->label('Status')
                ->options([
                    'tersedia' => 'Tersedia',
                    'dipesan' => 'Dipesan',
                    'terisi' => 'Terisi',
                    'perbaikan' => 'Perbaikan',
                ])
                ->default('tersedia')
                ->required(),

            Textarea::make('deskripsi')
                ->columnSpan('full'),
        ]);
    }
}
