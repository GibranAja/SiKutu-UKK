@extends('layouts.anggota')

@section('title', 'Denda Saya - Sikutu')
@section('header', 'Informasi Denda')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-amber-500 text-white border-amber-600">
        <h3 class="font-oswald text-lg font-medium opacity-90">Total Denda Belum Lunas</h3>
        <p class="font-montserrat text-4xl font-bold mt-2">Rp {{ number_format($totalBelumLunas, 0, ',', '.') }}</p>
    </div>
    
    <div class="col-span-1 md:col-span-2 card flex items-center bg-blue-50 border-blue-100 p-6">
        <div class="mr-4 text-blue-600 bg-white p-3 rounded-full shadow-sm">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h4 class="font-oswald font-medium text-lg text-blue-900 mb-1">Informasi Pembayaran</h4>
            <p class="text-sm text-blue-800 font-montserrat">
                Denda dapat dibayar secara <strong>Tunai</strong> langsung ke petugas perpustakaan, atau <strong>Transfer</strong> ke rekening Bank Sekolah (BCA: 1234567890 a.n Sikutu). Jangan lupa upload bukti transfer!
            </p>
        </div>
    </div>
</div>

<div class="card p-0 overflow-hidden" x-data="{ modalOpen: false, selectedDenda: null, metode: 'TUNAI', base64Data: '', imageUrl: '' }">
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
                        @if($denda->status_denda == 'BELUM_LUNAS')
                            <button @click="selectedDenda = '{{ $denda->uuid }}'; modalOpen = true; metode = 'TUNAI'; base64Data = ''; imageUrl = '';" class="btn-primary py-1.5 px-3 text-xs">
                                Bayar
                            </button>
                        @else
                            <span class="text-xs text-gray-400 italic">Tidak ada aksi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Bagus! Kamu tidak memiliki riwayat denda.</td>
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

    <!-- Modal Pembayaran -->
    <div x-show="modalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="modalOpen = false" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="modalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form :action="'{{ url('siswa/denda') }}/' + selectedDenda + '/bayar'" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl leading-6 font-bold font-oswald text-gray-900" id="modal-title">
                                    Bayar Denda
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <!-- Custom AlpineJS Select -->
                                    <div class="relative" x-data="{ openSelect: false }">
                                        <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Metode Pembayaran</label>
                                        <input type="hidden" name="metode_pembayaran" x-model="metode">
                                        <div @click="openSelect = !openSelect" class="input-field flex justify-between items-center cursor-pointer bg-white">
                                            <span x-text="metode === 'TUNAI' ? 'Bayar Tunai ke Petugas' : 'Transfer Bank'"></span>
                                            <svg class="w-5 h-5 text-gray-400 transform transition-transform" :class="{'rotate-180': openSelect}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="openSelect" @click.away="openSelect = false" style="display: none;" class="absolute z-10 mt-1 w-full bg-white rounded shadow-lg border border-gray-200">
                                            <div @click="metode = 'TUNAI'; openSelect = false" class="px-4 py-2 hover:bg-blue-50 cursor-pointer font-montserrat text-sm transition-colors">Bayar Tunai ke Petugas</div>
                                            <div @click="metode = 'TRANSFER'; openSelect = false" class="px-4 py-2 hover:bg-blue-50 cursor-pointer font-montserrat text-sm transition-colors border-t border-gray-100">Transfer Bank</div>
                                        </div>
                                    </div>

                                    <div x-show="metode === 'TRANSFER'" x-transition class="bg-blue-50 p-4 rounded border border-blue-100 mt-4">
                                        <p class="text-sm font-semibold text-blue-900 font-oswald mb-1">Info Rekening Sekolah</p>
                                        <p class="text-sm text-blue-800">Bank BCA: <strong>1234567890</strong> (a.n Sikutu)</p>
                                    </div>

                                    <!-- Custom AlpineJS Image Uploader -->
                                    <div x-show="metode === 'TRANSFER'" x-transition class="mt-4" 
                                         @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50')" 
                                         @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50')" 
                                         @drop.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50'); handleDrop($event)"
                                         @paste.window="if(metode === 'TRANSFER') handlePaste($event)">
                                        
                                        <label class="block text-sm font-medium text-gray-700 mb-1 font-oswald">Bukti Transfer <span class="text-red-500">*</span></label>
                                        <input type="hidden" name="bukti_pembayaran_base64" x-model="base64Data">
                                        
                                        <div class="w-full relative border-2 border-dashed border-gray-300 bg-white rounded-lg p-4 flex flex-col items-center justify-center transition-colors cursor-pointer" @click="$refs.fileInputBukti.click()">
                                            <input type="file" x-ref="fileInputBukti" @change="handleFileSelect($event)" accept="image/*" class="hidden">
                                            
                                            <div x-show="!imageUrl" class="text-center">
                                                <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                                <p class="mt-1 text-xs text-gray-600 font-montserrat">Klik, drag, atau Ctrl+V</p>
                                            </div>

                                            <div x-show="imageUrl" class="relative w-full flex justify-center" style="display: none;">
                                                <img :src="imageUrl" class="max-h-32 rounded shadow-sm object-contain">
                                                <button type="button" @click.stop="removeImage()" class="absolute top-0 right-0 -mt-2 -mr-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 focus:outline-none transition-transform hover:scale-110">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm font-oswald transition-colors">
                            Submit Pembayaran
                        </button>
                        <button type="button" @click="modalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm font-oswald transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('pembayaranDenda', () => ({
        // Using Alpine $data from parent div implicitly
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
            this.$refs.fileInputBukti.value = '';
        }
    }));
});
</script>
@endsection