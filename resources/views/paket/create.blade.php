@extends('layouts.app')
@section('title', 'Input Paket')
@section('page-title', 'Input Paket Baru')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h3 class="text-xl font-bold"><i class="fas fa-plus-circle mr-2"></i>Input Data Paket Baru</h3>
            <p class="text-blue-100 mt-1">Masukkan informasi paket dari kurir</p>
        </div>
        
        <form action="{{ route('paket.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk *</label>
                    <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl @error('tanggal_masuk') border-red-500 @enderror" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Resi *</label>
                    <input type="text" name="no_resi" value="{{ old('no_resi') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl @error('no_resi') border-red-500 @enderror" 
                           placeholder="Contoh: JNE123456789" required>
                    @error('no_resi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima *</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Nama mahasiswa" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No WhatsApp *</label>
                    <input type="tel" name="no_whatsapp" value="{{ old('no_whatsapp') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="08xxxxxxxxxx" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rak Penyimpanan *</label>
                    <select name="rak" class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                        <option value="">Pilih Rak</option>
                        @foreach($raks as $rak)
                            <option value="{{ $rak->kode_rak }}" {{ old('rak') == $rak->kode_rak ? 'selected' : '' }}>
                                Rak {{ $rak->kode_rak }} - {{ $rak->lokasi }} (Sisa: {{ $rak->sisa_kapasitas }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat (kg) *</label>
                    <input type="number" name="berat" step="0.1" value="{{ old('berat') }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="0.5" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ekspedisi</label>
                    <select name="ekspedisi" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                        @foreach($ekspedisiList as $eks)
                            <option value="{{ $eks }}" {{ old('ekspedisi') == $eks ? 'selected' : '' }}>{{ $eks }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Batas Pengambilan *</label>
                    <input type="date" name="batas_pengambilan" value="{{ old('batas_pengambilan', date('Y-m-d', strtotime('+3 days'))) }}" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl" required>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
            </div>
            
            <div class="flex items-center space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="kirim_notifikasi" value="1" checked class="w-5 h-5 text-blue-600 rounded">
                    <span class="text-sm text-gray-700">Kirim notifikasi WhatsApp ke penerima</span>
                </label>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition shadow-lg">
                    <i class="fas fa-save mr-2"></i>Simpan Data Paket
                </button>
                <a href="{{ route('paket.index') }}" class="px-6 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
