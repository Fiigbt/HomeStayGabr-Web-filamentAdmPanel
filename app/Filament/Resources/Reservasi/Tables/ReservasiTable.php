<?php

namespace App\Filament\Resources\Reservasi\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ReservasiTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penyewa.nama_penyewa')
                    ->label('Penyewa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('tgl_checkin')->date(),
                Tables\Columns\TextColumn::make('tgl_checkout')->date(),

                Tables\Columns\TextColumn::make('jumlah_tamu')
                    ->label('Tamu'),

                Tables\Columns\BadgeColumn::make('status_reservasi')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info'    => 'checkin',
                        'danger'  => 'checkout',
                        'success' => 'selesai',
                    ]),

                Tables\Columns\TextColumn::make('total_harga')
                    ->money('IDR'),
            ])

            ->recordActions([
                EditAction::make(),

                Action::make('checkin')
                    ->label('Set Check-in')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->color('info')
                    ->visible(fn ($record) =>
                        $record->status_reservasi === 'pending'
                    )
                    ->action(fn ($record) =>
                        $record->update(['status_reservasi' => 'checkin'])
                    ),

                Action::make('checkout')
                    ->label('Set Check-out')
                    ->icon('heroicon-o-arrow-up-on-square')
                    ->color('warning')
                    ->visible(fn ($record) =>
                        $record->status_reservasi === 'checkin'
                    )
                    ->action(fn ($record) =>
                        $record->update(['status_reservasi' => 'checkout'])
                    ),

                Action::make('selesai')
                    ->label('Set Selesai')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn ($record) =>
                        $record->status_reservasi !== 'selesai'
                    )
                    ->action(fn ($record) =>
                        $record->update(['status_reservasi' => 'selesai'])
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
