<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portfolio;
use App\Models\QuoteRequest;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Portofolio
        // Truncate tables to avoid duplicates
        Portfolio::truncate();
        QuoteRequest::truncate();

        // Data Portofolio dari public site
        $portfolios = [
            [
                'title' => 'Video Company Profile PT Indonesia Xinhai Steel Structure',
                'category' => 'Corporate Video',
                'client' => 'PT Indonesia Xinhai Steel Structure',
                'year' => 2023,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'description' => 'Video company profile untuk PT Indonesia Xinhai Steel Structure, menampilkan keunggulan dan layanan perusahaan.',
                'service_type' => 'Corporate Video',
                'tags' => ['corporate', 'profile', 'national'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
            ],
            [
                'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
                'category' => 'Commercial Video',
                'client' => 'Majestic Cruise',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'description' => '<p>Video promosi pariwisata untuk <strong>Majestic Cruise</strong> di Raja Ampat, menampilkan keindahan alam dan pengalaman wisata eksklusif.</p><ul><li>Pengambilan gambar bawah laut (Underwater 4K)</li><li>Liputan interior kapal pesiar mewah</li><li>Drone aerial shot pulau karang</li></ul><p><em>Proyek ini menargetkan audiens global.</em></p>',
                'service_type' => 'Commercial Video',
                'tags' => ['commercial', 'tourism', 'cruise'],
                'project_scope' => 'Internasional',
                'tag_scheme' => 'B',
            ],
            [
                'title' => 'Pertamina Hulu Energi - Advanced Aerial Survey',
                'category' => 'Drone FPV',
                'client' => 'Pertamina Hulu Energi',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'description' => 'Eksplorasi visual area kilang minyak lepas pantai menggunakan manuver Drone FPV Oneshot berkecepatan tinggi.',
                'service_type' => 'Drone FPV',
                'tags' => ['drone', 'fpv', 'national', 'offshore'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
            ],
            [
                'title' => 'Unilever – Glow & Lovely Corporate Campaign',
                'category' => 'Corporate Video',
                'client' => 'Unilever Indonesia',
                'year' => 2023,
                'video_url' => '',
                'description' => 'Dokumentasi kegiatan internal corporate social responsibility (CSR) Unilever Indonesia dengan pendekatan emosional.',
                'service_type' => 'Corporate Video',
                'tags' => ['corporate', 'csr', 'campaign'],
                'project_scope' => null,
                'tag_scheme' => 'A',
            ],
            [
                'title' => 'Sea Safari Bandaneira – Deep Sea Documentary',
                'category' => 'Commercial Video',
                'client' => 'Sea Safari',
                'year' => 2025,
                'video_url' => '',
                'description' => 'Video cinematic campaign untuk mempromosikan rute liveaboard eksklusif pesona laut Banda Neira.',
                'service_type' => 'Commercial Video',
                'tags' => ['commercial', 'documentary', 'sea'],
                'project_scope' => 'Lokal',
                'tag_scheme' => 'B',
            ],
            [
                'title' => 'Kawasan Industri Greenland – Industrial Drone Cinematic',
                'category' => 'Drone FPV',
                'client' => 'Greenland',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'description' => 'Pengambilan gambar dramatis tanpa putus untuk memperlihatkan skala infrastruktur gudang manufaktur modern.',
                'service_type' => 'Drone FPV',
                'tags' => ['drone', 'fpv', 'national', 'industrial'],
                'project_scope' => 'Regional',
                'tag_scheme' => 'A',
            ]
        ];

        foreach ($portfolios as $p) {
            Portfolio::create($p);
        }

        // Data Permintaan Penawaran (Quotes)
        $quotes = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'phone' => '081234567890',
                'service_interested' => 'Company Profile',
                'message' => 'Halo tim Cinemahtegraphy, kami berencana membuat video profil perusahaan berdurasi 3 menit. Kira-kira berapa estimasi anggarannya?',
                'status' => 'new',
                'created_at' => now()->subHours(2),
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@weddingku.com',
                'phone' => '087654321098',
                'service_interested' => 'Wedding Videography',
                'message' => 'Apakah tanggal 15 Agustus 2026 tim Anda available untuk liputan resepsi pernikahan di Jakarta Selatan?',
                'status' => 'processing',
                'read_at' => now()->subDay(),
                'created_at' => now()->subDays(2),
            ],
            [
                'name' => 'Reza Rahadian',
                'email' => 'reza@startup.id',
                'phone' => '',
                'service_interested' => 'Product Video',
                'message' => 'Saya ingin membuat video promosi produk untuk peluncuran aplikasi startup kami bulan depan.',
                'status' => 'finished',
                'is_archived' => true,
                'read_at' => now()->subDays(5),
                'created_at' => now()->subDays(6),
            ]
        ];

        foreach ($quotes as $q) {
            QuoteRequest::create($q);
        }
    }
}
