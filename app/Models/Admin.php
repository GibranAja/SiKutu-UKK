<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'admins';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_admin';

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'photo_profile',
    ];

    /**
     * Atribut yang disembunyikan dari serialisasi.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Admin mendaftarkan banyak anggota perpustakaan.
     */
    public function anggotaYangDidaftarkan(): HasMany
    {
        return $this->hasMany(AnggotaPerpustakaan::class, 'id_admin', 'id_admin');
    }

    /**
     * Admin menyetujui banyak peminjaman.
     */
    public function peminjamanYangDisetujui(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_admin_pinjam', 'id_admin');
    }

    /**
     * Admin memproses banyak pengembalian.
     */
    public function pengembalianYangDiproses(): HasMany
    {
        return $this->hasMany(Pengembalian::class, 'id_petugas_kembali', 'id_admin');
    }

    /**
     * Admin memiliki banyak log aktivitas.
     */
    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'id_admin', 'id_admin');
    }
}
