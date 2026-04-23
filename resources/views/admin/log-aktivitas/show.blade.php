@extends('layouts.admin')

@section('title', 'Detail Log Aktivitas - Sikutu')
@section('header', 'Detail Log Aktivitas')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <a href="{{ route('admin.log-aktivitas.index') }}" class="text-blue-600 hover:text-blue-800 font-medium flex items-center transition-colors w-fit">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Log
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 animate-[fadeIn_0.3s_ease-in-out]">
    <div class="lg:col-span-1 space-y-6">
        <div class="card p-5 border-t-4 border-t-blue-500">
            <h3 class="font-oswald text-lg font-medium text-gray-800 mb-4 border-b pb-2">Informasi Umum</h3>
            
            <div class="space-y-4 text-sm">
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Waktu Aktivitas</span>
                    <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($log->created_at)->format('d F Y H:i:s') }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Admin</span>
                    <span class="font-medium text-gray-900">{{ $log->admin->nama_lengkap ?? 'Sistem' }} ({{ $log->admin->username ?? '-' }})</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">IP Address / User Agent</span>
                    <span class="font-medium text-gray-900">{{ $log->ip_address }}</span>
                    <span class="block text-xs text-gray-500 mt-1 truncate" title="{{ $log->user_agent }}">{{ $log->user_agent }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Jenis Aktivitas</span>
                    <span class="px-2 py-1 text-xs font-bold rounded bg-gray-200 text-gray-800 uppercase inline-block">{{ $log->jenis_aktivitas }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Tabel Terkait</span>
                    <span class="font-medium text-gray-900">{{ $log->tabel_terkait ?: '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-500 font-semibold uppercase mb-1">Deskripsi</span>
                    <p class="text-gray-800 bg-gray-50 p-2 rounded border">{{ $log->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-6">
        @if($log->data_lama || $log->data_baru)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="card p-0 overflow-hidden border-t-4 border-t-red-400">
                <div class="p-3 bg-red-50 border-b border-red-100">
                    <h4 class="font-oswald font-medium text-red-800">Data Lama (Sebelum)</h4>
                </div>
                <div class="p-0">
                    @if($log->data_lama)
                        <pre class="text-xs p-4 overflow-x-auto text-gray-700 bg-gray-50">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT) }}</pre>
                    @else
                        <div class="p-6 text-center text-gray-400 text-sm italic">Tidak ada data lama</div>
                    @endif
                </div>
            </div>

            <div class="card p-0 overflow-hidden border-t-4 border-t-emerald-500">
                <div class="p-3 bg-emerald-50 border-b border-emerald-100">
                    <h4 class="font-oswald font-medium text-emerald-800">Data Baru (Sesudah)</h4>
                </div>
                <div class="p-0">
                    @if($log->data_baru)
                        <pre class="text-xs p-4 overflow-x-auto text-gray-700 bg-gray-50">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT) }}</pre>
                    @else
                        <div class="p-6 text-center text-gray-400 text-sm italic">Tidak ada data baru</div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="card p-10 flex flex-col items-center justify-center text-center">
            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <h3 class="text-lg font-medium text-gray-900 font-oswald mb-1">Tidak Ada Detail Data Tersimpan</h3>
            <p class="text-sm text-gray-500">Aktivitas ini tidak mencatat perubahan data JSON (data lama/baru).</p>
        </div>
        @endif
    </div>
</div>
@endsection
