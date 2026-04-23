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
        <div class="card p-4">
            <h3 class="font-oswald text-base font-medium text-gray-800 mb-3 border-b pb-2">Pilih Peminjaman</h3>
            <form action="{{ route('admin.pengembalian.create') }}" method="GET" class="mb-4">
                @php
                    $optionsPeminjaman = ['' => 'Pilih Transaksi Aktif...'];
                    foreach($peminjamanAktif as $p) {
                        $optionsPeminjaman[$p->id_peminjaman] = $p->anggota->nama_lengkap . ' - ' . Str::limit($p->buku->judul_buku, 20);
                    }
                @endphp
                <x-custom-select name="peminjaman" :options="$optionsPeminjaman" selected="{{ request('peminjaman') }}" placeholder="Pilih Transaksi Aktif..." onchange="$el.closest('form').submit()" id="form-peminjaman" />
            </form>
            <p class="text-xs text-gray-500">Pilih dari daftar transaksi yang masih berstatus DIPINJAM untuk memproses pengembalian.</p>
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
