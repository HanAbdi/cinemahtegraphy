@extends('layouts.app')

@section('title', 'Frequently Asked Questions | CINEMAHTEGRAPHY')

@section('content')
<section class="bg-[#0b0f19] text-gray-100 min-h-screen pt-32 pb-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-xs uppercase tracking-widest text-amber-500 font-bold bg-amber-500/10 px-4 py-2 border border-amber-500/20 rounded-full">
                Common Questions
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-white mt-6 mb-4 uppercase leading-none">
                Pertanyaan <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600">Populer</span>
            </h1>
            <p class="text-sm sm:text-base text-gray-400 font-light leading-relaxed">
                Punya pertanyaan seputar alur kerja, harga, atau lisensi produksi video kami? Temukan jawaban ringkasnya di bawah ini.
            </p>
        </div>

        <div class="space-y-4 mb-20">
            @foreach($faqs as $index => $item)
                <div class="faq-item bg-[#0f1524] border border-gray-900 rounded-sm overflow-hidden transition duration-300">
                    <button class="faq-toggle w-full flex items-center justify-between p-6 text-left focus:outline-none group">
                        <span class="text-sm sm:text-base font-bold uppercase text-white tracking-wide group-hover:text-amber-400 transition duration-300">
                            {{ $item['question'] }}
                        </span>
                        <span class="faq-icon text-gray-500 group-hover:text-amber-500 transition duration-300 ml-4">
                            <i class="fas fa-chevron-down transform transition-transform duration-300"></i>
                        </span>
                    </button>

                    <div class="faq-content max-h-0 opacity-0 transition-all duration-300 ease-in-out bg-[#0c111d]">
                        <div class="p-6 text-xs sm:text-sm text-gray-400 font-light leading-relaxed border-t border-gray-900/40">
                            {{ $item['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-gradient-to-r from-amber-500/10 to-transparent border border-amber-500/20 rounded-sm p-8 text-center sm:text-left sm:flex sm:items-center sm:justify-between gap-6 shadow-xl">
            <div class="space-y-2 mb-6 sm:mb-0">
                <h3 class="text-base sm:text-lg font-bold text-white uppercase tracking-wider">Pertanyaan Anda Belum Terjawab?</h3>
                <p class="text-xs sm:text-sm text-gray-400 font-light">Hubungi tim administrasi kami secara langsung untuk konsultasi kebutuhan kustom video Anda.</p>
            </div>
            <a href="{{ route('contact') }}" class="inline-block whitespace-nowrap bg-amber-500 text-black font-bold uppercase tracking-wider text-xs px-6 py-3.5 rounded-sm hover:bg-amber-400 transition duration-300 shadow-md">
                <i class="fas fa-paper-plane mr-2 text-sm"></i> Hubungi Kami
            </a>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    // Logika Interaktif Akordeon FAQ Vanilla JS
    document.addEventListener('DOMContentLoaded', () => {
        const toggles = document.querySelectorAll('.faq-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const item = this.parentElement;
                const content = this.nextElementSibling;
                const icon = this.querySelector('.faq-icon i');

                // Cek apakah item ini sudah aktif
                const isActive = item.classList.contains('active');

                // Tutup semua item FAQ yang sedang terbuka (Opsi eksklusif accordion)
                document.querySelectorAll('.faq-item').forEach(el => {
                    el.classList.remove('active');
                    el.querySelector('.faq-content').style.maxHeight = null;
                    el.querySelector('.faq-content').style.opacity = '0';
                    el.querySelector('.faq-icon i').style.transform = 'rotate(0deg)';
                });

                // Jika sebelumnya tidak aktif, maka buka item yang diklik
                if (!isActive) {
                    item.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + "px";
                    content.style.opacity = '1';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });
    });
</script>
@endpush