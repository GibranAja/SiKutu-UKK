@extends('layouts.admin')

@section('title', 'Tambah Buku - Sikutu')
@section('header', 'Tambah Buku Baru')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.buku.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Buku
    </a>
</div>

<div class="card max-w-4xl animate-[fadeIn_0.3s_ease-in-out]">
    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Kiri -->
            <div class="space-y-5">
                <div>
                    <label for="kode_buku" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Kode Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="kode_buku" name="kode_buku" value="{{ old('kode_buku') }}" required class="input-field" placeholder="Contoh: BK-001">
                    @error('kode_buku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="judul_buku" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" id="judul_buku" name="judul_buku" value="{{ old('judul_buku') }}" required class="input-field" placeholder="Masukkan judul buku">
                    @error('judul_buku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="pengarang" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Pengarang <span class="text-red-500">*</span></label>
                    <input type="text" id="pengarang" name="pengarang" value="{{ old('pengarang') }}" required class="input-field" placeholder="Nama pengarang">
                    @error('pengarang') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Penerbit</label>
                    <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit') }}" class="input-field" placeholder="Nama penerbit">
                    @error('penerbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="tahun_terbit" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tahun Terbit</label>
                    <input type="number" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="input-field" placeholder="Contoh: 2023" min="1900" max="{{ date('Y') }}">
                    @error('tahun_terbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="space-y-5">
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Stok Buku <span class="text-red-500">*</span></label>
                    <input type="number" id="stok" name="stok" value="{{ old('stok', 0) }}" required class="input-field" min="0">
                    @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Kondisi Fisik <span class="text-red-500">*</span></label>
                    <select id="kondisi" name="kondisi" required class="input-field bg-white">
                        <option value="BAIK" {{ old('kondisi') == 'BAIK' ? 'selected' : '' }}>Baik</option>
                        <option value="RUSAK" {{ old('kondisi') == 'RUSAK' ? 'selected' : '' }}>Rusak</option>
                        <option value="HILANG" {{ old('kondisi') == 'HILANG' ? 'selected' : '' }}>Hilang</option>
                    </select>
                    @error('kondisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 font-oswald">Genre / Kategori</label>
                    <div class="bg-gray-50 p-3 rounded border border-gray-200 max-h-40 overflow-y-auto">
                        @foreach($genres as $genre)
                            <div class="flex items-center mb-2">
                                <input id="genre_{{ $genre->id_genre }}" name="genres[]" type="checkbox" value="{{ $genre->id_genre }}" 
                                    class="w-4 h-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500"
                                    {{ in_array($genre->id_genre, old('genres', [])) ? 'checked' : '' }}>
                                <label for="genre_{{ $genre->id_genre }}" class="ml-2 text-sm text-gray-700">{{ $genre->nama_genre }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('genres') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="imageUploader()">
                    <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Cover Buku</label>
                    <input type="hidden" name="gambar_cover_base64" x-model="base64Data">
                    
                    <div @dragover.prevent="dragover = true" @dragleave.prevent="dragover = false" @drop.prevent="handleDrop($event)"
                         :class="{'border-blue-500 bg-blue-50': dragover, 'border-gray-300 bg-white': !dragover}"
                         class="w-full relative border-2 border-dashed rounded-lg p-6 flex flex-col items-center justify-center transition-colors cursor-pointer"
                         @click="$refs.fileInput.click()"
                         tabindex="0"
                         @keydown.enter="$refs.fileInput.click()"
                         @paste.window="handlePaste($event)">
                        
                        <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" accept="image/*" class="hidden">
                        
                        <div x-show="!imageUrl" class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            <p class="mt-1 text-sm text-gray-600 font-montserrat">Klik, drag file, atau Ctrl+V untuk upload</p>
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                        </div>

                        <div x-show="imageUrl" class="relative w-full flex justify-center" style="display: none;">
                            <img :src="imageUrl" class="max-h-48 rounded shadow-sm object-contain">
                            <button type="button" @click.stop="removeImage()" class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 focus:outline-none transition-transform hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                    @error('gambar_cover_base64') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end border-t pt-4">
            <button type="reset" class="btn-secondary mr-2">Reset Form</button>
            <button type="submit" class="btn-primary">Simpan Buku</button>
        </div>
    </form>
</div>

<script>
function imageUploader() {
    return {
        dragover: false,
        imageUrl: '',
        base64Data: '',
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.processFile(file);
        },
        handleDrop(event) {
            this.dragover = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) this.processFile(file);
        },
        handlePaste(event) {
            const items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (let index in items) {
                const item = items[index];
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const file = item.getAsFile();
                    this.processFile(file);
                    break;
                }
            }
        },
        processFile(file) {
            // Check size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl = e.target.result;
                this.base64Data = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage() {
            this.imageUrl = '';
            this.base64Data = '';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endsection