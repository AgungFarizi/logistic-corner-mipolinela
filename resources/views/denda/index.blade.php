@extends('layouts.app')
@section('title', 'Denda & Telat')
@section('page-title', 'Paket Telat & Denda')

@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-red-500 to-orange-500 p-6 text-white">
        <h3 class="text-xl font-bold"><i class="fas fa-exclamation-triangle mr-2"></i>Paket Telat & Denda</h3>
        <p class="text-red-100 mt-1">Daftar paket yang terlambat (denda RP. 1000 / Hari)</p>
    </div>
    <div class="p-6">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <i class="fas fa-info-circle text-yellow-400 mt-1 mr-3"></i>
                <div>
                    <p class="font-semibold text-yellow-800">Total Denda Terkumpul: Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
                    <p class="text-yellow-700 text-sm">Denda dihitung otomatis Rp 1.000 per hari setelah melewati batas pengambilan.</p>
                </div>
            </div>
        </div>
        
        <div class="mb-4">
            <form action="{{ route('denda.hitung-ulang') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-orange-500 text-white px-6 py-2 rounded-xl hover:bg-orange-600 transition">
                    <i class="fas fa-calculator mr-2"></i>Hitung Ulang Semua Denda
                </button>
            </form>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">No Resi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">Penerima</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">No WA</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">Batas Ambil</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">Hari Telat</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">Total Denda</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-red-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($paketTelat as $paket)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono">{{ $paket->no_resi }}</td>
                        <td class="px-4 py-3 font-medium">{{ $paket->nama_penerima }}</td>
                        <td class="px-4 py-3">{{ $paket->no_whatsapp }}</td>
                        <td class="px-4 py-3">{{ $paket->batas_pengambilan->locale('id')->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3"><span class="px-3 py-1 bg-red-100 text-red-700 rounded-full font-semibold">{{ $paket->hari_telat }} hari</span></td>
                        <td class="px-4 py-3 text-red-600 font-bold">Rp {{ number_format($paket->denda_otomatis, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-2">
                                <form action="{{ route('paket.ambil', $paket) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 text-sm">
                                        <i class="fas fa-check mr-1"></i>Ambil
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Tidak ada paket yang telat 🎉</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">{{ $paketTelat->links() }}</div>
    </div>
</div>
@endsection