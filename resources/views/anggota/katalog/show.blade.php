@extends('layouts.anggota')

@section('title', 'Detail Buku - Sikutu')
@section('header', 'Detail Buku')

<style>
    [x-cloak] { display: none !important; }
</style>

@section('content')
<div x-data="borrowModal()" x-init="init()">

    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center text-sm font-montserrat text-gray-600">
        <a href="{{ route('siswa.katalog.index') }}" class="hover:text-blue-600 transition-colors">Katalog Buku</a>
        <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-900 font-medium truncate">{{ $buku->judul_buku }}</span>
    </div>

    {{-- Card Detail Buku --}}
    {{-- PENTING: Hilangkan overflow-hidden dari card agar tidak membuat stacking context baru --}}
    <div class="card p-0 bg-white rounded-lg shadow">
        <div class="flex flex-col md:flex-row">

            {{-- Cover --}}
            <div class="w-full md:w-1/3 lg:w-1/4 bg-gray-100 p-6 flex justify-center items-start">
                <div class="w-full max-w-[200px] md:max-w-full rounded-lg overflow-hidden shadow-lg relative pt-[140%]">
                    @if($buku->gambar_cover)
                        <img src="{{ Storage::url($buku->gambar_cover) }}"
                             alt="{{ $buku->judul_buku }}"
                             class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-200 text-gray-400">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Detail --}}
            <div class="w-full md:w-2/3 lg:w-3/4 p-6 md:p-8">
                <div class="mb-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($buku->status_buku == 'TERSEDIA' && $buku->kondisi == 'BAIK' && $buku->stok > 0)
                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 rounded-full">
                                    Tersedia ({{ $buku->stok }} buku)
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-red-100 text-red-800 rounded-full">
                                    Tidak Tersedia
                                </span>
                            @endif
                            <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-800 rounded-full">
                                {{ $buku->kode_buku }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold font-oswald text-gray-900 mb-2">{{ $buku->judul_buku }}</h1>
                        <p class="text-lg text-blue-600 font-medium font-montserrat">{{ $buku->pengarang }}</p>
                    </div>
                </div>

                <div class="py-4 border-y border-gray-100 mb-6 mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 font-oswald uppercase tracking-wide">Penerbit</p>
                            <p class="font-medium text-gray-800">{{ $buku->penerbit ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-oswald uppercase tracking-wide">Tahun Terbit</p>
                            <p class="font-medium text-gray-800">{{ $buku->tahun_terbit ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-oswald uppercase tracking-wide">Jenis Buku</p>
                            <p class="font-medium text-gray-800">{{ $buku->jenis_buku ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 font-oswald uppercase tracking-wide">Kondisi Fisik</p>
                            <p class="font-medium {{ $buku->kondisi == 'BAIK' ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $buku->kondisi }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm text-gray-500 font-oswald uppercase tracking-wide mb-2">Genre / Kategori</h3>
                    <div class="flex flex-wrap gap-2 mb-6">
                        @forelse($buku->genres as $genre)
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full border border-gray-200">
                                {{ $genre->nama_genre }}
                            </span>
                        @empty
                            <span class="text-sm text-gray-500 italic">Tidak ada genre</span>
                        @endforelse
                    </div>

                    @if($buku->isTersedia())
                        <button
                            type="button"
                            @click.stop="openModal()"
                            class="btn-primary px-6 py-3 text-lg w-full sm:w-auto text-center flex justify-center items-center"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Pinjam Buku
                        </button>
                    @else
                        <button disabled class="px-6 py-3 bg-gray-300 text-gray-500 font-oswald font-medium rounded shadow-none cursor-not-allowed w-full sm:w-auto text-center">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         MODAL — Struktur yang benar:

         MASALAH SEBELUMNYA:
         Di dalam wrapper fixed z-50, overlay juga pakai "fixed inset-0"
         tanpa z-index eksplisit. Element dengan position:fixed di dalam
         stacking context selalu berada di atas elemen non-positioned,
         sehingga overlay menimpa dialog. Datepicker keliatan karena
         z-[9999] cukup tinggi untuk tembus overlay.

         SOLUSI:
         1. Wrapper modal  → fixed inset-0 z-50 flex (pusat alignment)
         2. Overlay        → absolute inset-0 (mengikuti wrapper, bukan viewport)
         3. Dialog         → relative z-10 (pasti di atas overlay)
         Tidak ada lagi dua elemen "fixed" dalam satu stacking context.
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
        aria-labelledby="modal-title"
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
            class="relative z-10 bg-white rounded-lg shadow-xl w-full max-w-lg overflow-visible"
            @click.stop
        >
            <form action="{{ route('siswa.katalog.pinjam', $buku->uuid) }}" method="POST">
                @csrf

                {{-- Header Modal --}}
                <div class="px-6 pt-6 pb-4">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="w-full">
                            <h3 class="text-xl font-bold font-oswald text-gray-900" id="modal-title">
                                Konfirmasi Peminjaman
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 font-montserrat">
                                Kamu akan meminjam buku <strong>{{ $buku->judul_buku }}</strong>.
                                Tanggal pinjam adalah hari ini. Silakan pilih tanggal pengembalian.
                            </p>

                            {{-- Datepicker --}}
                            <div class="relative mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">
                                    Tanggal Kembali <span class="text-red-500">*</span>
                                </label>

                                <input type="hidden" name="tanggal_harus_kembali" x-model="selectedDate">

                                {{-- Trigger --}}
                                <div
                                    @click.stop="showDatepicker = !showDatepicker"
                                    class="input-field flex justify-between items-center cursor-pointer bg-white border border-gray-300 rounded-md px-3 py-2 select-none"
                                >
                                    <span
                                        x-text="formattedDate"
                                        :class="selectedDate ? 'text-gray-800' : 'text-gray-400'"
                                    ></span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                {{-- Dropdown Kalender --}}
                                <div
                                    x-show="showDatepicker"
                                    x-cloak
                                    @click.stop
                                    @click.away="showDatepicker = false"
                                    class="absolute z-20 mt-1 w-full bg-white rounded-lg shadow-lg border border-gray-200 p-3"
                                >
                                    {{-- Navigasi Bulan --}}
                                    <div class="flex justify-between items-center mb-2">
                                        <button type="button" @click="changeMonth(-1)" class="p-1 hover:bg-gray-100 rounded text-gray-600 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                            </svg>
                                        </button>
                                        <span class="font-oswald font-medium text-gray-800" x-text="monthNames[month] + ' ' + year"></span>
                                        <button type="button" @click="changeMonth(1)" class="p-1 hover:bg-gray-100 rounded text-gray-600 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Header Hari --}}
                                    <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-1">
                                        <div>Min</div><div>Sen</div><div>Sel</div>
                                        <div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                                    </div>

                                    {{-- Grid Tanggal --}}
                                    <div class="grid grid-cols-7 gap-1 text-sm text-center">
                                        <template x-for="blank in blankDays" :key="'blank-' + blank">
                                            <div class="p-1"></div>
                                        </template>
                                        <template x-for="day in daysInMonth" :key="day">
                                            <button
                                                type="button"
                                                @click="selectDate(day)"
                                                :disabled="isPastDate(day)"
                                                :class="{
                                                    'bg-blue-600 text-white font-bold rounded-full': isSelected(day),
                                                    'text-gray-800 hover:bg-blue-100 rounded-full': !isSelected(day) && !isPastDate(day),
                                                    'text-gray-300 cursor-not-allowed': isPastDate(day)
                                                }"
                                                class="p-1.5 w-8 h-8 flex items-center justify-center mx-auto transition-colors focus:outline-none"
                                            >
                                                <span x-text="day"></span>
                                            </button>
                                        </template>
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
                        :disabled="!selectedDate"
                        :class="selectedDate ? 'bg-blue-600 hover:bg-blue-700 cursor-pointer' : 'bg-blue-300 cursor-not-allowed'"
                        class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-sm font-medium font-oswald text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                    >
                        Ajukan Pinjaman
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function borrowModal() {
    return {
        modalOpen: false,
        showDatepicker: false,
        selectedDate: '',
        formattedDate: 'Pilih Tanggal',
        month: new Date().getMonth(),
        year: new Date().getFullYear(),
        daysInMonth: [],
        blankDays: [],
        monthNames: [
            'Januari','Februari','Maret','April','Mei','Juni',
            'Juli','Agustus','September','Oktober','November','Desember'
        ],

        init() {
            this.initDatepicker();
        },

        openModal() {
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
            this.showDatepicker = false;
        },

        initDatepicker() {
            // Default: 3 hari dari hari ini
            let d = new Date();
            d.setDate(d.getDate() + 3);
            this.month = d.getMonth();
            this.year  = d.getFullYear();
            this.selectedDate   = this.formatDateForInput(d);
            this.formattedDate  = this.formatDateForDisplay(d);
            this.getDays();
        },

        formatDateForInput(date) {
            let d = new Date(date);
            let mm = String(d.getMonth() + 1).padStart(2, '0');
            let dd = String(d.getDate()).padStart(2, '0');
            return `${d.getFullYear()}-${mm}-${dd}`;
        },

        formatDateForDisplay(date) {
            let d = new Date(date);
            return `${d.getDate()} ${this.monthNames[d.getMonth()]} ${d.getFullYear()}`;
        },

        getDays() {
            let totalDays   = new Date(this.year, this.month + 1, 0).getDate();
            let startDay    = new Date(this.year, this.month, 1).getDay();

            this.blankDays  = Array.from({ length: startDay }, (_, i) => i);
            this.daysInMonth = Array.from({ length: totalDays }, (_, i) => i + 1);
        },

        changeMonth(amount) {
            this.month += amount;
            if (this.month < 0)  { this.month = 11; this.year--; }
            if (this.month > 11) { this.month = 0;  this.year++; }
            this.getDays();
        },

        isPastDate(day) {
            let d     = new Date(this.year, this.month, day);
            let today = new Date();
            today.setHours(0, 0, 0, 0);
            return d <= today;
        },

        isSelected(day) {
            let d = new Date(this.year, this.month, day);
            return this.selectedDate === this.formatDateForInput(d);
        },

        selectDate(day) {
            if (this.isPastDate(day)) return;
            let d = new Date(this.year, this.month, day);
            this.selectedDate  = this.formatDateForInput(d);
            this.formattedDate = this.formatDateForDisplay(d);
            this.showDatepicker = false;
        }
    }
}
</script>
@endsection
