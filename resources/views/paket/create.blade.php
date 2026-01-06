@extends('layouts.app')
@section('title', 'Input Paket')
@section('page-title', 'Input Paket Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
            <h3 class="text-xl font-bold">
                <i class="fas fa-plus-circle mr-2"></i>Input Data Paket Baru
            </h3>
            <p class="text-blue-100 mt-1">Masukkan informasi paket dari kurir</p>
        </div>

        <form action="{{ route('paket.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium mb-2">Tanggal Masuk *</label>
                    <input type="date" name="tanggal_masuk"
                        value="{{ old('tanggal_masuk', now()->format('Y-m-d')) }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">No Resi *</label>
                    <input type="text" name="no_resi" value="{{ old('no_resi') }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                    @error('no_resi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Nama Penerima *</label>
                    <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">No WhatsApp *</label>
                    <input type="tel" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Rak Penyimpanan *</label>
                    <select name="rak" class="form-control" required>
                    <option value="">-- Pilih Rak --</option>

                    @forelse($raks as $rak)
                        <option value="{{ $rak->kode_rak }}">
                            Rak {{ $rak->kode_rak }} - {{ $rak->lokasi }}
                            (Sisa: {{ $rak->kapasitas - $rak->terisi }})
                        </option>
                    @empty
                        <option value="">Rak tidak tersedia</option>
                    @endforelse
                </select>

                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Berat (kg) *</label>
                    <input type="number" name="berat" step="0.1"
                        value="{{ old('berat') }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Ekspedisi *</label>
                    <select name="ekspedisi" class="w-full px-4 py-3 border rounded-xl">
                        @foreach($ekspedisiList as $eks)
                            <option value="{{ $eks }}">{{ $eks }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Batas Pengambilan *</label>
                    <input type="date" name="batas_pengambilan"
                        value="{{ old('batas_pengambilan', now()->addDays(3)->format('Y-m-d')) }}"
                        class="w-full px-4 py-3 border rounded-xl" required>
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-3 border rounded-xl"></textarea>
            </div>

            <div class="flex items-center space-x-2">
                <input type="checkbox" name="kirim_notifikasi" value="1" checked>
                <span class="text-sm">Kirim notifikasi WhatsApp ke penerima</span>
            </div>

            <div class="flex gap-4">
                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-semibold">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>

                <a href="{{ route('paket.index') }}"
                    class="px-6 bg-gray-300 py-3 rounded-xl font-semibold">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
