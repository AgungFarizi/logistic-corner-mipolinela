@extends('layouts.app')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Data Paket')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h3 class="text-xl font-bold"><i class="fas fa-edit mr-2"></i>Edit Data Paket</h3>
            <p class="text-blue-100 mt-1">Ubah informasi paket</p>
        </div>
        
        <form action="{{ route('paket.update', $paket) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $paket->tanggal_masuk->format('Y-m-d')) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Resi</label>
                    <input type="text" name="no_resi" value="{{ old('no_resi', $paket->no_resi) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima', $paket->nama_penerima) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No WhatsApp</label>
                    <input type="tel" name="no_whatsapp" value="{{ old('no_whatsapp', $paket->no_whatsapp) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rak Penyimpanan</label>
                    <select name="rak" class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                        @foreach($raks as $rak)
                            <option value="{{ $rak->kode_rak }}" {{ old('rak', $paket->rak) == $rak->kode_rak ? 'selected' : '' }}>
                                Rak {{ $rak->kode_rak }} - {{ $rak->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat (kg)</label>
                    <input type="number" name="berat" step="0.1" value="{{ old('berat', $paket->berat) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ekspedisi</label>
                    <select name="ekspedisi" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                        @foreach($ekspedisiList as $eks)
                            <option value="{{ $eks }}" {{ old('ekspedisi', $paket->ekspedisi) == $eks ? 'selected' : '' }}>{{ $eks }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                        <option value="menunggu" {{ old('status', $paket->status) == 'menunggu' ? 'selected' : '' }}>Menunggu Diambil</option>
                        <option value="diambil" {{ old('status', $paket->status) == 'diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batas Pengambilan</label>
                    <input type="date" name="batas_pengambilan" value="{{ old('batas_pengambilan', $paket->batas_pengambilan->format('Y-m-d')) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl">{{ old('keterangan', $paket->keterangan) }}</textarea>
            </div>
            
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <a href="{{ route('paket.index') }}" class="px-6 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection