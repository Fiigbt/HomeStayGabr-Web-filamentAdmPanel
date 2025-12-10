<?php

namespace App\Filament\Resources\Reservasi\Pages;

use App\Filament\Resources\Reservasi\ReservasiResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ReservasiKamar;
use App\Models\Kamar;
use Carbon\Carbon;

class CreateReservasi extends CreateRecord
{
    protected static string $resource = ReservasiResource::class;

    protected function afterCreate(): void
    {
        $state = $this->form->getState();

        $kamarDipilih = $state['kamar_list'] ?? [];

        // Hitung jumlah malam
        $checkin  = Carbon::parse($state['tgl_checkin']);
        $checkout = Carbon::parse($state['tgl_checkout']);
        
        $malam = $checkout->diffInDays($checkin);
        if ($malam < 1) $malam = 1;

        // Insert pivot & update status kamar
        foreach ($kamarDipilih as $idKamar) {

            $kamar = Kamar::find($idKamar);

            ReservasiKamar::create([
                'id_reservasi'    => $this->record->id,
                'id_kamar'        => $idKamar,
                'harga_per_malam' => $kamar->harga_per_malam,
            ]);

            // Update status kamar sesuai status reservasi
            if ($state['status_reservasi'] === 'checkin') {
                $kamar->update(['status' => 'terisi']);
            }
        }

        // Hitung total harga (harga × malam)
        $total = ReservasiKamar::where('id_reservasi', $this->record->id)
            ->sum('harga_per_malam') * $malam;

        $this->record->update(['total_harga' => $total]);
    }
}
