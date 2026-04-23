@extends('layouts.admin')

@section('title', 'Tambah Anggota - Sikutu')
@section('header', 'Tambah Anggota Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.anggota.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Anggota
    </a>
</div>

<div class="card max-w-4xl animate-[fadeIn_0.3s_ease-in-out]">
    <form action="{{ route('admin.anggota.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-5">
                <div>
                    <label for="nis" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">NIS <span class="text-red-500">*</span></label>
                    <input type="text" id="nis" name="nis" value="{{ old('nis') }}" required class="input-field" placeholder="Contoh: 123456789">
                    @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="input-field" placeholder="Masukkan nama lengkap siswa">
                    @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Username <span class="text-red-500">*</span></label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required class="input-field" placeholder="Gunakan huruf, angka, atau dash">
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password <span class="text-red-500">*</span></label>
                    <input type="password" id="password" name="password" required class="input-field" placeholder="Minimal 6 karakter">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="input-field" placeholder="opsional@email.com">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-5">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="kelas" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Kelas <span class="text-red-500">*</span></label>
                        <x-custom-select name="kelas" :options="['' => 'Pilih Kelas', '10' => '10', '11' => '11', '12' => '12']" selected="{{ old('kelas') }}" placeholder="Pilih Kelas" />
                        @error('kelas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex-[2]">
                        <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Jurusan <span class="text-red-500">*</span></label>
                        @php
                            $optionsJurusan = ['' => 'Pilih Jurusan'];
                            foreach($jurusanList as $j) { $optionsJurusan[$j] = $j; }
                        @endphp
                        <x-custom-select name="jurusan" :options="$optionsJurusan" selected="{{ old('jurusan') }}" placeholder="Pilih Jurusan" />
                        @error('jurusan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">No Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" class="input-field" placeholder="Contoh: 081234567890">
                    @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="2" class="input-field" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="status_anggota" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Status <span class="text-red-500">*</span></label>
                        <x-custom-select name="status_anggota" :options="['AKTIF' => 'Aktif', 'NONAKTIF' => 'Nonaktif', 'DIBLOKIR' => 'Diblokir']" selected="{{ old('status_anggota', 'AKTIF') }}" placeholder="Pilih Status" />
                        @error('status_anggota') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="flex-1">
                        <label for="masa_berlaku" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Masa Berlaku <span class="text-red-500">*</span></label>
                        <input type="date" id="masa_berlaku" name="masa_berlaku" value="{{ old('masa_berlaku', \Carbon\Carbon::now()->addYears(3)->format('Y-m-d')) }}" required class="input-field">
                        @error('masa_berlaku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="reset" class="btn-secondary mr-2">Reset Form</button>
            <button type="submit" class="btn-primary">Simpan Anggota</button>
        </div>
    </form>
</div>
@endsection
