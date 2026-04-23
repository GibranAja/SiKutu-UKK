<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnggotaPerpustakaan extends Authenticatable
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'anggota_perpustakaan';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id_anggota';

    /**
     * Daftar kelas yang tersedia.
     */
    public const KELAS = ['10', '11', '12'];

    /**
     * Daftar jurusan yang tersedia beserta kelas-kelasnya.
     */
    public const JURUSAN = [
        'PPLG' => ['10 PPLG 1', '10 PPLG 2', '10 PPLG 3', '11 PPLG 1', '11 PPLG 2', '11 PPLG 3', '12 PPLG 1', '12 PPLG 2', '12 PPLG 3'],
        'BCF'  => ['10 BCF 1', '10 BCF 2', '11 BCF 1', '11 BCF 2', '12 BCF 1', '12 BCF 2'],
        'ANM'  => ['10 ANM 1', '10 ANM 2', '11 ANM 1', '11 ANM 2', '12 ANM 1', '12 ANM 2'],
        'TO'   => ['10 TO 1', '10 TO 2', '11 TO 1', '11 TO 2', '12 TO 1', '12 TO 2'],
        'TPFL' => ['10 TPFL 1', '10 TPFL 2', '11 TPFL 1', '11 TPFL 2', '12 TPFL 1', '12 TPFL 2'],
    ];

    /**
     * Status anggota yang tersedia.
     */
    public const STATUS = ['AKTIF', 'NONAKTIF', 'DIBLOKIR'];

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'nis',
        'kelas',
        'jurusan',
        'alamat',
        'no_telepon',
        'email',
        'photo_profile',
        'status_anggota',
        'tanggal_daftar',
        'masa_berlaku',
        'id_admin',
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
            'tanggal_daftar' => 'date',
            'masa_berlaku' => 'date',
        ];
    }

    // =========================================================================
    //  RELATIONSHIPS
    // =========================================================================

    /**
     * Anggota didaftarkan oleh satu admin.
     */
    public function adminPendaftar(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    /**
     * Anggota memiliki banyak peminjaman.
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah anggota aktif.
     */
    public function isAktif(): bool
    {
        return $this->status_anggota === 'AKTIF';
    }

    /**
     * Cek apakah kartu anggota masih berlaku.
     */
    public function isMasihBerlaku(): bool
    {
        return $this->masa_berlaku >= now()->toDateString();
    }

    /**
     * Mendapatkan semua pilihan jurusan dalam format flat array.
     */
    public static function getAllJurusan(): array
    {
        $all = [];
        foreach (self::JURUSAN as $jurusan => $kelas) {
            $all = array_merge($all, $kelas);
        }
        return $all;
    }

    /**
     * Hitung jumlah buku yang sedang dipinjam.
     */
    public function jumlahBukuDipinjam(): int
    {
        return $this->peminjaman()
                    ->where('status_peminjaman', 'DIPINJAM')
                    ->count();
    }
}
