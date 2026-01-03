@extends('layouts.auth')

@section('content')
<div class="w-full max-w-md mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-4 text-gray-700">Ganti Password</h2>

    @if (session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-600">Password Lama</label>
            <input type="password" name="password_lama"
                   class="w-full mt-1 p-2 border rounded focus:ring focus:ring-blue-300">
            @error('password_lama')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-600">Password Baru</label>
            <input type="password" name="password_baru"
                   class="w-full mt-1 p-2 border rounded focus:ring focus:ring-blue-300">
            @error('password_baru')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="text-sm font-semibold text-gray-600">Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation"
                   class="w-full mt-1 p-2 border rounded focus:ring focus:ring-blue-300">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Simpan Password Baru
        </button>
    </form>

</div>
@endsection
