<?php

namespace App\Filament\Resources\Reservasi\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use App\Models\ReservasiKamar;
use App\Models\Kamar;

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

                Tables\Columns\TextColumn::make('tgl_checkin')
                    ->label('Check-in')
                    ->date(),

                Tables\Columns\TextColumn::make('tgl_checkout')
                    ->label('Check-out')
                    ->date(),

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
                    ->label('Total')
                    ->money('IDR'),
            ])

            ->recordActions([
                EditAction::make(),

                // === SET CHECK-IN ===
                Action::make('set_checkin')
                    ->label('Set Check-in')
                    ->icon('heroicon-s-arrow-down-on-square')
                    ->color('info')
                    ->visible(fn ($record) =>
                        $record->status_reservasi === 'pending'
                    )
                    ->action(function ($record) {

                        $record->update(['status_reservasi' => 'checkin']);

                        // Update kamar -> terisi
                        $kamarList = ReservasiKamar::where('id_reservasi', $record->id)->get();
                        foreach ($kamarList as $row) {
                            Kamar::where('id', $row->id_kamar)
                                ->update(['status_kamar' => 'terisi']);
                        }
                    }),

                // === SET CHECK-OUT ===
                Action::make('set_checkout')
                    ->label('Set Check-out')
                    ->icon('heroicon-s-arrow-up-on-square')
                    ->color('warning')
                    ->visible(fn ($record) =>
                        $record->status_reservasi === 'checkin'
                    )
                    ->action(function ($record) {

                        $record->update(['status_reservasi' => 'checkout']);

                        // Balikan kamar -> tersedia
                        $kamarList = ReservasiKamar::where('id_reservasi', $record->id)->get();
                        foreach ($kamarList as $row) {
                            Kamar::where('id', $row->id_kamar)
                                ->update(['status_kamar' => 'tersedia']);
                        }
                    }),

                // === SET SELESAI ===
                Action::make('set_selesai')
                    ->label('Set Selesai')
                    ->icon('heroicon-s-check')
                    ->color('success')
                    ->visible(fn ($record) =>
                        $record->status_reservasi !== 'selesai'
                    )
                    ->action(function ($record) {

                        $record->update(['status_reservasi' => 'selesai']);

                        // Pastikan kamar tersedia
                        $kamarList = ReservasiKamar::where('id_reservasi', $record->id)->get();
                        foreach ($kamarList as $row) {
                            Kamar::where('id', $row->id_kamar)
                                ->update(['status_kamar' => 'tersedia']);
                        }
                    }),
            ])

            ->toolbarActions([
                BulkActionGroup::make([

                    // DELETE BULK ACTION
                    DeleteBulkAction::make()
                        ->before(function ($records) {

                            foreach ($records as $record) {

                                // Kembalikan semua kamar menjadi tersedia
                                $kamarList = ReservasiKamar::where('id_reservasi', $record->id)->get();
                                foreach ($kamarList as $row) {
                                    Kamar::where('id', $row->id_kamar)
                                        ->update(['status_kamar' => 'tersedia']);
                                }

                                // Hapus pivot
                                ReservasiKamar::where('id_reservasi', $record->id)->delete();
                            }
                        }),
                ]),
            ]);
    }
}
