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

        // Data Portofolio dari public site dengan 6 YouTube Links
        $portfolios = [
            [
                'title' => 'Video Company Profile PT Indonesia Xinhai Steel Structure',
                'category' => 'Corporate Video',
                'client' => 'PT Indonesia Xinhai Steel Structure',
                'year' => 2023,
                'video_url' => 'https://www.youtube.com/embed/4F8syVaiq_s',
                'description' => 'Video company profile untuk PT Indonesia Xinhai Steel Structure, menampilkan keunggulan dan layanan perusahaan.',
                'service_type' => 'Corporate Video',
                'tags' => ['corporate', 'profile', 'national'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => true,
            ],
            [
                'title' => 'Majestic Cruise Raja Ampat - Tourism Promotional Video',
                'category' => 'Video Promosi',
                'client' => 'Majestic Cruise',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/oJ6A-V_ADkI',
                'description' => '<p>Video promosi pariwisata untuk <strong>Majestic Cruise</strong> di Raja Ampat, menampilkan keindahan alam dan pengalaman wisata eksklusif.</p><ul><li>Pengambilan gambar bawah laut (Underwater 4K)</li><li>Liputan interior kapal pesiar mewah</li><li>Drone aerial shot pulau karang</li></ul><p><em>Proyek ini menargetkan audiens global.</em></p>',
                'service_type' => 'Video Promosi',
                'tags' => ['commercial', 'tourism', 'cruise'],
                'project_scope' => 'Internasional',
                'tag_scheme' => 'B',
                'is_featured' => true,
            ],
            [
                'title' => 'Pertamina Hulu Energi - Advanced Aerial Survey',
                'category' => 'Drone FPV',
                'client' => 'Pertamina Hulu Energi',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/IXjdlVZW8p8',
                'description' => 'Eksplorasi visual area kilang minyak lepas pantai menggunakan manuver Drone FPV Oneshot berkecepatan tinggi.',
                'service_type' => 'Drone FPV',
                'tags' => ['drone', 'fpv', 'national', 'offshore'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => true,
            ],
            [
                'title' => 'Unilever – Glow & Lovely Corporate Campaign',
                'category' => 'Video Promosi',
                'client' => 'Unilever Indonesia',
                'year' => 2023,
                'video_url' => 'https://www.youtube.com/embed/G2bu9xsOe_M',
                'description' => 'Dokumentasi kegiatan internal corporate social responsibility (CSR) Unilever Indonesia dengan pendekatan emosional.',
                'service_type' => 'Video Promosi',
                'tags' => ['corporate', 'csr', 'campaign'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => false,
            ],
            [
                'title' => 'Sea Safari Bandaneira – Deep Sea Documentary',
                'category' => 'Produksi Video Dokumenter Event',
                'client' => 'Sea Safari',
                'year' => 2025,
                'video_url' => 'https://www.youtube.com/embed/dx_djKHV-6E',
                'description' => 'Video cinematic campaign untuk mempromosikan rute liveaboard eksklusif pesona laut Banda Neira.',
                'service_type' => 'Produksi Video Dokumenter Event',
                'tags' => ['commercial', 'documentary', 'sea'],
                'project_scope' => 'Internasional',
                'tag_scheme' => 'B',
                'is_featured' => false,
            ],
            [
                'title' => 'Kawasan Industri Greenland – Industrial Drone Cinematic',
                'category' => 'Drone FPV',
                'client' => 'Greenland Industrial',
                'year' => 2024,
                'video_url' => 'https://www.youtube.com/embed/kurHKMymPKc',
                'description' => 'Pengambilan gambar dramatis tanpa putus untuk memperlihatkan skala infrastruktur gudang manufaktur modern.',
                'service_type' => 'Drone FPV',
                'tags' => ['drone', 'fpv', 'national', 'industrial'],
                'project_scope' => 'Regional',
                'tag_scheme' => 'A',
                'is_featured' => false,
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
