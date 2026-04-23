@extends('layouts.admin')

@section('title', 'Tambah Peminjaman - Sikutu')
@section('header', 'Tambah Peminjaman Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Peminjaman
    </a>
</div>

<div class="card max-w-4xl animate-[fadeIn_0.3s_ease-in-out]">
    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-5">
                <div>
                    <label for="id_anggota" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Anggota Peminjam <span class="text-red-500">*</span></label>
                    @php
                        $optionsAnggota = ['' => 'Pilih Anggota'];
                        foreach($anggotas as $anggota) { $optionsAnggota[$anggota->id_anggota] = $anggota->nis . ' - ' . $anggota->nama_lengkap; }
                    @endphp
                    <x-custom-select name="id_anggota" :options="$optionsAnggota" selected="{{ old('id_anggota') }}" placeholder="Pilih Anggota" />
                    @error('id_anggota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="id_buku" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Buku yang Dipinjam <span class="text-red-500">*</span></label>
                    @php
                        $optionsBuku = ['' => 'Pilih Buku'];
                        foreach($bukus as $buku) { $optionsBuku[$buku->id_buku] = $buku->kode_buku . ' - ' . $buku->judul_buku . ' (Stok: ' . $buku->stok . ')'; }
                    @endphp
                    <x-custom-select name="id_buku" :options="$optionsBuku" selected="{{ old('id_buku') }}" placeholder="Pilih Buku" />
                    @error('id_buku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-5">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tanggal Pinjam <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', \Carbon\Carbon::now()->format('Y-m-d')) }}" required class="input-field">
                        @error('tanggal_pinjam') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex-1">
                        <label for="tanggal_harus_kembali" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tanggal Harus Kembali <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_harus_kembali" name="tanggal_harus_kembali" value="{{ old('tanggal_harus_kembali', \Carbon\Carbon::now()->addDays($maksHari)->format('Y-m-d')) }}" required class="input-field">
                        @error('tanggal_harus_kembali') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="catatan_peminjaman" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Catatan (Opsional)</label>
                    <textarea id="catatan_peminjaman" name="catatan_peminjaman" rows="3" class="input-field" placeholder="Tambahkan catatan jika ada">{{ old('catatan_peminjaman') }}</textarea>
                    @error('catatan_peminjaman') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="submit" class="btn-primary">Proses Peminjaman</button>
        </div>
    </form>
</div>
@endsection
