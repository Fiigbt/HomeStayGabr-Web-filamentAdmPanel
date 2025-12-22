<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeStay - Tempat Menginap Terbaik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg hero-gradient flex items-center justify-center text-white font-bold text-lg">H</div>
                    <a href="/" class="text-2xl font-bold text-gray-900">HomeStay</a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-blue-600 transition font-medium">Beranda</a>
                    <a href="#kamar" class="text-gray-700 hover:text-blue-600 transition font-medium">Kamar</a>
                    <a href="#features" class="text-gray-700 hover:text-blue-600 transition font-medium">Fitur</a>
                    <a href="{{ route('reservations.index') }}" class="px-6 py-2 btn-primary text-white rounded-lg font-semibold">Pesan Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white pt-32 pb-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">Temukan Kenyamanan Menginap di HomeStay</h1>
                    <p class="text-xl mb-8 text-blue-100 leading-relaxed">Nikmati pengalaman menginap yang tak terlupakan dengan harga terjangkau dan pelayanan terbaik. Pilih kamar impian Anda hari ini.</p>
                    <div class="flex gap-4">
                        <a href="{{ route('reservations.index') }}" class="px-8 py-4 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition">Cari Kamar</a>
                        <a href="#features" class="px-8 py-4 border-2 border-white text-white rounded-lg font-bold hover:bg-white hover:text-blue-600 transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-gradient-to-br from-blue-300 to-purple-400 rounded-2xl aspect-square flex items-center justify-center">
                        <svg class="w-48 h-48 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5.353-1.008.066.54-.066-.54 5.353 1.008a1 1 0 001.169-1.409l-7-14z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kamar Preview Section -->
    <section id="kamar" class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Koleksi Kamar Premium</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">Pilih dari berbagai pilihan kamar yang dirancang untuk kenyamanan maksimal Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kamar Card 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md card-hover">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kamar Standard</h3>
                        <p class="text-gray-600 mb-4">Kamar nyaman dengan fasilitas lengkap untuk keluarga kecil</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">Rp 150K</span>
                            <span class="text-sm text-gray-500">/malam</span>
                        </div>
                    </div>
                </div>

                <!-- Kamar Card 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md card-hover">
                    <div class="h-48 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kamar Deluxe</h3>
                        <p class="text-gray-600 mb-4">Kamar mewah dengan pemandangan bagus dan AC premium</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-purple-600">Rp 250K</span>
                            <span class="text-sm text-gray-500">/malam</span>
                        </div>
                    </div>
                </div>

                <!-- Kamar Card 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-md card-hover">
                    <div class="h-48 bg-gradient-to-br from-pink-400 to-pink-600 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-30" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Kamar Suite</h3>
                        <p class="text-gray-600 mb-4">Kamar VIP dengan area kerja dan fasilitas terlengkap</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-pink-600">Rp 400K</span>
                            <span class="text-sm text-gray-500">/malam</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('reservations.index') }}" class="inline-block px-8 py-3 btn-primary text-white rounded-lg font-bold">Lihat Semua Kamar</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih HomeStay?</h2>
                <p class="text-gray-600 text-lg">Kami menyediakan layanan terbaik untuk kenyamanan Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a6 6 0 100 12h.5a1.5 1.5 0 001.5-1.5V4a2 2 0 00-2-2 1 1 0 10 2h-.5A1.5 1.5 0 004 5.5V16a2 2 0 002 2h12a2 2 0 002-2v-5.5a1.5 1.5 0 00-1.5-1.5H14a1 1 0 100 2h.5a.5.5 0 01.5.5V16H6V5.5a.5.5 0 01.5-.5H4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                    <p class="text-gray-600">Dapatkan kamar berkualitas dengan harga yang sangat kompetitif</p>
                </div>

                <div class="text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600">Terletak di pusat kota dengan akses mudah ke berbagai tempat</p>
                </div>

                <div class="text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda kapan saja, siang maupun malam</p>
                </div>

                <div class="text-center">
                    <div class="feature-icon mx-auto mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Terjamin Aman</h3>
                    <p class="text-gray-600">Keamanan Anda adalah prioritas utama dengan sistem keamanan canggih</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 px-4 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Tamu Kami?</h2>
                <p class="text-gray-600 text-lg">Ribuan tamu puas telah merasakan kenyamanan di HomeStay</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500 text-white flex items-center justify-center font-bold">B</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Budi Santoso</h4>
                            <p class="text-sm text-gray-500">Jakarta, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600">"Pelayanan sangat memuaskan, kamarnya bersih dan nyaman. Harga juga sangat terjangkau. Pasti akan menginap lagi!"</p>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-purple-500 text-white flex items-center justify-center font-bold">S</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Siti Nurhaliza</h4>
                            <p class="text-sm text-gray-500">Bandung, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600">"Lokasi sangat strategis, dekat dengan berbagai tempat wisata. Staff-nya ramah dan membantu. Rekomendasi 5 bintang!"</p>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-pink-500 text-white flex items-center justify-center font-bold">A</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Ahmad Wijaya</h4>
                            <p class="text-sm text-gray-500">Surabaya, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex mb-2">
                        <span class="text-yellow-400">★★★★★</span>
                    </div>
                    <p class="text-gray-600">"Fasilitas lengkap, WiFi cepat, dan AC dingin. Cocok untuk bisnis maupun liburan. Sangat merekomendasikan!"</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="hero-gradient text-white py-16 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Untuk Pengalaman Menginap Terbaik?</h2>
            <p class="text-xl mb-8 text-blue-100">Pesan kamar Anda sekarang dan dapatkan harga spesial untuk pemesanan hari ini</p>
            <a href="{{ route('reservations.index') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition">Pesan Kamar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 rounded-lg hero-gradient"></div>
                        <h3 class="text-xl font-bold">HomeStay</h3>
                    </div>
                    <p class="text-gray-400">Tempat terbaik untuk menginap saat Anda berpergian</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('reservations.index') }}" class="hover:text-white transition">Kamar</a></li>
                        <li><a href="#features" class="hover:text-white transition">Fitur</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Kontak</h4>
                    <p class="text-gray-400 mb-2">Email: info@homestay.com</p>
                    <p class="text-gray-400 mb-2">Telepon: +62 123 456 789</p>
                    <p class="text-gray-400">WhatsApp: +62 123 456 789</p>
                </div>
                <div>
                    <h4 class="text-lg font-bold mb-4">Jam Operasional</h4>
                    <p class="text-gray-400 mb-2">Senin - Jumat</p>
                    <p class="text-gray-400 mb-2">09:00 - 18:00 WIB</p>
                    <p class="text-gray-400 text-sm">Sabtu - Minggu: 10:00 - 20:00</p>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 HomeStay. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
