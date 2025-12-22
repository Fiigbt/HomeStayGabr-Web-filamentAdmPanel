<?php

namespace App\Filament\Resources\Pembayaran\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;

class PembayaranTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservasi.penyewa.nama_penyewa')
                    ->label('Penyewa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tgl_bayar')
                    ->label('Tanggal Bayar')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('metode_bayar')
                    ->label('Metode'),

                Tables\Columns\BadgeColumn::make('status_bayar')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'lunas',
                    ])
                    ->sortable(),
            ])

            ->filters([])

            ->recordActions([
                EditAction::make(),

                Action::make('lunas')
                    ->label('Set Lunas')
                    ->color('success')
                    ->visible(fn ($record) => $record->status_bayar !== 'lunas')
                    ->action(fn ($record) =>
                        $record->update(['status_bayar' => 'lunas'])
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}