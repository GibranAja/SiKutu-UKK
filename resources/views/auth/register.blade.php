@extends('layouts.app')

@section('title', 'Daftar - Sikutu')

@section('content')
<div class="card w-full max-w-lg mx-auto overflow-hidden animate-[fadeIn_0.5s_ease-in-out]">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-600 font-oswald mb-2">DAFTAR</h1>
        <p class="text-gray-500 font-montserrat">Buat akun Siswa baru</p>
    </div>

    <form method="POST" action="{{ route('register.process') }}" class="space-y-5">
        @csrf
        
        <div>
            <label for="nis" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">NIS (Nomor Induk Siswa)</label>
            <input type="text" id="nis" name="nis" value="{{ old('nis') }}" required class="input-field" placeholder="Contoh: 123456">
            @error('nis')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Nama Lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="input-field" placeholder="Nama Lengkap Sesuai Identitas">
            @error('nama_lengkap')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required class="input-field" placeholder="Buat username untuk login">
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div x-data="{
            tingkat: '{{ old('tingkat') }}',
            jurusan: '{{ old('jurusan_base') }}',
            rombel: '{{ old('rombel') }}',
            get maxRombel() {
                return this.jurusan === 'PPLG' ? 3 : (this.jurusan ? 2 : 0);
            }
        }">
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="tingkat" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Kelas</label>
                    <select id="tingkat" name="tingkat" x-model="tingkat" required class="input-field bg-white">
                        <option value="">Pilih</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div>
                    <label for="jurusan_base" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Jurusan</label>
                    <select id="jurusan_base" name="jurusan_base" x-model="jurusan" required class="input-field bg-white" @change="rombel = ''">
                        <option value="">Pilih</option>
                        <option value="PPLG">PPLG</option>
                        <option value="BCF">BCF</option>
                        <option value="ANM">ANM</option>
                        <option value="TO">TO</option>
                        <option value="TPFL">TPFL</option>
                    </select>
                </div>
                <div>
                    <label for="rombel" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Rombel</label>
                    <select id="rombel" name="rombel" x-model="rombel" required class="input-field bg-white" :disabled="!jurusan">
                        <option value="">Pilih</option>
                        <template x-for="i in maxRombel" :key="i">
                            <option :value="i" x-text="i" :selected="rombel == i"></option>
                        </template>
                    </select>
                </div>
            </div>
            @error('tingkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @error('jurusan_base') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            @error('rombel') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="Email aktif untuk reset password">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password</label>
            <input type="password" id="password" name="password" required class="input-field" placeholder="Minimal 6 karakter">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="input-field" placeholder="Ulangi password di atas">
        </div>

        <div>
            <button type="submit" class="w-full btn-primary py-3 text-lg mt-4">
                Daftar Sekarang
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 ease-in-out">
            Masuk di sini
        </a>
    </div>
</div>
@endsection