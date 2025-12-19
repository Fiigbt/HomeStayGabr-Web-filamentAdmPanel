<?php

namespace App\Observers;

use App\Models\Reservasi;

class ReservasiObserver
{
    /**
     * Jalan SETELAH create & update
     */
    public function saved(Reservasi $reservasi): void
    {
        match ($reservasi->status_reservasi) {
            'checkin'  => $this->updateStatusKamar($reservasi, 'terisi'),
            'checkout' => $this->updateStatusKamar($reservasi, 'dibersihkan'),
            'selesai'  => $this->updateStatusKamar($reservasi, 'tersedia'),
            default    => null,
        };
    }

    /**
     * Saat reservasi dihapus
     */
    public function deleted(Reservasi $reservasi): void
    {
        $this->updateStatusKamar($reservasi, 'tersedia');
    }

    /**
     * Update status kamar
     */
    protected function updateStatusKamar(Reservasi $reservasi, string $status): void
    {
        foreach ($reservasi->kamar as $kamar) {
            $kamar->update([
                'status_kamar' => $status,
            ]);
        }
    }
}
