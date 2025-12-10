<?php

namespace App\Filament\Resources\FotoKamar\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class FotoKamarTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('url')
                    ->label('Foto')
                    ->size(100),

                TextColumn::make('kamar.nomor_kamar')
                    ->label('Kamar')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('caption')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable(),

                ToggleColumn::make('is_cover')
                    ->label('Sampul Kamar')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
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
