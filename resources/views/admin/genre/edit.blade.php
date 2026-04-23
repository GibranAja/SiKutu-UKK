@extends('layouts.admin')

@section('title', 'Edit Genre - Sikutu')
@section('header', 'Edit Genre')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.genre.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Genre
    </a>
</div>

<div class="card max-w-2xl animate-[fadeIn_0.3s_ease-in-out]">
    <form action="{{ route('admin.genre.update', $genre->uuid) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label for="nama_genre" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Nama Genre <span class="text-red-500">*</span></label>
                <input type="text" id="nama_genre" name="nama_genre" value="{{ old('nama_genre', $genre->nama_genre) }}" required class="input-field" placeholder="Contoh: Fiksi, Sejarah, Sains">
                @error('nama_genre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="input-field" placeholder="Masukkan deskripsi genre ini (opsional)">{{ old('deskripsi', $genre->deskripsi) }}</textarea>
                @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="submit" class="btn-primary">Update Genre</button>
        </div>
    </form>
</div>
@endsection
