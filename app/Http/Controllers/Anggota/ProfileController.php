<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $anggota = Auth::guard('anggota')->user();
        return view('anggota.profile.index', compact('anggota'));
    }

    public function update(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'alamat'        => 'nullable|string|max:500',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100|unique:anggota_perpustakaan,email,' . $anggota->id_anggota . ',id_anggota',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama_lengkap', 'alamat', 'no_telepon', 'email']);

        if ($request->hasFile('photo_profile')) {
            if ($anggota->photo_profile) {
                Storage::disk('public')->delete($anggota->photo_profile);
            }
            $data['photo_profile'] = $request->file('photo_profile')->store('profiles/anggota', 'public');
        }

        $anggota->update($data);
        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $anggota = Auth::guard('anggota')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $anggota->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $anggota->update(['password' => $request->input('new_password')]);
        return redirect()->route('siswa.profile')->with('success', 'Password berhasil diubah.');
    }
}
