<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    /**
     * Nama tabel yang digunakan model ini.
     */
    protected $table = 'password_resets';

    /**
     * Nonaktifkan timestamps otomatis karena kita hanya punya created_at.
     */
    public $timestamps = false;

    /**
     * Atribut yang bisa diisi massal.
     */
    protected $fillable = [
        'username',
        'token',
        'tipe_user',
        'is_used',
        'expired_at',
        'created_at',
    ];

    /**
     * Cast atribut.
     */
    protected function casts(): array
    {
        return [
            'is_used' => 'boolean',
            'expired_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    // =========================================================================
    //  HELPER METHODS
    // =========================================================================

    /**
     * Cek apakah token masih valid (belum expired & belum digunakan).
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expired_at->isFuture();
    }

    /**
     * Tandai token sebagai sudah digunakan.
     */
    public function markAsUsed(): void
    {
        $this->update(['is_used' => true]);
    }
}
