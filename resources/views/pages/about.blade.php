@extends('layouts.app')

@section('title', 'Tentang Kami | CINEMAHTE')

@section('content')
<section class="bg-[#0b0f19] text-gray-100 min-h-screen pt-32 pb-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                Behind The Lens
            </span>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white mt-6 mb-6 uppercase leading-none">
                Mengukir Reputasi <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Lewat Cerita Visual</span>
            </h1>
            <p class="text-base sm:text-lg text-gray-400 font-light leading-relaxed">
                CINEMAHTE hadir sebagai production house spesialis pembuatan video corporate profesional nasional yang mengedepankan kualitas sinematik papan atas dengan efisiensi biaya.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
            <div class="relative group aspect-square bg-[#0f1524] rounded-sm overflow-hidden border border-gray-800 shadow-2xl flex items-center justify-center">
                <img src="{{ asset('assets/img/about.jpeg') }}" 
                     alt="Anril Film Production Crew" 
                     class="w-full h-full object-contain group-hover:scale-102 transition duration-700">
            </div>

            <div class="space-y-6">
                <h2 class="text-2xl font-bold uppercase text-white tracking-wider">Kreativitas Tanpa Batas, Pengalaman 20 Tahun</h2>
                <p class="text-gray-400 font-light leading-relaxed">
                    Lebih dari sekadar merekam gambar, kami mengolah setiap frame menjadi identitas visual murni yang berkelas. Didukung oleh tim kreator, sutradara, dan videografer berpengalaman industri, kami memahami cara menyampaikan pesan korporasi secara emosional dan struktural.
                </p>
                <p class="text-gray-400 font-light leading-relaxed">
                    Setiap pengerjaan video kami lakukan menggunakan teknologi sinematik mutakhir berstandar industri penyiaran, termasuk pemanfaatan Drone FPV Oneshot canggih guna menangkap presisi megahnya lanskap bisnis Anda dari udara.
                </p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                    <div class="bg-[#0f1524] p-5 border border-gray-900 rounded-sm">
                        <h3 class="text-sm font-bold text-amber-500 uppercase tracking-wider mb-2"><i class="fas fa-eye mr-2"></i> Visi Kami</h3>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">Menjadi production house andalan utama korporat nasional dalam membentuk reputasi visual digital kelas dunia.</p>
                    </div>
                    <div class="bg-[#0f1524] p-5 border border-gray-900 rounded-sm">
                        <h3 class="text-sm font-bold text-amber-500 uppercase tracking-wider mb-2"><i class="fas fa-bullseye mr-2"></i> Misi Kami</h3>
                        <p class="text-xs text-gray-400 font-light leading-relaxed">Menghadirkan layanan video bernilai estetika tinggi, transparan, dan ekonomis bagi pertumbuhan bisnis klien.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#090d16] border border-gray-900 rounded-sm p-8 sm:p-12 shadow-xl">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y lg:divide-y-0 lg:divide-x divide-gray-800/60">
                @foreach($stats as $stat)
                    <div class="pt-6 lg:pt-0 first:pt-0">
                        <p class="text-4xl sm:text-5xl font-black text-amber-500 tracking-tight mb-2">{{ $stat['number'] }}</p>
                        <p class="text-xs sm:text-sm uppercase font-semibold text-gray-400 tracking-widest">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@endsection