@extends('layouts.app')

@section('title', 'Lupa Password - Sikutu')

@section('content')
<div class="card w-full max-w-md mx-auto overflow-hidden animate-[fadeIn_0.5s_ease-in-out]">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-blue-600 font-oswald mb-2">Lupa Password</h1>
        <p class="text-gray-500 font-montserrat text-sm">Masukkan email atau username Anda untuk mereset password.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.forgot.process') }}" class="space-y-5">
        @csrf
        
        <div>
            <label for="identifier" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Username atau Email</label>
            <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}" required autofocus class="input-field" placeholder="Masukkan username / email">
            @error('identifier')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="w-full btn-primary py-3 mt-4">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm">
        <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-blue-600 transition-colors duration-300 ease-in-out flex items-center justify-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Login
        </a>
    </div>
</div>
@endsection