<?php

namespace App\Filament\Resources\FotoKamar\Pages;

use App\Filament\Resources\FotoKamar\FotoKamarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFotoKamar extends ListRecords
{
    protected static string $resource = FotoKamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
