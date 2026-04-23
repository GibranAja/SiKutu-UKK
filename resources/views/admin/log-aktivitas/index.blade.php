@extends('layouts.admin')

@section('title', 'Log Aktivitas - Sikutu')
@section('header', 'Log Aktivitas Sistem')

@section('content')
<div class="card p-0 overflow-hidden">
    <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
        <h3 class="font-oswald text-lg font-medium text-gray-800">Catatan Aktivitas Admin</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 font-oswald">
                <tr>
                    <th class="px-6 py-4">Waktu</th>
                    <th class="px-6 py-4">Admin</th>
                    <th class="px-6 py-4">Aktivitas</th>
                    <th class="px-6 py-4 text-right">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium">{{ $log->admin->nama_lengkap ?? 'System' }}</div>
                        <div class="text-xs text-gray-500">{{ $log->ip_address }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded bg-gray-200 text-gray-700 uppercase">{{ $log->jenis_aktivitas }}</span>
                        <p class="mt-1 text-gray-800">{{ $log->deskripsi }}</p>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($log->data_lama || $log->data_baru)
                        <a href="{{ route('admin.log-aktivitas.show', $log->id_log) }}" class="text-blue-600 hover:text-blue-900 text-xs font-semibold uppercase tracking-wider flex items-center justify-end">
                            Lihat
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        @else
                        <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">Belum ada log aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
