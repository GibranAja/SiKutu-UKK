@extends('layouts.admin')

@section('title', 'Proses Pengembalian - Sikutu')
@section('header', 'Proses Pengembalian Buku')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pengembalian.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Riwayat Pengembalian
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    <div class="lg:col-span-1 space-y-6">
        <div class="card p-4" x-data="{ 
            search: '', 
            items: {{ $peminjamanAktif->map(fn($p) => [
                'id' => $p->id_peminjaman,
                'nama' => $p->anggota->nama_lengkap,
                'nis' => $p->anggota->nis,
                'buku' => $p->buku->judul_buku,
                'url' => route('admin.pengembalian.create', ['peminjaman' => $p->id_peminjaman])
            ])->toJson() }},
            showSuggestions: false,
            get filteredItems() {
                if (this.search.length < 2) return [];
                return this.items.filter(i => 
                    i.nama.toLowerCase().includes(this.search.toLowerCase()) || 
                    i.nis.toLowerCase().includes(this.search.toLowerCase()) || 
                    i.buku.toLowerCase().includes(this.search.toLowerCase())
                ).slice(0, 10);
            }
        }">
            <h3 class="font-oswald text-base font-medium text-gray-800 mb-3 border-b pb-2">Cari Peminjaman Aktif</h3>
            <div class="relative">
                <div class="relative">
                    <input 
                        type="text" 
                        x-model="search" 
                        @input="showSuggestions = true"
                        @click.away="showSuggestions = false"
                        @focus="showSuggestions = true"
                        placeholder="Ketik nama, NISN, atau judul buku..." 
                        class="input-field pl-10"
                    >
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <!-- Suggestions Dropdown -->
                <div 
                    x-show="showSuggestions && filteredItems.length > 0" 
                    class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg max-h-64 overflow-y-auto"
                    x-transition
                >
                    <template x-for="item in filteredItems" :key="item.id">
                        <a :href="item.url" class="block px-4 py-3 hover:bg-blue-50 border-b border-gray-50 last:border-0 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-sm font-bold text-gray-800" x-text="item.nama"></div>
                                    <div class="text-xs text-gray-500" x-text="'NISN: ' + item.nis"></div>
                                    <div class="text-xs text-blue-600 font-medium mt-1" x-text="item.buku"></div>
                                </div>
                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                    </template>
                </div>

                <div x-show="search.length >= 2 && filteredItems.length === 0" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg p-4 text-center text-sm text-gray-500">
                    Tidak ditemukan hasil untuk "<span x-text="search" class="font-medium"></span>"
                </div>
            </div>
            <p class="text-[10px] text-gray-500 mt-3 italic">* Masukkan minimal 2 karakter untuk mulai mencari transaksi yang masih DIPINJAM.</p>
        </div>

        @if($peminjaman)
        <div class="card p-4 border-t-4 border-t-blue-500">
            <h3 class="font-oswald text-base font-medium text-gray-800 mb-3 border-b pb-2">Info Keterlambatan</h3>
            @php
                $tglKembali = \Carbon\Carbon::now();
                $isTerlambat = \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->isPast();
                $hariTerlambat = $isTerlambat ? \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->diffInDays($tglKembali) : 0;
                $dendaKeterlambatan = $isTerlambat && $pengaturan ? $pengaturan->hitungDendaKeterlambatan($hariTerlambat) : 0;
            @endphp
            
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Batas Kembali</span>
                    <span class="font-medium">{{ \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    @if($isTerlambat)
                        <span class="text-red-600 font-bold">Terlambat {{ $hariTerlambat }} Hari</span>
                    @else
                        <span class="text-emerald-600 font-bold">Tepat Waktu</span>
                    @endif
                </div>
                <div class="flex justify-between pt-2 border-t">
                    <span class="text-gray-800 font-medium">Denda Keterlambatan</span>
                    <span class="font-bold text-red-600">Rp {{ number_format($dendaKeterlambatan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="lg:col-span-2">
        <div class="card">
            @if(!$peminjaman)
            <div class="text-center py-10">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <h3 class="text-lg font-medium text-gray-900 font-oswald">Belum Ada Transaksi Dipilih</h3>
                <p class="mt-1 text-gray-500 text-sm">Silakan pilih peminjaman aktif dari menu di samping kiri untuk memproses pengembalian.</p>
            </div>
            @else
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Formulir Pengembalian</h3>
            
            <form action="{{ route('admin.pengembalian.store') }}" method="POST" x-data="{ kondisi: 'BAIK' }">
                @csrf
                <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id_peminjaman }}">
                
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 mb-6 flex items-start gap-4">
                    <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 flex-shrink-0">
                        @if($peminjaman->buku->gambar_cover)
                            <img src="{{ Storage::url($peminjaman->buku->gambar_cover) }}" alt="Cover" class="w-full h-full object-cover rounded">
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-semibold uppercase">Buku yang Dikembalikan</p>
                        <p class="font-oswald font-medium text-lg text-gray-800">{{ $peminjaman->buku->judul_buku }}</p>
                        <p class="text-sm text-gray-600">Peminjam: <span class="font-medium">{{ $peminjaman->anggota->nama_lengkap }}</span> ({{ $peminjaman->anggota->nis }})</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Tanggal Pengembalian <span class="text-red-500">*</span></label>
                        <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali', \Carbon\Carbon::now()->format('Y-m-d')) }}" required class="input-field">
                        @error('tanggal_kembali') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Kondisi Buku Kembali <span class="text-red-500">*</span></label>
                        <x-custom-select name="kondisi_buku_kembali" :options="['BAIK' => 'Kondisi Baik', 'RUSAK' => 'Kondisi Rusak']" selected="BAIK" onchange="kondisi = value" />
                    </div>
                    
                    <div x-show="kondisi === 'RUSAK'" x-transition class="md:col-span-2 bg-orange-50 p-4 rounded border border-orange-100">
                        <label for="denda_kondisi" class="block text-sm font-medium text-orange-800 mb-1 font-oswald">Nominal Denda Kerusakan Buku (Rp)</label>
                        <input type="number" id="denda_kondisi" name="denda_kondisi" value="{{ old('denda_kondisi', 0) }}" class="input-field border-orange-200 focus:ring-orange-500 focus:border-orange-500" min="0" step="1000">
                        <p class="text-xs text-orange-600 mt-1">Masukkan nominal denda jika buku dikembalikan dalam keadaan rusak. Kosongkan (0) jika tidak ada denda tambahan.</p>
                        @error('denda_kondisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="catatan_petugas" class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Catatan (Opsional)</label>
                        <textarea id="catatan_petugas" name="catatan_petugas" rows="2" class="input-field" placeholder="Catatan mengenai kondisi buku atau hal lainnya">{{ old('catatan_petugas') }}</textarea>
                        @error('catatan_petugas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end border-t pt-4">
                    <button type="submit" class="btn-primary bg-emerald-600 hover:bg-emerald-700">Proses Pengembalian</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection
