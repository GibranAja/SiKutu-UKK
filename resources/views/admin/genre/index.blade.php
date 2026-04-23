@extends('layouts.admin')

@section('title', 'Manajemen Genre - Sikutu')
@section('header', 'Manajemen Genre')

@section('content')
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<div x-data="genreManager()" class="space-y-4">
    <div class="mb-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <form action="{{ route('admin.genre.index') }}" method="GET" class="w-full sm:w-auto flex-1 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama genre..." class="input-field w-full sm:max-w-xs">
        <button type="submit" class="btn-secondary whitespace-nowrap">Filter</button>
        @if(request()->filled('search'))
            <a href="{{ route('admin.genre.index') }}" class="btn-danger whitespace-nowrap bg-gray-500 hover:bg-gray-600 border-none ring-0">Reset</a>
        @endif
    </form>

        <div class="flex gap-2">
            <button type="button" @click="$refs.fileImport.click()" class="btn-secondary whitespace-nowrap flex items-center bg-teal-600 hover:bg-teal-700 text-white border-none">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import
            </button>
            <input type="file" x-ref="fileImport" @change="handleImport" accept=".xlsx" class="hidden">
            
            <div class="relative" x-data="{ openExport: false }">
                <button type="button" @click="openExport = !openExport" class="btn-secondary whitespace-nowrap flex items-center bg-gray-600 hover:bg-gray-700 text-white border-none">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export
                </button>
                <div x-show="openExport" @click.away="openExport = false" class="absolute right-0 mt-2 w-32 bg-white rounded-md shadow-lg border border-gray-200 z-10" x-cloak>
                    <button type="button" @click="exportExcel(); openExport = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Excel (.xlsx)</button>
                    <button type="button" @click="exportCSV(); openExport = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">CSV (.csv)</button>
                    <button type="button" @click="exportPDF(); openExport = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDF / Print</button>
                </div>
            </div>

            <a href="{{ route('admin.genre.create') }}" class="btn-primary whitespace-nowrap flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah
            </a>
        </div>
    </div>

<div class="card p-0 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Nama Genre</th>
                    <th class="px-6 py-4">Deskripsi</th>
                    <th class="px-6 py-4">Jumlah Buku</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($genres as $genre)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $genre->nama_genre }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ Str::limit($genre->deskripsi, 50) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $genre->bukus_count }} Buku</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.genre.edit', $genre->uuid) }}" class="text-amber-600 hover:text-amber-900 p-1 inline-block transition-transform hover:scale-110" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.genre.destroy', $genre->id_genre) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus genre ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 p-1 transition-transform hover:scale-110" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">Data genre tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($genres->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $genres->links() }}
    </div>
    @endif
</div>
</div>

<script>
function genreManager() {
    return {
        async getAllGenre() {
            try {
                const response = await fetch('{{ route("admin.genre.get-all") }}');
                return await response.json();
            } catch (err) {
                alert('Gagal mengambil data genre.');
                return [];
            }
        },
        
        formatDataForExport(data) {
            return data.map(g => ({
                'Nama Genre': g.nama_genre,
                'Deskripsi': g.deskripsi || '-',
                'Jumlah Buku': g.bukus_count || 0
            }));
        },

        async exportExcel() {
            const data = await this.getAllGenre();
            if(!data.length) return alert('Tidak ada data.');
            const ws = XLSX.utils.json_to_sheet(this.formatDataForExport(data));
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Data Genre");
            XLSX.writeFile(wb, "Data_Genre_Sikutu.xlsx");
        },

        async exportCSV() {
            const data = await this.getAllGenre();
            if(!data.length) return alert('Tidak ada data.');
            const ws = XLSX.utils.json_to_sheet(this.formatDataForExport(data));
            const csv = XLSX.utils.sheet_to_csv(ws);
            const blob = new Blob(["\uFEFF"+csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "Data_Genre_Sikutu.csv";
            link.click();
        },

        async exportPDF() {
            const data = await this.getAllGenre();
            if(!data.length) return alert('Tidak ada data.');
            let html = '<table border="1" cellpadding="5" cellspacing="0" style="width:100%; border-collapse:collapse; font-family:sans-serif; font-size:12px;">';
            html += '<tr><th>Nama Genre</th><th>Deskripsi</th><th>Jumlah Buku</th></tr>';
            data.forEach(g => {
                html += `<tr><td>${g.nama_genre}</td><td>${g.deskripsi||'-'}</td><td>${g.bukus_count||0}</td></tr>`;
            });
            html += '</table>';
            
            const printWin = window.open('', '_blank');
            printWin.document.write('<html><head><title>Cetak PDF Data Genre</title></head><body>');
            printWin.document.write('<h2>Data Genre Sikutu</h2>');
            printWin.document.write(html);
            printWin.document.write('</body></html>');
            printWin.document.close();
            setTimeout(() => { printWin.print(); }, 500);
        },

        handleImport(e) {
            const file = e.target.files[0];
            if(!file) return;
            const reader = new FileReader();
            reader.onload = async (evt) => {
                const data = evt.target.result;
                const wb = XLSX.read(data, { type: 'binary' });
                const wsname = wb.SheetNames[0];
                const ws = wb.Sheets[wsname];
                const json = XLSX.utils.sheet_to_json(ws);
                
                if(!json.length) return alert('File kosong atau format salah!');
                
                const payload = json.map(row => ({
                    nama_genre: row['Nama Genre'] || row['nama_genre'] || '',
                    deskripsi: row['Deskripsi'] || row['deskripsi'] || ''
                })).filter(g => g.nama_genre);
                
                if(!payload.length) return alert('Format Excel tidak sesuai. Pastikan ada kolom Nama Genre.');
                
                try {
                    const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
                    const res = await fetch('{{ route("admin.genre.import-json") }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                        body: JSON.stringify({ genres: payload })
                    });
                    const result = await res.json();
                    if(result.success) {
                        alert(result.message);
                        window.location.reload();
                    } else {
                        alert('Gagal mengimpor: ' + (result.message || 'Error validasi'));
                    }
                } catch(err) {
                    alert('Terjadi kesalahan saat mengimpor.');
                }
                this.$refs.fileImport.value = '';
            };
            reader.readAsBinaryString(file);
        }
    }
}
</script>
@endsection
