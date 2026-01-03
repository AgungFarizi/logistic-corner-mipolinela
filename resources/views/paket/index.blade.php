@extends('layouts.app')
@section('title', 'Daftar Paket')
@section('page-title', 'Daftar Semua Paket')
@section('content')
<div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white">
        <h3 class="text-xl font-bold"><i class="fas fa-list mr-2"></i>Daftar Semua Paket</h3>
        <p class="text-green-100 mt-1">Kelola dan pantau semua paket</p>
    </div>
    
    <div class="p-6">
        <!-- Filters -->
        <form action="{{ route('paket.index') }}" method="GET" class="flex flex-wrap gap-4 mb-6">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="flex-1 min-w-64 px-4 py-2 border border-gray-200 rounded-xl" placeholder="Cari nama, resi...">
            <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="diambil" {{ request('status') == 'diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                <option value="telat" {{ request('status') == 'telat' ? 'selected' : '' }}>Telat Ambil</option>
            </select>
            <select name="rak" class="px-4 py-2 border border-gray-200 rounded-xl">
                <option value="">Semua Rak</option>
                @foreach($raks as $rak)
                    <option value="{{ $rak->kode_rak }}" {{ request('rak') == $rak->kode_rak ? 'selected' : '' }}>Rak {{ $rak->kode_rak }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </form>
        
        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No Resi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Penerima</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No WA</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Rak</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tgl Masuk</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Denda</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pakets as $index => $paket)
                    @php
                        $denda = $paket->status === 'diambil' ? $paket->denda : $paket->denda_otomatis;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-500">{{ $pakets->firstItem() + $index }}</td>
                        <td class="px-4 py-3 font-mono text-sm">{{ $paket->no_resi }}</td>
                        <td class="px-4 py-3 font-medium">{{ $paket->nama_penerima }}</td>
                        <td class="px-4 py-3">{{ $paket->no_whatsapp }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm">{{ $paket->rak }}</span></td>
                        <td class="px-4 py-3">{{ $paket->tanggal_masuk->locale('id')->translatedFormat('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if($paket->status === 'diambil')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">Sudah Diambil</span>
                            @elseif($paket->hari_telat > 0)
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-sm">Telat {{ $paket->hari_telat }} hari</span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-sm">Menunggu</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-red-600 font-semibold">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex space-x-1">
                                @if($paket->status === 'menunggu')
                                    <form action="{{ route('paket.ambil', $paket) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200" title="Tandai Diambil">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('paket.edit', $paket) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('paket.destroy', $paket) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('paket.reminder', $paket) }}" target="_blank" class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200" title="Kirim WA">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="px-4 py-8 text-center text-gray-500">Tidak ada data paket</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6">
            {{ $pakets->links() }}
        </div>
    </div>
</div>
@endsection