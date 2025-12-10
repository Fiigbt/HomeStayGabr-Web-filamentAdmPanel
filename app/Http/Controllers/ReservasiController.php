<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\ReservasiKamar;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    public function index()
    {
        return Reservasi::with(['penyewa', 'user', 'kamar', 'pembayaran'])->get();
    }

    public function show($id)
    {
        return Reservasi::with(['penyewa', 'user', 'kamar', 'pembayaran'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_penyewa' => 'required|exists:penyewa,id_penyewa',
            'id_user' => 'nullable|exists:users,id_user',
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date|after:tgl_checkin',
            'jumlah_tamu' => 'required|integer|min:1',
            'kamar' => 'required|array',
            'kamar.*' => 'exists:kamar,id_kamar',
            'dp' => 'nullable|numeric',
            'catatan' => 'nullable|string'
        ]);

        // Hitung total hari
        $days = Carbon::parse($data['tgl_checkin'])->diffInDays($data['tgl_checkout']);

        // Hitung total harga
        $totalHarga = 0;
        foreach ($data['kamar'] as $idKamar) {
            $kamar = Kamar::findOrFail($idKamar);
            $totalHarga += $kamar->harga_per_malam * $days;
        }

        $reservasi = Reservasi::create([
            ...$data,
            'total_harga' => $totalHarga,
            'status_reservasi' => 'pending'
        ]);

        // Simpan kamar ke pivot table
        foreach ($data['kamar'] as $idKamar) {
            ReservasiKamar::create([
                'id_reservasi' => $reservasi->id_reservasi,
                'id_kamar' => $idKamar,
                'harga_per_malam' => Kamar::find($idKamar)->harga_per_malam
            ]);
        }

        return $reservasi->load(['penyewa', 'kamar']);
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update($request->all());
        return $reservasi;
    }

    public function destroy($id)
    {
        Reservasi::destroy($id);
        return response()->json(['message' => 'Reservasi dihapus']);
    }
}
