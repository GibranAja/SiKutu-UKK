<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengaturanDenda;
use App\Models\LogAktivitas;

class DendaController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanDenda::getAktif();
        return view('admin.denda.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'denda_per_hari'  => 'required|numeric|min:0',
            'maks_hari_pinjam' => 'required|integer|min:1|max:90',
        ], [
            'denda_per_hari.required'   => 'Denda per hari wajib diisi.',
            'denda_per_hari.min'        => 'Denda per hari tidak boleh negatif.',
            'maks_hari_pinjam.required' => 'Maksimal hari pinjam wajib diisi.',
            'maks_hari_pinjam.min'      => 'Minimal 1 hari.',
            'maks_hari_pinjam.max'      => 'Maksimal 90 hari.',
        ]);

        $pengaturan = PengaturanDenda::getAktif();
        $dataLama = $pengaturan ? $pengaturan->toArray() : null;

        if ($pengaturan) {
            $pengaturan->update([
                'denda_per_hari'   => $request->input('denda_per_hari'),
                'maks_hari_pinjam' => $request->input('maks_hari_pinjam'),
                'updated_by'       => Auth::guard('admin')->id(),
            ]);
        } else {
            $pengaturan = PengaturanDenda::create([
                'denda_per_hari'   => $request->input('denda_per_hari'),
                'maks_hari_pinjam' => $request->input('maks_hari_pinjam'),
                'is_active'        => true,
                'updated_by'       => Auth::guard('admin')->id(),
            ]);
        }

        LogAktivitas::catat(Auth::guard('admin')->id(), 'UPDATE_PENGATURAN_DENDA', 'denda', "Mengupdate pengaturan denda: Rp " . number_format($pengaturan->denda_per_hari, 0, ',', '.') . "/hari, maks {$pengaturan->maks_hari_pinjam} hari", $dataLama, $pengaturan->fresh()->toArray());

        return redirect()->route('admin.denda.index')->with('success', 'Pengaturan denda berhasil diperbarui.');
    }
}
