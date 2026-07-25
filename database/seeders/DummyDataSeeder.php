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

        // Data Portofolio dari produksi sinetron Mantan IPA & IPS
        $portfolios = [
            [
                'title' => 'Behind The Scenes Syuting Sinetron Mantan IPA & IPS - Episode Spesial',
                'category' => 'Produksi Video Dokumenter Event',
                'client' => 'MNC Pictures / GTV',
                'year' => 2022,
                'video_url' => 'https://www.youtube.com/embed/4F8syVaiq_s',
                'description' => '<p>Dokumentasi liputan di balik layar (*Behind The Scenes*) proses produksi sinetron drama remaja <strong>Mantan IPA & IPS</strong>. Mengabadikan kerja keras tim sinematografi, pengarahan sutradara, serta interaksi para pemain utama dalam menghasilkan adegan sinematik berkualitas penyiaran televisi nasional.</p>',
                'service_type' => 'Produksi Video Dokumenter Event',
                'tags' => ['behind-the-scenes', 'bts', 'sinetron', 'mnc-pictures'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => true,
            ],
            [
                'title' => 'Cinematic Production Roll - Sinetron Mantan IPA & IPS',
                'category' => 'Produksi Video Dokumenter Event',
                'client' => 'MNC Pictures / GTV',
                'year' => 2022,
                'video_url' => 'https://www.youtube.com/embed/oJ6A-V_ADkI',
                'description' => '<p>Video dokumentasi proses perekaman multi-kamera dan pencahayaan lapangan saat pengambilan gambar adegan drama sinetron <strong>Mantan IPA & IPS</strong>. Menampilkan performa akting dan teknik kerja tim teknis di lokasi syuting.</p>',
                'service_type' => 'Produksi Video Dokumenter Event',
                'tags' => ['cinematic', 'production', 'tv-series'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'B',
                'is_featured' => true,
            ],
            [
                'title' => 'Aerial Drone Location Coverage - Set Sinetron Mantan IPA & IPS',
                'category' => 'Drone FPV',
                'client' => 'MNC Pictures / GTV',
                'year' => 2022,
                'video_url' => 'https://www.youtube.com/embed/IXjdlVZW8p8',
                'description' => '<p>Pengambilan gambar dari udara (*Aerial Shot*) dan sudut pandang dinamis lokasi syuting luar ruangan (*outdoor set*) untuk sinetron <strong>Mantan IPA & IPS</strong> menggunakan teknologi drone terkini.</p>',
                'service_type' => 'Drone FPV',
                'tags' => ['drone', 'aerial', 'bts', 'fpv'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => true,
            ],
            [
                'title' => 'Official Promotional Teaser Campaign - Mantan IPA & IPS',
                'category' => 'Video Promosi',
                'client' => 'MNC Pictures / GTV',
                'year' => 2022,
                'video_url' => 'https://www.youtube.com/embed/G2bu9xsOe_M',
                'description' => '<p>Video promosi dan teaser komersial penayangan serial drama remaja <strong>Mantan IPA & IPS</strong>. Dikemas dengan pengeditan cepat, ritme suara dinamis, dan *color grading* sinematik.</p>',
                'service_type' => 'Video Promosi',
                'tags' => ['promo', 'teaser', 'commercial'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'A',
                'is_featured' => false,
            ],
            [
                'title' => 'Behind The Scenes High Energy Drama Scene - Mantan IPA & IPS',
                'category' => 'Produksi Video Dokumenter Event',
                'client' => 'MNC Pictures / GTV',
                'year' => 2023,
                'video_url' => 'https://www.youtube.com/embed/dx_djKHV-6E',
                'description' => '<p>Dokumentasi liputan khusus adegan emosional dan klimaks cerita pada serial TV <strong>Mantan IPA & IPS</strong>. Menyoroti koordinasi ketat antara pemeran, sutradara, dan juru kamera.</p>',
                'service_type' => 'Produksi Video Dokumenter Event',
                'tags' => ['bts', 'drama', 'behind-the-scenes'],
                'project_scope' => 'Nasional',
                'tag_scheme' => 'B',
                'is_featured' => false,
            ],
            [
                'title' => 'Vlog On Set & Fun Bloopers - Para Pemain Mantan IPA & IPS',
                'category' => 'Private Vlogger',
                'client' => 'MNC Pictures / GTV',
                'year' => 2023,
                'video_url' => 'https://www.youtube.com/embed/kurHKMymPKc',
                'description' => '<p>Video vlogging eksklusif dan rekaman momen lucu (*bloopers*) di sela-sela jeda Istirahat syuting para aktor dan aktris sinetron <strong>Mantan IPA & IPS</strong>.</p>',
                'service_type' => 'Private Vlogger',
                'tags' => ['vlog', 'bloopers', 'cast', 'fun'],
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
