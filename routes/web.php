<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    $portfolios = [
        [
            'id' => 1,
            'title' => 'Video Company Profile PT Indonesia Xinhai Steel Structure',
            'category' => 'Corporate Video',
            'thumbnail' => 'thumb-1.jpg',
            'description' => 'Video company profile untuk PT Indonesia Xinhai Steel Structure, menampilkan keunggulan dan layanan perusahaan.',
            'is_national_project' => true
        ],
        [
            'id' => 2,
            'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
            'category' => 'Commercial Video',
            'thumbnail' => 'thumb-2.jpg',
            'description' => 'Video promosi pariwisata untuk Majestic Cruise di Raja Ampat, menampilkan keindahan alam dan pengalaman wisata.',
            'is_national_project' => false
        ],
        [
            'id' => 3,
            'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
            'category' => 'Commercial Video',
            'thumbnail' => 'thumb-3.jpg',
            'description' => 'Video promosi pariwisata untuk Majestic Cruise di Raja Ampat, menampilkan keindahan alam dan pengalaman wisata.',
            'is_national_project' => false
        ]
    ];

    $clients = [
        ['name' => 'Klien Mitra 1', 'logo' => 'logo-1.png'],
        ['name' => 'Klien Mitra 2', 'logo' => 'logo-2.png'],
        ['name' => 'Klien Mitra 3', 'logo' => 'logo-3.png'],
    ];

    return view('pages.index', compact('portfolios', 'clients'));
});

Route::get('/portfolio/{id}', function ($id) {
    $allPortfolios = [
        1 => [
            'title' => 'Video Company Profile PT Indonesia Xinhai Steel Structure',
            'category' => 'Corporate Video',
            'client' => 'PT Indonesia Xinhai Steel Structure',
            'year' => '2025',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'description' => 'Video company profile untuk PT Indonesia Xinhai Steel Structure, menampilkan keunggulan, workshop, alur kerja, dan layanan manufaktur struktur baja struktural perusahaan berskala internasional.',
            'service_type' => 'Full Video Production + FPV Drone Shoot'
        ],
        2 => [
            'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
            'category' => 'Commercial Video',
            'client' => 'Majestic Cruise Tour',
            'year' => '2026',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'description' => 'Video promosi pariwisata untuk Majestic Cruise di Raja Ampat, menampilkan keindahan alam bawah laut, fasilitas kapal pesiar mewah, dan pengalaman wisata eksklusif.',
            'service_type' => 'Commercial Ad Production + Underwater Shooting'
        ],
        3 => [
            'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
            'category' => 'Commercial Video',
            'client' => 'Majestic Cruise Tour',
            'year' => '2026',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'description' => 'Video promosi pariwisata untuk Majestic Cruise di Raja Ampat, menampilkan keindahan alam bawah laut, fasilitas kapal pesiar mewah, dan pengalaman wisata eksklusif.',
            'service_type' => 'Commercial Ad Production + Underwater Shooting'
        ]
    ];

    $portfolio = $allPortfolios[$id] ?? abort(404);

    return view('pages.portfolio-detail', compact('portfolio'));
})->name('portfolio.detail');

Route::get('/tentang', function () {
    // Statistik pencapaian sinematik (Bisa di-CRUD di admin/di-hardcode sesuai kebutuhan TA)
    $stats = [
        ['number' => '20+', 'label' => 'Tahun Pengalaman'],
        ['number' => '150+', 'label' => 'Proyek Korporat'],
        ['number' => '50+', 'label' => 'Dokumentasi Nasional'],
        ['number' => '100%', 'label' => 'Kepuasan Klien'],
    ];

    return view('pages.about', compact('stats'));
})->name('about');

Route::get('/layanan', function () {
    // Array Dummy Layanan Utama Anril Film
    $services = [
        [
            'title' => 'Company Profile Video',
            'icon' => 'fas fa-building',
            'short_desc' => 'Visualisasi profesional untuk merepresentasikan visi, misi, infrastruktur, dan nilai budaya korporasi Anda.',
            'features' => ['Liputan Lapangan & Pabrik', 'Wawancara Direksi Eksekutif', 'Motion Graphics Data Infografis', 'Opsi Voice Over Profesional']
        ],
        [
            'title' => 'Video Promosi / TVC',
            'icon' => 'fas fa-ad',
            'short_desc' => 'Iklan komersial kreatif berkonsep cinematic storytelling untuk meningkatkan konversi penjualan dan branding produk.',
            'features' => ['Konsep Jernih & Scriptwriting', 'Talent / Model Casting', 'Color Grading Berstandar Bioskop', 'Editing Efek Suara Premium']
        ],
        [
            'title' => 'Produksi Video Iklan Komersial',
            'icon' => 'fas fa-helicopter',
            'short_desc' => 'Pengambilan gambar udara presisi tinggi menggunakan drone FPV untuk menghasilkan transisi tanpa putus (oneshot) yang spektakuler.',
            'features' => ['Pilot Drone Berlisensi Resmi', 'Manuver Indoor & Outdoor Ketat', 'Kamera Resolusi 4K / 6K Raw', 'Aman untuk Area Manufaktur']
        ],
        [
            'title' => 'Produksi Video Dokumentasi Event',
            'icon' => 'fas fa-helicopter',
            'short_desc' => 'Pengambilan gambar udara presisi tinggi menggunakan drone FPV untuk menghasilkan transisi tanpa putus (oneshot) yang spektakuler.',
            'features' => ['Pilot Drone Berlisensi Resmi', 'Manuver Indoor & Outdoor Ketat', 'Kamera Resolusi 4K / 6K Raw', 'Aman untuk Area Manufaktur']
        ],
        [
            'title' => 'Video Drone FPV Oneshot',
            'icon' => 'fas fa-helicopter',
            'short_desc' => 'Pengambilan gambar udara presisi tinggi menggunakan drone FPV untuk menghasilkan transisi tanpa putus (oneshot) yang spektakuler.',
            'features' => ['Pilot Drone Berlisensi Resmi', 'Manuver Indoor & Outdoor Ketat', 'Kamera Resolusi 4K / 6K Raw', 'Aman untuk Area Manufaktur']
        ],
        [
            'title' => 'Custom Project Video',
            'icon' => 'fas fa-sliders',
            'short_desc' => 'Solusi kustomisasi penuh produksi video dokumentasi event akbar, internal training, atau peluncuran produk baru sesuai bujet Anda.',
            'features' => ['Fleksibilitas Skala Kru', 'Manajemen Aset File Cloud', 'Multi-camera Setup Multi-angle', 'Sistem Revisi Terjadwal']
        ]
    ];

    return view('pages.services', compact('services'));
})->name('services');

Route::get('/portfolios', function () {
    // Array Master Portofolio Lengkap untuk Halaman Kumpulan Portofolio
    $allPortfolios = [
        [
            'id' => 1,
            'title' => 'Video Company Profile PT Indonesia Xinhai Steel Structure',
            'category' => 'Corporate Video',
            'thumbnail' => 'thumb-1.jpg',
            'description' => 'Video company profile untuk PT Indonesia Xinhai Steel Structure, menampilkan keunggulan dan layanan perusahaan.',
            'is_national_project' => true
        ],
        [
            'id' => 2,
            'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
            'category' => 'Commercial Video',
            'thumbnail' => 'thumb-2.jpg',
            'description' => 'Video promosi pariwisata untuk Majestic Cruise di Raja Ampat, menampilkan keindahan alam dan pengalaman wisata.',
            'is_national_project' => false
        ],
        [
            'id' => 3,
            'title' => 'Pertamina Hulu Energi - Advanced Aerial Survey',
            'category' => 'Drone FPV',
            'thumbnail' => 'thumb-1.jpg', // Pake aset gambar lo yang ada aja bro
            'description' => 'Eksplorasi visual area kilang minyak lepas pantai menggunakan manuver Drone FPV Oneshot berkecepatan tinggi.',
            'is_national_project' => true
        ],
        [
            'id' => 4,
            'title' => 'Unilever – Glow & Lovely Corporate Campaign',
            'category' => 'Corporate Video',
            'thumbnail' => 'thumb-2.jpg',
            'description' => 'Dokumentasi kegiatan internal corporate social responsibility (CSR) Unilever Indonesia dengan pendekatan emosional.',
            'is_national_project' => false
        ],
        [
            'id' => 5,
            'title' => 'Sea Safari Bandaneira – Deep Sea Documentary',
            'category' => 'Commercial Video',
            'thumbnail' => 'thumb-1.jpg',
            'description' => 'Video cinematic campaign untuk mempromosikan rute liveaboard eksklusif pesona laut Banda Neira.',
            'is_national_project' => false
        ],
        [
            'id' => 6,
            'title' => 'Kawasan Industri Greenland – Industrial Drone Cinematic',
            'category' => 'Drone FPV',
            'thumbnail' => 'thumb-2.jpg',
            'description' => 'Pengambilan gambar dramatis tanpa putus untuk memperlihatkan skala infrastruktur gudang manufaktur modern.',
            'is_national_project' => true
        ]
    ];

    return view('pages.portfolios', compact('allPortfolios'));
})->name('portfolios.index');

Route::get('/faq', function () {
    // Array Data Dummy FAQ - Memudahkan integrasi CRUD oleh tim backend nanti
    $faqs = [
        [
            'question' => 'Berapa lama estimasi proses pengerjaan satu project video?',
            'answer' => 'Estimasi pengerjaan bervariasi tergantung skala project. Untuk Video Company Profile standar biasanya memakan waktu 14–21 hari kerja, meliputi tahap pra-produksi, syuting, hingga pasca-produksi (editing & color grading).'
        ],
        [
            'question' => 'Apakah Anril Film melayani produksi video di luar Jabodetabek?',
            'answer' => 'Ya, kami melayani produksi video ke seluruh wilayah Indonesia. Untuk project di luar Jabodetabek, biaya transportasi dan akomodasi kru akan disesuaikan di dalam dokumen penawaran harga.'
        ],
        [
            'question' => 'Apakah pilot drone yang digunakan sudah tersertifikasi?',
            'answer' => 'Tentu saja. Semua pilot drone kami, terutama untuk kebutuhan Drone FPV Oneshot, telah memiliki lisensi resmi dan sertifikasi kepilotan drone untuk menjamin keamanan di area industri atau manufaktur.'
        ],
        [
            'question' => 'Berapa kali batas revisi video yang diberikan?',
            'answer' => 'Secara standar, kami memberikan batas revisi sebanyak 2 hingga 3 kali pada tahap pasca-produksi (editing offline & online), asalkan tidak mengubah konsep dasar yang telah disepakati di tahap storyboard awal.'
        ],
        [
            'question' => 'Apakah klien bisa mendapatkan seluruh file mentah (raw footage)?',
            'answer' => 'Semua file mentah (raw footage) merupakan hak cipta production house, namun dapat diserahkan kepada klien dengan kesepakatan khusus atau biaya tambahan untuk pemindahan aset data via cloud/harddisk eksternal.'
        ]
    ];

    return view('pages.faq', compact('faqs'));
})->name('faq');

Route::get('/kontak', function () {
    return view('pages.contact');
})->name('contact');

// Jalur login admin default bawaan Breeze biarkan tetap utuh di bawah ini
require __DIR__.'/auth.php';