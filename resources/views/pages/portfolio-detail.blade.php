@extends('layouts.app')

@section('title', $portfolio->title . ' | CINEMAHTEGRAPHY Showcase')

@section('content')
<article class="pt-32 pb-24 bg-[#0b0f19]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-400 hover:text-amber-500 transition mb-8 group">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition"></i> Kembali ke Beranda
        </a>

        <header class="mb-12">
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-amber-500 bg-amber-500/10 px-3 py-1 border border-amber-500/20 rounded-sm">
                    {{ $portfolio->category }}
                </span>
                @if($portfolio->project_scope)
                    <span class="text-xs font-bold uppercase tracking-widest {{ $portfolio->tag_scheme === 'B' ? 'text-white bg-blue-500 border-blue-500/20' : 'text-black bg-amber-500 border-amber-500/20' }} px-3 py-1 border rounded-sm">
                        @if($portfolio->tag_scheme === 'B')
                            <i class="fas fa-globe mr-1"></i>
                        @else
                            <i class="fas fa-star mr-1"></i>
                        @endif
                        {{ $portfolio->project_scope }}
                    </span>
                @endif
            </div>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white mt-4 uppercase leading-tight">
                {{ $portfolio->title }}
            </h1>
        </header>

        @if($portfolio->video_url)
        <div class="relative aspect-video w-full bg-black rounded-sm overflow-hidden shadow-2xl border border-gray-900 mb-12 group">
            <iframe class="absolute inset-0 w-full h-full" 
                    src="{{ $portfolio->video_url }}" 
                    title="YouTube video player" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
            </iframe>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 border-t border-gray-900 pt-10">
            <div class="md:col-span-2 space-y-4">
                <h2 class="text-lg font-bold text-white uppercase tracking-wider">Tentang Proyek</h2>
                <div class="text-gray-400 font-light leading-relaxed text-base sm:text-lg [&_p]:mb-4 [&_ul]:list-disc [&_ul]:ml-5 [&_ol]:list-decimal [&_ol]:ml-5 [&_strong]:font-bold [&_strong]:text-white [&_b]:font-bold [&_b]:text-white [&_em]:italic [&_i]:italic [&_u]:underline [&_a]:text-amber-500 [&_a]:underline [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:text-white [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-white [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-white">
                    {!! $portfolio->description !!}
                </div>
            </div>

            <div class="bg-[#0f1524] border border-gray-900 p-6 rounded-sm h-fit space-y-6">
                <div>
                    <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Nama Klien</h3>
                    <p class="text-sm font-semibold text-white">{{ $portfolio->client }}</p>
                </div>
                <div>
                    <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Tahun Produksi</h3>
                    <p class="text-sm font-semibold text-white">{{ $portfolio->year }}</p>
                </div>
                <div>
                    <h3 class="text-xs uppercase font-bold text-gray-500 tracking-wider mb-1">Cakupan Produk</h3>
                    <p class="text-sm font-semibold text-amber-500">{{ $portfolio->service_type }}</p>
                </div>
                
                <a href="{{ url('/#contact') }}" class="block text-center bg-amber-500 text-black py-3 rounded-sm text-xs font-bold uppercase tracking-wider hover:bg-amber-400 transition shadow-lg shadow-amber-500/10">
                    Diskusi Project Mirip
                </a>
            </div>
        </div>

    </div>
</article>
@endsection