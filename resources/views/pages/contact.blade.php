@extends('layouts.app')

@section('title', 'Hubungi Kami & Request Penawaran | CINEMAHTEGRAPHY')

@section('content')
    <section class="bg-[#0b0f19] text-gray-100 min-h-screen pt-32 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-2xl mx-auto mb-16">
                <span
                    class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                    Get In Touch
                </span>
                <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white mt-6 mb-4 uppercase leading-none">
                    Mulai Proyek <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Video Anda</span>
                </h1>
                <p class="text-sm sm:text-base text-gray-400 font-light leading-relaxed">
                    Siap meningkatkan nilai visual brand atau korporasi Anda? Isi formulir brief di bawah, tim kami akan
                    segera membalas dengan draf penawaran harga terbaik.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-[#0f1524] border border-gray-900 rounded-sm p-8 space-y-8 shadow-xl">
                        <h2 class="text-lg font-bold uppercase text-white tracking-wider border-b border-gray-800 pb-4">
                            Informasi Kantor</h2>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-sm flex items-center justify-center text-amber-500 shrink-0">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Alamat Utama</h3>
                                <p class="text-sm text-gray-300 font-light leading-relaxed"> Jl. Cakra Sentosa Block z No.3
                                    - Wisma
                                    Cakra. Kel. Limo - Kec Limo - Cinere Depok</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-sm flex items-center justify-center text-amber-500 shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Korespondensi
                                    Email</h3>
                                <p class="text-sm text-gray-300 font-light">info@cinemahtegraphy.com</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div
                                class="w-10 h-10 bg-amber-500/10 border border-amber-500/20 rounded-sm flex items-center justify-center text-amber-500 shrink-0">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Hotline / WhatsApp
                                </h3>
                                <p class="text-sm text-gray-300 font-light">(+62) 123-456-789</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-full aspect-video bg-gray-950 border border-gray-900 rounded-sm overflow-hidden shadow-xl opacity-70 hover:opacity-100 transition duration-500">
                        <iframe
                            src="https://maps.google.com/maps?q=Jl.%20Cakra%20Sentosa%20Block%20z%20No.3%20-%20Wisma%20Cakra.%20Kel.%20Limo%20-%20Kec%20Limo%20-%20Cinere%20Depok&t=&z=16&ie=UTF8&iwloc=&output=embed"
                            class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <div class="lg:col-span-7 bg-[#0f1524] border border-gray-900 rounded-sm p-8 sm:p-10 shadow-2xl">
                    <h2 class="text-lg font-bold uppercase text-white tracking-wider mb-2">Request Penawaran Harga</h2>
                    <p class="text-xs text-gray-400 font-light mb-8 border-b border-gray-800 pb-4">Silakan isi formulir di
                        bawah ini dengan lengkap untuk mendapatkan kalkulasi estimasi anggaran.</p>

                    @if(session('success'))
                        <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-sm mb-6 flex items-center gap-3">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Honeypot Field -->
                        <input type="text" name="website_url" class="absolute opacity-0 -z-10" tabindex="-1" autocomplete="off">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Nama
                                    Lengkap / Instansi</label>
                                <input type="text" id="name" name="name" required
                                    placeholder="Contoh: Budi Sudarsono / PT. Maju Jaya"
                                    class="w-full bg-[#0c111d] border border-gray-800/80 rounded-sm px-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300">
                            </div>
                            <div class="space-y-2">
                                <label for="email"
                                    class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Alamat Email
                                    Resmi</label>
                                <input type="email" id="email" name="email" required placeholder="Contoh: budi@company.com"
                                    class="w-full bg-[#0c111d] border border-gray-800/80 rounded-sm px-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="phone"
                                    class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Nomor Handphone /
                                    WA</label>
                                <input type="tel" id="phone" name="phone" required placeholder="Contoh: 628123456789"
                                    class="w-full bg-[#0c111d] border border-gray-800/80 rounded-sm px-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300">
                            </div>
                            <div class="space-y-2">
                                <label for="subject"
                                    class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Subjek
                                    Project</label>
                                <input type="text" id="subject" name="subject" required
                                    placeholder="Contoh: Penawaran Video Profile Pabrik"
                                    class="w-full bg-[#0c111d] border border-gray-800/80 rounded-sm px-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="message"
                                class="text-xs uppercase font-semibold text-gray-400 tracking-wider">Jelaskan Singkat
                                Rencana Project Video Anda</label>
                            <textarea id="message" name="message" rows="5" required
                                placeholder="Tuliskan durasi video, rencana lokasi shooting, perkiraan timeline pengerjaan, atau referensi gaya visual yang Anda inginkan..."
                                class="w-full bg-[#0c111d] border border-gray-800/80 rounded-sm px-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300 resize-none"></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-amber-500 text-black font-bold uppercase tracking-wider text-xs py-4 rounded-sm hover:bg-amber-400 transition duration-300 shadow-lg shadow-amber-500/10 cursor-pointer">
                            Kirim Formulir Brief <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection