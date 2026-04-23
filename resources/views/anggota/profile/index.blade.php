@extends('layouts.anggota')

@section('title', 'Profile Saya - Sikutu')
@section('header', 'Profile & Akun Saya')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    
    <!-- Kolom Kiri: Info Singkat & Avatar -->
    <div class="lg:col-span-1">
        <div class="card flex flex-col items-center text-center border-t-4 border-t-blue-500">
            <div class="w-24 h-24 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-3xl font-bold uppercase mb-4 shadow-sm border-4 border-white ring-2 ring-gray-100">
                {{ substr(Auth::guard('anggota')->user()->nama_lengkap, 0, 1) }}
            </div>
            <h2 class="text-xl font-bold font-oswald text-gray-800">{{ Auth::guard('anggota')->user()->nama_lengkap }}</h2>
            <p class="text-gray-500 text-sm mb-4">{{ Auth::guard('anggota')->user()->nis }}</p>
            
            <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800 uppercase tracking-wider mb-6">
                Siswa Kelas {{ Auth::guard('anggota')->user()->kelas }} {{ Auth::guard('anggota')->user()->jurusan }}
            </span>
            
            <div class="w-full text-left space-y-3 pt-4 border-t border-gray-100">
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Status Keanggotaan</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        @if(Auth::guard('anggota')->user()->status_anggota == 'AKTIF') bg-emerald-100 text-emerald-800 
                        @elseif(Auth::guard('anggota')->user()->status_anggota == 'NONAKTIF') bg-gray-100 text-gray-800 
                        @else bg-red-100 text-red-800 @endif">
                        {{ Auth::guard('anggota')->user()->status_anggota }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Masa Berlaku</span>
                    <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse(Auth::guard('anggota')->user()->masa_berlaku)->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Terakhir Login</span>
                    <span class="font-medium text-gray-800">{{ Auth::guard('anggota')->user()->last_login_at ? \Carbon\Carbon::parse(Auth::guard('anggota')->user()->last_login_at)->diffForHumans() : '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Update Profil & Password -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Form Update Data Profil -->
        <div class="card">
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informasi Kontak & Profil</h3>
            <form action="{{ route('siswa.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::guard('anggota')->user()->nama_lengkap) }}" required class="input-field">
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Username</label>
                        <input type="text" id="username" name="username" value="{{ Auth::guard('anggota')->user()->username }}" class="input-field bg-gray-50 cursor-not-allowed" readonly title="Username tidak bisa diubah">
                    </div>
                    
                    <div>
                        <label for="nis" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">NIS</label>
                        <input type="text" id="nis" name="nis" value="{{ Auth::guard('anggota')->user()->nis }}" class="input-field bg-gray-50 cursor-not-allowed" readonly title="NIS tidak bisa diubah. Hubungi admin jika ada kesalahan.">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::guard('anggota')->user()->email) }}" class="input-field" placeholder="opsional@email.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">No Telepon</label>
                        <input type="text" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', Auth::guard('anggota')->user()->no_telepon) }}" class="input-field" placeholder="08123456789">
                        @error('no_telepon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" class="input-field" placeholder="Alamat tempat tinggal">{{ old('alamat', Auth::guard('anggota')->user()->alamat) }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Form Ubah Password -->
        <div class="card border-t-4 border-t-gray-700">
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Ubah Password</h3>
            <form action="{{ route('siswa.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password Saat Ini <span class="text-red-500">*</span></label>
                        <input type="password" id="current_password" name="current_password" required class="input-field">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password Baru <span class="text-red-500">*</span></label>
                            <input type="password" id="new_password" name="new_password" required class="input-field" placeholder="Minimal 6 karakter">
                            @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required class="input-field" placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="btn-secondary">Perbarui Password</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
