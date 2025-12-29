@extends('layouts.app')

@section('title', 'Daftar Kamar - HomeStay')

@section('content')
<div class="mb-12">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">Daftar Kamar Kami</h1>
            <p class="text-gray-600 mt-2 text-lg">Pilih kamar yang sesuai dengan kebutuhan dan budget Anda</p>
        </div>
        <div class="flex gap-2">
            <a href="/" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 transition">Kembali ke Beranda</a>
        </div>
    </div>
</div>

<!-- Daftar Kamar -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    @forelse($kamar as $item)
        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 hover:transform hover:-translate-y-2">
            <!-- Kamar Image -->
            @php
                $fotoCover = $item->fotos->firstWhere('is_cover', true) ?? $item->fotos->first();
            @endphp
            <div class="h-56 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
                @if($fotoCover)
                    <img src="{{ asset('storage/' . $fotoCover->url) }}" alt="{{ $item->nomor_kamar }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <svg class="w-24 h-24 text-white relative z-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                @endif
            </div>

            <!-- Kamar Info -->
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $item->nomor_kamar }}</h3>
                        @if(in_array($item->id, $kamarDiPesan))
                            <p class="text-sm text-red-500">Sedang dipesan</p>
                        @else
                            <p class="text-sm text-gray-500">Kamar tersedia</p>
                        @endif
                    </div>
                    @if(in_array($item->id, $kamarDiPesan))
                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-bold rounded-full">
                            DIPESAN
                        </span>
                    @else
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                            TERSEDIA
                        </span>
                    @endif
                </div>

                <!-- Amenities -->
                <div class="space-y-2 mb-4 text-sm text-gray-600 py-3 border-y">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2h8z"></path>
                        </svg>
                        <span>Kapasitas: <strong>{{ $item->kapasitas }} tamu</strong></span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 6a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zm0 8a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Luas: <strong>{{ $item->luas ?? 'N/A' }} m²</strong></span>
                    </div>
                </div>

                <!-- Harga -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600">Harga per Malam</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($item->harga_per_malam, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Booking Button -->
                @if(in_array($item->id, $kamarDiPesan))
                    <button disabled class="w-full bg-gray-400 text-white py-3 rounded-lg cursor-not-allowed font-bold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 2.526a6 6 0 008.367 8.368zm1.414-1.414A8 8 0 11.707.707a8 8 0 0112.084 12.084z" clip-rule="evenodd"></path>
                        </svg>
                        Kamar Dipesan
                    </button>
                @else
                    <button onclick="window.location.href='{{ route('reservations.create', $item->id) }}'" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 font-bold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM15.657 14.243a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM11 17a1 1 0 102 0v-1a1 1 0 10-2 0v1zM5.757 15.657a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM2 10a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.757 5.757a1 1 0 000-1.414L5.05 3.636a1 1 0 10-1.414 1.414l.707.707z"></path>
                        </svg>
                        Pesan Sekarang
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl p-12 text-center shadow-md">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-gray-600 text-lg font-medium">Kamar tidak tersedia</p>
                <p class="text-gray-500 mt-1">Silakan coba lagi nanti atau hubungi kami untuk informasi lebih lanjut</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($kamar->hasPages())
    <div class="flex justify-center">
        <nav class="flex gap-2">
            {{ $kamar->links() }}
        </nav>
    </div>
@endif
@endsection