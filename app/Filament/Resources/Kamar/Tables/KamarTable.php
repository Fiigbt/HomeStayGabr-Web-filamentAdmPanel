<?php

namespace App\Filament\Resources\Kamar\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class KamarTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nomor_kamar')
                    ->label('Nomor Kamar')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('lantai')
                    ->label('Lantai')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kapasitas')
                    ->label('Kapasitas')
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga_per_malam')
                    ->label('Harga per Malam')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status_kamar')
                    ->label('Status')
                    ->colors([
                        'success' => 'tersedia',
                        'danger' => 'tidak tersedia',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->deskripsi),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
