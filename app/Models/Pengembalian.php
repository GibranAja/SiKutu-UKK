<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasUuid;

class Pengembalian extends Model
{
    use HasFactory, HasUuid;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'pengembalians';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_pengembalian';

    /**
     * Konstanta kondisi buku saat dikembalikan.
     */
    public const KONDISI_KEMBALI = ['BAIK', 'RUSAK'];

    /**
     * Konstanta status denda.
     */
    public const STATUS_DENDA = ['LUNAS', 'BELUM_LUNAS', 'TIDAK_ADA'];

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'id_peminjaman',
        'tanggal_kembali',
        'kondisi_buku_kembali',
        'denda_keterlambatan',
        'denda_kondisi',
        'denda_total',
        'status_denda',
        'id_petugas_kembali',
        'catatan_petugas',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'tanggal_kembali' => 'date',
            'denda_keterlambatan' => 'decimal:2',
            'denda_kondisi' => 'decimal:2',
            'denda_total' => 'decimal:2',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Pengembalian milik satu peminjaman (1:1).
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Pengembalian diproses oleh satu admin.
     */
    public function petugasKembali(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_petugas_kembali', 'id_admin');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah ada denda.
     */
    public function adaDenda(): bool
    {
        return $this->denda_total > 0;
    }

    /**
     * Cek apakah denda sudah lunas.
     */
    public function isDendaLunas(): bool
    {
        return $this->status_denda === 'LUNAS' || $this->status_denda === 'TIDAK_ADA';
    }

    /**
     * Tandai denda sebagai lunas.
     */
    public function lunaskanDenda(): void
    {
        if ($this->adaDenda()) {
            $this->update(['status_denda' => 'LUNAS']);
        }
    }
}
