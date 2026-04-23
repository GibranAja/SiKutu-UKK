<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengembalian;

class DendaController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();

        $dendas = Pengembalian::with(['peminjaman.buku'])
            ->whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->where('denda_total', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalBelumLunas = Pengembalian::whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->whereIn('status_denda', ['BELUM_LUNAS', 'DITOLAK'])
            ->sum('denda_total');

        return view('anggota.denda.index', compact('dendas', 'totalBelumLunas'));
    }

    public function bayar(\Illuminate\Http\Request $request, string $id)
    {
        $anggota = Auth::guard('anggota')->user();
        
        $pengembalian = Pengembalian::where('uuid', $id)
            ->whereHas('peminjaman', fn($q) => $q->where('id_anggota', $anggota->id_anggota))
            ->firstOrFail();

        if ($pengembalian->status_denda !== 'BELUM_LUNAS' && $pengembalian->status_denda !== 'DITOLAK') {
            return back()->with('error', 'Status denda tidak valid untuk pembayaran.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:TUNAI,TRANSFER',
            'bukti_pembayaran_base64' => 'required_if:metode_pembayaran,TRANSFER|nullable|string',
        ], [
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
            'bukti_pembayaran_base64.required_if' => 'Bukti pembayaran wajib diunggah untuk metode Transfer.',
        ]);

        $data = [
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_denda' => 'MENUNGGU_KONFIRMASI'
        ];

        if ($request->metode_pembayaran === 'TRANSFER' && $request->filled('bukti_pembayaran_base64')) {
            $base64 = $request->input('bukti_pembayaran_base64');
            if (str_contains($base64, ';base64,')) {
                @list($type, $file_data) = explode(';', $base64);
                @list(, $file_data)      = explode(',', $file_data);
                
                $extension = 'jpg';
                if (str_contains($type, 'png')) $extension = 'png';
                else if (str_contains($type, 'webp')) $extension = 'webp';
                
                $fileName = 'bukti/' . \Illuminate\Support\Str::uuid() . '.' . $extension;
                \Illuminate\Support\Facades\Storage::disk('public')->put($fileName, base64_decode($file_data));
                $data['bukti_pembayaran'] = $fileName;
            }
        }

        $pengembalian->update($data);

        return back()->with('success', 'Pembayaran berhasil diajukan. Silakan tunggu konfirmasi admin.');
    }
}
