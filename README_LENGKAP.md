# SIKUTU - Sistem Katalog Terpadu Universitas

Dokumentasi Lengkap Aplikasi Manajemen Perpustakaan Digital

---

## DAFTAR ISI

1. Deskripsi Proyek
2. Fitur-Fitur Utama
3. Teknologi yang Digunakan
4. Prasyarat Sistem
5. Panduan Instalasi
6. Konfigurasi Lingkungan
7. Struktur Database
8. Struktur Direktori Proyek
9. Routes dan Endpoints API
10. Model dan Relationships
11. Panduan Pengguna Admin
12. Panduan Pengguna Anggota
13. Fitur-Fitur Detail
14. Panduan Development
15. Testing dan Quality Assurance
16. Troubleshooting dan FAQ
17. Kontribusi dan Lisensi

---

## 1. DESKRIPSI PROYEK

SIKUTU adalah aplikasi web modern untuk mengelola perpustakaan digital dengan kemampuan manajemen buku, anggota, peminjaman, pengembalian, dan sistem denda otomatis.

### 1.1 Tujuan Aplikasi

Aplikasi ini dirancang untuk:

- Mengelola katalog buku perpustakaan secara terpusat dan terstruktur
- Memudahkan proses peminjaman dan pengembalian buku
- Mengotomatisasi sistem perhitungan denda keterlambatan
- Memberikan akses mudah bagi anggota perpustakaan untuk melihat buku dan riwayat peminjaman
- Menyediakan dashboard admin untuk monitoring dan kontrol penuh
- Mencatat semua aktivitas dalam log untuk audit trail
- Menyediakan sistem kategorisasi buku berdasarkan genre

### 1.2 Target Pengguna

- Admin Perpustakaan: Mengelola semua aspek perpustakaan
- Anggota Perpustakaan: Melihat katalog buku dan mengelola peminjaman pribadi

---

## 2. FITUR-FITUR UTAMA

### 2.1 Fitur Admin

#### Manajemen Buku
- Tambah, edit, dan hapus buku
- Kelola stok buku
- Tentukan kondisi buku (BAIK, RUSAK, HILANG)
- Kelola status buku (TERSEDIA, DIPINJAM, TIDAK_TERSEDIA)
- Asosiasikan buku dengan genre
- Upload cover buku
- Import data buku dari file JSON
- Soft delete untuk recovery data yang terhapus

#### Manajemen Genre
- Tambah, edit, dan hapus kategori genre buku
- Asosiasikan multiple genre ke satu buku

#### Manajemen Anggota
- Tambah anggota perpustakaan baru
- Edit data anggota
- Lihat data detail anggota
- Toggle status aktif/nonaktif anggota
- Reset password anggota
- Hapus data anggota

#### Manajemen Peminjaman
- Lihat semua permintaan peminjaman
- Terima permintaan peminjaman (status menjadi DIPINJAM)
- Tolak permintaan peminjaman
- Kelola durasi peminjaman
- Catat catatan peminjaman
- Tracking tanggal pengembalian

#### Manajemen Pengembalian
- Lihat semua pengembalian buku
- Proses pengembalian buku
- Hitung dan kelola denda keterlambatan otomatis
- Terima pembayaran denda
- Tolak pembayaran denda

#### Pengaturan Denda
- Tentukan tarif denda per hari
- Update pengaturan denda kapan saja

#### Log Aktivitas
- Pencatatan otomatis semua aktivitas
- Filter berdasarkan tipe aktivitas
- Filter berdasarkan user yang melakukan

#### Recycle Bin
- Restore data yang telah dihapus
- Lihat data yang terhapus dengan timestamp
- Permanent delete data

#### Dashboard Admin
- Overview statistik perpustakaan
- Jumlah buku, anggota, peminjaman aktif
- Grafik peminjaman
- Notifikasi keterlambatan
- Widget ringkasan

### 2.2 Fitur Anggota

#### Browsing Katalog
- Cari buku berdasarkan judul, pengarang, penerbit
- Filter buku berdasarkan genre
- Lihat detail buku lengkap
- Lihat cover buku
- Lihat ketersediaan stok buku

#### Permintaan Peminjaman
- Ajukan peminjaman buku
- Lihat status permintaan peminjaman
- Tentukan durasi peminjaman yang diinginkan
- Tambahkan catatan permintaan
- Lihat history permintaan yang ditolak

#### Kelola Peminjaman
- Lihat daftar buku yang sedang dipinjam
- Lihat tanggal harus kembali
- Hitung sisa hari peminjaman
- Lihat warning keterlambatan
- Notifikasi deadline peminjaman

#### Pengembalian Buku
- Informasi self-service untuk pengembalian
- Lihat daftar buku yang harus dikembalikan
- Tracking status pengembalian
- Lihat apakah ada denda

#### Kelola Denda
- Lihat detail denda keterlambatan
- Lihat history pembayaran denda
- Status pembayaran (belum dibayar, menunggu konfirmasi, dibayar)

#### Profil User
- Edit data profil pribadi
- Ubah password
- Lihat informasi akun
- Lihat history aktivitas pribadi

#### Dashboard Anggota
- Ringkasan buku yang sedang dipinjam
- Ringkasan denda yang belum dibayar
- Widget notifikasi penting
- Quick access ke fitur utama

---

## 3. TEKNOLOGI YANG DIGUNAKAN

### 3.1 Backend

- **PHP 8.3+**: Bahasa pemrograman server-side
- **Laravel 13.0**: Web framework PHP modern
- **MySQL**: Database relasional
- **Vinkla Hashids**: Library untuk generate hash ID unik

### 3.2 Frontend

- **Blade Template Engine**: Laravel template engine
- **Tailwind CSS 4.2**: CSS framework utility-first
- **Alpine.js 3.15**: Lightweight JavaScript framework
- **Vite**: Build tool dan module bundler
- **PostCSS**: CSS transformation tool
- **Autoprefixer**: CSS vendor prefixing

### 3.3 Development Tools

- **Composer**: PHP package manager
- **npm**: JavaScript package manager
- **Pest**: Testing framework modern untuk PHP
- **Laravel Pail**: Log monitoring
- **Laravel Pint**: PHP code style formatter
- **Mockery**: Mocking library untuk unit tests

### 3.4 Utilities

- **Fontsource Montserrat**: Custom font Montserrat
- **Fontsource Oswald**: Custom font Oswald
- **Collision**: Error reporting untuk Laravel

---

## 4. PRASYARAT SISTEM

### 4.1 Requirement Minimal

- PHP 8.3 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.5 atau lebih tinggi
- Composer (PHP dependency manager)
- Node.js 18+ dan npm 9+
- Git

### 4.2 Web Server

- Apache dengan mod_rewrite enabled, atau
- Nginx dengan proper configuration, atau
- Laravel Artisan Development Server (untuk development)

### 4.3 File System

- Write access ke direktori: `storage/`, `bootstrap/cache/`
- Izin eksekusi untuk file: `artisan`

### 4.4 Disk Space

- Minimal 500 MB untuk vendor dan node_modules
- Minimal 100 MB untuk database
- Ruang tambahan untuk upload cover buku

---

## 5. PANDUAN INSTALASI

### 5.1 Instalasi dengan Setup Script

Cara tercepat menggunakan script setup yang sudah disiapkan:

```bash
composer setup
```

Script ini akan otomatis melakukan:
1. Install PHP dependencies via Composer
2. Copy file .env.example ke .env jika belum ada
3. Generate APP_KEY Laravel
4. Jalankan database migrations
5. Install JavaScript dependencies via npm
6. Build assets dengan Vite

### 5.2 Instalasi Manual Step-by-Step

Jika ingin melakukan instalasi manual:

STEP 1: Clone repository
```bash
git clone <repository-url> sikutu
cd sikutu
```

STEP 2: Copy environment file
```bash
cp .env.example .env
```

STEP 3: Install PHP dependencies
```bash
composer install
```

STEP 4: Generate application key
```bash
php artisan key:generate
```

STEP 5: Buat database MySQL
```sql
CREATE DATABASE sikutu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

STEP 6: Konfigurasi .env file
Edit file `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sikutu
DB_USERNAME=root
DB_PASSWORD=
APP_URL=http://localhost:8000
```

STEP 7: Jalankan database migrations
```bash
php artisan migrate --force
```

STEP 8: (Optional) Jalankan database seeders
```bash
php artisan db:seed
```

STEP 9: Install JavaScript dependencies
```bash
npm install --ignore-scripts
```

STEP 10: Build front-end assets
Untuk production:
```bash
npm run build
```

Atau untuk development:
```bash
npm run dev
```

### 5.3 Verifikasi Instalasi

Untuk memastikan instalasi berhasil:

```bash
# Jalankan development server
php artisan serve

# Di terminal lain, jalankan Vite dev server
npm run dev

# Di terminal ketiga, jalankan queue listener (opsional)
php artisan queue:listen --tries=1
```

Akses aplikasi di: http://localhost:8000

---

## 6. KONFIGURASI LINGKUNGAN

### 6.1 Konfigurasi .env

Berikut adalah variabel environment yang penting:

```
APP_NAME=SIKUTU
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=single
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sikutu
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@sikutu.test
MAIL_FROM_NAME="SIKUTU"
```

### 6.2 Konfigurasi Database

Database dikonfigurasi di `config/database.php`. Untuk MySQL:

```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', 3306),
    'database' => env('DB_DATABASE', 'sikutu'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]
```

### 6.3 Konfigurasi Session

Session dikonfigurasi di `config/session.php`:

```php
'driver' => env('SESSION_DRIVER', 'file'),
'lifetime' => env('SESSION_LIFETIME', 120),
'cookie' => env('SESSION_COOKIE', 'XSRF-TOKEN'),
```

### 6.4 Konfigurasi Cache

Cache dikonfigurasi di `config/cache.php`:

```php
'default' => env('CACHE_DRIVER', 'file'),
'stores' => [
    'file' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/data'),
    ],
]
```

### 6.5 Konfigurasi Queue

Queue dikonfigurasi di `config/queue.php`:

```php
'default' => env('QUEUE_CONNECTION', 'database'),
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
    ],
]
```

### 6.6 Konfigurasi Mail

Mail dikonfigurasi di `config/mail.php` untuk development biasanya menggunakan log driver.

### 6.7 Konfigurasi Tailwind CSS

Tailwind CSS dikonfigurasi di `tailwind.config.js`:

```javascript
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
```

### 6.8 Konfigurasi Vite

Vite dikonfigurasi di `vite.config.js`:

```javascript
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default {
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
    tailwindcss(),
  ],
}
```

---

## 7. STRUKTUR DATABASE

### 7.1 Tabel Admins

Tabel untuk menyimpan data admin perpustakaan.

```
COLUMNS:
- id (PRIMARY KEY)
- nama_admin (VARCHAR 255)
- email (VARCHAR 255, UNIQUE)
- password (VARCHAR 255)
- nomor_hp (VARCHAR 20, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- deleted_at (TIMESTAMP, NULLABLE - SoftDelete)

INDEXES:
- email (UNIQUE)
- deleted_at
```

### 7.2 Tabel AnggotaPerpustakaan

Tabel untuk menyimpan data anggota perpustakaan.

```
COLUMNS:
- id (PRIMARY KEY)
- nama_lengkap (VARCHAR 255)
- nim_nis (VARCHAR 50, UNIQUE)
- email (VARCHAR 255, UNIQUE)
- password (VARCHAR 255)
- nomor_hp (VARCHAR 20)
- alamat (TEXT)
- jurusan (VARCHAR 100)
- tahun_masuk (YEAR)
- status (ENUM: AKTIF, NONAKTIF)
- foto (VARCHAR 255, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- deleted_at (TIMESTAMP, NULLABLE - SoftDelete)

INDEXES:
- email (UNIQUE)
- nim_nis (UNIQUE)
- status
- deleted_at
```

### 7.3 Tabel Genres

Tabel untuk menyimpan kategori/genre buku.

```
COLUMNS:
- id (PRIMARY KEY)
- nama_genre (VARCHAR 255)
- deskripsi (TEXT, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- nama_genre (UNIQUE)
```

### 7.4 Tabel Bukus

Tabel untuk menyimpan data buku.

```
COLUMNS:
- id_buku (UUID PRIMARY KEY)
- kode_buku (VARCHAR 100, UNIQUE)
- judul_buku (VARCHAR 255)
- pengarang (VARCHAR 255)
- penerbit (VARCHAR 255)
- tahun_terbit (YEAR)
- jenis_buku (VARCHAR 100)
- stok (INTEGER)
- kondisi (ENUM: BAIK, RUSAK, HILANG)
- gambar_cover (VARCHAR 255, NULLABLE)
- status_buku (ENUM: TERSEDIA, DIPINJAM, TIDAK_TERSEDIA)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- deleted_at (TIMESTAMP, NULLABLE - SoftDelete)

INDEXES:
- kode_buku (UNIQUE)
- judul_buku
- pengarang
- status_buku
- deleted_at
```

### 7.5 Tabel BukuGenre

Tabel pivot untuk relasi many-to-many antara Buku dan Genre.

```
COLUMNS:
- id (PRIMARY KEY)
- id_buku (UUID, FOREIGN KEY -> bukus.id_buku)
- id_genre (BIGINT UNSIGNED, FOREIGN KEY -> genres.id)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- id_buku (FOREIGN KEY)
- id_genre (FOREIGN KEY)
- Unique(id_buku, id_genre)
```

### 7.6 Tabel Peminjamans

Tabel untuk menyimpan data peminjaman buku.

```
COLUMNS:
- id_peminjaman (UUID PRIMARY KEY)
- id_anggota (BIGINT UNSIGNED, FOREIGN KEY -> anggota_perpustakaans.id)
- id_buku (UUID, FOREIGN KEY -> bukus.id_buku)
- id_admin_pinjam (BIGINT UNSIGNED, FOREIGN KEY -> admins.id)
- tanggal_pinjam (DATE)
- tanggal_harus_kembali (DATE)
- status_peminjaman (ENUM: DIPINJAM, DIKEMBALIKAN)
- catatan_peminjaman (TEXT, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- id_anggota (FOREIGN KEY)
- id_buku (FOREIGN KEY)
- id_admin_pinjam (FOREIGN KEY)
- status_peminjaman
- tanggal_harus_kembali
```

### 7.7 Tabel Pengembalians

Tabel untuk menyimpan data pengembalian buku.

```
COLUMNS:
- id (PRIMARY KEY)
- id_peminjaman (UUID, FOREIGN KEY -> peminjamans.id_peminjaman)
- id_anggota (BIGINT UNSIGNED, FOREIGN KEY -> anggota_perpustakaans.id)
- id_buku (UUID, FOREIGN KEY -> bukus.id_buku)
- tanggal_pengembalian (DATE)
- kondisi_buku_dikembalikan (ENUM: BAIK, RUSAK)
- denda_keterlambatan (DECIMAL 10,2)
- status_denda (ENUM: BELUM_DIBAYAR, MENUNGGU_KONFIRMASI, DIBAYAR)
- catatan_pengembalian (TEXT, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- id_peminjaman (FOREIGN KEY, UNIQUE)
- id_anggota (FOREIGN KEY)
- id_buku (FOREIGN KEY)
- status_denda
```

### 7.8 Tabel PengaturanDendas

Tabel untuk menyimpan konfigurasi sistem denda.

```
COLUMNS:
- id (PRIMARY KEY)
- denda_per_hari (DECIMAL 10,2)
- maksimal_hari_peminjaman (INTEGER)
- denda_maksimal (DECIMAL 10,2, NULLABLE)
- status (ENUM: AKTIF, NONAKTIF)
- catatan (TEXT, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- status
```

### 7.9 Tabel LogAktivitas

Tabel untuk mencatat semua aktivitas di sistem.

```
COLUMNS:
- id (PRIMARY KEY)
- user_id (BIGINT UNSIGNED, NULLABLE, FOREIGN KEY)
- tipe_aktivitas (VARCHAR 255)
- deskripsi (TEXT)
- tabel_terkait (VARCHAR 255, NULLABLE)
- id_tabel_terkait (VARCHAR 255, NULLABLE)
- ip_address (VARCHAR 45, NULLABLE)
- user_agent (TEXT, NULLABLE)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)

INDEXES:
- user_id (FOREIGN KEY)
- tipe_aktivitas
- created_at
```

### 7.10 Tabel PasswordResets

Tabel untuk menyimpan token reset password.

```
COLUMNS:
- email (VARCHAR 255, PRIMARY KEY)
- token (VARCHAR 255)
- created_at (TIMESTAMP)

INDEXES:
- created_at
```

### 7.11 Tabel Cache dan Jobs (Framework)

```
cache:
- key (VARCHAR 255, PRIMARY KEY)
- value (TEXT)
- expiration (BIGINT)

jobs:
- id (BIGINT UNSIGNED PRIMARY KEY)
- queue (VARCHAR 255)
- payload (TEXT)
- attempts (TINYINT UNSIGNED)
- reserved_at (BIGINT UNSIGNED, NULLABLE)
- available_at (BIGINT UNSIGNED)
- created_at (BIGINT UNSIGNED)
```

---

## 8. STRUKTUR DIREKTORI PROYEK

### 8.1 Root Directory

```
sikutu-ukk/
├── app/                          # Aplikasi utama
│   ├── Http/
│   │   ├── Controllers/          # Controllers
│   │   │   ├── Admin/            # Admin controllers
│   │   │   ├── Anggota/          # Anggota controllers
│   │   │   ├── AuthController.php
│   │   │   ├── RegisterController.php
│   │   │   └── ForgotPasswordController.php
│   │   ├── Middleware/           # Custom middleware
│   │   └── Requests/             # Form requests untuk validation
│   ├── Models/                   # Eloquent models
│   │   ├── Admin.php
│   │   ├── AnggotaPerpustakaan.php
│   │   ├── Buku.php
│   │   ├── Genre.php
│   │   ├── Peminjaman.php
│   │   ├── Pengembalian.php
│   │   ├── PengaturanDenda.php
│   │   ├── LogAktivitas.php
│   │   └── PasswordReset.php
│   ├── Providers/                # Service providers
│   │   └── AppServiceProvider.php
│   └── Traits/                   # Reusable traits
│       └── HasUuid.php           # UUID generator trait
├── bootstrap/                    # Bootstrap files
│   ├── app.php                   # Application bootstrap
│   ├── providers.php             # Provider bootstrap
│   └── cache/                    # Cache files
├── config/                       # Configuration files
│   ├── app.php                   # App configuration
│   ├── auth.php                  # Authentication
│   ├── cache.php                 # Cache driver
│   ├── database.php              # Database connection
│   ├── filesystems.php           # File storage
│   ├── hashids.php               # Hashids config
│   ├── logging.php               # Logging config
│   ├── mail.php                  # Mail configuration
│   ├── queue.php                 # Queue configuration
│   ├── services.php              # Third-party services
│   └── session.php               # Session configuration
├── database/                     # Database files
│   ├── factories/                # Model factories untuk testing
│   │   └── UserFactory.php
│   ├── migrations/               # Database migrations
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2026_04_22_000001_create_admins_table.php
│   │   ├── 2026_04_22_000002_create_anggota_perpustakaan_table.php
│   │   ├── 2026_04_22_000003_create_genres_table.php
│   │   ├── 2026_04_22_000004_create_bukus_table.php
│   │   ├── 2026_04_22_000005_create_buku_genre_table.php
│   │   ├── 2026_04_22_000006_create_peminjamans_table.php
│   │   ├── 2026_04_22_000007_create_pengembalians_table.php
│   │   ├── 2026_04_22_000008_create_pengaturan_denda_table.php
│   │   ├── 2026_04_22_000009_create_log_aktivitas_table.php
│   │   └── 2026_04_22_000010_create_password_resets_table.php
│   └── seeders/                  # Database seeders
├── public/                       # Public web root
│   ├── index.php                 # Application entry point
│   ├── robots.txt
│   ├── storage/                  # Symlink to storage/app/public
│   └── build/                    # Vite build output
├── resources/                    # Frontend resources
│   ├── css/                      # CSS files
│   │   └── app.css              # Main stylesheet
│   ├── js/                       # JavaScript files
│   │   └── app.js               # Main JavaScript
│   └── views/                    # Blade templates
│       ├── layouts/              # Layout templates
│       ├── admin/                # Admin views
│       ├── anggota/              # Anggota views
│       ├── auth/                 # Authentication views
│       ├── components/           # Reusable components
│       └── errors/               # Error pages
├── routes/                       # Route definitions
│   ├── web.php                   # Web routes
│   └── console.php               # Console commands
├── storage/                      # Storage directory
│   ├── app/                      # App storage
│   ├── framework/                # Framework files
│   ├── logs/                     # Application logs
│   └── cache/                    # Cache files
├── tests/                        # Test files
│   ├── Pest.php                  # Pest configuration
│   ├── TestCase.php              # Base test case
│   ├── Feature/                  # Feature tests
│   └── Unit/                     # Unit tests
├── vendor/                       # Composer dependencies (generated)
├── node_modules/                 # npm dependencies (generated)
├── .env.example                  # Environment file template
├── .gitignore                    # Git ignore file
├── artisan                       # Artisan console script
├── composer.json                 # Composer configuration
├── composer.lock                 # Composer lock file
├── package.json                  # npm configuration
├── package-lock.json             # npm lock file
├── phpunit.xml                   # PHPUnit configuration
├── postcss.config.js             # PostCSS configuration
├── tailwind.config.js            # Tailwind CSS configuration
├── vite.config.js                # Vite configuration
└── README.md                     # This file
```

### 8.2 Direktori Penting

#### app/Http/Controllers/

Controllers diorganisir dalam subdirectori berdasarkan role:

```
Controllers/
├── AuthController.php            # Login/logout
├── RegisterController.php         # Register anggota baru
├── ForgotPasswordController.php   # Password reset
├── Admin/
│   ├── DashboardController.php
│   ├── BukuController.php
│   ├── GenreController.php
│   ├── AnggotaController.php
│   ├── PeminjamanController.php
│   ├── PengembalianController.php
│   ├── DendaController.php
│   ├── LogAktivitasController.php
│   ├── RecycleBinController.php
│   ├── ProfileController.php
│   └── ExportController.php
└── Anggota/
    ├── DashboardController.php
    ├── BukuController.php
    ├── PeminjamanController.php
    ├── DendaController.php
    ├── ProfileController.php
    └── NotifikasiController.php
```

#### app/Models/

Setiap model mewakili entitas database:

```
Models/
├── Admin.php                     # Admin perpustakaan
├── AnggotaPerpustakaan.php       # Anggota (members)
├── Buku.php                      # Books
├── Genre.php                     # Book genres/categories
├── Peminjaman.php                # Borrowing records
├── Pengembalian.php              # Return records
├── PengaturanDenda.php           # Fine settings
├── LogAktivitas.php              # Activity logs
└── PasswordReset.php             # Password reset tokens
```

#### resources/views/

Views diorganisir berdasarkan feature/page:

```
views/
├── layouts/
│   ├── app.blade.php             # Main layout
│   ├── admin.blade.php           # Admin layout
│   └── anggota.blade.php         # Anggota layout
├── admin/
│   ├── dashboard/
│   │   └── index.blade.php
│   ├── buku/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── anggota/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── show.blade.php
│   ├── peminjaman/
│   ├── pengembalian/
│   ├── denda/
│   ├── log-aktivitas/
│   └── recycle-bin/
├── anggota/
│   ├── dashboard/
│   ├── buku/
│   ├── peminjaman/
│   ├── denda/
│   └── profil/
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php
│   └── forgot-password.blade.php
├── components/
│   ├── navbar.blade.php
│   ├── sidebar.blade.php
│   ├── form.blade.php
│   └── modal.blade.php
└── errors/
    ├── 404.blade.php
    └── 500.blade.php
```

#### database/migrations/

Migrations disusun berdasarkan urutan eksekusi dan dependencies:

```
migrations/
├── [Laravel Framework Tables]
│   ├── 0001_01_01_000001_create_cache_table.php
│   └── 0001_01_01_000002_create_jobs_table.php
├── [Aplikasi Tables]
│   ├── 2026_04_22_000001_create_admins_table.php
│   ├── 2026_04_22_000002_create_anggota_perpustakaan_table.php
│   ├── 2026_04_22_000003_create_genres_table.php
│   ├── 2026_04_22_000004_create_bukus_table.php
│   ├── 2026_04_22_000005_create_buku_genre_table.php
│   ├── 2026_04_22_000006_create_peminjamans_table.php
│   ├── 2026_04_22_000007_create_pengembalians_table.php
│   ├── 2026_04_22_000008_create_pengaturan_denda_table.php
│   ├── 2026_04_22_000009_create_log_aktivitas_table.php
│   └── 2026_04_22_000010_create_password_resets_table.php
```

---

## 9. ROUTES DAN ENDPOINTS API

### 9.1 Public Routes (Guest Only)

Route yang hanya bisa diakses oleh user yang belum login.

#### Authentication Routes

ENDPOINT: GET /login
METHOD: GET
DESCRIPTION: Tampilkan form login
RESPONSE: Blade template form login
MIDDLEWARE: guest.sikutu

ENDPOINT: POST /login
METHOD: POST
DESCRIPTION: Process login request
BODY: {email, password}
RESPONSE: Redirect ke dashboard
MIDDLEWARE: guest.sikutu
VALIDATION: Email required dan valid, password required

ENDPOINT: GET /register
METHOD: GET
DESCRIPTION: Tampilkan form register anggota baru
RESPONSE: Blade template form register
MIDDLEWARE: guest.sikutu

ENDPOINT: POST /register
METHOD: POST
DESCRIPTION: Process registrasi anggota baru
BODY: {nama_lengkap, nim_nis, email, password, nomor_hp, alamat, jurusan, tahun_masuk}
RESPONSE: Redirect ke login dengan success message
MIDDLEWARE: guest.sikutu
VALIDATION: Semua field wajib diisi, email dan nim_nis unique

#### Password Reset Routes

ENDPOINT: GET /forgot-password
METHOD: GET
DESCRIPTION: Tampilkan form lupa password
RESPONSE: Blade template form forgot password
MIDDLEWARE: guest.sikutu

ENDPOINT: POST /forgot-password
METHOD: POST
DESCRIPTION: Request password reset
BODY: {email}
RESPONSE: Redirect dengan success message
MIDDLEWARE: guest.sikutu
VALIDATION: Email harus terdaftar di sistem

ENDPOINT: GET /reset-password
METHOD: GET
QUERY PARAMS: token={reset_token}&email={email}
DESCRIPTION: Tampilkan form reset password
RESPONSE: Blade template form reset password
MIDDLEWARE: guest.sikutu

ENDPOINT: POST /reset-password
METHOD: POST
DESCRIPTION: Process password reset
BODY: {email, token, password, password_confirmation}
RESPONSE: Redirect ke login
MIDDLEWARE: guest.sikutu
VALIDATION: Token valid, password minimal 8 karakter

#### Logout Route

ENDPOINT: POST /logout
METHOD: POST
DESCRIPTION: Process logout
RESPONSE: Redirect ke login
MIDDLEWARE: auth (user harus sudah login)

---

### 9.2 Admin Routes

Route untuk admin perpustakaan dengan prefix `/admin`.

#### Dashboard

ENDPOINT: GET /admin/dashboard
METHOD: GET
DESCRIPTION: Tampilkan admin dashboard
RESPONSE: Dashboard view dengan statistik
MIDDLEWARE: auth.admin
STATS: Total buku, anggota, peminjaman aktif, denda belum dibayar

#### Manajemen Buku

ENDPOINT: GET /admin/buku
METHOD: GET
DESCRIPTION: List semua buku dengan pagination
QUERY PARAMS: page=1, search=, genre_id=, status=
RESPONSE: List view dengan search dan filter
MIDDLEWARE: auth.admin
FEATURES: Search judul/pengarang/penerbit, filter genre, filter status

ENDPOINT: GET /admin/buku/get-all
METHOD: GET
DESCRIPTION: Get all buku (API response)
RESPONSE: JSON array of books dengan relationships
MIDDLEWARE: auth.admin
FORMAT: JSON {id_buku, kode_buku, judul_buku, pengarang, stok, status_buku, genres}

ENDPOINT: POST /admin/buku/import-json
METHOD: POST
DESCRIPTION: Import buku dari file JSON
BODY: Form data dengan file
RESPONSE: Redirect dengan success/error message
MIDDLEWARE: auth.admin
VALIDATION: File harus JSON valid

ENDPOINT: GET /admin/buku/create
METHOD: GET
DESCRIPTION: Tampilkan form tambah buku
RESPONSE: Create view
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/buku
METHOD: POST
DESCRIPTION: Simpan buku baru
BODY: {kode_buku, judul_buku, pengarang, penerbit, tahun_terbit, jenis_buku, stok, kondisi, status_buku, genre_ids, gambar_cover}
RESPONSE: Redirect ke detail buku
MIDDLEWARE: auth.admin
VALIDATION: kode_buku unique, stok >= 0

ENDPOINT: GET /admin/buku/{uuid}
METHOD: GET
DESCRIPTION: Tampilkan detail buku
RESPONSE: Detail view
MIDDLEWARE: auth.admin
PARAM: uuid adalah UUID dari buku

ENDPOINT: GET /admin/buku/{uuid}/edit
METHOD: GET
DESCRIPTION: Tampilkan form edit buku
RESPONSE: Edit view
MIDDLEWARE: auth.admin
PARAM: uuid adalah UUID dari buku

ENDPOINT: PUT /admin/buku/{uuid}
METHOD: PUT
DESCRIPTION: Update buku
BODY: {kode_buku, judul_buku, pengarang, penerbit, tahun_terbit, jenis_buku, stok, kondisi, status_buku, genre_ids}
RESPONSE: Redirect ke detail buku
MIDDLEWARE: auth.admin
PARAM: uuid adalah UUID dari buku

ENDPOINT: DELETE /admin/buku/{uuid}
METHOD: DELETE
DESCRIPTION: Hapus (soft delete) buku
RESPONSE: Redirect ke list buku
MIDDLEWARE: auth.admin
PARAM: uuid adalah UUID dari buku
NOTE: Buku tidak benar-benar dihapus, bisa di-restore dari recycle bin

#### Manajemen Genre

ENDPOINT: GET /admin/genre
METHOD: GET
DESCRIPTION: List semua genre
QUERY PARAMS: page=1, search=
RESPONSE: List view
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/genre/get-all
METHOD: GET
DESCRIPTION: Get all genre (API response)
RESPONSE: JSON array of genres
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/genre/import-json
METHOD: POST
DESCRIPTION: Import genre dari file JSON
BODY: Form data dengan file
RESPONSE: Redirect dengan success/error message
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/genre/create
METHOD: GET
DESCRIPTION: Tampilkan form tambah genre
RESPONSE: Create view
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/genre
METHOD: POST
DESCRIPTION: Simpan genre baru
BODY: {nama_genre, deskripsi}
RESPONSE: Redirect ke list genre
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/genre/{id}/edit
METHOD: GET
DESCRIPTION: Tampilkan form edit genre
RESPONSE: Edit view
MIDDLEWARE: auth.admin

ENDPOINT: PUT /admin/genre/{id}
METHOD: PUT
DESCRIPTION: Update genre
BODY: {nama_genre, deskripsi}
RESPONSE: Redirect ke list genre
MIDDLEWARE: auth.admin

ENDPOINT: DELETE /admin/genre/{id}
METHOD: DELETE
DESCRIPTION: Hapus genre
RESPONSE: Redirect ke list genre
MIDDLEWARE: auth.admin

#### Manajemen Anggota

ENDPOINT: GET /admin/anggota
METHOD: GET
DESCRIPTION: List semua anggota
QUERY PARAMS: page=1, search=, status=
RESPONSE: List view
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/anggota/create
METHOD: GET
DESCRIPTION: Tampilkan form tambah anggota
RESPONSE: Create view
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/anggota
METHOD: POST
DESCRIPTION: Simpan anggota baru
BODY: {nama_lengkap, nim_nis, email, password, nomor_hp, alamat, jurusan, tahun_masuk, status}
RESPONSE: Redirect ke list anggota
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/anggota/{id}
METHOD: GET
DESCRIPTION: Tampilkan detail anggota
RESPONSE: Detail view
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/anggota/{id}/edit
METHOD: GET
DESCRIPTION: Tampilkan form edit anggota
RESPONSE: Edit view
MIDDLEWARE: auth.admin

ENDPOINT: PUT /admin/anggota/{id}
METHOD: PUT
DESCRIPTION: Update anggota
BODY: {nama_lengkap, email, nomor_hp, alamat, jurusan, status}
RESPONSE: Redirect ke detail anggota
MIDDLEWARE: auth.admin

ENDPOINT: DELETE /admin/anggota/{id}
METHOD: DELETE
DESCRIPTION: Hapus anggota (soft delete)
RESPONSE: Redirect ke list anggota
MIDDLEWARE: auth.admin

ENDPOINT: PATCH /admin/anggota/{id}/toggle-status
METHOD: PATCH
DESCRIPTION: Toggle status anggota aktif/nonaktif
RESPONSE: Redirect ke list anggota dengan success message
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/anggota/{id}/reset-password
METHOD: POST
DESCRIPTION: Reset password anggota
BODY: {new_password}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin

#### Manajemen Peminjaman

ENDPOINT: GET /admin/peminjaman
METHOD: GET
DESCRIPTION: List semua peminjaman
QUERY PARAMS: page=1, status=, anggota_id=, buku_id=
RESPONSE: List view
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/peminjaman/create
METHOD: GET
DESCRIPTION: Tampilkan form tambah peminjaman
RESPONSE: Create view
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/peminjaman
METHOD: POST
DESCRIPTION: Simpan peminjaman baru
BODY: {id_anggota, id_buku, tanggal_pinjam, durasi_hari, catatan_peminjaman}
RESPONSE: Redirect ke detail peminjaman
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/peminjaman/{uuid}
METHOD: GET
DESCRIPTION: Tampilkan detail peminjaman
RESPONSE: Detail view
MIDDLEWARE: auth.admin

ENDPOINT: PUT /admin/peminjaman/{uuid}
METHOD: PUT
DESCRIPTION: Update peminjaman
RESPONSE: Redirect ke detail peminjaman
MIDDLEWARE: auth.admin

ENDPOINT: DELETE /admin/peminjaman/{uuid}
METHOD: DELETE
DESCRIPTION: Hapus peminjaman
RESPONSE: Redirect ke list peminjaman
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/peminjaman/{uuid}/terima
METHOD: POST
DESCRIPTION: Terima/setujui permintaan peminjaman
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin
ACTION: Set status menjadi DIPINJAM, update status buku

ENDPOINT: POST /admin/peminjaman/{uuid}/tolak
METHOD: POST
DESCRIPTION: Tolak permintaan peminjaman
BODY: {alasan}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin
ACTION: Hapus record peminjaman atau set status khusus

#### Manajemen Pengembalian

ENDPOINT: GET /admin/pengembalian
METHOD: GET
DESCRIPTION: List semua pengembalian
QUERY PARAMS: page=1, tab=, status_denda=
RESPONSE: List view dengan tab
MIDDLEWARE: auth.admin
TABS: Semua, Pending denda, Lunas, Menunggu konfirmasi

ENDPOINT: GET /admin/pengembalian/create
METHOD: GET
DESCRIPTION: Tampilkan form tambah pengembalian
RESPONSE: Create view dengan daftar peminjaman aktif
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/pengembalian
METHOD: POST
DESCRIPTION: Simpan pengembalian baru
BODY: {id_peminjaman, tanggal_pengembalian, kondisi_buku_dikembalikan}
RESPONSE: Redirect ke detail pengembalian
MIDDLEWARE: auth.admin
ACTION: Hitung denda otomatis, set status peminjaman DIKEMBALIKAN

ENDPOINT: GET /admin/pengembalian/{id}
METHOD: GET
DESCRIPTION: Tampilkan detail pengembalian
RESPONSE: Detail view
MIDDLEWARE: auth.admin

ENDPOINT: PATCH /admin/pengembalian/{id}/terima-pembayaran
METHOD: PATCH
DESCRIPTION: Terima pembayaran denda
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin
ACTION: Set status_denda menjadi DIBAYAR

ENDPOINT: PATCH /admin/pengembalian/{id}/tolak-pembayaran
METHOD: PATCH
DESCRIPTION: Tolak pembayaran denda
BODY: {alasan}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin
ACTION: Set status_denda kembali ke BELUM_DIBAYAR

#### Pengaturan Denda

ENDPOINT: GET /admin/denda/setting
METHOD: GET
DESCRIPTION: Tampilkan halaman setting denda
RESPONSE: Setting view dengan form
MIDDLEWARE: auth.admin

ENDPOINT: PUT /admin/denda/setting
METHOD: PUT
DESCRIPTION: Update pengaturan denda
BODY: {denda_per_hari, maksimal_hari_peminjaman, denda_maksimal}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin
ACTION: Update data pengaturan denda

#### Log Aktivitas

ENDPOINT: GET /admin/log-aktivitas
METHOD: GET
DESCRIPTION: List log aktivitas
QUERY PARAMS: page=1, tipe_aktivitas=, user_id=, date_from=, date_to=
RESPONSE: List view
MIDDLEWARE: auth.admin

ENDPOINT: GET /admin/log-aktivitas/{id}
METHOD: GET
DESCRIPTION: Tampilkan detail log aktivitas
RESPONSE: Detail view
MIDDLEWARE: auth.admin

#### Recycle Bin

ENDPOINT: GET /admin/recycle-bin
METHOD: GET
DESCRIPTION: List data yang dihapus (soft deleted)
QUERY PARAMS: page=1, model_type=
RESPONSE: List view
MIDDLEWARE: auth.admin

ENDPOINT: POST /admin/recycle-bin/{id}/restore
METHOD: POST
DESCRIPTION: Restore data yang dihapus
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin

ENDPOINT: DELETE /admin/recycle-bin/{id}
METHOD: DELETE
DESCRIPTION: Permanent delete data
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.admin

---

### 9.3 Anggota Routes

Route untuk anggota perpustakaan (members) tanpa prefix khusus.

#### Dashboard Anggota

ENDPOINT: GET /anggota/dashboard
METHOD: GET
DESCRIPTION: Tampilkan anggota dashboard
RESPONSE: Dashboard view
MIDDLEWARE: auth.anggota
WIDGETS: Buku sedang dipinjam, denda belum dibayar, notifikasi

#### Browsing Buku

ENDPOINT: GET /anggota/buku
METHOD: GET
DESCRIPTION: List buku tersedia
QUERY PARAMS: page=1, search=, genre_id=, sort=
RESPONSE: List view dengan search dan filter
MIDDLEWARE: auth.anggota

ENDPOINT: GET /anggota/buku/{uuid}
METHOD: GET
DESCRIPTION: Tampilkan detail buku
RESPONSE: Detail view
MIDDLEWARE: auth.anggota

#### Manajemen Peminjaman Anggota

ENDPOINT: GET /anggota/peminjaman
METHOD: GET
DESCRIPTION: List peminjaman pribadi
QUERY PARAMS: page=1, status=
RESPONSE: List view
MIDDLEWARE: auth.anggota

ENDPOINT: GET /anggota/peminjaman/create
METHOD: GET
DESCRIPTION: Tampilkan form request peminjaman
RESPONSE: Create view dengan daftar buku tersedia
MIDDLEWARE: auth.anggota

ENDPOINT: POST /anggota/peminjaman
METHOD: POST
DESCRIPTION: Submit request peminjaman
BODY: {id_buku, durasi_hari, catatan_peminjaman}
RESPONSE: Redirect ke list peminjaman dengan success message
MIDDLEWARE: auth.anggota
ACTION: Create record peminjaman dengan status pending

ENDPOINT: GET /anggota/peminjaman/{uuid}
METHOD: GET
DESCRIPTION: Tampilkan detail peminjaman pribadi
RESPONSE: Detail view
MIDDLEWARE: auth.anggota

#### Denda dan Pengembalian

ENDPOINT: GET /anggota/denda
METHOD: GET
DESCRIPTION: List denda anggota
QUERY PARAMS: page=1, status=
RESPONSE: List view dengan filter
MIDDLEWARE: auth.anggota

ENDPOINT: GET /anggota/pengembalian
METHOD: GET
DESCRIPTION: Status pengembalian buku anggota
RESPONSE: List view
MIDDLEWARE: auth.anggota

#### Profil Anggota

ENDPOINT: GET /anggota/profil
METHOD: GET
DESCRIPTION: Tampilkan profil pribadi
RESPONSE: Profil view
MIDDLEWARE: auth.anggota

ENDPOINT: PUT /anggota/profil
METHOD: PUT
DESCRIPTION: Update profil pribadi
BODY: {nama_lengkap, email, nomor_hp, alamat, foto}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.anggota

ENDPOINT: PUT /anggota/profil/password
METHOD: PUT
DESCRIPTION: Update password
BODY: {password_lama, password_baru, password_confirmation}
RESPONSE: Redirect dengan success message
MIDDLEWARE: auth.anggota
VALIDATION: Password lama harus cocok, password baru minimal 8 karakter

---

## 10. MODEL DAN RELATIONSHIPS

### 10.1 Model Admin

```php
namespace App\Models;

class Admin extends Model {
    - id: Primary Key
    - nama_admin: string
    - email: string (unique)
    - password: string (hashed)
    - nomor_hp: string (nullable)
    - timestamps
    - soft deletes

    Relationships:
    - peminjaman (HasMany): Peminjaman yang diterima admin
    - logAktivitas (HasMany): Log aktivitas yang dibuat admin
}
```

Contoh Usage:
```php
$admin = Admin::find($id);
$peminjamanAdminTerima = $admin->peminjaman;
$aktivitasAdmin = $admin->logAktivitas;
```

### 10.2 Model AnggotaPerpustakaan

```php
namespace App\Models;

class AnggotaPerpustakaan extends Model {
    - id: Primary Key
    - nama_lengkap: string
    - nim_nis: string (unique)
    - email: string (unique)
    - password: string (hashed)
    - nomor_hp: string
    - alamat: text
    - jurusan: string
    - tahun_masuk: integer
    - status: enum (AKTIF, NONAKTIF)
    - foto: string (nullable)
    - timestamps
    - soft deletes

    Relationships:
    - peminjaman (HasMany): Semua peminjaman anggota
    - pengembalian (HasMany): Semua pengembalian anggota
    - denda (HasMany): Semua denda anggota
    - logAktivitas (HasMany): Log aktivitas anggota
}
```

Contoh Usage:
```php
$anggota = AnggotaPerpustakaan::find($id);
$peminjamanAktif = $anggota->peminjaman()->where('status_peminjaman', 'DIPINJAM')->get();
$dendaBelumDibayar = $anggota->denda()->where('status_denda', '!=', 'DIBAYAR')->get();
```

### 10.3 Model Buku

```php
namespace App\Models;

class Buku extends Model {
    - id_buku: UUID (Primary Key)
    - kode_buku: string (unique)
    - judul_buku: string
    - pengarang: string
    - penerbit: string
    - tahun_terbit: integer
    - jenis_buku: string
    - stok: integer
    - kondisi: enum (BAIK, RUSAK, HILANG)
    - gambar_cover: string (nullable)
    - status_buku: enum (TERSEDIA, DIPINJAM, TIDAK_TERSEDIA)
    - timestamps
    - soft deletes

    Relationships:
    - genres (BelongsToMany): Genre buku
    - peminjaman (HasMany): Semua peminjaman buku
    - pengembalian (HasMany): Semua pengembalian buku
}
```

Contoh Usage:
```php
$buku = Buku::find($uuid);
$genreBuku = $buku->genres; // Get semua genre
$peminjamanAktif = $buku->peminjaman()->where('status_peminjaman', 'DIPINJAM')->get();
```

### 10.4 Model Genre

```php
namespace App\Models;

class Genre extends Model {
    - id: Primary Key
    - nama_genre: string
    - deskripsi: text (nullable)
    - timestamps

    Relationships:
    - buku (BelongsToMany): Semua buku dalam genre
}
```

Contoh Usage:
```php
$genre = Genre::find($id);
$bukuGenre = $genre->buku; // Get semua buku dalam genre
```

### 10.5 Model Peminjaman

```php
namespace App\Models;

class Peminjaman extends Model {
    - id_peminjaman: UUID (Primary Key)
    - id_anggota: foreign key (AnggotaPerpustakaan)
    - id_buku: UUID foreign key (Buku)
    - id_admin_pinjam: foreign key (Admin)
    - tanggal_pinjam: date
    - tanggal_harus_kembali: date
    - status_peminjaman: enum (DIPINJAM, DIKEMBALIKAN)
    - catatan_peminjaman: text (nullable)
    - timestamps

    Relationships:
    - anggota (BelongsTo): Anggota yang meminjam
    - buku (BelongsTo): Buku yang dipinjam
    - admin (BelongsTo): Admin penerima
    - pengembalian (HasOne): Record pengembalian (jika ada)
}
```

Contoh Usage:
```php
$peminjaman = Peminjaman::with(['anggota', 'buku', 'admin'])->find($id);
$hariTersisa = $peminjaman->tanggal_harus_kembali->diffInDays(now());
$sudahKembali = $peminjaman->pengembalian;
```

### 10.6 Model Pengembalian

```php
namespace App\Models;

class Pengembalian extends Model {
    - id: Primary Key
    - id_peminjaman: UUID foreign key (Peminjaman, unique)
    - id_anggota: foreign key (AnggotaPerpustakaan)
    - id_buku: UUID foreign key (Buku)
    - tanggal_pengembalian: date
    - kondisi_buku_dikembalikan: enum (BAIK, RUSAK)
    - denda_keterlambatan: decimal
    - status_denda: enum (BELUM_DIBAYAR, MENUNGGU_KONFIRMASI, DIBAYAR)
    - catatan_pengembalian: text (nullable)
    - timestamps

    Relationships:
    - peminjaman (BelongsTo): Record peminjaman terkait
    - anggota (BelongsTo): Anggota yang mengembalikan
    - buku (BelongsTo): Buku yang dikembalikan
}
```

Contoh Usage:
```php
$pengembalian = Pengembalian::with(['anggota', 'buku'])->find($id);
$perluBayar = $pengembalian->denda_keterlambatan;
$sudahDibayar = $pengembalian->status_denda === 'DIBAYAR';
```

### 10.7 Model PengaturanDenda

```php
namespace App\Models;

class PengaturanDenda extends Model {
    - id: Primary Key
    - denda_per_hari: decimal
    - maksimal_hari_peminjaman: integer
    - denda_maksimal: decimal (nullable)
    - status: enum (AKTIF, NONAKTIF)
    - catatan: text (nullable)
    - timestamps
}
```

Contoh Usage:
```php
$setting = PengaturanDenda::where('status', 'AKTIF')->latest()->first();
$dendaPerHari = $setting->denda_per_hari;
$hariBermaksimal = $setting->maksimal_hari_peminjaman;
```

### 10.8 Model LogAktivitas

```php
namespace App\Models;

class LogAktivitas extends Model {
    - id: Primary Key
    - user_id: nullable foreign key (Admin atau AnggotaPerpustakaan)
    - tipe_aktivitas: string (e.g., 'buku_ditambah', 'peminjaman_diterima')
    - deskripsi: text
    - tabel_terkait: string (nullable, nama tabel)
    - id_tabel_terkait: string (nullable, ID record)
    - ip_address: string (nullable)
    - user_agent: text (nullable)
    - timestamps

    Relationships:
    - user (BelongsTo): Admin atau Anggota yang melakukan
}
```

Contoh Usage:
```php
$aktivitas = LogAktivitas::orderBy('created_at', 'desc')
    ->where('tipe_aktivitas', 'peminjaman_diterima')
    ->paginate(20);

foreach ($aktivitas as $log) {
    echo $log->deskripsi; // "Admin John menerima peminjaman untuk Buku XYZ"
}
```

### 10.9 Model PasswordReset

```php
namespace App\Models;

class PasswordReset extends Model {
    - email: Primary Key
    - token: string
    - created_at: timestamp
}
```

### 10.10 Relational Diagram

```
Admin (1) -------- (M) Peminjaman
           id              id_admin_pinjam

AnggotaPerpustakaan (1) -------- (M) Peminjaman
                    id              id_anggota

Buku (1) -------- (M) Peminjaman
     id_buku        id_buku

Buku (M) -------- (M) Genre
     (pivot: buku_genre)

Peminjaman (1) -------- (1) Pengembalian
           id_peminjaman

AnggotaPerpustakaan (1) -------- (M) Pengembalian
                    id              id_anggota

Buku (1) -------- (M) Pengembalian
     id_buku        id_buku

Admin (1) -------- (M) LogAktivitas
     id              user_id

AnggotaPerpustakaan (1) -------- (M) LogAktivitas
                    id              user_id
```

---

## 11. PANDUAN PENGGUNA ADMIN

### 11.1 Akses Dashboard Admin

1. Buka aplikasi di browser
2. Login dengan akun admin
3. Anda akan diarahkan ke dashboard admin
4. Dashboard menampilkan overview statistik perpustakaan

### 11.2 Manajemen Buku

#### Tambah Buku Baru

1. Klik menu "Buku" di sidebar
2. Klik tombol "Tambah Buku Baru"
3. Isi form dengan data buku:
   - Kode Buku: Kode unik untuk setiap buku
   - Judul Buku: Judul lengkap buku
   - Pengarang: Nama pengarang
   - Penerbit: Nama penerbit
   - Tahun Terbit: Tahun penerbitan
   - Jenis Buku: Kategori jenis buku
   - Stok: Jumlah buku yang tersedia
   - Kondisi: Pilih antara BAIK, RUSAK, HILANG
   - Status: Pilih antara TERSEDIA, DIPINJAM, TIDAK_TERSEDIA
   - Genre: Pilih satu atau lebih genre
   - Cover Buku: Upload gambar cover (optional)
4. Klik tombol "Simpan"
5. Buku baru akan ditambahkan ke sistem

#### Edit Buku Eksisting

1. Di halaman list buku, klik buku yang ingin diedit
2. Klik tombol "Edit"
3. Update data buku sesuai kebutuhan
4. Klik tombol "Simpan"
5. Data buku akan diperbarui

#### Hapus Buku

1. Di halaman list buku, cari buku yang ingin dihapus
2. Klik tombol "Hapus" atau "Delete"
3. Sistem akan menampilkan konfirmasi
4. Klik "Konfirmasi Hapus" untuk melanjutkan
5. Buku akan dipindahkan ke recycle bin

#### Search dan Filter Buku

1. Di halaman list buku, gunakan search box untuk mencari:
   - Judul buku
   - Nama pengarang
   - Nama penerbit
2. Gunakan filter untuk menyaring:
   - Genre
   - Status buku (Tersedia/Dipinjam/Tidak Tersedia)
3. Hasil akan otomatis di-filter sesuai kriteria

#### Import Buku dari JSON

1. Siapkan file JSON dengan struktur:
```json
[
  {
    "kode_buku": "BK001",
    "judul_buku": "Laravel Programming",
    "pengarang": "John Doe",
    "penerbit": "Tech Publisher",
    "tahun_terbit": 2023,
    "jenis_buku": "Programming",
    "stok": 5,
    "kondisi": "BAIK"
  }
]
```
2. Klik menu "Buku"
3. Klik tombol "Import JSON"
4. Upload file JSON
5. Review data yang akan diimport
6. Klik tombol "Konfirmasi Import"
7. Data akan diimport ke sistem

### 11.3 Manajemen Genre

#### Tambah Genre

1. Klik menu "Genre" di sidebar
2. Klik tombol "Tambah Genre"
3. Isi nama genre dan deskripsi (optional)
4. Klik tombol "Simpan"

#### Edit Genre

1. Klik menu "Genre"
2. Cari genre yang ingin diedit
3. Klik tombol "Edit"
4. Update nama dan deskripsi
5. Klik tombol "Simpan"

#### Hapus Genre

1. Klik menu "Genre"
2. Cari genre yang ingin dihapus
3. Klik tombol "Hapus"
4. Konfirmasi penghapusan

### 11.4 Manajemen Anggota

#### Tambah Anggota Baru

1. Klik menu "Anggota" di sidebar
2. Klik tombol "Tambah Anggota"
3. Isi form:
   - Nama Lengkap
   - NIM/NIS (nomor identitas unik)
   - Email (unique)
   - Password
   - Nomor HP
   - Alamat
   - Jurusan
   - Tahun Masuk
4. Klik tombol "Simpan"

#### Edit Data Anggota

1. Klik menu "Anggota"
2. Cari anggota yang ingin diedit
3. Klik nama anggota untuk detail
4. Klik tombol "Edit"
5. Update data sesuai kebutuhan
6. Klik tombol "Simpan"

#### Toggle Status Anggota

1. Di halaman list anggota
2. Cari anggota yang status-nya ingin diubah
3. Klik tombol "Toggle Status"
4. Status akan berubah dari AKTIF ke NONAKTIF atau sebaliknya
5. Anggota dengan status NONAKTIF tidak bisa melakukan peminjaman

#### Reset Password Anggota

1. Di halaman detail anggota
2. Klik tombol "Reset Password"
3. Masukkan password baru
4. Klik tombol "Simpan"
5. Password anggota akan diubah ke password baru

### 11.5 Manajemen Peminjaman

#### Lihat Daftar Peminjaman

1. Klik menu "Peminjaman" di sidebar
2. Sistem akan menampilkan daftar semua peminjaman
3. Gunakan filter untuk menyaring berdasarkan status atau anggota

#### Menerima Permintaan Peminjaman

1. Di halaman peminjaman, cari permintaan yang masih pending
2. Klik detail untuk melihat informasi lengkap
3. Klik tombol "Terima"
4. Status peminjaman akan berubah menjadi DIPINJAM
5. Stok buku akan berkurang

#### Menolak Permintaan Peminjaman

1. Di halaman peminjaman, cari permintaan yang ingin ditolak
2. Klik tombol "Tolak"
3. Masukkan alasan penolakan (optional)
4. Klik tombol "Konfirmasi Tolak"
5. Permintaan akan dihapus dari sistem

### 11.6 Manajemen Pengembalian

#### Proses Pengembalian Buku

1. Klik menu "Pengembalian" di sidebar
2. Klik tombol "Proses Pengembalian Baru"
3. Pilih peminjaman yang ingin dikembalikan dari daftar
4. Masukkan tanggal pengembalian
5. Masukkan kondisi buku saat dikembalikan
6. Sistem akan otomatis menghitung denda (jika ada keterlambatan)
7. Klik tombol "Simpan"

#### Menerima Pembayaran Denda

1. Di halaman pengembalian, cari record dengan status "Menunggu Konfirmasi"
2. Klik detail
3. Klik tombol "Terima Pembayaran"
4. Status denda akan berubah menjadi DIBAYAR
5. Log aktivitas akan terecatat

#### Menolak Pembayaran Denda

1. Di halaman pengembalian, cari record dengan status denda yang ditolak
2. Klik tombol "Tolak Pembayaran"
3. Masukkan alasan penolakan
4. Status akan kembali ke BELUM_DIBAYAR

### 11.7 Pengaturan Denda

#### Mengubah Tarif Denda

1. Klik menu "Pengaturan" > "Denda"
2. Atau bisa melalui menu "Denda" > tab "Setting"
3. Update nilai:
   - Denda Per Hari: Tarif denda per hari keterlambatan
   - Maksimal Hari Peminjaman: Jumlah hari maksimal anggota bisa meminjam
   - Denda Maksimal: Batas maksimal denda yang bisa dikenakan (optional)
4. Klik tombol "Simpan"
5. Pengaturan akan langsung berlaku untuk penghitungan denda baru

### 11.8 Log Aktivitas

#### Melihat Log Aktivitas

1. Klik menu "Log Aktivitas" di sidebar
2. Sistem akan menampilkan daftar semua aktivitas
3. Gunakan filter untuk menyaring:
   - Tipe Aktivitas
   - User yang melakukan
   - Tanggal aktivitas

#### Detail Aktivitas

1. Klik pada salah satu baris log
2. Sistem akan menampilkan detail lengkap:
   - Siapa yang melakukan aktivitas
   - Apa jenis aktivitasnya
   - Kapan dilakukan
   - IP address dan user agent
   - Data tabel yang terkait

### 11.9 Recycle Bin

#### Restore Data yang Dihapus

1. Klik menu "Recycle Bin" di sidebar
2. Cari data yang ingin di-restore
3. Klik tombol "Restore"
4. Data akan dikembalikan ke tempat semula

#### Permanent Delete

1. Di halaman Recycle Bin
2. Cari data yang ingin dihapus permanen
3. Klik tombol "Delete Permanen"
4. Konfirmasi penghapusan
5. Data akan dihapus secara permanen dari database

---

## 12. PANDUAN PENGGUNA ANGGOTA

### 12.1 Registrasi dan Login

#### Cara Registrasi

1. Buka aplikasi di browser
2. Klik link "Daftar" atau langsung ke halaman register
3. Isi form registrasi:
   - Nama Lengkap
   - NIM/NIS (nomor unik)
   - Email
   - Password (minimal 8 karakter)
   - Nomor HP
   - Alamat
   - Jurusan
   - Tahun Masuk (tahun masuk ke universitas)
4. Klik tombol "Daftar"
5. Anda akan diarahkan ke login untuk login pertama kali

#### Cara Login

1. Buka halaman login
2. Masukkan email atau NIM/NIS
3. Masukkan password
4. Klik tombol "Login"
5. Anda akan diarahkan ke dashboard anggota

#### Lupa Password

1. Di halaman login, klik link "Lupa Password?"
2. Masukkan email terdaftar Anda
3. Klik tombol "Kirim Link Reset"
4. Email akan dikirimkan dengan link reset
5. Klik link di email untuk mengubah password
6. Masukkan password baru
7. Klik tombol "Reset Password"
8. Password berhasil diubah, login dengan password baru

### 12.2 Dashboard Anggota

Dashboard menampilkan:

- Ringkasan buku yang sedang dipinjam
- Total denda yang belum dibayar
- Notifikasi deadline peminjaman
- Quick access ke menu penting

### 12.3 Browsing dan Mencari Buku

#### Melihat Katalog Buku

1. Klik menu "Katalog Buku" atau "Cari Buku"
2. Sistem akan menampilkan semua buku yang tersedia
3. Setiap buku menampilkan:
   - Judul
   - Pengarang
   - Penerbit
   - Tahun Terbit
   - Genre
   - Stok tersedia
   - Cover buku

#### Mencari Buku

1. Di halaman katalog, gunakan search box
2. Cari berdasarkan:
   - Judul buku
   - Nama pengarang
   - Nama penerbit
3. Hasil pencarian akan ditampilkan secara real-time

#### Filter Berdasarkan Genre

1. Di halaman katalog, lihat list genre di sidebar
2. Klik salah satu genre
3. Hanya buku dalam genre tersebut yang akan ditampilkan
4. Klik "Semua Genre" untuk kembali melihat semua buku

#### Lihat Detail Buku

1. Klik pada salah satu buku
2. Halaman detail akan menampilkan:
   - Cover buku
   - Judul lengkap
   - Pengarang dan penerbit
   - Tahun terbit
   - Genre
   - Deskripsi (jika ada)
   - Stok tersedia
   - Tombol "Pinjam" (jika tersedia)

### 12.4 Ajukan Peminjaman

#### Cara Meminjam Buku

1. Di halaman detail buku, klik tombol "Pinjam Sekarang"
2. Atau di halaman katalog, klik tombol "Pinjam" pada kartu buku
3. Form peminjaman akan muncul
4. Isi form:
   - Durasi Peminjaman: Berapa hari ingin meminjam (sesuai kebijakan, biasanya 7-14 hari)
   - Catatan: Tambahkan catatan jika ada (optional)
5. Klik tombol "Ajukan Peminjaman"
6. Permintaan peminjaman akan dikirim ke admin
7. Tunggu approval dari admin (biasanya 1x24 jam)

#### Lihat Status Permintaan Peminjaman

1. Klik menu "Peminjaman"
2. Di tab "Menunggu Approval", lihat daftar permintaan Anda
3. Status akan menampilkan:
   - Pending: Menunggu approval admin
   - Ditolak: Admin menolak permintaan
   - Approved: Admin menyetujui dan buku bisa diambil

### 12.5 Kelola Peminjaman Aktif

#### Lihat Buku yang Sedang Dipinjam

1. Klik menu "Buku Saya" atau "Peminjaman Saya"
2. Tab "Aktif" menampilkan buku yang sedang dipinjam
3. Untuk setiap buku, ditampilkan:
   - Judul dan pengarang
   - Tanggal peminjaman
   - Tanggal harus kembali
   - Sisa hari peminjaman
   - Warning jika sudah keterlambatan

#### Monitor Deadline

- Sistem akan mengirim notifikasi jika:
  - 3 hari sebelum deadline
  - Pada hari deadline
  - Jika sudah keterlambatan

### 12.6 Pengembalian Buku

#### Self-Service Pengembalian

Untuk pengembalian buku, anggota:

1. Bawa buku ke desk perpustakaan
2. Admin akan memproses pengembalian
3. Admin akan mencatat kondisi buku
4. Sistem akan otomatis menghitung denda (jika ada keterlambatan)

#### Lihat Status Pengembalian

1. Klik menu "Riwayat Pengembalian"
2. Lihat daftar buku yang sudah dikembalikan
3. Status pengembalian akan ditampilkan

### 12.7 Kelola Denda

#### Lihat Denda yang Belum Dibayar

1. Klik menu "Denda Saya"
2. Tab "Belum Dibayar" menampilkan denda yang masih harus dibayar
3. Untuk setiap denda, ditampilkan:
   - Buku yang terlambat
   - Jumlah denda
   - Tanggal pengembalian
   - Alasan denda

#### Lihat History Pembayaran Denda

1. Klik menu "Denda Saya"
2. Tab "Riwayat" menampilkan denda yang sudah dibayar

#### Bayar Denda

Proses pembayaran denda:

1. Di halaman denda, lihat daftar denda belum dibayar
2. Pergi ke desk perpustakaan untuk melakukan pembayaran
3. Admin akan mencatat pembayaran denda
4. Status akan berubah menjadi "Menunggu Konfirmasi" lalu "Dibayar"

### 12.8 Profil Anggota

#### Edit Profil

1. Klik menu "Profil" atau "Akun Saya"
2. Klik tombol "Edit Profil"
3. Update data pribadi:
   - Nama Lengkap
   - Email
   - Nomor HP
   - Alamat
   - Foto Profil (upload foto baru)
4. Klik tombol "Simpan"
5. Data profil akan diperbarui

#### Ubah Password

1. Di halaman profil, klik tab "Keamanan"
2. Klik tombol "Ubah Password"
3. Isi form:
   - Password Lama: Masukkan password saat ini
   - Password Baru: Masukkan password baru (minimal 8 karakter)
   - Konfirmasi Password: Masukkan ulang password baru
4. Klik tombol "Ubah Password"
5. Password akan diperbarui

---

## 13. FITUR-FITUR DETAIL

### 13.1 Sistem Otomatis Perhitungan Denda

#### Cara Kerja

1. Admin mengatur tarif denda di menu Pengaturan > Denda
2. Saat buku dikembalikan terlambat, sistem otomatis menghitung:
   - Hari keterlambatan = Tanggal Pengembalian - Tanggal Harus Kembali
   - Denda = Hari Keterlambatan x Denda Per Hari
3. Jika ada denda maksimal, denda tidak akan melebihi batas tersebut
4. Denda akan dicatat dalam record pengembalian

#### Contoh Perhitungan

```
Pengaturan:
- Denda Per Hari: Rp 5.000
- Denda Maksimal: Rp 100.000

Peminjaman:
- Tanggal Harus Kembali: 2026-04-22
- Tanggal Pengembalian: 2026-04-28

Perhitungan:
- Hari Keterlambatan = 6 hari
- Denda = 6 x Rp 5.000 = Rp 30.000
- Denda Final = Rp 30.000 (kurang dari Rp 100.000)
```

### 13.2 Sistem Log Aktivitas

#### Tipe Aktivitas yang Dicatat

- Buku ditambahkan
- Buku diedit
- Buku dihapus
- Genre ditambahkan
- Anggota didaftarkan
- Anggota diedit
- Peminjaman diajukan
- Peminjaman diterima
- Peminjaman ditolak
- Pengembalian diproses
- Denda dibayar
- Password direset
- Login/Logout

#### Informasi yang Dicatat

- User ID (siapa yang melakukan)
- Tipe aktivitas
- Deskripsi detail
- Tabel dan ID record yang terkait
- IP Address
- User Agent
- Timestamp

### 13.3 Sistem Kontrol Akses

#### Middleware Autentikasi

- `auth`: Memastikan user sudah login
- `auth.admin`: Memastikan user adalah admin
- `auth.anggota`: Memastikan user adalah anggota
- `guest.sikutu`: Memastikan user belum login

#### Otorisasi

Setiap fitur memiliki otorisasi yang ketat:
- Admin bisa akses semua fitur admin
- Anggota hanya bisa akses fitur anggota
- Anggota dengan status NONAKTIF tidak bisa melakukan peminjaman

### 13.4 Soft Delete dan Restore

#### Konsep Soft Delete

Ketika data dihapus (buku, anggota), sistem tidak langsung menghapus dari database, tetapi hanya menambahkan timestamp `deleted_at`. Data masih tersimpan untuk audit trail.

#### Restore Data

1. Klik menu "Recycle Bin"
2. Lihat daftar data yang dihapus
3. Klik tombol "Restore" pada data yang ingin dikembalikan
4. Data akan langsung kembali aktif di sistem
5. Log aktivitas akan terecatat

### 13.5 Relasi Many-to-Many: Buku dan Genre

#### Cara Kerja

- Satu buku bisa memiliki banyak genre
- Satu genre bisa memiliki banyak buku
- Relasi tersimpan di tabel pivot `buku_genre`

#### Contoh

```
Buku: "Clean Code"
Genre: [Programming, Technology, Reference]

Tabel buku_genre:
id_buku | id_genre
1       | 1 (Programming)
1       | 2 (Technology)
1       | 3 (Reference)
```

### 13.6 UUID untuk Primary Key pada Buku

#### Alasan Menggunakan UUID

- UUID adalah identifier unik yang dihasilkan secara random
- Tidak sequential seperti AUTO_INCREMENT
- Lebih aman dan susah untuk di-predict
- Memudahkan data replication dan distributed systems

#### Format UUID

```
UUID v4 Format: xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
Contoh: 550e8400-e29b-41d4-a716-446655440000
```

---

## 14. PANDUAN DEVELOPMENT

### 14.1 Development Setup

#### Menjalankan Development Server

Untuk development dengan auto-reload:

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite build watcher
npm run dev

# Terminal 3 (optional): Queue listener
php artisan queue:listen --tries=1
```

Atau gunakan script konvensi yang ada:

```bash
composer dev
```

Script ini akan menjalankan ketiga service secara concurrent.

### 14.2 Database Migrations

#### Membuat Migration Baru

```bash
php artisan make:migration create_nama_tabel_table
```

Atau dengan model:

```bash
php artisan make:model NamaTabel -m
```

#### Jalankan Migrations

```bash
# Jalankan semua migration
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Rollback semua dan jalankan lagi
php artisan migrate:refresh

# Rollback dan seed
php artisan migrate:refresh --seed
```

#### Struktur Migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nama_tabel', function (Blueprint $table) {
            $table->id();
            $table->string('kolom1');
            $table->integer('kolom2');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nama_tabel');
    }
};
```

### 14.3 Membuat Model

#### Generate Model

```bash
# Model saja
php artisan make:model NamaModel

# Model + Migration
php artisan make:model NamaModel -m

# Model + Migration + Factory + Seeder
php artisan make:model NamaModel -mfs
```

#### Struktur Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NamaModel extends Model
{
    protected $fillable = ['kolom1', 'kolom2'];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function relasi(): HasMany
    {
        return $this->hasMany(ModelLain::class);
    }
}
```

### 14.4 Membuat Controller

#### Generate Controller

```bash
# Controller kosong
php artisan make:controller NamaController

# Resource controller (CRUD)
php artisan make:controller NamaController --resource

# Resource controller + model
php artisan make:controller NamaController --resource --model=Nama
```

#### Struktur Resource Controller

```php
<?php

namespace App\Http\Controllers;

use App\Models\Nama;
use Illuminate\Http\Request;

class NamaController extends Controller
{
    public function index()
    {
        // GET /nama - List semua
    }

    public function create()
    {
        // GET /nama/create - Form create
    }

    public function store(Request $request)
    {
        // POST /nama - Simpan baru
    }

    public function show(Nama $nama)
    {
        // GET /nama/{id} - Detail
    }

    public function edit(Nama $nama)
    {
        // GET /nama/{id}/edit - Form edit
    }

    public function update(Request $request, Nama $nama)
    {
        // PUT /nama/{id} - Update
    }

    public function destroy(Nama $nama)
    {
        // DELETE /nama/{id} - Hapus
    }
}
```

### 14.5 Membuat Views (Blade)

#### Direktori Views

```
resources/views/
├── layouts/app.blade.php
├── admin/
│   └── buku/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
└── components/
    └── navbar.blade.php
```

#### Syntax Blade Dasar

```blade
// Echo variable
{{ $variable }}

// If statement
@if ($condition)
    ...
@endif

// Loop
@foreach ($items as $item)
    {{ $item->name }}
@endforeach

// Include component
@include('components.navbar')

// Extend layout
@extends('layouts.app')

// Section
@section('content')
    ...
@endsection

// Form field
@csrf
{{ method_field('PUT') }}
```

### 14.6 Coding Standards

#### PHP Coding Standard

Gunakan Laravel Pint untuk automatic formatting:

```bash
php artisan pint
```

#### CSS dan JavaScript

- Gunakan Tailwind CSS untuk styling
- Gunakan Alpine.js untuk interaktivitas ringan
- Hindari inline styles

### 14.7 Git Workflow

#### Branch Naming

```
feature/fitur-baru
bugfix/nama-bug
hotfix/nama-urgent
refactor/nama-refactor
```

#### Commit Message

```
[FEATURE] Menambah fitur X
[BUGFIX] Memperbaiki bug Y
[REFACTOR] Merapikan kode Z
```

#### Push dan Pull Request

```bash
git add .
git commit -m "[FEATURE] Menambah manajemen buku"
git push origin feature/manajemen-buku
# Buat pull request di GitHub/GitLab
```

---

## 15. TESTING DAN QUALITY ASSURANCE

### 15.1 Testing dengan Pest

#### Setup Testing

Testing framework sudah tersedia menggunakan Pest.

#### Membuat Test

```bash
# Feature test
php artisan make:pest Feature/BukuTest

# Unit test
php artisan make:pest Unit/BukuTest --unit
```

#### Struktur Test

```php
<?php

test('dapat membuat buku baru', function () {
    $response = $this->post('/admin/buku', [
        'kode_buku' => 'BK001',
        'judul_buku' => 'Test Book',
        'pengarang' => 'Test Author',
        'penerbit' => 'Test Publisher',
        'tahun_terbit' => 2026,
        'jenis_buku' => 'Testing',
        'stok' => 5,
        'kondisi' => 'BAIK',
        'status_buku' => 'TERSEDIA',
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('bukus', [
        'judul_buku' => 'Test Book',
    ]);
});
```

#### Jalankan Test

```bash
# Jalankan semua test
php artisan test

# Jalankan test tertentu
php artisan test tests/Feature/BukuTest.php

# Jalankan dengan coverage
php artisan test --coverage
```

### 15.2 Database Seeding untuk Testing

#### Membuat Seeder

```bash
php artisan make:seeder AdminSeeder
```

#### Struktur Seeder

```php
<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama_admin' => 'Admin 1',
            'email' => 'admin@sikutu.test',
            'password' => bcrypt('password123'),
            'nomor_hp' => '081234567890',
        ]);
    }
}
```

#### Jalankan Seeder

```bash
# Jalankan seeder tertentu
php artisan db:seed --class=AdminSeeder

# Jalankan semua seeder
php artisan db:seed

# Refresh database dan seed
php artisan migrate:refresh --seed
```

### 15.3 Manual Testing Checklist

#### Authentication
- [ ] Login dengan email berhasil
- [ ] Login dengan NIM/NIS berhasil
- [ ] Password salah error
- [ ] Register anggota baru berhasil
- [ ] Lupa password berfungsi
- [ ] Reset password berhasil
- [ ] Logout berhasil
- [ ] Session timeout bekerja

#### Admin Features
- [ ] Tambah buku berhasil
- [ ] Edit buku berhasil
- [ ] Hapus buku berfungsi (soft delete)
- [ ] Import buku dari JSON
- [ ] Search dan filter buku
- [ ] Genre CRUD berfungsi
- [ ] Anggota CRUD berfungsi
- [ ] Toggle status anggota
- [ ] Reset password anggota
- [ ] Terima peminjaman
- [ ] Tolak peminjaman
- [ ] Proses pengembalian
- [ ] Perhitungan denda otomatis
- [ ] Terima pembayaran denda
- [ ] Update pengaturan denda

#### Anggota Features
- [ ] Registrasi berhasil
- [ ] Login berhasil
- [ ] Browse katalog buku
- [ ] Search buku berfungsi
- [ ] Filter genre berfungsi
- [ ] Lihat detail buku
- [ ] Ajukan peminjaman
- [ ] Lihat status peminjaman
- [ ] Lihat buku yang sedang dipinjam
- [ ] Lihat daftar denda
- [ ] Lihat history pengembalian
- [ ] Edit profil
- [ ] Ubah password

#### Database
- [ ] Data buku tersimpan
- [ ] Data anggota tersimpan
- [ ] Relasi buku-genre bekerja
- [ ] Soft delete berfungsi
- [ ] Restore dari recycle bin
- [ ] Permanent delete
- [ ] Log aktivitas terecatat

---

## 16. TROUBLESHOOTING DAN FAQ

### 16.1 Common Issues dan Solutions

#### Issue 1: "Class 'App\Models\Buku' not found"

PENYEBAB: Model belum di-generate atau namespace salah

SOLUSI:
```bash
# Generate model yang hilang
php artisan make:model Buku

# Atau check import di controller
use App\Models\Buku;
```

#### Issue 2: "Migrations tidak berjalan"

PENYEBAB: Database belum dikonfigurasi atau file .env salah

SOLUSI:
```bash
# Check konfigurasi .env
DB_HOST=127.0.0.1
DB_DATABASE=sikutu
DB_USERNAME=root

# Buat database jika belum ada
mysql -u root -e "CREATE DATABASE sikutu;"

# Jalankan migration
php artisan migrate --force
```

#### Issue 3: "Column not found" saat query

PENYEBAB: Migration belum dijalankan atau kolom belum ditambahkan

SOLUSI:
```bash
# Cek status migration
php artisan migrate:status

# Jalankan migration yang belum
php artisan migrate
```

#### Issue 4: npm build error

PENYEBAB: Dependency belum install atau syntax error di CSS/JS

SOLUSI:
```bash
# Reinstall npm
rm -rf node_modules package-lock.json
npm install --ignore-scripts

# Build dengan verbose untuk error detail
npm run build
```

#### Issue 5: CORS error

PENYEBAB: Request dari domain berbeda tanpa konfigurasi

SOLUSI:
Edit `config/cors.php`:
```php
'allowed_origins' => ['*'],
```

#### Issue 6: 419 Page Expired

PENYEBAB: CSRF token tidak valid

SOLUSI:
```blade
{{-- Di setiap form, pastikan ada CSRF token --}}
@csrf
```

#### Issue 7: Migration foreign key error

PENYEBAB: Kolom foreign key tipe data tidak match

SOLUSI:
```php
// Parent table
$table->id(); // Ini adalah BIGINT UNSIGNED

// Child table
$table->foreignId('parent_id')->constrained('parents');
// Ini juga BIGINT UNSIGNED, cocok!
```

### 16.2 Performance Tips

#### Optimize Database Queries

```php
// Bad - N+1 query problem
$bukus = Buku::all();
foreach ($bukus as $buku) {
    echo $buku->genres; // Query database setiap iterasi!
}

// Good - Eager loading
$bukus = Buku::with('genres')->get();
foreach ($bukus as $buku) {
    echo $buku->genres; // Sudah di-load sebelumnya
}
```

#### Caching

```php
// Cache query hasil
Cache::remember('semua_genre', 3600, function () {
    return Genre::all();
});
```

#### Pagination

Selalu gunakan pagination untuk list besar:

```php
$bukus = Buku::paginate(20); // Bukan get()
```

### 16.3 Security Best Practices

#### Password Hashing

```php
// Selalu hash password
$user->password = bcrypt($plainPassword);
```

#### SQL Injection Prevention

```php
// Good - Gunakan parameter binding
DB::select('SELECT * FROM bukus WHERE judul = ?', [$judul]);

// Bad - String concatenation
DB::select("SELECT * FROM bukus WHERE judul = '$judul'");
```

#### CSRF Protection

```blade
<!-- Selalu ada di form -->
@csrf
```

#### Authorization

```php
// Check permission sebelum update
$this->authorize('update', $buku);
```

### 16.4 FAQ

**Q: Bagaimana cara reset database?**

A: Jalankan command:
```bash
php artisan migrate:reset
php artisan migrate --force
php artisan db:seed
```

**Q: Bagaimana cara backup database?**

A: Gunakan command mysqldump:
```bash
mysqldump -u root sikutu > backup.sql
```

**Q: Bagaimana cara generate dummy data?**

A: Gunakan Factory dan Seeder:
```php
// Di seeder
Admin::factory(10)->create();
```

**Q: Bagaimana cara update production database?**

A: Jalankan migration dengan force flag:
```bash
php artisan migrate --force
```

**Q: Bagaimana implementasi email verification?**

A: Laravel punya feature built-in, cek dokumentasi resmi Laravel.

**Q: Bagaimana implementasi two-factor authentication?**

A: Gunakan package seperti `laravel-fortify`.

**Q: File upload ke mana?**

A: Default tersimpan di `storage/app/public/`, dapat diakses via `public/storage`.

**Q: Bagaimana update asset CSS/JS di production?**

A: Build dengan npm run build dan push ke repo.

---

## 17. KONTRIBUSI DAN LISENSI

### 17.1 Kontribusi

Untuk berkontribusi:

1. Fork repository
2. Buat branch feature baru (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### 17.2 Lisensi

Proyek ini dilisensikan di bawah MIT License - lihat file LICENSE untuk detail.

### 17.3 Author dan Support

Untuk pertanyaan atau issue, silakan buka GitHub Issue.

---

## APPENDIX: Useful Commands

```bash
# Artisan Commands
php artisan serve                    # Start dev server
php artisan tinker                   # Interactive shell
php artisan migration:status         # Check migration status
php artisan migrate:refresh          # Reset dan jalankan semua migration
php artisan db:seed                  # Jalankan seeder
php artisan cache:clear              # Clear cache
php artisan route:list               # List semua route
php artisan make:model Model         # Create model
php artisan make:controller Controller # Create controller
php artisan make:migration            # Create migration
php artisan make:middleware           # Create middleware
php artisan make:request FormRequest  # Create form request

# Composer Commands
composer install                      # Install dependencies
composer update                       # Update dependencies
composer require package/name         # Add package
composer remove package/name          # Remove package

# npm Commands
npm install                          # Install JS dependencies
npm run dev                          # Development mode
npm run build                        # Production build
npm run watch                        # Watch for changes

# Testing
php artisan test                     # Run tests
php artisan test --coverage          # Run with coverage

# Git Commands
git status                           # Status
git add .                            # Stage all changes
git commit -m "message"              # Commit
git push                             # Push to remote
git pull                             # Pull from remote
git branch -a                        # List branches
```

---

END OF DOCUMENTATION

Dokumentasi ini adalah panduan lengkap untuk menggunakan, mengembangkan, dan memelihara aplikasi SIKUTU. Untuk pertanyaan lebih lanjut, silakan lihat dokumentasi resmi Laravel di https://laravel.com/docs atau buat issue di repository.

Terakhir diupdate: April 24, 2026
