<?php

namespace App\Filament\Resources\Reservasi\Pages;

use App\Filament\Resources\Reservasi\ReservasiResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\ReservasiKamar;
use App\Models\Kamar;
use Carbon\Carbon;

class EditReservasi extends EditRecord
{
    protected static string $resource = ReservasiResource::class;

    // Isi MultiSelect saat buka edit
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['kamar_list'] = ReservasiKamar::where('id_reservasi', $data['id'])
            ->pluck('id_kamar')
            ->toArray();

        return $data;
    }

    protected function afterSave(): void
    {
        $state = $this->form->getState();

        // Hitung jumlah malam
        $checkin  = Carbon::parse($state['tgl_checkin']);
        $checkout = Carbon::parse($state['tgl_checkout']);
        $malam = max(1, $checkout->diffInDays($checkin));

        // Ambil kamar lama sebelum refresh pivot
        $kamarLama = ReservasiKamar::where('id_reservasi', $this->record->id)->get();

        // Kembalikan seluruh kamar lama menjadi tersedia
        foreach ($kamarLama as $row) {
            if ($kamar = Kamar::find($row->id_kamar)) {
                $kamar->update(['status' => 'tersedia']);
            }
        }

        // Clear pivot
        ReservasiKamar::where('id_reservasi', $this->record->id)->delete();

        // Insert ulang kamar baru
        foreach ($state['kamar_list'] as $idKamar) {

            $kamar = Kamar::find($idKamar);

            ReservasiKamar::create([
                'id_reservasi'    => $this->record->id,
                'id_kamar'        => $idKamar,
                'harga_per_malam' => $kamar->harga_per_malam,
            ]);

            // Update status kamar baru
            if ($state['status_reservasi'] === 'checkin') {
                $kamar->update(['status' => 'terisi']);
            } else {
                $kamar->update(['status' => 'tersedia']);
            }
        }

        // Hitung total harga
        $total = ReservasiKamar::where('id_reservasi', $this->record->id)
            ->sum('harga_per_malam') * $malam;

        $this->record->update(['total_harga' => $total]);
    }

    protected function afterDelete(): void
    {
        // Ambil semua kamar yg terhubung
        $kamarList = ReservasiKamar::where('id_reservasi', $this->record->id)->get();

        // Kembalikan status kamar → tersedia
        foreach ($kamarList as $item) {
            if ($kamar = Kamar::find($item->id_kamar)) {
                $kamar->update(['status' => 'tersedia']);
            }
        }

        // Hapus pivot
        ReservasiKamar::where('id_reservasi', $this->record->id)->delete();
    }
}
