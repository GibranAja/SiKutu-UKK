@extends('layouts.anggota')

@section('title', 'Denda Saya - Sikutu')
@section('header', 'Informasi Denda')

<style>
    [x-cloak] { display: none !important; }
</style>

@section('content')

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-amber-500 text-white border-amber-600">
        <h3 class="font-oswald text-lg font-medium opacity-90">Total Denda Belum Lunas</h3>
        <p class="font-montserrat text-4xl font-bold mt-2">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
    </div>

    <div class="col-span-1 md:col-span-2 card flex items-center bg-blue-50 border-blue-100 p-6">
        <div class="mr-4 text-blue-600 bg-white p-3 rounded-full shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <h4 class="font-oswald font-medium text-lg text-blue-900 mb-1">Informasi Pembayaran</h4>
            <p class="text-sm text-blue-800 font-montserrat">
                Denda dapat dibayar secara <strong>Tunai</strong> langsung ke petugas perpustakaan, atau
                <strong>Transfer</strong> ke rekening Bank Sekolah (BCA: 1234567890 a.n Sikutu).
                Jangan lupa upload bukti transfer!
            </p>
        </div>
    </div>
</div>

{{-- Tabel Denda --}}
{{--
    PENTING: x-data sekarang merujuk ke komponen Alpine terdaftar "dendaModal()"
    agar semua method (handleFileSelect, processFile, dll.) bisa diakses.
    Sebelumnya method-method itu didefinisikan di Alpine.data('pembayaranDenda')
    yang berbeda nama dengan x-data inline di div → method tidak pernah terhubung.
--}}
<div class="card p-0" x-data="dendaModal()">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Buku</th>
                    <th class="px-6 py-4">Keterlambatan</th>
                    <th class="px-6 py-4">Total Denda</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dendas as $denda)
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900 font-oswald">{{ Str::limit($denda->peminjaman->buku->judul_buku, 30) }}</p>
                        <p class="text-xs text-gray-500">Tgl Kembali: {{ \Carbon\Carbon::parse($denda->tanggal_kembali)->format('d M Y') }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-600">
                        Rp {{ number_format($denda->denda_keterlambatan, 0, ',', '.') }}
                        @if($denda->denda_kondisi > 0)
                            <br><span class="text-xs text-red-500">Kondisi: Rp {{ number_format($denda->denda_kondisi, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">
                        Rp {{ number_format($denda->denda_total, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($denda->status_denda == 'LUNAS')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">Lunas</span>
                        @elseif($denda->status_denda == 'MENUNGGU_KONFIRMASI')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu Konfirmasi</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Belum Lunas</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if(in_array($denda->status_denda, ['BELUM_LUNAS', 'DITOLAK']))
                            {{-- .stop agar event tidak bubble ke atas --}}
                            <button
                                type="button"
                                @click.stop="openModal('{{ $denda->uuid }}')"
                                class="btn-primary py-1.5 px-3 text-xs {{ $denda->status_denda == 'DITOLAK' ? 'bg-amber-600 hover:bg-amber-700 border-none' : '' }}"
                            >
                                {{ $denda->status_denda == 'DITOLAK' ? 'Bayar Ulang' : 'Bayar' }}
                            </button>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Bagus! Kamu tidak memiliki riwayat denda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($dendas->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $dendas->links() }}
    </div>
    @endif

    {{-- ============================================================
         MODAL PEMBAYARAN — Pattern sama seperti modal peminjaman:

         FIX UTAMA (root cause sama):
         1. Wrapper  → fixed inset-0 z-50 flex  (pusat alignment)
         2. Overlay  → absolute inset-0          (ikut wrapper, bukan viewport)
         3. Dialog   → relative z-10             (pasti di atas overlay)

         Sebelumnya overlay pakai "fixed inset-0" di dalam wrapper
         yang juga "fixed" → overlay sebagai positioned element otomatis
         di atas dialog yang non-positioned → dialog tertutup overlay.
    ============================================================ --}}
    <div
        x-cloak
        x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-denda-title"
        @keydown.escape.window="closeModal()"
    >
        {{-- Overlay: absolute agar tidak bikin stacking context baru --}}
        <div
            class="absolute inset-0 bg-gray-500 bg-opacity-75"
            @click="closeModal()"
            aria-hidden="true"
        ></div>

        {{-- Dialog: relative z-10 → pasti di atas overlay --}}
        <div
            class="relative z-10 bg-white rounded-lg shadow-xl w-full max-w-lg"
            @click.stop
        >
            <form :action="'{{ url('siswa/denda') }}/' + selectedDenda + '/bayar'" method="POST">
                @csrf

                {{-- Header Modal --}}
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                            <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div class="w-full space-y-4">
                            <h3 class="text-xl font-bold font-oswald text-gray-900" id="modal-denda-title">
                                Bayar Denda
                            </h3>

                            {{-- Select Metode Pembayaran --}}
                            <div class="relative" x-data="{ openSelect: false }">
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">
                                    Metode Pembayaran
                                </label>
                                <input type="hidden" name="metode_pembayaran" x-model="metode">
                                <div
                                    @click.stop="openSelect = !openSelect"
                                    class="input-field flex justify-between items-center cursor-pointer bg-white border border-gray-300 rounded-md px-3 py-2 select-none"
                                >
                                    <span x-text="metode === 'TUNAI' ? 'Bayar Tunai ke Petugas' : 'Transfer Bank'"></span>
                                    <svg class="w-5 h-5 text-gray-400 transition-transform" :class="{'rotate-180': openSelect}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div
                                    x-show="openSelect"
                                    x-cloak
                                    @click.away="openSelect = false"
                                    @click.stop
                                    class="absolute z-20 mt-1 w-full bg-white rounded shadow-lg border border-gray-200"
                                >
                                    <div @click="metode = 'TUNAI'; openSelect = false" class="px-4 py-2 hover:bg-blue-50 cursor-pointer font-montserrat text-sm transition-colors">
                                        Bayar Tunai ke Petugas
                                    </div>
                                    <div @click="metode = 'TRANSFER'; openSelect = false" class="px-4 py-2 hover:bg-blue-50 cursor-pointer font-montserrat text-sm transition-colors border-t border-gray-100">
                                        Transfer Bank
                                    </div>
                                </div>
                            </div>

                            {{-- Info Rekening (muncul jika Transfer) --}}
                            <div x-show="metode === 'TRANSFER'" x-transition class="bg-blue-50 p-4 rounded border border-blue-100">
                                <p class="text-sm font-semibold text-blue-900 font-oswald mb-1">Info Rekening Sekolah</p>
                                <p class="text-sm text-blue-800">Bank BCA: <strong>1234567890</strong> (a.n Sikutu)</p>
                            </div>

                            {{-- Upload Bukti Transfer --}}
                            <div
                                x-show="metode === 'TRANSFER'"
                                x-transition
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="isDragging = false; handleDrop($event)"
                                @paste.window="if(metode === 'TRANSFER') handlePaste($event)"
                            >
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">
                                    Bukti Transfer <span class="text-red-500">*</span>
                                </label>
                                <input type="hidden" name="bukti_pembayaran_base64" x-model="base64Data">

                                <div
                                    class="w-full border-2 border-dashed rounded-lg p-4 flex flex-col items-center justify-center transition-colors cursor-pointer"
                                    :class="isDragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-white'"
                                    @click="$refs.fileInput.click()"
                                >
                                    <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" accept="image/*" class="hidden">

                                    {{-- Placeholder --}}
                                    <div x-show="!imageUrl" class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <p class="mt-1 text-xs text-gray-600 font-montserrat">Klik, drag & drop, atau Ctrl+V</p>
                                    </div>

                                    {{-- Preview Gambar --}}
                                    <div x-show="imageUrl" x-cloak class="relative w-full flex justify-center">
                                        <img :src="imageUrl" class="max-h-32 rounded shadow-sm object-contain">
                                        <button
                                            type="button"
                                            @click.stop="removeImage()"
                                            class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 focus:outline-none transition-transform hover:scale-110"
                                        >
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Modal --}}
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2 border-t border-gray-100 rounded-b-lg">
                    <button
                        type="button"
                        @click="closeModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium font-oswald text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-sm font-medium font-oswald text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        Submit Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function dendaModal() {
    return {
        // State modal
        modalOpen:    false,
        selectedDenda: null,

        // State metode pembayaran
        metode:    'TUNAI',

        // State upload gambar
        base64Data: '',
        imageUrl:   '',
        isDragging: false,

        openModal(uuid) {
            this.selectedDenda = uuid;
            this.metode        = 'TUNAI';
            this.base64Data    = '';
            this.imageUrl      = '';
            this.modalOpen     = true;
        },

        closeModal() {
            this.modalOpen  = false;
            this.isDragging = false;
        },

        // ---- File handlers ----
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.processFile(file);
        },

        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) this.processFile(file);
        },

        handlePaste(event) {
            const items = (event.clipboardData || event.originalEvent.clipboardData).items;
            for (let i = 0; i < items.length; i++) {
                if (items[i].kind === 'file' && items[i].type.startsWith('image/')) {
                    this.processFile(items[i].getAsFile());
                    break;
                }
            }
        },

        processFile(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imageUrl   = e.target.result;
                this.base64Data = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removeImage() {
            this.imageUrl   = '';
            this.base64Data = '';
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endsection
