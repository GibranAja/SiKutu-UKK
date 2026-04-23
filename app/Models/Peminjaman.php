<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use App\Traits\HasUuid;

class Peminjaman extends Model
{
    use HasFactory, HasUuid;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'peminjamans';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_peminjaman';

    /**
     * Konstanta status peminjaman.
     */
    public const STATUS = ['DIPINJAM', 'DIKEMBALIKAN'];

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'id_anggota',
        'id_buku',
        'id_admin_pinjam',
        'tanggal_pinjam',
        'tanggal_harus_kembali',
        'status_peminjaman',
        'catatan_peminjaman',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_harus_kembali' => 'date',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Peminjaman milik satu anggota.
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(AnggotaPerpustakaan::class, 'id_anggota', 'id_anggota');
    }

    /**
     * Peminjaman untuk satu buku.
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    /**
     * Peminjaman disetujui oleh satu admin.
     */
    public function adminPinjam(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin_pinjam', 'id_admin');
    }

    /**
     * Peminjaman memiliki satu pengembalian (1:1).
     */
    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id_peminjaman');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah peminjaman sudah melewati batas waktu.
     */
    public function isTerlambat(): bool
    {
        return Carbon::now()->gt($this->tanggal_harus_kembali) && $this->status_peminjaman === 'DIPINJAM';
    }

    /**
     * Hitung jumlah hari keterlambatan.
     */
    public function hitungHariTerlambat(): int
    {
        if (!$this->isTerlambat()) {
            return 0;
        }

        $now = Carbon::now()->startOfDay();
        $harus = $this->tanggal_harus_kembali->copy()->startOfDay();

        return (int) abs($now->diffInDays($harus));
    }

    /**
     * Hitung jumlah hari terlambat berdasarkan tanggal pengembalian aktual.
     */
    public function hitungHariTerlambatDari(Carbon $tanggalKembali): int
    {
        $kembali = $tanggalKembali->copy()->startOfDay();
        $harus = $this->tanggal_harus_kembali->copy()->startOfDay();

        if ($kembali->lte($harus)) {
            return 0;
        }

        return (int) abs($kembali->diffInDays($harus));
    }

    /**
     * Cek apakah peminjaman sudah dikembalikan.
     */
    public function isDikembalikan(): bool
    {
        return $this->status_peminjaman === 'DIKEMBALIKAN';
    }
}
