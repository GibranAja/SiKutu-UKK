<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'log_aktivitas';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_log';

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'id_admin',
        'aksi',
        'modul',
        'deskripsi',
        'ip_address',
        'user_agent',
        'data_lama',
        'data_baru',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'data_lama' => 'array',
            'data_baru' => 'array',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Log milik satu admin.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Catat aktivitas admin.
     */
    public static function catat(
        ?int $idAdmin,
        string $aksi,
        string $modul,
        ?string $deskripsi = null,
        ?array $dataLama = null,
        ?array $dataBaru = null
    ): self {
        return static::create([
            'id_admin'   => $idAdmin,
            'aksi'       => $aksi,
            'modul'      => $modul,
            'deskripsi'  => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'data_lama'  => $dataLama,
            'data_baru'  => $dataBaru,
        ]);
    }
}
