<?php

namespace App\Filament\Resources\Penyewa\Pages;

use App\Filament\Resources\Penyewa\PenyewaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenyewa extends ListRecords
{
    protected static string $resource = PenyewaResource::class;

   protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ]; 
    }
}
