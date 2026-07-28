@extends('layouts.app')

@section('title', 'Produk Video Sinematik | CINEMAHTE')

@section('content')
<section class="bg-[#0b0f19] text-gray-100 min-h-screen pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                What We Do Best
            </span>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white mt-6 mb-6 uppercase leading-none">
                Katalog Produk <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Video Kelas Industri</span>
            </h1>
            <p class="text-base sm:text-lg text-gray-400 font-light leading-relaxed">
                Kami menyediakan ekosistem produksi video ujung-ke-ujung (end-to-end processing). Mulai dari pra-produksi, shooting, hingga pasca-produksi ditangani oleh kru ahli.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
            @foreach($services as $service)
                <div class="group bg-[#0f1524] border border-gray-900 rounded-sm p-8 hover:border-amber-500/30 transition duration-500 flex flex-col justify-between shadow-xl">
                    <div>
                        <div class="w-14 h-14 bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 text-2xl rounded-sm mb-6 group-hover:bg-amber-500 group-hover:text-black transition duration-500 shadow-md">
                            <i class="{{ $service['icon'] }}"></i>
                        </div>
                        
                        <h2 class="text-xl sm:text-2xl font-bold uppercase text-white mb-4 tracking-wide group-hover:text-amber-400 transition">
                            {{ $service['title'] }}
                        </h2>
                        <p class="text-gray-400 font-light text-sm sm:text-base leading-relaxed mb-6">
                            {{ $service['short_desc'] }}
                        </p>

                        <ul class="space-y-3 border-t border-gray-800/60 pt-6 mb-8">
                            @foreach($service['features'] as $feature)
                                <li class="flex items-start text-xs sm:text-sm text-gray-300 font-light">
                                    <span class="text-amber-500 mr-3 mt-0.5"><i class="fas fa-check-circle text-xs"></i></span>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{ route('contact') }}" class="w-full text-center border border-gray-800 text-gray-400 group-hover:border-amber-500 group-hover:text-black group-hover:bg-amber-500 font-bold uppercase tracking-wider text-xs py-3 rounded-sm transition duration-300">
                        Konsultasi Bujet Project
                    </a>
                </div>
            @endforeach
        </div>

        <!-- Section Kapasitas Tim & Peralatan -->
        <div class="bg-[#0f1524] border border-gray-900 rounded-sm p-8 sm:p-12 mb-16 shadow-2xl">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <span class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-3 py-1.5 border border-amber-500/20 rounded-full">
                    Kapasitas Produksi & Peralatan
                </span>
                <h3 class="text-2xl sm:text-3xl font-bold uppercase text-white mt-4 tracking-wider">
                    Dukungan Tim & Peralatan Sinematik
                </h3>
                <p class="text-xs sm:text-sm text-gray-400 font-light mt-2">
                    Kami siap menangani eksekusi skala kecil hingga event akbar dengan kesiapan sumber daya manusia dan peralatan produksi yang matang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Manpower -->
                <div class="bg-[#090d16] border border-gray-800 p-6 rounded-sm flex flex-col justify-between hover:border-amber-500/40 transition duration-300">
                    <div>
                        <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center rounded-sm mb-4 text-xl">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white uppercase tracking-wide mb-2">18 Personel Kru Profesional</h4>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">
                            Total 18 tim kru terampil yang siap diterjunkan secara fleksibel untuk mendukung kelancaran produksi skala besar maupun kecil.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Multi-Camera -->
                <div class="bg-[#090d16] border border-gray-800 p-6 rounded-sm flex flex-col justify-between hover:border-amber-500/40 transition duration-300">
                    <div>
                        <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center rounded-sm mb-4 text-xl">
                            <i class="fas fa-video"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white uppercase tracking-wide mb-2">Setup 3 Kamera per Tim</h4>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">
                            Setiap tim eksekusi dibekali standar 3 unit kamera profesional untuk pengambilan gambar *multi-angle* yang dinamis dan komprehensif.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Drone Fleet -->
                <div class="bg-[#090d16] border border-gray-800 p-6 rounded-sm flex flex-col justify-between hover:border-amber-500/40 transition duration-300">
                    <div>
                        <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 flex items-center justify-center rounded-sm mb-4 text-xl">
                            <i class="fas fa-helicopter"></i>
                        </div>
                        <h4 class="text-lg font-bold text-white uppercase tracking-wide mb-2">Armada Drone FPV & Cinema</h4>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">
                            Dukungan unit udara lengkap (Drone FPV & Cinema) beserta pilot berlisensi resmi untuk menghasilkan visual udara yang spektakuler.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#090d16] border border-gray-900 rounded-sm p-8 sm:p-12 shadow-2xl">
            <h3 class="text-center text-xl sm:text-2xl font-bold uppercase text-white mb-12 tracking-wider">Alur Kerja Produksi Kami</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 relative">
                <div class="text-center space-y-4">
                    <div class="w-10 h-10 mx-auto bg-amber-500 text-black font-black flex items-center justify-center rounded-full text-sm shadow-lg shadow-amber-500/20">1</div>
                    <h4 class="text-sm font-bold uppercase text-white tracking-wider">Pra-Produksi</h4>
                    <p class="text-xs text-gray-500 font-light leading-relaxed">Diskusi konsep kreatif, pembuatan script/storyboard, perencanaan jadwal syuting, dan kalkulasi penawaran bujet.</p>
                </div>
                <div class="text-center space-y-4">
                    <div class="w-10 h-10 mx-auto bg-amber-500 text-black font-black flex items-center justify-center rounded-full text-sm shadow-lg shadow-amber-500/20">2</div>
                    <h4 class="text-sm font-bold uppercase text-white tracking-wider">Produksi (Syuting)</h4>
                    <p class="text-xs text-gray-500 font-light leading-relaxed">Eksekusi pengambilan video di lokasi menggunakan setup kamera profesional, drone FPV udara, lighting, serta audio capture.</p>
                </div>
                <div class="text-center space-y-4">
                    <div class="w-10 h-10 mx-auto bg-amber-500 text-black font-black flex items-center justify-center rounded-full text-sm shadow-lg shadow-amber-500/20">3</div>
                    <h4 class="text-sm font-bold uppercase text-white tracking-wider">Pasca-Produksi</h4>
                    <p class="text-xs text-gray-500 font-light leading-relaxed">Proses editing, penyelarasan warna (color grading), sound design/mixing, motion graphics infografis, hingga render final.</p>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection