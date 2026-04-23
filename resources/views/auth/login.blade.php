@extends('layouts.app')

@section('title', 'Login - Sikutu')

@section('content')
<div class="card w-full max-w-md mx-auto overflow-hidden animate-[fadeIn_0.5s_ease-in-out]">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-blue-600 font-oswald mb-2">SIKUTU</h1>
        <p class="text-gray-500 font-montserrat">Masuk ke Sistem Perpustakaan</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->has('login'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-sm">
            {{ $errors->first('login') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
        @csrf
        
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus class="input-field" placeholder="Masukkan username">
            @error('username')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Password</label>
            <input type="password" id="password" name="password" required class="input-field" placeholder="Masukkan password">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-300 ease-in-out">
                <label for="remember" class="ml-2 block text-sm text-gray-900 font-montserrat">
                    Ingat Saya
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.forgot') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 ease-in-out">
                    Lupa password?
                </a>
            </div>
        </div>

        <div>
            <button type="submit" class="w-full btn-primary py-3 text-lg mt-4">
                Masuk
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-300 ease-in-out">
            Daftar sebagai Siswa
        </a>
    </div>
</div>
@endsection