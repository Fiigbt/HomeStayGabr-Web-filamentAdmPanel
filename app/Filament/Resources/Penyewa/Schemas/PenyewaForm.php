<?php

namespace App\Filament\Resources\Penyewa\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;

class PenyewaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\TextInput::make('nama_penyewa')
                ->label('Nama Penyewa')
                ->required()
                ->maxLength(255),

            Forms\Components\DatePicker::make('tgl_lahir')
                ->label('Tanggal Lahir')
                ->required(),

            Forms\Components\TextInput::make('umur')
                ->label('Umur')
                ->numeric(),

            Forms\Components\Select::make('jk')
                ->label('Jenis Kelamin')
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
                ])
                ->required(),

            Forms\Components\TextInput::make('no_tlp')
                ->label('Nomor Telepon')
                ->tel()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(255),
        ]);
    }
}
