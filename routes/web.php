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

// Jalur login admin default bawaan Breeze biarkan tetap utuh di bawah ini
require __DIR__.'/auth.php';