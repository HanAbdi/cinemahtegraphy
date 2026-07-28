@extends('layouts.app')

@section('title', 'Kumpulan Portfolio Video Sinematik | CINEMAHTE')

@section('content')
<section class="bg-[#0b0f19] text-gray-100 min-h-screen pt-32 pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                Our Masterpieces
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white mt-6 mb-4 uppercase leading-none">
                Kumpulan <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Portofolio</span>
            </h1>
            <p class="text-sm sm:text-base text-gray-400 font-light leading-relaxed">
                Telusuri seluruh rekam jejak produksi video kami. Gunakan filter di bawah untuk melihat berdasarkan spesialisasi kategori proyek.
            </p>
        </div>

        <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-4 mb-16 border-b border-gray-900 pb-6">
            <button class="filter-btn active text-xs sm:text-sm font-bold uppercase tracking-wider px-5 py-2.5 bg-amber-500 text-black rounded-sm transition duration-300 cursor-pointer" data-category="all">
                All Projects
            </button>
            @php
                $existingCategories = $allPortfolios->pluck('category')->unique()->filter();
            @endphp
            @foreach($existingCategories as $cat)
                <button class="filter-btn text-xs sm:text-sm font-bold uppercase tracking-wider px-5 py-2.5 bg-[#0f1524] text-gray-400 border border-gray-900 rounded-sm hover:border-amber-500/30 hover:text-white transition duration-300 cursor-pointer" data-category="{{ $cat }}">
                    {{ $cat }}
                </button>
            @endforeach
        </div>

        <div id="portfolio-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($allPortfolios as $item)
                @php
                    $thumbnail = null;
                    if ($item->image_path) {
                        $thumbnail = asset('storage/' . $item->image_path);
                    } elseif ($item->video_url) {
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $item->video_url, $matches)) {
                            $thumbnail = 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
                        }
                    }
                @endphp
                <article class="portfolio-item group bg-[#0f1524] border border-gray-900 rounded-sm overflow-hidden hover:border-gray-800 transition duration-300 flex flex-col h-full shadow-lg" data-category="{{ $item->category }}">
                    
                    <div class="relative aspect-video bg-black overflow-hidden">
                        @if($thumbnail)
                            <img src="{{ $thumbnail }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80 group-hover:opacity-100">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-900">
                                <i class="fas fa-film text-4xl text-gray-700"></i>
                            </div>
                        @endif

                        @if($item->project_scope)
                            <span class="absolute top-4 left-4 {{ $item->tag_scheme === 'B' ? 'bg-blue-500 text-white' : 'bg-amber-500 text-black' }} font-black text-[10px] tracking-wider uppercase px-2.5 py-1 rounded-xs shadow-md z-10">
                                @if($item->tag_scheme === 'B')
                                    <i class="fas fa-globe text-[9px] mr-1"></i>
                                @else
                                    <i class="fas fa-star text-[9px] mr-1"></i>
                                @endif
                                {{ $item->project_scope }}
                            </span>
                        @endif

                        <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300">
                            <div class="w-14 h-14 bg-amber-500 rounded-full flex items-center justify-center text-black shadow-lg shadow-amber-500/20 transform scale-75 group-hover:scale-100 transition duration-300">
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
                            {{ Str::limit(strip_tags($item->description), 100) }}
                        </p>
                        <a href="{{ url('/portfolio/' . $item->id) }}" class="mt-auto text-xs font-semibold uppercase tracking-wider text-gray-300 hover:text-white border-b border-gray-800 hover:border-amber-500 pb-1 self-start transition duration-200">
                            Detail Proyek <i class="fas fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    // Logic Filter Frontend Interaktif Tanpa Reload Page (Biar Dosen Senang)
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Ubah Style Button Active
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-amber-500', 'text-black');
                btn.classList.add('bg-[#0f1524]', 'text-gray-400');
            });
            button.classList.remove('bg-[#0f1524]', 'text-gray-400');
            button.classList.add('bg-amber-500', 'text-black');

            const selectedCategory = button.getAttribute('data-category');

            // Saring Card Grid
            portfolioItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush