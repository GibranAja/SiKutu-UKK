<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\LogAktivitas;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'email'         => 'required|email|max:100|unique:admins,email,' . $admin->id_admin . ',id_admin',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama_lengkap', 'email']);

        if ($request->hasFile('photo_profile')) {
            if ($admin->photo_profile) {
                Storage::disk('public')->delete($admin->photo_profile);
            }
            $data['photo_profile'] = $request->file('photo_profile')->store('profiles/admin', 'public');
        }

        $admin->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password minimal 6 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $admin->update(['password' => $request->input('new_password')]);

        LogAktivitas::catat($admin->id_admin, 'CHANGE_PASSWORD', 'profile', 'Admin mengubah password');

        return redirect()->route('admin.profile')->with('success', 'Password berhasil diubah.');
    }
}
