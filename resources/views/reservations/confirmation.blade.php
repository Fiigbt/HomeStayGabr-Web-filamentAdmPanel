@extends('layouts.app')

@section('title', 'Konfirmasi Pemesanan - HomeStay')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <!-- Success Badge -->
    <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4 animate-bounce">
            <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Pemesanan Berhasil!</h1>
        <p class="text-gray-600 text-lg">Terima kasih telah memilih HomeStay Kami</p>
    </div>

    @php
        $kamar = $reservasi->kamar->first();
        $fotoCover = $kamar?->fotos?->firstWhere('is_cover', true) ?? $kamar?->fotos?->first();
        $checkin = \Carbon\Carbon::parse($reservasi->tgl_checkin);
        $checkout = \Carbon\Carbon::parse($reservasi->tgl_checkout);
        $nights = $checkout->diffInDays($checkin);
    @endphp

    <!-- Detail Pemesanan -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b">Detail Pemesanan Anda</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

            <!-- Penyewa -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                    </svg>
                    Informasi Penyewa
                </h3>
                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Nama Penyewa</p>
                        <p class="font-semibold text-gray-900">{{ $reservasi->penyewa->nama_penyewa }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $reservasi->penyewa->email }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $reservasi->penyewa->no_tlp }}</p>
                    </div>
                </div>
            </div>

            <!-- Kamar -->
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Informasi Kamar
                </h3>

                <div class="h-40 rounded-lg overflow-hidden mb-4 bg-gray-200">
                    @if($fotoCover)
                        <img src="{{ asset('storage/' . $fotoCover->url) }}" alt="{{ $kamar->nomor_kamar }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Nomor Kamar</p>
                        <p class="font-semibold text-gray-900">{{ $kamar->nomor_kamar }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Kapasitas</p>
                        <p class="font-semibold text-gray-900">{{ $kamar->kapasitas }} tamu</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Harga per Malam</p>
                        <p class="font-semibold text-gray-900">Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-8">

        <!-- Tanggal & Biaya -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v2H4a2 2 0 00-2 2v2h16V7a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v2H7V3a1 1 0 00-1-1zm0 5a2 2 0 002 2h8a2 2 0 002-2H6z" clip-rule="evenodd"></path>
                    </svg>
                    Tanggal Menginap
                </h3>
                <div class="space-y-3">
                    <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Check-in</p>
                        <p class="font-semibold text-gray-900">{{ $checkin->format('d M Y') }}</p>
                    </div>
                    <div class="bg-blue-50 border border-blue-200 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Check-out</p>
                        <p class="font-semibold text-gray-900">{{ $checkout->format('d M Y') }}</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Jumlah Malam</p>
                        <p class="font-semibold text-gray-900">{{ $nights }} malam</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                    Ringkasan Biaya
                </h3>
                <div class="space-y-3">
                    <div class="bg-gray-50 p-3 rounded-lg flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg flex justify-between">
                        <span class="text-gray-600">Biaya Layanan:</span>
                        <span class="font-semibold">Rp 0</span>
                    </div>
                    <div class="bg-blue-50 border-2 border-blue-600 p-4 rounded-lg flex justify-between items-center">
                        <span class="font-bold text-lg text-gray-900">Total Pembayaran:</span>
                        <span class="font-bold text-2xl text-blue-600">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Pembayaran -->
    <div class="rounded-xl p-6 mb-8
        @if($pembayaran?->status_bayar === 'paid') bg-green-50 border-2 border-green-400
        @elseif($pembayaran?->status_bayar === 'confirmed') bg-blue-50 border-2 border-blue-400
        @else bg-yellow-50 border-2 border-yellow-400 @endif">

        <div class="flex items-start gap-3">
            @if($pembayaran?->status_bayar === 'paid')
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-green-900 mb-1">Pembayaran Dikonfirmasi</h3>
                    <p class="text-green-800 text-sm">Terima kasih. Pemesanan Anda sudah dikonfirmasi dan siap untuk check-in.</p>
                </div>
            @elseif($pembayaran?->status_bayar === 'confirmed')
                <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-blue-900 mb-1">Pembayaran Terverifikasi</h3>
                    <p class="text-blue-800 text-sm">Pembayaran Anda telah diverifikasi. Tunggu email konfirmasi untuk detail check-in.</p>
                </div>
            @else
                <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <div class="flex-1">
                    <h3 class="font-bold text-yellow-900 mb-1">Menunggu Pembayaran</h3>
                    <p class="text-yellow-800 text-sm">Pemesanan akan dibatalkan jika tidak ada pembayaran dalam 24 jam. Silakan hubungi kami untuk melanjutkan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Pembayaran -->
    @if($pembayaran)
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
            </svg>
            Detail Pembayaran
        </h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="text-gray-600">Jumlah Pembayaran:</span>
                <span class="font-bold text-lg">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="text-gray-600">Status:</span>
                <span class="@if($pembayaran->status_bayar === 'paid') bg-green-100 text-green-800 @elseif($pembayaran->status_bayar === 'confirmed') bg-blue-100 text-blue-800 @else bg-yellow-100 text-yellow-800 @endif px-3 py-1 rounded-full text-sm font-bold">
                    {{ ucfirst($pembayaran->status_bayar) }}
                </span>
            </div>
            @if($pembayaran->metode_bayar)
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="text-gray-600">Metode:</span>
                <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_bayar)) }}</span>
            </div>
            @endif
            @if($pembayaran->tgl_bayar)
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Tanggal Pembayaran:</span>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d M Y H:i') }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Next Steps -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1h-2a1 1 0 100 2 2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm2-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
            </svg>
            Langkah Berikutnya
        </h3>
        <ol class="space-y-4">
            <li class="flex gap-3">
                <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-sm">1</span>
                <div>
                    <p class="font-bold text-gray-900">Hubungi Kami</p>
                    <p class="text-gray-600 text-sm">Hubungi customer service kami untuk detail pembayaran</p>
                </div>
            </li>
            <li class="flex gap-3">
                <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-sm">2</span>
                <div>
                    <p class="font-bold text-gray-900">Transfer Pembayaran</p>
                    <p class="text-gray-600 text-sm">Lakukan transfer ke rekening bank yang telah diberikan</p>
                </div>
            </li>
            <li class="flex gap-3">
                <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-sm">3</span>
                <div>
                    <p class="font-bold text-gray-900">Konfirmasi Pembayaran</p>
                    <p class="text-gray-600 text-sm">Setelah transfer, hubungi kami untuk konfirmasi pembayaran</p>
                </div>
            </li>
            <li class="flex gap-3">
                <span class="flex-shrink-0 flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 text-white font-bold text-sm">4</span>
                <div>
                    <p class="font-bold text-gray-900">Siap untuk Check-in</p>
                    <p class="text-gray-600 text-sm">Tunggu email konfirmasi. Anda siap untuk melakukan check-in</p>
                </div>
            </li>
        </ol>
    </div>

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('reservations.index') }}"
           class="inline-flex items-center gap-2 px-8 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 font-bold transition-colors">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
            </svg>
            Kembali ke Daftar Kamar
        </a>
    </div>

</div>
@endsection
