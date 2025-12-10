<?php

namespace App\Filament\Resources\FotoKamar\Pages;

use App\Filament\Resources\FotoKamar\FotoKamarResource;
use App\Models\FotoKamar;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFotoKamar extends EditRecord
{
    protected static string $resource = FotoKamarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika is_cover diset true, unset is_cover dari foto lain di kamar yang sama
        if ($data['is_cover'] ?? false) {
            $idKamar = $data['id_kamar'] ?? $this->record->id_kamar;
            if ($idKamar) {
                FotoKamar::where('id_kamar', $idKamar)
                    ->where('id', '!=', $this->record->id)
                    ->where('is_cover', true)
                    ->update(['is_cover' => false]);
            }
        }

        return $data;
    }
}
