<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('admin');

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('aksi', 'like', "%{$s}%")
                  ->orWhere('modul', 'like', "%{$s}%")
                  ->orWhere('deskripsi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('modul')) {
            $query->where('modul', $request->input('modul'));
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->input('tanggal_dari'));
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->input('tanggal_sampai'));
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        $modulList = LogAktivitas::select('modul')->distinct()->orderBy('modul')->pluck('modul');

        return view('admin.log-aktivitas.index', compact('logs', 'modulList'));
    }

    public function show(int $id)
    {
        $log = LogAktivitas::with('admin')->findOrFail($id);
        return view('admin.log-aktivitas.show', compact('log'));
    }
}
