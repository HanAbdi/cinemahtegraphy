<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    $portfolios = \App\Models\Portfolio::orderBy('is_featured', 'desc')->orderBy('created_at', 'desc')->take(3)->get();

    $clients = \App\Models\ClientLogo::orderBy('created_at', 'asc')->get();

    $testimonials = \App\Models\Testimonial::where('status', 'approved')
        ->orderBy('is_featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->take(6)
        ->get();
    
    $averageRating = round(\App\Models\Testimonial::where('status', 'approved')->avg('rating') ?: 5.0, 1);
    $totalTestimonialsCount = \App\Models\Testimonial::where('status', 'approved')->count();

    return view('pages.index', compact('portfolios', 'clients', 'testimonials', 'averageRating', 'totalTestimonialsCount'));
});

Route::get('/portfolio/{id}', function ($id) {
    $portfolio = \App\Models\Portfolio::findOrFail($id);

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

Route::get('/produk', function () {
    // Array Dummy Produk Utama Anril Film
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
            'title' => 'Produksi Video Dokumenter Event',
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
        ],
        [
            'title' => 'Private Vlogger',
            'icon' => 'fas fa-video',
            'short_desc' => 'Dokumentasi eksklusif gaya vlogging untuk keperluan personal, event VIP, atau di balik layar (BTS).',
            'features' => ['Perekaman Gaya POV', 'Peralatan Ringkas & Mobile', 'Editing Cepat untuk Sosmed', 'Nuansa Intim & Personal']
        ],
        [
            'title' => 'Event Fotografer',
            'icon' => 'fas fa-camera',
            'short_desc' => 'Layanan fotografi profesional untuk mengabadikan momen penting acara Anda dengan kualitas resolusi tinggi.',
            'features' => ['Fotografer Berpengalaman', 'Pemrosesan Warna Premium', 'Pengiriman File Cepat', 'Album Digital Eksklusif']
        ]
    ];

    return view('pages.products', compact('services'));
})->name('products');

Route::get('/portfolios', function () {
    // Array Master Portofolio Lengkap untuk Halaman Kumpulan Portofolio
    $allPortfolios = \App\Models\Portfolio::orderBy('created_at', 'desc')->get();
    return view('pages.portfolios', compact('allPortfolios'));
})->name('portfolios.index');

Route::get('/faq', function () {
    // Array Data Dummy FAQ - Memudahkan integrasi CRUD oleh tim backend nanti
    $faqs = [
        [
            'question' => 'Berapa lama estimasi proses pengerjaan satu project video?',
            'answer' => 'Estimasi pengerjaan bervariasi tergantung skala proyek. Untuk eksekusi produksi lapangan biasanya memakan waktu sekitar 4 hari kerja. Adapun untuk tahapan pra-produksi, pasca-produksi, hingga proyek produksi berskala besar (sebulan), jangka waktu dan teknisnya dapat disesuaikan berdasarkan kesepakatan.'
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
            'answer' => 'Semua file mentah (raw footage) merupakan hak cipta production house, namun dapat diserahkan kepada klien berdasarkan kesepakatan khusus.'
        ]
    ];

    return view('pages.faq', compact('faqs'));
})->name('faq');

Route::get('/kontak', function () {
    return view('pages.contact');
})->name('contact');

Route::post('/kontak', function (Illuminate\Http\Request $request) {
    // Honeypot check
    if ($request->filled('website_url')) {
        return back(); // Silently ignore bot
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
    ]);

    \App\Models\QuoteRequest::create([
        'name' => strip_tags($validated['name']),
        'email' => strip_tags($validated['email']),
        'phone' => strip_tags($validated['phone']),
        'service_interested' => strip_tags($validated['subject']),
        'message' => strip_tags($validated['message']),
        'status' => 'new',
    ]);

    return back()->with('success', 'Formulir berhasil dikirim! Tim kami akan segera menghubungi Anda.');
})->name('contact.submit')->middleware('throttle:3,1');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $todayVisitors = \App\Models\VisitorLog::where('visited_date', now()->toDateString())->count();
        $totalVisitors = \App\Models\VisitorLog::count();
        $totalPortfolios = \App\Models\Portfolio::count();
        $newQuotes = \App\Models\QuoteRequest::where('status', 'new')->count();
        $activeChats = \App\Models\ChatRoom::where('is_active', true)->count();
        
        $recentQuotes = \App\Models\QuoteRequest::latest()->take(5)->get();
        $recentChats = \App\Models\ChatRoom::with(['messages' => function($q) {
            $q->latest()->limit(1);
        }])->latest('updated_at')->take(3)->get();

        return view('dashboard', compact(
            'todayVisitors', 'totalVisitors', 'totalPortfolios',
            'newQuotes', 'activeChats', 'recentQuotes', 'recentChats'
        ));
    })->name('dashboard');

    Route::get('/portfolios', \App\Livewire\PortfolioManager::class)->name('portfolios.index')->middleware('permission:portofolio');
    Route::get('/portfolios/create', \App\Livewire\PortfolioForm::class)->name('portfolios.create')->middleware('permission:portofolio');
    Route::get('/portfolios/{id}/edit', \App\Livewire\PortfolioForm::class)->name('portfolios.edit')->middleware('permission:portofolio');
    Route::get('/quotes', \App\Livewire\QuoteRequestManager::class)->name('quotes.index')->middleware('permission:penawaran');
    Route::get('/chat', \App\Livewire\AdminChatManager::class)->name('chat')->middleware('permission:live_chat');
    Route::get('/client-logos', \App\Livewire\ClientLogoManager::class)->name('client-logos.index')->middleware('permission:mitra_kerja');
    Route::get('/testimonials', \App\Livewire\TestimonialManager::class)->name('testimonials.index')->middleware('permission:ulasan_rating');
    Route::get('/settings', \App\Livewire\CompanySettingsManager::class)->name('settings.index')->middleware('permission:informasi_kantor');
    
    // CRM / Projects Workflow
    Route::get('/projects/kanban', \App\Livewire\ProjectKanban::class)->name('projects.kanban')->middleware('permission:penawaran');
    Route::get('/projects/calendar', \App\Livewire\ProjectCalendar::class)->name('projects.calendar')->middleware('permission:penawaran');
    Route::get('/projects/{project}/invoice', [\App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('projects.invoice')->middleware('permission:penawaran');

    // Account Management (Super Admin only - using a specific role check)
    Route::get('/accounts', \App\Livewire\AccountManager::class)->name('accounts.index')->middleware('permission:superadmin_only');
});

// Jalur login admin default bawaan Breeze biarkan tetap utuh di bawah ini
require __DIR__.'/auth.php';