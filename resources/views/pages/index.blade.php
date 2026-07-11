@extends('layouts.app')

@section('title', 'CINEMAHTEGRAPHY | Home Cinematic Video Portfolio')

@section('content')

    <header class="relative h-screen w-full flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <video autoplay muted loop playsinline preload="auto"
                class="w-full h-full object-cover opacity-40 scale-105 filter brightness-75">
                <source src="{{ asset('assets/vid/hero-dummy.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0f19] via-[#0b0f19]/40 to-transparent"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto px-4 mt-12">
            <span
                class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                Video Production House
            </span>
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white mt-6 mb-6 leading-none uppercase">
                Experienced. <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Cinematic.</span>
                Economic.
            </h1>
            <p class="text-base sm:text-xl text-gray-400 max-w-2xl mx-auto mb-10 font-light">
                CINEMAHTEGRAPHY menghadirkan solusi pembuatan video corporate elegan berstandar industri nasional dengan
                efisiensi biaya optimal.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('portfolios.index') }}"
                    class="w-full sm:w-auto bg-amber-500 text-black text-center px-8 py-4 font-bold tracking-wider uppercase text-sm rounded-sm hover:bg-amber-400 transition duration-300 shadow-xl shadow-amber-500/10">
                    <i class="fas fa-play mr-2 text-xs"></i> Lihat Karya Kami
                </a>
                <a href="{{ route('contact') }}"
                    class="w-full sm:w-auto border border-gray-700 text-white text-center px-8 py-4 font-bold tracking-wider uppercase text-sm rounded-sm hover:bg-white hover:text-black transition duration-300">
                    Minta Penawaran Harga
                </a>
            </div>
        </div>
    </header>

    <section class="py-12 bg-[#090d16] border-y border-gray-900 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-xs font-semibold tracking-widest text-gray-500 uppercase mb-8">
                Dipercaya oleh Berbagai Perusahaan Terkemuka
            </p>
            
            @if($clients->count() > 6)
                <!-- Marquee Container (Sliding Left to Right) -->
                <div class="relative overflow-hidden py-4 w-full group">
                    <div class="flex w-max animate-marquee-ltr group-hover:[animation-play-state:paused]">
                        <!-- Set 1 -->
                        @foreach($clients as $client)
                            <div class="flex-none w-40 sm:w-56 flex justify-center items-center px-4 sm:px-8">
                                <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="h-10 object-contain client-logo-filter">
                            </div>
                        @endforeach
                        <!-- Set 2 -->
                        @foreach($clients as $client)
                            <div class="flex-none w-40 sm:w-56 flex justify-center items-center px-4 sm:px-8">
                                <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="h-10 object-contain client-logo-filter">
                            </div>
                        @endforeach
                        <!-- Set 3 -->
                        @foreach($clients as $client)
                            <div class="flex-none w-40 sm:w-56 flex justify-center items-center px-4 sm:px-8">
                                <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="h-10 object-contain client-logo-filter">
                            </div>
                        @endforeach
                        <!-- Set 4 -->
                        @foreach($clients as $client)
                            <div class="flex-none w-40 sm:w-56 flex justify-center items-center px-4 sm:px-8">
                                <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}" class="h-10 object-contain client-logo-filter">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Normal Grid if few logos (Rata Kanan Kiri) -->
                <div class="flex flex-wrap justify-evenly items-center px-4 py-4 w-full">
                    @forelse($clients as $client)
                        <img src="{{ Storage::url($client->logo_path) }}" alt="{{ $client->name }}"
                            class="h-10 object-contain client-logo-filter">
                    @empty
                        <p class="text-gray-600 text-sm italic">Belum ada logo klien yang ditambahkan.</p>
                    @endforelse
                </div>
            @endif
        </div>
    </section>

    <section id="portfolio" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div>
                <h2 class="text-xs uppercase tracking-widest text-amber-500 font-bold mb-3">Featured Showcases</h2>
                <p class="text-3xl sm:text-4xl font-black text-white uppercase">Karya Pilihan Sinematik</p>
            </div>
            <a href="{{ route('portfolios.index') }}"
                class="mt-4 md:mt-0 text-sm font-bold text-amber-500 hover:text-amber-400 group items-center inline-flex">
                Lihat Semua Portofolio <i
                    class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($portfolios as $item)
                <article
                    class="group bg-[#0f1524] border border-gray-900 rounded-sm overflow-hidden hover:border-gray-800 transition duration-300 flex flex-col h-full shadow-lg">
                    <div class="relative aspect-video bg-black overflow-hidden">
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80 group-hover:opacity-100">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-900">
                                <i class="fas fa-film text-4xl text-gray-700"></i>
                            </div>
                        @endif

                        @if($item->project_scope === 'Nasional')
                            <span
                                class="absolute top-4 left-4 bg-amber-500 text-black font-black text-[10px] tracking-wider uppercase px-2.5 py-1 rounded-xs shadow-md">
                                <i class="fas fa-star text-[9px] mr-1"></i> Proyek Nasional
                            </span>
                        @endif

                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300">
                            <div
                                class="w-14 h-14 bg-amber-500 rounded-full flex items-center justify-center text-black shadow-lg shadow-amber-500/20 transform scale-75 group-hover:scale-100 transition duration-300">
                                <i class="fas fa-play text-lg ml-1"></i>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <span class="text-[11px] uppercase tracking-widest text-amber-500 font-bold mb-2 block">
                            {{ $item->category }}
                        </span>
                        <h3 class="text-lg font-bold text-white mb-3 line-clamp-1 group-hover:text-amber-400 transition">
                            {{ $item->title }}
                        </h3>
                        <p class="text-sm text-gray-400 line-clamp-2 font-light leading-relaxed mb-4">
                            {{ strip_tags($item->description) }}
                        </p>
                        <a href="{{ route('portfolio.detail', $item->id) }}"
                            class="mt-auto text-xs font-semibold uppercase tracking-wider text-gray-300 hover:text-white border-b border-gray-800 hover:border-amber-500 pb-1 self-start transition duration-200">
                            Detail Proyek <i class="fas fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

@endsection