@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Administrator')
@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100">Total Paket</p>
                <h3 class="text-3xl font-bold mt-1">{{ $totalPaket }}</h3>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-boxes text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100">Sudah Diambil</p>
                <h3 class="text-3xl font-bold mt-1">{{ $paketDiambil }}</h3>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100">Belum Diambil</p>
                <h3 class="text-3xl font-bold mt-1">{{ $paketMenunggu }}</h3>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100">Total Denda</p>
                <h3 class="text-3xl font-bold mt-1">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
            </div>
            <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-2xl"></i>
            </div>
        </div>
    </div>
</div>
<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-4 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-line mr-2 text-blue-500"></i>Grafik Paket Bulanan
        </h3>
        <div class="h-32">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl p-4 shadow-lg">
        <h3 class="text-sm font-bold text-gray-800 mb-2">
            <i class="fas fa-chart-pie mr-2 text-purple-500"></i>Status Paket
        </h3>
        <div class="h-32">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>
<!-- Recent Packages -->
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">
            <i class="fas fa-history mr-2 text-green-500"></i>Paket Terbaru
        </h3>
        <a href="{{ route('paket.index') }}" class="text-blue-500 hover:underline text-sm">Lihat Semua</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No Resi</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Penerima</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Rak</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($paketTerbaru as $paket)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-sm">{{ $paket->no_resi }}</td>
                    <td class="px-4 py-3 font-medium">{{ $paket->nama_penerima }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm">{{ $paket->rak }}</span></td>
                    <td class="px-4 py-3">
                        @if($paket->status === 'diambil')
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">Diambil</span>
                        @elseif($paket->hari_telat > 0)
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">Telat</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-sm">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-3 py-2 text-gray-500 text-xs">{{ $paket->tanggal_masuk->locale('id')->translatedFormat('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data paket</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Paket Masuk',
                data: @json($dataBulanan),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Sudah Diambil', 'Menunggu', 'Telat'],
            datasets: [{
                data: [{{ $dataStatus['diambil'] }}, {{ $dataStatus['menunggu'] }}, {{ $dataStatus['telat'] }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>
@endpush