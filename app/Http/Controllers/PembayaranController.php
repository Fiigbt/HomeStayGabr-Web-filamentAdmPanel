<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return Pembayaran::with('reservasi')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_reservasi' => 'required|exists:reservasi,id_reservasi',
            'tgl_bayar' => 'required|date',
            'jumlah' => 'required|numeric',
            'status_bayar' => 'nullable|in:pending,lunas,gagal,refund',
            'metode_bayar' => 'required|in:cash,transfer,qris',
            'catatan' => 'nullable|string'
        ]);

        $pembayaran = Pembayaran::create($data);

        // Jika lunas → update status reservasi
        if ($data['status_bayar'] === 'lunas') {
            Reservasi::where('id_reservasi', $data['id_reservasi'])
                ->update(['status_reservasi' => 'confirmed']);
        }

        return $pembayaran;
    }

    public function destroy($id)
    {
        Pembayaran::destroy($id);
        return response()->json(['message' => 'Pembayaran dihapus']);
    }
}
