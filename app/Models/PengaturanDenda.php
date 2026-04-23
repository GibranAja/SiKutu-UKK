<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanDenda extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'pengaturan_denda';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_pengaturan';

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'denda_per_hari',
        'maks_hari_pinjam',
        'is_active',
        'updated_by',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'denda_per_hari' => 'decimal:2',
            'maks_hari_pinjam' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Pengaturan terakhir diupdate oleh admin.
     */
    public function updatedByAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id_admin');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Ambil pengaturan denda yang aktif.
     */
    public static function getAktif(): ?self
    {
        return static::where('is_active', true)->first();
    }

    /**
     * Hitung denda keterlambatan berdasarkan jumlah hari.
     */
    public function hitungDendaKeterlambatan(int $jumlahHari): float
    {
        return $jumlahHari * (float) $this->denda_per_hari;
    }
}
