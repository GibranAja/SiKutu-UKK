<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\HasUuid;

class Genre extends Model
{
    use HasFactory, HasUuid;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'genres';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_genre';

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'nama_genre',
        'deskripsi',
    ];

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Genre dimiliki oleh banyak buku (Many-to-Many).
     */
    public function bukus(): BelongsToMany
    {
        return $this->belongsToMany(Buku::class, 'buku_genre', 'id_genre', 'id_buku');
    }
}
