@extends('layouts.app')
@section('title', 'Statistik')
@section('page-title', 'Statistik & Analisis Data')
@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-4">
    <!-- Total Paket -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-xs">Total Paket</p>
                <h3 class="text-xl font-bold">{{ number_format($totalPaket) }}</h3>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-boxes text-sm"></i>
            </div>
        </div>
    </div>
    
    <!-- Sudah Diambil -->
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-xs">Diambil</p>
                <h3 class="text-xl font-bold">{{ number_format($paketDiambil) }}</h3>
                <p class="text-green-200 text-xs">{{ $persenDiambil }}%</p>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-check-circle text-sm"></i>
            </div>
        </div>
    </div>
    
    <!-- Menunggu -->
    <div class="bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-xs">Menunggu</p>
                <h3 class="text-xl font-bold">{{ number_format($paketMenunggu) }}</h3>
                <p class="text-yellow-200 text-xs">{{ $persenMenunggu }}%</p>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-sm"></i>
            </div>
        </div>
    </div>
    
    <!-- Telat -->
    <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-xs">Telat</p>
                <h3 class="text-xl font-bold">{{ number_format($paketTelat) }}</h3>
                <p class="text-red-200 text-xs">{{ $persenTelat }}%</p>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-sm"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Denda -->
    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-xs">Total Denda</p>
                <h3 class="text-sm font-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-sm"></i>
            </div>
        </div>
    </div>
    
    <!-- Rata-rata Waktu Ambil -->
    <div class="bg-gradient-to-br from-cyan-500 to-teal-600 rounded-xl p-3 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-cyan-100 text-xs">Rata-rata Ambil</p>
                <h3 class="text-xl font-bold">{{ $avgWaktuAmbil }} <span class="text-sm font-normal">hari</span></h3>
            </div>
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fas fa-hourglass-half text-sm"></i>
            </div>
        </div>
    </div>
</div>
<!-- Statistik Hari Ini & Bulan Ini -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
    <!-- Hari Ini -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2 flex items-center">
            <i class="fas fa-calendar-day mr-2 text-blue-500"></i>Statistik Hari Ini
            <span class="ml-auto text-xs text-gray-400">{{ now()->format('d M Y') }}</span>
        </h3>
        <div class="grid grid-cols-3 gap-2">
            <div class="bg-blue-50 rounded-lg p-2 text-center">
                <p class="text-xl font-bold text-blue-600">{{ $hariIni['masuk'] }}</p>
                <p class="text-xs text-blue-500">Masuk</p>
            </div>
            <div class="bg-green-50 rounded-lg p-2 text-center">
                <p class="text-xl font-bold text-green-600">{{ $hariIni['diambil'] }}</p>
                <p class="text-xs text-green-500">Diambil</p>
            </div>
            <div class="bg-red-50 rounded-lg p-2 text-center">
                <p class="text-xl font-bold text-red-600">{{ $hariIni['telat'] }}</p>
                <p class="text-xs text-red-500">Telat</p>
            </div>
        </div>
    </div>
    
    <!-- Bulan Ini -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2 flex items-center">
            <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>Statistik Bulan Ini
            <span class="ml-auto text-xs text-gray-400">{{ now()->format('F Y') }}</span>
        </h3>
        <div class="grid grid-cols-3 gap-2">
            <div class="bg-purple-50 rounded-lg p-2 text-center">
                <p class="text-xl font-bold text-purple-600">{{ $bulanIni['masuk'] }}</p>
                <p class="text-xs text-purple-500">Masuk</p>
            </div>
            <div class="bg-indigo-50 rounded-lg p-2 text-center">
                <p class="text-xl font-bold text-indigo-600">{{ $bulanIni['diambil'] }}</p>
                <p class="text-xs text-indigo-500">Diambil</p>
            </div>
            <div class="bg-pink-50 rounded-lg p-2 text-center">
                <p class="text-sm font-bold text-pink-600">Rp {{ number_format($bulanIni['denda'], 0, ',', '.') }}</p>
                <p class="text-xs text-pink-500">Denda</p>
            </div>
        </div>
    </div>
</div>
<!-- Grafik Utama - 2 Kolom -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">
    <!-- Grafik Bulanan -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-line mr-2 text-blue-500"></i>Tren Paket 12 Bulan Terakhir
        </h3>
        <div style="height: 180px;">
            <canvas id="chartBulanan"></canvas>
        </div>
    </div>
    
    <!-- Grafik Mingguan -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-bar mr-2 text-green-500"></i>Aktivitas 7 Hari Terakhir
        </h3>
        <div style="height: 180px;">
            <canvas id="chartMingguan"></canvas>
        </div>
    </div>
</div>
<!-- Grafik Per Ekspedisi, Status, Denda - 3 Kolom -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
    <!-- Per Ekspedisi -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-truck mr-2 text-orange-500"></i>Per Ekspedisi
        </h3>
        <div style="height: 160px;">
            <canvas id="chartEkspedisi"></canvas>
        </div>
    </div>
    
    <!-- Status Paket -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-pie mr-2 text-purple-500"></i>Status Paket
        </h3>
        <div style="height: 160px;">
            <canvas id="chartStatus"></canvas>
        </div>
    </div>
    
    <!-- Distribusi Denda -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-coins mr-2 text-yellow-500"></i>Distribusi Denda
        </h3>
        <div style="height: 160px;">
            <canvas id="chartDenda"></canvas>
        </div>
    </div>
</div>
<!-- Statistik Rak & Berat - 2 Kolom -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">
    <!-- Kapasitas Rak -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-warehouse mr-2 text-indigo-500"></i>Kapasitas Rak Penyimpanan
        </h3>
        <div class="space-y-2 max-h-40 overflow-y-auto">
            @foreach($kapasitasRak as $rak)
            @php
                $persen = $rak->kapasitas > 0 ? ($rak->terisi / $rak->kapasitas) * 100 : 0;
            @endphp
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-medium">Rak {{ $rak->kode_rak }}</span>
                    <span class="text-gray-500">{{ $rak->terisi }}/{{ $rak->kapasitas }} ({{ round($persen) }}%)</span>
                </div>
                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                    @if($persen > 80)
                        <div class="h-full bg-red-500 rounded-full" style="width: {{ $persen }}%"></div>
                    @elseif($persen > 50)
                        <div class="h-full bg-yellow-500 rounded-full" style="width: {{ $persen }}%"></div>
                    @else
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ $persen }}%"></div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Statistik Berat -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-weight-hanging mr-2 text-teal-500"></i>Statistik Berat Paket
        </h3>
        <div class="grid grid-cols-2 gap-2">
            <div class="bg-teal-50 rounded-lg p-2">
                <p class="text-xs text-teal-600">Total Berat</p>
                <p class="text-lg font-bold text-teal-700">{{ number_format($totalBerat, 1) }} kg</p>
            </div>
            <div class="bg-blue-50 rounded-lg p-2">
                <p class="text-xs text-blue-600">Rata-rata</p>
                <p class="text-lg font-bold text-blue-700">{{ number_format($avgBerat ?? 0, 2) }} kg</p>
            </div>
            <div class="bg-green-50 rounded-lg p-2">
                <p class="text-xs text-green-600">Terberat</p>
                <p class="text-lg font-bold text-green-700">{{ number_format($maxBerat ?? 0, 2) }} kg</p>
            </div>
            <div class="bg-orange-50 rounded-lg p-2">
                <p class="text-xs text-orange-600">Teringan</p>
                <p class="text-lg font-bold text-orange-700">{{ number_format($minBerat ?? 0, 2) }} kg</p>
            </div>
        </div>
    </div>
</div>
<!-- Top Penerima & Paket Terlama - 2 Kolom -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">
    <!-- Top 10 Penerima -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-trophy mr-2 text-yellow-500"></i>Top 10 Penerima Paket
        </h3>
        <div class="overflow-x-auto max-h-40">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-2 py-1 text-left">#</th>
                        <th class="px-2 py-1 text-left">Nama</th>
                        <th class="px-2 py-1 text-left">No WA</th>
                        <th class="px-2 py-1 text-center">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($topPenerima as $index => $penerima)
                    <tr class="hover:bg-gray-50">
                        <td class="px-2 py-1">
                            @if($index == 0)
                                <span class="text-yellow-500"><i class="fas fa-medal"></i></span>
                            @elseif($index == 1)
                                <span class="text-gray-400"><i class="fas fa-medal"></i></span>
                            @elseif($index == 2)
                                <span class="text-amber-600"><i class="fas fa-medal"></i></span>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td class="px-2 py-1 font-medium">{{ Str::limit($penerima->nama_penerima, 15) }}</td>
                        <td class="px-2 py-1 text-gray-500">{{ $penerima->no_whatsapp }}</td>
                        <td class="px-2 py-1 text-center">
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-bold">{{ $penerima->total_paket }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-2 py-3 text-center text-gray-500">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Paket Terlama Belum Diambil -->
    <div class="bg-white rounded-xl p-3 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-hourglass-end mr-2 text-red-500"></i>Paket Terlama Belum Diambil
        </h3>
        <div class="overflow-x-auto max-h-40">
            <table class="w-full text-xs">
                <thead class="bg-red-50 sticky top-0">
                    <tr>
                        <th class="px-2 py-1 text-left">No Resi</th>
                        <th class="px-2 py-1 text-left">Penerima</th>
                        <th class="px-2 py-1 text-center">Lama</th>
                        <th class="px-2 py-1 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($paketTerlama as $paket)
                    @php
                        $lama = \Carbon\Carbon::parse($paket->tanggal_masuk)->diffInDays(now());
                        $denda = $paket->denda_otomatis;
                    @endphp
                    <tr class="hover:bg-red-50">
                        <td class="px-2 py-1 font-mono text-xs">{{ Str::limit($paket->no_resi, 12) }}</td>
                        <td class="px-2 py-1">{{ Str::limit($paket->nama_penerima, 12) }}</td>
                        <td class="px-2 py-1 text-center">
                            <span class="px-1.5 py-0.5 bg-red-100 text-red-700 rounded-full font-bold text-xs">{{ $lama }}hr</span>
                        </td>
                        <td class="px-2 py-1 text-right text-red-600 font-bold">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-2 py-3 text-center text-gray-500">Tidak ada paket menunggu 🎉</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Detail Per Ekspedisi -->
<div class="bg-white rounded-xl p-3 shadow-lg">
    <h3 class="text-sm font-bold text-gray-800 mb-2">
        <i class="fas fa-shipping-fast mr-2 text-blue-500"></i>Detail Paket per Ekspedisi
    </h3>
    <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-2">
        @forelse($perEkspedisi as $eks)
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-2 text-center border">
            <p class="text-xl font-bold text-gray-700">{{ $eks->total }}</p>
            <p class="text-xs text-gray-500 font-medium truncate">{{ $eks->ekspedisi }}</p>
        </div>
        @empty
        <div class="col-span-7 text-center text-gray-500 py-3">Belum ada data</div>
        @endforelse
    </div>
</div>
@endsection
@push('scripts')
<script>
    // Tunggu DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Data dari Controller
        const labelBulanan = @json($labelBulanan ?? []);
        const dataBulananMasuk = @json($dataBulanan['masuk'] ?? []);
        const dataBulananDiambil = @json($dataBulanan['diambil'] ?? []);
        
        const labelMingguan = @json($labelMingguan ?? []);
        const dataMingguanMasuk = @json($dataMingguan['masuk'] ?? []);
        const dataMingguanDiambil = @json($dataMingguan['diambil'] ?? []);
        
        const perEkspedisi = @json($perEkspedisi ?? []);
        
        // Chart Bulanan
        const ctxBulanan = document.getElementById('chartBulanan');
        if (ctxBulanan) {
            new Chart(ctxBulanan, {
                type: 'line',
                data: {
                    labels: labelBulanan,
                    datasets: [
                        {
                            label: 'Paket Masuk',
                            data: dataBulananMasuk,
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        },
                        {
                            label: 'Paket Diambil',
                            data: dataBulananDiambil,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { boxWidth: 10, font: { size: 9 }, padding: 10 } 
                        }
                    },
                    scales: {
                        x: { ticks: { font: { size: 8 }, maxRotation: 45 } },
                        y: { beginAtZero: true, ticks: { font: { size: 9 } } }
                    }
                }
            });
        }
        
        // Chart Mingguan
        const ctxMingguan = document.getElementById('chartMingguan');
        if (ctxMingguan) {
            new Chart(ctxMingguan, {
                type: 'bar',
                data: {
                    labels: labelMingguan,
                    datasets: [
                        {
                            label: 'Masuk',
                            data: dataMingguanMasuk,
                            backgroundColor: '#3B82F6',
                            borderRadius: 4
                        },
                        {
                            label: 'Diambil',
                            data: dataMingguanDiambil,
                            backgroundColor: '#10B981',
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'bottom', 
                            labels: { boxWidth: 10, font: { size: 9 }, padding: 10 } 
                        }
                    },
                    scales: {
                        x: { ticks: { font: { size: 7 }, maxRotation: 45 } },
                        y: { beginAtZero: true, ticks: { font: { size: 9 } } }
                    }
                }
            });
        }
        
        // Chart Ekspedisi
        const ctxEkspedisi = document.getElementById('chartEkspedisi');
        if (ctxEkspedisi) {
            new Chart(ctxEkspedisi, {
                type: 'doughnut',
                data: {
                    labels: perEkspedisi.map(e => e.ekspedisi),
                    datasets: [{
                        data: perEkspedisi.map(e => e.total),
                        backgroundColor: ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#6B7280']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'right', 
                            labels: { boxWidth: 8, font: { size: 8 }, padding: 5 } 
                        }
                    }
                }
            });
        }
        
        // Chart Status
        const ctxStatus = document.getElementById('chartStatus');
        if (ctxStatus) {
            new Chart(ctxStatus, {
                type: 'pie',
                data: {
                    labels: ['Diambil', 'Menunggu', 'Telat'],
                    datasets: [{
                        data: [{{ $paketDiambil }}, {{ max(0, $paketMenunggu - $paketTelat) }}, {{ $paketTelat }}],
                        backgroundColor: ['#10B981', '#F59E0B', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'right', 
                            labels: { boxWidth: 8, font: { size: 9 }, padding: 8 } 
                        }
                    }
                }
            });
        }
        
        // Chart Denda
        const ctxDenda = document.getElementById('chartDenda');
        if (ctxDenda) {
            new Chart(ctxDenda, {
                type: 'doughnut',
                data: {
                    labels: ['Terkumpul', 'Belum Dibayar'],
                    datasets: [{
                        data: [{{ $totalDendaTerkumpul }}, {{ $totalDendaBelumBayar }}],
                        backgroundColor: ['#10B981', '#EF4444']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'right', 
                            labels: { boxWidth: 8, font: { size: 9 }, padding: 8 } 
                        }
                    }
                }
            });
        }
    });
</script>
@endpush