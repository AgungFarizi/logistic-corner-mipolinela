@extends('layouts.app')
@section('title', 'Ekspor Laporan')
@section('page-title', 'Ekspor Laporan Excel')

@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white">
        <h3 class="text-xl font-bold"><i class="fas fa-file-excel mr-2"></i>Ekspor Laporan</h3>
        <p class="text-emerald-100 mt-1">Unduh data paket dalam format Excel</p>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Export Harian -->
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-blue-400 transition">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-day text-blue-500 text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Ekspor Harian</h4>
                <p class="text-sm text-gray-500 mb-4">Unduh data paket berdasarkan tanggal tertentu</p>
                <form action="{{ route('export.harian') }}" method="POST">
                    @csrf
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border rounded-lg mb-4" required>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                        <i class="fas fa-download mr-2"></i>Unduh
                    </button>
                </form>
            </div>
            
            <!-- Export Bulanan -->
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-green-400 transition">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-green-500 text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Ekspor Bulanan</h4>
                <p class="text-sm text-gray-500 mb-4">Unduh data paket berdasarkan bulan</p>
                <form action="{{ route('export.bulanan') }}" method="POST">
                    @csrf
                    <input type="month" name="bulan" value="{{ date('Y-m') }}" class="w-full px-4 py-2 border rounded-lg mb-4" required>
                    <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 transition">
                        <i class="fas fa-download mr-2"></i>Unduh
                    </button>
                </form>
            </div>
            
            <!-- Export Tahunan -->
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:border-purple-400 transition">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar text-purple-500 text-2xl"></i>
                </div>
                <h4 class="font-bold text-gray-800 mb-2">Ekspor Tahunan</h4>
                <p class="text-sm text-gray-500 mb-4">Unduh semua data paket per tahun</p>
                <form action="{{ route('export.tahunan') }}" method="POST">
                    @csrf
                    <select name="tahun" class="w-full px-4 py-2 border rounded-lg mb-4" required>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="w-full bg-purple-500 text-white py-2 rounded-lg hover:bg-purple-600 transition">
                        <i class="fas fa-download mr-2"></i>Unduh
                    </button>
                </form>
            </div>
        </div>
        
        <div class="mt-8 p-6 bg-gray-50 rounded-2xl">
            <h4 class="font-bold text-gray-800 mb-4"><i class="fas fa-file-export mr-2"></i>Ekspor Semua Data</h4>
            <p class="text-sm text-gray-500 mb-4">Unduh seluruh data paket yang ada di sistem</p>
            <a href="{{ route('export.semua') }}" class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-xl hover:opacity-90 transition shadow-lg">
                <i class="fas fa-download mr-2"></i>Unduh Semua Data (Excel)
            </a>
        </div>
    </div>
</div>
@endsection