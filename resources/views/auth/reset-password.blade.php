@extends('layouts.app')

@section('title', 'Reset Password - Sikutu')

@section('content')
<div class="card w-full max-w-md mx-auto overflow-hidden animate-[fadeIn_0.5s_ease-in-out]">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600 font-oswald mb-2">Reset Password</h1>
        <p class="text-gray-500 font-montserrat text-sm">Buat password baru untuk akun Anda.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.reset.process') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token ?? request()->query('token') }}">
        <input type="hidden" name="username" value="{{ $username ?? request()->query('username') }}">
        <input type="hidden" name="tipe_user" value="{{ $tipe ?? request()->query('tipe_user') }}">
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password Baru</label>
            <input type="password" id="password" name="password" required autofocus class="input-field" placeholder="Minimal 6 karakter">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Konfirmasi Password Baru</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="input-field" placeholder="Ulangi password baru">
        </div>

        <div>
            <button type="submit" class="w-full btn-primary py-3 mt-4">
                Simpan Password Baru
            </button>
        </div>
    </form>
</div>
@endsection