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
                    <x-custom-select name="tingkat" :options="['' => 'Pilih', '10' => '10', '11' => '11', '12' => '12']" selected="{{ old('tingkat') }}" placeholder="Pilih" onchange="tingkat = value" />
                </div>
                <div>
                    <label for="jurusan_base" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Jurusan</label>
                    <x-custom-select name="jurusan_base" :options="['' => 'Pilih', 'PPLG' => 'PPLG', 'BCF' => 'BCF', 'ANM' => 'ANM', 'TO' => 'TO', 'TPFL' => 'TPFL']" selected="{{ old('jurusan_base') }}" placeholder="Pilih" onchange="jurusan = value; rombel = ''" />
                </div>
                <div>
                    <label for="rombel" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Rombel</label>
                    <div class="relative z-[98] w-full" x-data="{ open: false }">
                        <button type="button" @click="if(jurusan) open = !open" @click.away="open = false" 
                                class="input-field w-full bg-white flex justify-between items-center text-left"
                                :class="{'opacity-50 cursor-not-allowed': !jurusan, 'ring-2 ring-blue-500 border-blue-500': open}"
                                :disabled="!jurusan">
                            <span x-text="rombel ? rombel : 'Pilih'" class="truncate"></span>
                            <svg class="w-4 h-4 ml-2 text-gray-500 flex-shrink-0 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="absolute mt-1 w-full bg-white border border-gray-200 rounded-md shadow-xl z-[9999] py-1 max-h-60 overflow-y-auto" style="display: none;" x-transition>
                            <button type="button" @click="rombel = ''; open = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                Pilih
                            </button>
                            <template x-for="i in maxRombel" :key="i">
                                <button type="button" @click="rombel = i; open = false" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors" 
                                        :class="{ 'bg-blue-50 font-bold': rombel == i }">
                                    <span x-text="i"></span>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" id="rombel" name="rombel" :value="rombel">
                    </div>
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