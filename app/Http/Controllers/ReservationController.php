<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Penyewa;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Tampilkan daftar kamar
    public function index()
    {
        $kamar = Kamar::with('fotos')->where('status_kamar', 'tersedia')->paginate(9);
        
        // Ambil kamar yang sedang di-checkin (tidak bisa dipesan)
        // Jika status berubah menjadi 'selesai', kamar bisa dipesan lagi
        $kamarDiPesan = Reservasi::whereIn('status_reservasi', ['checkin'])
            ->with('kamar')
            ->get()
            ->flatMap(function ($reservasi) {
                return $reservasi->kamar->pluck('id');
            })
            ->toArray();
        
        return view('reservations.index', compact('kamar', 'kamarDiPesan'));
    }

    // Tampilkan form pemesanan untuk kamar tertentu
    public function create($id)
    {
        $kamar = Kamar::with('fotos')->findOrFail($id);
        return view('reservations.create', compact('kamar'));
    }

    // Simpan pemesanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:20',
            'email' => 'required|email',
            'id_kamar' => 'required|exists:kamar,id',
            'tgl_checkin' => 'required|date|after_or_equal:today',
            'tgl_checkout' => 'required|date|after_or_equal:tgl_checkin',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        // Cek apakah ada reservasi dengan checkin yang sama untuk kamar tersebut (hanya yang statusnya belum selesai)
        $existingReservasi = Reservasi::whereHas('kamar', function ($query) use ($validated) {
            $query->where('kamar.id', $validated['id_kamar']);
        })->where('tgl_checkin', $validated['tgl_checkin'])
          ->whereNotIn('status_reservasi', ['selesai', 'cancelled'])
          ->exists();

        if ($existingReservasi) {
            return back()->withErrors(['tgl_checkin' => 'Kamar ini sudah dipesan untuk tanggal ' . $validated['tgl_checkin']]);
        }

        // Cari atau buat penyewa
        $penyewa = Penyewa::firstOrCreate(
            ['no_tlp' => $validated['no_tlp']],
            [
                'nama_penyewa' => $validated['nama_penyewa'],
                'email' => $validated['email'],
            ]
        );

        // Hitung total harga
        $kamar = Kamar::findOrFail($validated['id_kamar']);
        $checkin = new \DateTime($validated['tgl_checkin']);
        $checkout = new \DateTime($validated['tgl_checkout']);
        $nights = $checkin->diff($checkout)->days;
        $total = $kamar->harga_per_malam * $nights;

        // Buat reservasi tanpa id_kamar
        $reservasi = Reservasi::create([
            'id_penyewa' => $penyewa->id_penyewa,
            'tgl_checkin' => $validated['tgl_checkin'],
            'tgl_checkout' => $validated['tgl_checkout'],
            'jumlah_tamu' => $validated['jumlah_tamu'],
            'total_harga' => $total,
            'status_reservasi' => 'pending',
        ]);

        // Attach kamar ke reservasi
        $reservasi->kamar()->attach($validated['id_kamar'], [
            'harga_per_malam' => $kamar->harga_per_malam
        ]);

        // Buat record pembayaran otomatis dengan status pending
        Pembayaran::create([
            'id_reservasi' => $reservasi->id,
            'jumlah' => $total,
            'status_bayar' => 'pending',
            'metode_bayar' => null,
        ]);

        return redirect()->route('reservations.confirmation', $reservasi->id)
            ->with('success', 'Pemesanan berhasil dibuat!');
    }

    // Tampilkan konfirmasi pemesanan
    public function show($id)
    {
        $reservasi = Reservasi::with('penyewa', 'kamar')->findOrFail($id);
        $pembayaran = Pembayaran::where('id_reservasi', $reservasi->id)->first();
        return view('reservations.confirmation', compact('reservasi', 'pembayaran'));
    }
}
