@extends('layouts.app')
@section('title', 'Tracking Paket')
@section('page-title', 'Tracking Paket')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 p-6 text-white text-center">
            <i class="fas fa-search-location text-5xl mb-4"></i>
            <h3 class="text-xl font-bold">Tracking Paket</h3>
            <p class="text-indigo-100 mt-1">Lacak status paket berdasarkan nomor resi</p>
        </div>
        <div class="p-6">
            <form action="{{ route('tracking') }}" method="GET" class="flex space-x-4 mb-6">
                <input type="text" name="resi" value="{{ request('resi') }}" 
                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl" placeholder="Masukkan nomor resi...">
                <button type="submit" class="px-6 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition">
                    <i class="fas fa-search mr-2"></i>Lacak
                </button>
            </form>
            
            @if(request('resi'))
                @if($paket)
                    @php $denda = $paket->status === 'diambil' ? $paket->denda : $paket->denda_otomatis; @endphp
                    <div class="border rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 text-white">
                            <i class="fas fa-check-circle mr-2"></i>Paket Ditemukan!
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">No Resi</p>
                                    <p class="font-semibold font-mono">{{ $paket->no_resi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Ekspedisi</p>
                                    <p class="font-semibold">{{ $paket->ekspedisi }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Penerima</p>
                                    <p class="font-semibold">{{ $paket->nama_penerima }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Lokasi Rak</p>
                                    <p class="font-semibold text-blue-600">{{ $paket->rak }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Masuk</p>
                                     <p class="font-semibold">{{ $paket->tanggal_masuk->locale('id')->translatedFormat('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    @if($paket->status === 'diambil')
                                        <p class="font-semibold text-green-600">Sudah Diambil</p>
                                    @elseif($paket->hari_telat > 0)
                                        <p class="font-semibold text-red-600">Telat {{ $paket->hari_telat }} hari</p>
                                    @else
                                        <p class="font-semibold text-yellow-600">Menunggu Diambil</p>
                                    @endif
                                </div>
                            </div>
                            @if($denda > 0)
                                <div class="bg-red-50 p-4 rounded-xl">
                                    <p class="text-red-600 font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i>Total Denda: Rp {{ number_format($denda, 0, ',', '.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="border border-red-200 rounded-2xl p-6 text-center bg-red-50">
                        <i class="fas fa-times-circle text-red-500 text-4xl mb-4"></i>
                        <h4 class="font-bold text-red-600">Paket Tidak Ditemukan</h4>
                        <p class="text-gray-500 mt-2">Periksa kembali nomor resi yang dimasukkan</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection