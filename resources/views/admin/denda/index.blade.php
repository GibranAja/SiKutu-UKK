@extends('layouts.admin')

@section('title', 'Pengaturan Denda - Sikutu')
@section('header', 'Pengaturan Peminjaman & Denda')

@section('content')
<div class="card max-w-2xl animate-[fadeIn_0.3s_ease-in-out]">
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <p class="text-sm text-blue-700">Atur batas maksimal hari peminjaman dan denda per hari jika terlambat. Pengaturan ini akan berlaku untuk semua transaksi peminjaman baru.</p>
    </div>

    <form action="{{ route('admin.denda.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label for="maks_hari_pinjam" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Maksimal Hari Peminjaman <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="number" id="maks_hari_pinjam" name="maks_hari_pinjam" value="{{ old('maks_hari_pinjam', $pengaturan->maks_hari_pinjam ?? 7) }}" required class="input-field pr-12" min="1" max="30">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Hari</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">Lama hari default peminjaman buku sebelum dianggap terlambat.</p>
                @error('maks_hari_pinjam') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="denda_per_hari" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Nominal Denda Keterlambatan Per Hari <span class="text-red-500">*</span></label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" id="denda_per_hari" name="denda_per_hari" value="{{ old('denda_per_hari', $pengaturan->denda_per_hari ?? 1000) }}" required class="input-field pl-10" min="0" step="500">
                </div>
                <p class="text-xs text-gray-500 mt-1">Jumlah denda yang dikenakan per hari jika anggota terlambat mengembalikan buku.</p>
                @error('denda_per_hari') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="submit" class="btn-primary">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
