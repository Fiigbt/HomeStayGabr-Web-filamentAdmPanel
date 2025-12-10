<?php

namespace App\Filament\Resources\Reservasi\Pages;

use App\Filament\Resources\Reservasi\ReservasiResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListReservasi extends ListRecords
{
    protected static string $resource = ReservasiResource::class;
     protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ]; 
    }
}
