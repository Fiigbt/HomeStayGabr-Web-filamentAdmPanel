@extends('layouts.app')

@section('title', 'Pesan Kamar - HomeStay')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Form Pemesanan Kamar</h1>
    <p class="text-gray-600 text-lg mb-8">Isi formulir di bawah untuk melanjutkan pemesanan Anda</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Kolom Kiri: Detail Kamar -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Kamar</h3>
                
                @php
                    $fotoCover = $kamar->fotos->firstWhere('is_cover', true) ?? $kamar->fotos->first();
                @endphp
                <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center relative overflow-hidden">
                    @if($fotoCover)
                        <img src="{{ asset('storage/' . $fotoCover->url) }}" alt="{{ $kamar->nomor_kamar }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    @endif
                </div>

                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Nomor Kamar</p>
                        <p class="text-lg font-bold text-gray-900">{{ $kamar->nomor_kamar }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kapasitas</p>
                        <p class="text-lg font-bold text-gray-900">{{ $kamar->kapasitas }} tamu</p>
                    </div>
                    <div class="border-t pt-3">
                        <p class="text-sm text-gray-500">Harga per Malam</p>
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Form -->
        <div class="md:col-span-2">
            <form action="{{ route('reservations.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-8">
                @csrf

                <!-- Info Penyewa -->
                <h3 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Data Penyewa</h3>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-600">*</span></label>
                    <input type="text" name="nama_penyewa" value="{{ old('nama_penyewa') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan nama lengkap">
                    @error('nama_penyewa')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan email">
                    @error('email')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon <span class="text-red-600">*</span></label>
                    <input type="tel" name="no_tlp" value="{{ old('no_tlp') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Masukkan nomor telepon">
                    @error('no_tlp')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal Pemesanan -->
                <h3 class="text-2xl font-bold text-gray-900 mb-6 mt-8 pb-4 border-b">Detail Pemesanan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Check-in <span class="text-red-600">*</span></label>
                        <input type="date" name="tgl_checkin" value="{{ old('tgl_checkin') }}" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" onchange="calculateTotal()">
                        @error('tgl_checkin')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Check-out <span class="text-red-600">*</span></label>
                        <input type="date" name="tgl_checkout" value="{{ old('tgl_checkout') }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" onchange="calculateTotal()">
                        @error('tgl_checkout')
                            <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Tamu <span class="text-red-600">*</span></label>
                    <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" required min="1" max="{{ $kamar->kapasitas }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    @error('jumlah_tamu')
                        <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Hidden Field -->
                <input type="hidden" name="id_kamar" value="{{ $kamar->id }}">

                <!-- Kalkulasi Total -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 mb-6 border border-blue-200">
                    <h4 class="font-bold text-gray-900 mb-4">Ringkasan Harga</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Harga per Malam:</span>
                            <span class="font-semibold">Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Jumlah Malam:</span>
                            <span class="font-semibold" id="nights">0</span>
                        </div>
                        <div class="border-t border-blue-200 pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-lg text-gray-900">Total Harga:</span>
                                <span class="font-bold text-xl text-blue-600" id="total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Button Submit -->
                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 font-bold text-lg flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"></path>
                    </svg>
                    Lanjutkan ke Pembayaran
                </button>

                <a href="{{ route('reservations.index') }}" class="block text-center mt-4 text-gray-600 hover:text-gray-900 transition">
                    Kembali ke Daftar Kamar
                </a>
            </form>
        </div>
    </div>
</div>

<script>
function calculateTotal() {
    const hargaPerMalam = {{ $kamar->harga_per_malam }};
    const checkin = new Date(document.querySelector('input[name="tgl_checkin"]').value);
    const checkout = new Date(document.querySelector('input[name="tgl_checkout"]').value);
    
    if (checkin && checkout && checkout > checkin) {
        const nights = Math.ceil((checkout - checkin) / (1000 * 60 * 60 * 24));
        const total = hargaPerMalam * nights;
        
        document.getElementById('nights').textContent = nights;
        document.getElementById('total').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
}

// Hitung saat halaman load
document.addEventListener('DOMContentLoaded', calculateTotal);
</script>
@endsection