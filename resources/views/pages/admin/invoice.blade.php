<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $project->title }}</title>
    <!-- Tailwind CSS (CDN for simple printing) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            background: #f3f4f6;
        }
        .invoice-box {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }
        @media print {
            body {
                background: white;
            }
            .invoice-box {
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-width: 100%;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    
    <div class="text-center mt-8 no-print">
        <button onclick="window.print()" class="bg-amber-500 hover:bg-amber-600 text-black px-6 py-2 rounded-lg font-bold shadow-md transition-colors">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()" class="ml-4 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-bold transition-colors">
            Tutup
        </button>
    </div>

    <div class="invoice-box">
        <div class="flex justify-between items-start border-b-2 border-gray-100 pb-8 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">INVOICE</h1>
                <p class="text-gray-500 mt-1 font-medium">INV-{{ date('Ymd') }}-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</p>
                <div class="mt-4">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        {{ $project->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 
                          ($project->payment_status == 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                        {{ $project->payment_status == 'paid' ? 'LUNAS' : ($project->payment_status == 'partial' ? 'CICILAN / DP' : 'BELUM LUNAS') }}
                    </span>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-bold text-gray-800">{{ $settings->company_name ?? 'Cinemahtegraphy' }}</h2>
                <p class="text-sm text-gray-500 mt-2 whitespace-pre-wrap">{{ $settings->address ?? 'Jakarta, Indonesia' }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $settings->email ?? 'info@cinemahtegraphy.com' }}</p>
                <p class="text-sm text-gray-500">{{ $settings->phone ?? '' }}</p>
            </div>
        </div>

        <div class="flex justify-between mb-8">
            <div>
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Ditagihkan Kepada:</h3>
                @if($project->quoteRequest)
                    <p class="text-lg font-bold text-gray-800">{{ $project->quoteRequest->name }}</p>
                    <p class="text-gray-600">{{ $project->quoteRequest->email }}</p>
                    <p class="text-gray-600">{{ $project->quoteRequest->phone }}</p>
                @else
                    <p class="text-lg font-bold text-gray-800">Klien</p>
                @endif
            </div>
            <div class="text-right">
                <div class="mb-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Invoice:</h3>
                    <p class="text-gray-800 font-medium">{{ now()->format('d F Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Event:</h3>
                    <p class="text-gray-800 font-medium">{{ $project->event_date ? $project->event_date->format('d F Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <table class="w-full text-left mb-8">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200">
                    <th class="py-3 px-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Deskripsi Layanan</th>
                    <th class="py-3 px-4 text-sm font-bold text-gray-600 uppercase tracking-wider text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-gray-100">
                    <td class="py-4 px-4">
                        <p class="font-bold text-gray-800">{{ $project->title }}</p>
                        @if($project->quoteRequest && $project->quoteRequest->service_interested)
                            <p class="text-sm text-gray-500 mt-1">Layanan: {{ $project->quoteRequest->service_interested }}</p>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right font-medium text-gray-800">
                        Rp {{ number_format($project->total_price ?: 0, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end mb-12">
            <div class="w-1/2">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Total Biaya:</span>
                    <span class="font-medium">Rp {{ number_format($project->total_price ?: 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-600">Terbayar (DP/Cicilan):</span>
                    <span class="font-medium text-green-600">Rp {{ number_format($project->dp_amount ?: 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-4 border-b-2 border-gray-800">
                    <span class="text-lg font-bold text-gray-800">Sisa Tagihan:</span>
                    @php
                        $sisa = ($project->total_price ?: 0) - ($project->dp_amount ?: 0);
                        if ($sisa < 0) $sisa = 0;
                    @endphp
                    <span class="text-lg font-bold {{ $sisa > 0 ? 'text-red-600' : 'text-gray-800' }}">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t-2 border-gray-100 pt-8 mt-8 flex justify-between items-end">
            <div>
                <h4 class="font-bold text-gray-800 mb-2">Instruksi Pembayaran:</h4>
                <p class="text-sm text-gray-600">Transfer dapat dilakukan ke rekening berikut:</p>
                <p class="text-sm font-bold text-gray-800 mt-1">BCA: 1234567890</p>
                <p class="text-sm text-gray-600">a.n Cinemahtegraphy</p>
            </div>
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-8">Hormat Kami,</p>
                <p class="font-bold text-gray-800">{{ $settings->company_name ?? 'Cinemahtegraphy' }}</p>
            </div>
        </div>
    </div>

    <!-- Auto trigger print on load if url has ?print=true (optional) -->
    <script>
        if(window.location.search.includes('print=true')) {
            window.onload = function() { window.print(); }
        }
    </script>
</body>
</html>
