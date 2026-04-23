<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\HasUuid;

class Buku extends Model
{
    use HasFactory, HasUuid;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'bukus';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_buku';

    /**
     * Konstanta kondisi buku.
     */
    public const KONDISI = ['BAIK', 'RUSAK', 'HILANG'];

    /**
     * Konstanta status buku.
     */
    public const STATUS = ['TERSEDIA', 'DIPINJAM', 'TIDAK_TERSEDIA'];

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jenis_buku',
        'stok',
        'kondisi',
        'gambar_cover',
        'status_buku',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'stok' => 'integer',
            'tahun_terbit' => 'integer',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Buku memiliki banyak genre (Many-to-Many).
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'buku_genre', 'id_buku', 'id_genre');
    }

    /**
     * Buku memiliki banyak peminjaman.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_buku', 'id_buku');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah buku tersedia untuk dipinjam.
     */
    public function isTersedia(): bool
    {
        return $this->status_buku === 'TERSEDIA' && $this->stok > 0;
    }

    /**
     * Kurangi stok buku saat dipinjam.
     */
    public function kurangiStok(): void
    {
        $this->decrement('stok');

        if ($this->stok <= 0) {
            $this->update(['status_buku' => 'TIDAK_TERSEDIA']);
        }
    }

    /**
     * Tambah stok buku saat dikembalikan.
     */
    public function tambahStok(): void
    {
        $this->increment('stok');

        if ($this->stok > 0 && $this->status_buku === 'TIDAK_TERSEDIA') {
            $this->update(['status_buku' => 'TERSEDIA']);
        }
    }
}
