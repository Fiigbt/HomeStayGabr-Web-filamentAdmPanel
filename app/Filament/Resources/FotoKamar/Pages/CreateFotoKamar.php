<?php

namespace App\Filament\Resources\FotoKamar\Pages;

use App\Filament\Resources\FotoKamar\FotoKamarResource;
use App\Models\FotoKamar;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateFotoKamar extends CreateRecord
{
    protected static string $resource = FotoKamarResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika is_cover diset true, unset is_cover dari foto lain di kamar yang sama
        if ($data['is_cover'] ?? false) {
            if ($data['id_kamar']) {
                FotoKamar::where('id_kamar', $data['id_kamar'])
                    ->where('is_cover', true)
                    ->update(['is_cover' => false]);
            }
        }

        return $data;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Foto Berhasil Disimpan!')
            ->body('Foto kamar telah disimpan ke storage dan akan langsung tampil di website.')
            ->send();
    }
}
