-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2026 at 05:38 AM
-- Server version: 8.0.30
-- PHP Version: 8.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikutu_ukk`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id_admin`, `uuid`, `username`, `password`, `nama_lengkap`, `email`, `photo_profile`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '37a0fa1c-3eb4-11f1-b465-a81e845d2f97', 'admin', '$2y$12$TwVQst9ttKSUN.Dxc0t3zeC5YPAyJuUo7JLNRfTckqcLhUpj8kQnO', 'Administrator 1 (Ryan Bow)', 'admin@sikutu.local', NULL, NULL, '2026-04-22 05:32:22', '2026-04-23 09:45:10');

-- --------------------------------------------------------

--
-- Table structure for table `anggota_perpustakaan`
--

CREATE TABLE `anggota_perpustakaan` (
  `id_anggota` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Enum: 10 | 11 | 12',
  `jurusan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Jurusan siswa: PPLG, BCF, ANM, TO, TPFL',
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_anggota` enum('AKTIF','NONAKTIF','DIBLOKIR') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `tanggal_daftar` date NOT NULL DEFAULT '2026-04-22',
  `masa_berlaku` date NOT NULL,
  `id_admin` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota_perpustakaan`
--

INSERT INTO `anggota_perpustakaan` (`id_anggota`, `uuid`, `username`, `password`, `nama_lengkap`, `nis`, `kelas`, `jurusan`, `alamat`, `no_telepon`, `email`, `photo_profile`, `status_anggota`, `tanggal_daftar`, `masa_berlaku`, `id_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '37311014-3eb4-11f1-b465-a81e845d2f97', 'siswa1', '$2y$12$sKpS1vz0NbgAQkshY0seGu1pnjRYXvreXtQzl83nEa540yp1ko52m', 'Ahmad Fauzi', '2024001', '10', '10 PPLG 1', 'Jl. Merdeka No. 1', '081234567890', 'ahmad@sikutu.local', NULL, 'AKTIF', '2026-04-22', '2027-04-22', 1, NULL, '2026-04-22 05:32:23', '2026-04-22 05:32:23'),
(2, '37311d4b-3eb4-11f1-b465-a81e845d2f97', 'siswa2', '$2y$12$nSm3Ln4v4Jhz38c/JQa.J.cuEU.IKmNCmQO/oc3dAKMiIHt1JqUUy', 'Siti Nurhaliza', '2024002', '10', '10 PPLG 2', 'Jl. Sudirman No. 5', '081234567891', 'siti@sikutu.local', NULL, 'AKTIF', '2026-04-22', '2026-04-30', 1, NULL, '2026-04-22 05:32:24', '2026-04-23 09:38:02'),
(3, '3731222a-3eb4-11f1-b465-a81e845d2f97', 'siswa3', '$2y$12$f8ufxqi2ss9EkSy5f2Teo.IFJDdB/As2wChKa2sRjg4B60cmz3uyK', 'Budi Santoso', '2024003', '11', '11 BCF 1', 'Jl. Gatot Subroto No. 10', '081234567892', 'budi@sikutu.local', NULL, 'AKTIF', '2026-04-22', '2027-04-22', 1, NULL, '2026-04-22 05:32:24', '2026-04-22 05:32:24'),
(4, '3731269c-3eb4-11f1-b465-a81e845d2f97', 'siswa4', '$2y$12$iSuWAjF74AbnNedB5Hb4r.cwU5l2ZZJdQBYc2YzoatUzprmGfblCe', 'Dewi Lestari', '2024004', '12', '12 ANM 1', 'Jl. Ahmad Yani No. 15', '081234567893', 'dewi@sikutu.local', NULL, 'AKTIF', '2026-04-22', '2027-04-22', 1, NULL, '2026-04-22 05:32:24', '2026-04-22 05:32:24'),
(5, '37312dc2-3eb4-11f1-b465-a81e845d2f97', 'siswa5', '$2y$12$Q8LOum3XymAFtvYYQsn36.jO4KBYp0N1TvLHQqCfqRhJDIoqk2FKK', 'Rizky Pratama', '2024005', '11', '11 TO 1', 'Jl. Diponegoro No. 20', '081234567894', 'rizky@sikutu.local', NULL, 'AKTIF', '2026-04-22', '2027-04-22', 1, NULL, '2026-04-22 05:32:25', '2026-04-22 05:32:25'),
(6, '406e7b08-b1bf-4c5c-beb7-8623e2d3fba2', 'rasyadicikiwir', '$2y$12$D5KL6AbgpzULVC.9Iye9zOqEtKmO7797KqylhP19niQOWiTsThz.O', 'Rasyad Helza', '232410102', '12', 'PPLG 2', NULL, NULL, 'rasyadhehe@gmail.com', NULL, 'AKTIF', '2026-04-23', '2027-04-23', NULL, NULL, '2026-04-23 09:27:48', '2026-04-23 09:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `bukus`
--

CREATE TABLE `bukus` (
  `id_buku` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_buku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_buku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengarang` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_terbit` year DEFAULT NULL,
  `jenis_buku` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Jenis/tipe buku: Fiksi, Non-Fiksi, dll',
  `stok` int NOT NULL DEFAULT '0',
  `kondisi` enum('BAIK','RUSAK','HILANG') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BAIK',
  `gambar_cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_buku` enum('TERSEDIA','DIPINJAM','TIDAK_TERSEDIA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'TERSEDIA',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bukus`
--

INSERT INTO `bukus` (`id_buku`, `uuid`, `kode_buku`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `jenis_buku`, `stok`, `kondisi`, `gambar_cover`, `status_buku`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '36e6e2c5-3eb4-11f1-b465-a81e845d2f97', 'BK-001', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', '2005', 'Fiksi', 5, 'BAIK', 'covers/455695ca-510c-4d95-b17f-63cbad008a58.png', 'TERSEDIA', '2026-04-22 05:32:22', '2026-04-23 00:45:14', NULL),
(2, '36e6ec4c-3eb4-11f1-b465-a81e845d2f97', 'BK-002', 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', '1980', 'Fiksi', 3, 'BAIK', 'covers/336beb64-aca1-43ee-9b38-305a23028045.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-22 23:07:57', NULL),
(3, '36e6ee37-3eb4-11f1-b465-a81e845d2f97', 'BK-003', 'Fisika Dasar', 'Halliday & Resnick', 'Erlangga', '2010', 'Non-Fiksi', 10, 'BAIK', 'covers/2246fc70-942a-47f2-b265-2eabe91039f5.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-22 23:08:31', NULL),
(4, '36e6efa9-3eb4-11f1-b465-a81e845d2f97', 'BK-004', 'Matematika Kelas 10', 'Tim Kemendikbud', 'Kemendikbud', '2022', 'Non-Fiksi', 15, 'BAIK', 'covers/78b769b5-d486-45db-b8c6-8088a8358a82.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-22 23:09:08', NULL),
(5, '36e6f117-3eb4-11f1-b465-a81e845d2f97', 'BK-005', 'Pemrograman Web dengan Laravel', 'Rahmat Hidayat', 'Informatika', '2023', 'Non-Fiksi', 4, 'BAIK', 'covers/8eb41437-8805-4a1c-87ae-f14602b4b245.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-22 23:09:33', NULL),
(6, '36e6f2a1-3eb4-11f1-b465-a81e845d2f97', 'BK-006', 'Sejarah Indonesia', 'Tim Penulis', 'Gramedia', '2020', 'Non-Fiksi', 7, 'BAIK', 'covers/d42ad335-7fa5-4f95-8a34-d7dc9b0eafc3.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-23 00:40:50', NULL),
(7, '36e6f3fa-3eb4-11f1-b465-a81e845d2f97', 'BK-007', 'Dilan 1990', 'Pidi Baiq', 'Pastel Books', '2014', 'Fiksi', 6, 'BAIK', 'covers/ed0363f5-f8c5-48d0-98d4-a458f9012023.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-23 00:41:56', NULL),
(8, '36e6f556-3eb4-11f1-b465-a81e845d2f97', 'BK-008', 'Algoritma dan Pemrograman', 'Rinaldi Munir', 'Informatika', '2016', 'Non-Fiksi', 8, 'RUSAK', 'covers/4c7571d8-5daf-4978-a9ae-8169c81ab5b1.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-23 00:42:54', NULL),
(9, '36e6f6b0-3eb4-11f1-b465-a81e845d2f97', 'BK-009', 'Bahasa Inggris Kelas 11', 'Tim Kemendikbud', 'Kemendikbud', '2022', 'Non-Fiksi', 12, 'RUSAK', 'covers/67a6e38a-62c8-482a-91be-ff7c6ea8b0df.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-22 23:53:49', NULL),
(10, '36e6f80d-3eb4-11f1-b465-a81e845d2f97', 'BK-010', 'Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', '2009', 'Fiksi', 4, 'BAIK', 'covers/7b237640-f3b3-4dbb-8879-7827b72919c8.png', 'TERSEDIA', '2026-04-22 05:32:23', '2026-04-23 00:44:23', NULL),
(11, 'f22e4e4d-da16-4555-a3a2-283cdd0b2896', 'BK-019', '10 Dosa Besar Soeharto', 'Drs. Wimanjaya K. Liotohe.', 'Upaya Warga Negara', '1998', NULL, 2, 'BAIK', 'covers/2eb9fd66-a2e5-46b7-b438-18cc5c16b460.png', 'TERSEDIA', '2026-04-22 20:39:43', '2026-04-23 19:46:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buku_genre`
--

CREATE TABLE `buku_genre` (
  `id_buku` bigint UNSIGNED NOT NULL,
  `id_genre` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buku_genre`
--

INSERT INTO `buku_genre` (`id_buku`, `id_genre`) VALUES
(1, 1),
(2, 1),
(7, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(8, 2),
(9, 2),
(3, 3),
(5, 4),
(8, 4),
(2, 5),
(6, 5),
(11, 5),
(4, 6),
(9, 7),
(11, 11),
(6, 12),
(1, 13),
(2, 13),
(7, 13),
(3, 15),
(4, 15),
(5, 15),
(6, 15),
(8, 15),
(9, 15),
(11, 15);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id_genre` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_genre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id_genre`, `uuid`, `nama_genre`, `deskripsi`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '37dfa38a-3eb4-11f1-b465-a81e845d2f97', 'Fiksi', 'Buku cerita rekaan/fiksi', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(2, '37dfae43-3eb4-11f1-b465-a81e845d2f97', 'Non-Fiksi', 'Buku berdasarkan fakta', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(3, '37dfb1c6-3eb4-11f1-b465-a81e845d2f97', 'Sains', 'Buku ilmu pengetahuan alam', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(4, '37dfb4a6-3eb4-11f1-b465-a81e845d2f97', 'Teknologi', 'Buku tentang teknologi dan komputer', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(5, '37dfb77e-3eb4-11f1-b465-a81e845d2f97', 'Sejarah', 'Buku tentang sejarah', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(6, '37dfba6e-3eb4-11f1-b465-a81e845d2f97', 'Matematika', 'Buku pelajaran matematika', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(7, '37dfbd62-3eb4-11f1-b465-a81e845d2f97', 'Bahasa', 'Buku bahasa Indonesia dan asing', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(8, '37dfc099-3eb4-11f1-b465-a81e845d2f97', 'Agama', 'Buku tentang agama dan spiritual', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(9, '37dfc402-3eb4-11f1-b465-a81e845d2f97', 'Seni & Budaya', 'Buku tentang seni dan kebudayaan', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(10, '37dfc702-3eb4-11f1-b465-a81e845d2f97', 'Olahraga', 'Buku tentang olahraga dan kesehatan', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(11, '37dfc9e6-3eb4-11f1-b465-a81e845d2f97', 'Biografi', 'Buku biografi tokoh terkenal', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(12, '37dfcccd-3eb4-11f1-b465-a81e845d2f97', 'Ensiklopedia', 'Buku referensi dan ensiklopedia', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(13, '37dfcfa6-3eb4-11f1-b465-a81e845d2f97', 'Novel', 'Novel fiksi dan sastra', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(14, '37dfd2c7-3eb4-11f1-b465-a81e845d2f97', 'Komik', 'Komik dan manga', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL),
(15, '37dfd62a-3eb4-11f1-b465-a81e845d2f97', 'Pendidikan', 'Buku pelajaran sekolah', '2026-04-22 05:32:22', '2026-04-22 05:32:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id_log` bigint UNSIGNED NOT NULL,
  `id_admin` bigint UNSIGNED DEFAULT NULL,
  `aksi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Contoh: CREATE_BUKU, DELETE_ANGGOTA, LOGIN, dll',
  `modul` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Modul yang diakses: buku, anggota, peminjaman, dll',
  `deskripsi` text COLLATE utf8mb4_unicode_ci COMMENT 'Detail lengkap aktivitas',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `data_lama` json DEFAULT NULL COMMENT 'Snapshot data sebelum perubahan',
  `data_baru` json DEFAULT NULL COMMENT 'Snapshot data setelah perubahan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id_log`, `id_admin`, `aksi`, `modul`, `deskripsi`, `ip_address`, `user_agent`, `data_lama`, `data_baru`, `created_at`, `updated_at`) VALUES
(1, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 17:40:33', '2026-04-22 17:40:33'),
(2, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 17:42:54', '2026-04-22 17:42:54'),
(3, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 18:24:36', '2026-04-22 18:24:36'),
(4, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 18:51:46', '2026-04-22 18:51:46'),
(5, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 19:08:56', '2026-04-22 19:08:56'),
(6, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 19:10:33', '2026-04-22 19:10:33'),
(7, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 20:11:15', '2026-04-22 20:11:15'),
(8, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 20:16:44', '2026-04-22 20:16:44'),
(9, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 20:23:49', '2026-04-22 20:23:49'),
(10, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 20:25:05', '2026-04-22 20:25:05'),
(11, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 20:27:58', '2026-04-22 20:27:58'),
(12, 1, 'CREATE_BUKU', 'buku', 'Menambahkan buku: 10 Dosa Besar Soeharto (Kode: BK-019)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, '{\"stok\": 1, \"uuid\": \"f22e4e4d-da16-4555-a3a2-283cdd0b2896\", \"id_buku\": 11, \"kondisi\": \"BAIK\", \"penerbit\": \"Upaya Warga Negara\", \"kode_buku\": \"BK-019\", \"pengarang\": \"Drs. Wimanjaya K. Liotohe.\", \"created_at\": \"2026-04-23T03:39:43.000000Z\", \"judul_buku\": \"10 Dosa Besar Soeharto\", \"updated_at\": \"2026-04-23T03:39:43.000000Z\", \"status_buku\": \"TERSEDIA\", \"tahun_terbit\": 1998}', '2026-04-22 20:39:43', '2026-04-22 20:39:43'),
(13, 1, 'UPDATE_PENGATURAN_DENDA', 'denda', 'Mengupdate pengaturan denda: Rp 1.000/hari, maks 7 hari', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"1000.00\", \"maks_hari_pinjam\": 7}', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"1000.00\", \"maks_hari_pinjam\": 7}', '2026-04-22 20:57:16', '2026-04-22 20:57:16'),
(14, 1, 'APPROVE_PEMINJAMAN', 'peminjaman', 'Menerima peminjaman buku \'Algoritma dan Pemrograman\' oleh Ahmad Fauzi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"buku\": {\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"BAIK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2016}, \"uuid\": \"8fcc3d78-3182-47e2-bbad-07a8a172fe8d\", \"id_buku\": 8, \"created_at\": \"2026-04-23T02:21:33.000000Z\", \"id_anggota\": 1, \"updated_at\": \"2026-04-23T02:21:33.000000Z\", \"id_peminjaman\": 1, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": null, \"status_peminjaman\": \"MENUNGGU_KONFIRMASI\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-24T00:00:00.000000Z\"}', '{\"uuid\": \"8fcc3d78-3182-47e2-bbad-07a8a172fe8d\", \"id_buku\": 8, \"created_at\": \"2026-04-23T02:21:33.000000Z\", \"id_anggota\": 1, \"updated_at\": \"2026-04-23T04:26:32.000000Z\", \"id_peminjaman\": 1, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": 1, \"status_peminjaman\": \"DIPINJAM\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-24T00:00:00.000000Z\"}', '2026-04-22 21:26:32', '2026-04-22 21:26:32'),
(15, 1, 'CREATE_PENGEMBALIAN', 'pengembalian', 'Pengembalian buku \'Algoritma dan Pemrograman\' oleh anggota. Denda: Rp 19.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, '{\"uuid\": \"39036983-a534-4522-966c-9cefe3c1c785\", \"created_at\": \"2026-04-23T04:28:52.000000Z\", \"updated_at\": \"2026-04-23T04:28:52.000000Z\", \"denda_total\": \"19000.00\", \"status_denda\": \"BELUM_LUNAS\", \"denda_kondisi\": \"20000.00\", \"id_peminjaman\": 1, \"catatan_petugas\": null, \"id_pengembalian\": 1, \"tanggal_kembali\": \"2026-04-25T00:00:00.000000Z\", \"id_petugas_kembali\": 1, \"denda_keterlambatan\": \"-1000.00\", \"kondisi_buku_kembali\": \"RUSAK\"}', '2026-04-22 21:28:52', '2026-04-22 21:28:52'),
(16, 1, 'APPROVE_PEMINJAMAN', 'peminjaman', 'Menerima peminjaman buku \'Bahasa Inggris Kelas 11\' oleh Ahmad Fauzi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"buku\": {\"stok\": 12, \"uuid\": \"36e6f6b0-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 9, \"kondisi\": \"BAIK\", \"penerbit\": \"Kemendikbud\", \"kode_buku\": \"BK-009\", \"pengarang\": \"Tim Kemendikbud\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Bahasa Inggris Kelas 11\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2022}, \"uuid\": \"d2c69d93-9948-4d66-a8b6-48e55d243afb\", \"id_buku\": 9, \"created_at\": \"2026-04-23T04:56:15.000000Z\", \"id_anggota\": 1, \"updated_at\": \"2026-04-23T04:56:15.000000Z\", \"id_peminjaman\": 2, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": null, \"status_peminjaman\": \"MENUNGGU_KONFIRMASI\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-24T00:00:00.000000Z\"}', '{\"uuid\": \"d2c69d93-9948-4d66-a8b6-48e55d243afb\", \"id_buku\": 9, \"created_at\": \"2026-04-23T04:56:15.000000Z\", \"id_anggota\": 1, \"updated_at\": \"2026-04-23T04:56:33.000000Z\", \"id_peminjaman\": 2, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": 1, \"status_peminjaman\": \"DIPINJAM\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-24T00:00:00.000000Z\"}', '2026-04-22 21:56:33', '2026-04-22 21:56:33'),
(17, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: 10 Dosa Besar Soeharto (Kode: BK-019)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 1, \"uuid\": \"f22e4e4d-da16-4555-a3a2-283cdd0b2896\", \"id_buku\": 11, \"kondisi\": \"BAIK\", \"penerbit\": \"Upaya Warga Negara\", \"kode_buku\": \"BK-019\", \"pengarang\": \"Drs. Wimanjaya K. Liotohe.\", \"created_at\": \"2026-04-23T03:39:43.000000Z\", \"jenis_buku\": null, \"judul_buku\": \"10 Dosa Besar Soeharto\", \"updated_at\": \"2026-04-23T03:39:43.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 1998}', '{\"stok\": 1, \"uuid\": \"f22e4e4d-da16-4555-a3a2-283cdd0b2896\", \"id_buku\": 11, \"kondisi\": \"BAIK\", \"penerbit\": \"Upaya Warga Negara\", \"kode_buku\": \"BK-019\", \"pengarang\": \"Drs. Wimanjaya K. Liotohe.\", \"created_at\": \"2026-04-23T03:39:43.000000Z\", \"jenis_buku\": null, \"judul_buku\": \"10 Dosa Besar Soeharto\", \"updated_at\": \"2026-04-23T06:07:18.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/2eb9fd66-a2e5-46b7-b438-18cc5c16b460.png\", \"tahun_terbit\": 1998}', '2026-04-22 23:07:18', '2026-04-22 23:07:18'),
(18, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Bumi Manusia (Kode: BK-002)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 3, \"uuid\": \"36e6ec4c-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 2, \"kondisi\": \"BAIK\", \"penerbit\": \"Hasta Mitra\", \"kode_buku\": \"BK-002\", \"pengarang\": \"Pramoedya Ananta Toer\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Bumi Manusia\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 1980}', '{\"stok\": 3, \"uuid\": \"36e6ec4c-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 2, \"kondisi\": \"BAIK\", \"penerbit\": \"Hasta Mitra\", \"kode_buku\": \"BK-002\", \"pengarang\": \"Pramoedya Ananta Toer\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Bumi Manusia\", \"updated_at\": \"2026-04-23T06:07:57.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/336beb64-aca1-43ee-9b38-305a23028045.png\", \"tahun_terbit\": 1980}', '2026-04-22 23:07:57', '2026-04-22 23:07:57'),
(19, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Fisika Dasar (Kode: BK-003)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 10, \"uuid\": \"36e6ee37-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 3, \"kondisi\": \"BAIK\", \"penerbit\": \"Erlangga\", \"kode_buku\": \"BK-003\", \"pengarang\": \"Halliday & Resnick\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Fisika Dasar\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2010}', '{\"stok\": 10, \"uuid\": \"36e6ee37-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 3, \"kondisi\": \"BAIK\", \"penerbit\": \"Erlangga\", \"kode_buku\": \"BK-003\", \"pengarang\": \"Halliday & Resnick\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Fisika Dasar\", \"updated_at\": \"2026-04-23T06:08:31.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/2246fc70-942a-47f2-b265-2eabe91039f5.png\", \"tahun_terbit\": 2010}', '2026-04-22 23:08:31', '2026-04-22 23:08:31'),
(20, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Matematika Kelas 10 (Kode: BK-004)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 15, \"uuid\": \"36e6efa9-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 4, \"kondisi\": \"BAIK\", \"penerbit\": \"Kemendikbud\", \"kode_buku\": \"BK-004\", \"pengarang\": \"Tim Kemendikbud\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Matematika Kelas 10\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2022}', '{\"stok\": 15, \"uuid\": \"36e6efa9-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 4, \"kondisi\": \"BAIK\", \"penerbit\": \"Kemendikbud\", \"kode_buku\": \"BK-004\", \"pengarang\": \"Tim Kemendikbud\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Matematika Kelas 10\", \"updated_at\": \"2026-04-23T06:09:08.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/78b769b5-d486-45db-b8c6-8088a8358a82.png\", \"tahun_terbit\": 2022}', '2026-04-22 23:09:08', '2026-04-22 23:09:08'),
(21, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Pemrograman Web dengan Laravel (Kode: BK-005)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 4, \"uuid\": \"36e6f117-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 5, \"kondisi\": \"BAIK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-005\", \"pengarang\": \"Rahmat Hidayat\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Pemrograman Web dengan Laravel\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2023}', '{\"stok\": 4, \"uuid\": \"36e6f117-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 5, \"kondisi\": \"BAIK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-005\", \"pengarang\": \"Rahmat Hidayat\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Pemrograman Web dengan Laravel\", \"updated_at\": \"2026-04-23T06:09:33.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/8eb41437-8805-4a1c-87ae-f14602b4b245.png\", \"tahun_terbit\": 2023}', '2026-04-22 23:09:33', '2026-04-22 23:09:33'),
(22, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Bahasa Inggris Kelas 11 (Kode: BK-009)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 11, \"uuid\": \"36e6f6b0-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 9, \"kondisi\": \"BAIK\", \"penerbit\": \"Kemendikbud\", \"kode_buku\": \"BK-009\", \"pengarang\": \"Tim Kemendikbud\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Bahasa Inggris Kelas 11\", \"updated_at\": \"2026-04-23T04:56:33.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2022}', '{\"stok\": 11, \"uuid\": \"36e6f6b0-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 9, \"kondisi\": \"BAIK\", \"penerbit\": \"Kemendikbud\", \"kode_buku\": \"BK-009\", \"pengarang\": \"Tim Kemendikbud\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Bahasa Inggris Kelas 11\", \"updated_at\": \"2026-04-23T06:19:42.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/67a6e38a-62c8-482a-91be-ff7c6ea8b0df.png\", \"tahun_terbit\": 2022}', '2026-04-22 23:19:42', '2026-04-22 23:19:42'),
(23, 1, 'TERIMA_PEMBAYARAN_DENDA', 'pengembalian', 'Menerima pembayaran denda Rp 19.000 untuk anggota Ahmad Fauzi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-22 23:36:58', '2026-04-22 23:36:58'),
(24, 1, 'UPDATE_PENGATURAN_DENDA', 'denda', 'Mengupdate pengaturan denda: Rp 10.000/hari, maks 7 hari', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"1000.00\", \"maks_hari_pinjam\": 7}', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-23T06:37:23.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"10000.00\", \"maks_hari_pinjam\": 7}', '2026-04-22 23:37:23', '2026-04-22 23:37:23'),
(25, 1, 'UPDATE_PENGATURAN_DENDA', 'denda', 'Mengupdate pengaturan denda: Rp 10.000/hari, maks 7 hari', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-23T06:37:23.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"10000.00\", \"maks_hari_pinjam\": 7}', '{\"is_active\": true, \"created_at\": \"2026-04-22T12:32:25.000000Z\", \"updated_at\": \"2026-04-23T06:37:23.000000Z\", \"updated_by\": 1, \"id_pengaturan\": 1, \"denda_per_hari\": \"10000.00\", \"maks_hari_pinjam\": 7}', '2026-04-22 23:37:24', '2026-04-22 23:37:24'),
(26, 1, 'CREATE_PENGEMBALIAN', 'pengembalian', 'Pengembalian buku \'Bahasa Inggris Kelas 11\' oleh anggota. Denda: Rp 140.000', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, '{\"uuid\": \"aead1429-c925-41fb-b909-a166c8407247\", \"created_at\": \"2026-04-23T06:53:49.000000Z\", \"updated_at\": \"2026-04-23T06:53:49.000000Z\", \"denda_total\": \"140000.00\", \"status_denda\": \"BELUM_LUNAS\", \"denda_kondisi\": \"80000.00\", \"id_peminjaman\": 2, \"catatan_petugas\": null, \"id_pengembalian\": 2, \"tanggal_kembali\": \"2026-04-30T00:00:00.000000Z\", \"id_petugas_kembali\": 1, \"denda_keterlambatan\": \"60000.00\", \"kondisi_buku_kembali\": \"RUSAK\"}', '2026-04-22 23:53:49', '2026-04-22 23:53:49'),
(27, 1, 'TOLAK_PEMBAYARAN_DENDA', 'pengembalian', 'Menolak pembayaran denda Rp 140.000 untuk anggota Ahmad Fauzi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 00:02:34', '2026-04-23 00:02:34'),
(28, 1, 'TERIMA_PEMBAYARAN_DENDA', 'pengembalian', 'Menerima pembayaran denda Rp 140.000 untuk anggota Ahmad Fauzi', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 00:08:38', '2026-04-23 00:08:38'),
(29, 1, 'DELETE_BUKU', 'buku', 'Menghapus buku: Negeri 5 Menara (Kode: BK-010)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 4, \"uuid\": \"36e6f80d-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 10, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-010\", \"pengarang\": \"Ahmad Fuadi\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Negeri 5 Menara\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2009}', NULL, '2026-04-23 00:39:32', '2026-04-23 00:39:32'),
(30, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Sejarah Indonesia (Kode: BK-006)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 7, \"uuid\": \"36e6f2a1-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 6, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-006\", \"pengarang\": \"Tim Penulis\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Sejarah Indonesia\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2020}', '{\"stok\": 7, \"uuid\": \"36e6f2a1-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 6, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-006\", \"pengarang\": \"Tim Penulis\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Sejarah Indonesia\", \"updated_at\": \"2026-04-23T07:40:49.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/ea3d1eed-e1fe-4f6e-af4e-362f2a9c1541.png\", \"tahun_terbit\": 2020}', '2026-04-23 00:40:49', '2026-04-23 00:40:49'),
(31, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Sejarah Indonesia (Kode: BK-006)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 7, \"uuid\": \"36e6f2a1-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 6, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-006\", \"pengarang\": \"Tim Penulis\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Sejarah Indonesia\", \"updated_at\": \"2026-04-23T07:40:49.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/ea3d1eed-e1fe-4f6e-af4e-362f2a9c1541.png\", \"tahun_terbit\": 2020}', '{\"stok\": 7, \"uuid\": \"36e6f2a1-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 6, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-006\", \"pengarang\": \"Tim Penulis\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Sejarah Indonesia\", \"updated_at\": \"2026-04-23T07:40:50.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/d42ad335-7fa5-4f95-8a34-d7dc9b0eafc3.png\", \"tahun_terbit\": 2020}', '2026-04-23 00:40:50', '2026-04-23 00:40:50'),
(32, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Dilan 1990 (Kode: BK-007)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 6, \"uuid\": \"36e6f3fa-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 7, \"kondisi\": \"BAIK\", \"penerbit\": \"Pastel Books\", \"kode_buku\": \"BK-007\", \"pengarang\": \"Pidi Baiq\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Dilan 1990\", \"updated_at\": \"2026-04-22T12:32:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2014}', '{\"stok\": 6, \"uuid\": \"36e6f3fa-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 7, \"kondisi\": \"BAIK\", \"penerbit\": \"Pastel Books\", \"kode_buku\": \"BK-007\", \"pengarang\": \"Pidi Baiq\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Dilan 1990\", \"updated_at\": \"2026-04-23T07:41:56.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/ed0363f5-f8c5-48d0-98d4-a458f9012023.png\", \"tahun_terbit\": 2014}', '2026-04-23 00:41:56', '2026-04-23 00:41:56'),
(33, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Algoritma dan Pemrograman (Kode: BK-008)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T04:28:52.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2016}', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T07:42:53.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/0fa23cf8-5557-4b2d-a5d4-3a8565b2bbce.png\", \"tahun_terbit\": 2016}', '2026-04-23 00:42:53', '2026-04-23 00:42:53'),
(34, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Algoritma dan Pemrograman (Kode: BK-008)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T07:42:53.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/0fa23cf8-5557-4b2d-a5d4-3a8565b2bbce.png\", \"tahun_terbit\": 2016}', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T07:42:53.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/e1fef48d-b657-4c9a-9d06-3fd85f38c204.png\", \"tahun_terbit\": 2016}', '2026-04-23 00:42:53', '2026-04-23 00:42:53'),
(35, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Algoritma dan Pemrograman (Kode: BK-008)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T07:42:53.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/e1fef48d-b657-4c9a-9d06-3fd85f38c204.png\", \"tahun_terbit\": 2016}', '{\"stok\": 8, \"uuid\": \"36e6f556-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 8, \"kondisi\": \"RUSAK\", \"penerbit\": \"Informatika\", \"kode_buku\": \"BK-008\", \"pengarang\": \"Rinaldi Munir\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Non-Fiksi\", \"judul_buku\": \"Algoritma dan Pemrograman\", \"updated_at\": \"2026-04-23T07:42:54.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/4c7571d8-5daf-4978-a9ae-8169c81ab5b1.png\", \"tahun_terbit\": 2016}', '2026-04-23 00:42:54', '2026-04-23 00:42:54'),
(36, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Negeri 5 Menara (Kode: BK-010)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 4, \"uuid\": \"36e6f80d-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 10, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-010\", \"pengarang\": \"Ahmad Fuadi\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Negeri 5 Menara\", \"updated_at\": \"2026-04-23T07:39:40.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2009}', '{\"stok\": 4, \"uuid\": \"36e6f80d-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 10, \"kondisi\": \"BAIK\", \"penerbit\": \"Gramedia\", \"kode_buku\": \"BK-010\", \"pengarang\": \"Ahmad Fuadi\", \"created_at\": \"2026-04-22T12:32:23.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Negeri 5 Menara\", \"updated_at\": \"2026-04-23T07:44:23.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/7b237640-f3b3-4dbb-8879-7827b72919c8.png\", \"tahun_terbit\": 2009}', '2026-04-23 00:44:23', '2026-04-23 00:44:23'),
(37, 1, 'UPDATE_BUKU', 'buku', 'Mengupdate buku: Laskar Pelangi (Kode: BK-001)', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"stok\": 5, \"uuid\": \"36e6e2c5-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 1, \"kondisi\": \"BAIK\", \"penerbit\": \"Bentang Pustaka\", \"kode_buku\": \"BK-001\", \"pengarang\": \"Andrea Hirata\", \"created_at\": \"2026-04-22T12:32:22.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Laskar Pelangi\", \"updated_at\": \"2026-04-22T12:32:22.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": null, \"tahun_terbit\": 2005}', '{\"stok\": 5, \"uuid\": \"36e6e2c5-3eb4-11f1-b465-a81e845d2f97\", \"id_buku\": 1, \"kondisi\": \"BAIK\", \"penerbit\": \"Bentang Pustaka\", \"kode_buku\": \"BK-001\", \"pengarang\": \"Andrea Hirata\", \"created_at\": \"2026-04-22T12:32:22.000000Z\", \"deleted_at\": null, \"jenis_buku\": \"Fiksi\", \"judul_buku\": \"Laskar Pelangi\", \"updated_at\": \"2026-04-23T07:45:14.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/455695ca-510c-4d95-b17f-63cbad008a58.png\", \"tahun_terbit\": 2005}', '2026-04-23 00:45:14', '2026-04-23 00:45:14'),
(38, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 04:56:45', '2026-04-23 04:56:45'),
(39, 1, 'LOGOUT', 'auth', 'Admin berhasil logout', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 05:43:18', '2026-04-23 05:43:18'),
(40, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 09:24:06', '2026-04-23 09:24:06'),
(41, 1, 'UPDATE_ANGGOTA', 'anggota', 'Mengupdate anggota: Siti Nurhaliza', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"nis\": \"2024002\", \"uuid\": \"37311d4b-3eb4-11f1-b465-a81e845d2f97\", \"email\": \"siti@sikutu.local\", \"kelas\": \"10\", \"alamat\": \"Jl. Sudirman No. 5\", \"jurusan\": \"10 PPLG 2\", \"id_admin\": 1, \"username\": \"siswa2\", \"created_at\": \"2026-04-22T12:32:24.000000Z\", \"id_anggota\": 2, \"no_telepon\": \"081234567891\", \"updated_at\": \"2026-04-23T16:00:24.000000Z\", \"masa_berlaku\": \"2027-04-22T00:00:00.000000Z\", \"nama_lengkap\": \"Siti Nurhaliza\", \"photo_profile\": null, \"status_anggota\": \"AKTIF\", \"tanggal_daftar\": \"2026-04-22T00:00:00.000000Z\"}', '{\"nis\": \"2024002\", \"uuid\": \"37311d4b-3eb4-11f1-b465-a81e845d2f97\", \"email\": \"siti@sikutu.local\", \"kelas\": \"10\", \"alamat\": \"Jl. Sudirman No. 5\", \"jurusan\": \"10 PPLG 2\", \"id_admin\": 1, \"username\": \"siswa2\", \"created_at\": \"2026-04-22T12:32:24.000000Z\", \"id_anggota\": 2, \"no_telepon\": \"081234567891\", \"updated_at\": \"2026-04-23T16:24:36.000000Z\", \"masa_berlaku\": \"2026-04-30T00:00:00.000000Z\", \"nama_lengkap\": \"Siti Nurhaliza\", \"photo_profile\": null, \"status_anggota\": \"DIBLOKIR\", \"tanggal_daftar\": \"2026-04-22T00:00:00.000000Z\"}', '2026-04-23 09:24:36', '2026-04-23 09:24:36'),
(42, 1, 'TOGGLE_STATUS_ANGGOTA', 'anggota', 'Mengubah status anggota Siti Nurhaliza dari DIBLOKIR ke AKTIF', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"status_anggota\": \"DIBLOKIR\"}', '{\"status_anggota\": \"AKTIF\"}', '2026-04-23 09:38:02', '2026-04-23 09:38:02'),
(43, 1, 'LOGIN', 'auth', 'Admin berhasil login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, NULL, '2026-04-23 19:31:54', '2026-04-23 19:31:54'),
(44, 1, 'APPROVE_PEMINJAMAN', 'peminjaman', 'Menerima peminjaman buku \'10 Dosa Besar Soeharto\' oleh Siti Nurhaliza', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"buku\": {\"stok\": 1, \"uuid\": \"f22e4e4d-da16-4555-a3a2-283cdd0b2896\", \"id_buku\": 11, \"kondisi\": \"BAIK\", \"penerbit\": \"Upaya Warga Negara\", \"kode_buku\": \"BK-019\", \"pengarang\": \"Drs. Wimanjaya K. Liotohe.\", \"created_at\": \"2026-04-23T03:39:43.000000Z\", \"deleted_at\": null, \"jenis_buku\": null, \"judul_buku\": \"10 Dosa Besar Soeharto\", \"updated_at\": \"2026-04-23T06:07:18.000000Z\", \"status_buku\": \"TERSEDIA\", \"gambar_cover\": \"covers/2eb9fd66-a2e5-46b7-b438-18cc5c16b460.png\", \"tahun_terbit\": 1998}, \"uuid\": \"45b2ca58-e881-4e58-931f-8a1f385205c0\", \"id_buku\": 11, \"created_at\": \"2026-04-23T16:02:22.000000Z\", \"id_anggota\": 2, \"updated_at\": \"2026-04-23T16:02:22.000000Z\", \"id_peminjaman\": 3, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": null, \"status_peminjaman\": \"MENUNGGU_KONFIRMASI\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-26T00:00:00.000000Z\"}', '{\"uuid\": \"45b2ca58-e881-4e58-931f-8a1f385205c0\", \"id_buku\": 11, \"created_at\": \"2026-04-23T16:02:22.000000Z\", \"id_anggota\": 2, \"updated_at\": \"2026-04-24T02:32:50.000000Z\", \"id_peminjaman\": 3, \"tanggal_pinjam\": \"2026-04-23T00:00:00.000000Z\", \"id_admin_pinjam\": 1, \"status_peminjaman\": \"DIPINJAM\", \"catatan_peminjaman\": null, \"tanggal_harus_kembali\": \"2026-04-26T00:00:00.000000Z\"}', '2026-04-23 19:32:50', '2026-04-23 19:32:50'),
(45, 1, 'CREATE_PENGEMBALIAN', 'pengembalian', 'Pengembalian buku \'10 Dosa Besar Soeharto\' oleh anggota. Denda: Rp 0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', NULL, '{\"uuid\": \"5077c94f-846e-4a0d-ac5c-f4d5b0b53859\", \"created_at\": \"2026-04-24T02:46:49.000000Z\", \"updated_at\": \"2026-04-24T02:46:49.000000Z\", \"denda_total\": \"0.00\", \"status_denda\": \"TIDAK_ADA\", \"denda_kondisi\": \"0.00\", \"id_peminjaman\": 3, \"catatan_petugas\": null, \"id_pengembalian\": 3, \"tanggal_kembali\": \"2026-04-26T00:00:00.000000Z\", \"id_petugas_kembali\": 1, \"denda_keterlambatan\": \"0.00\", \"kondisi_buku_kembali\": \"BAIK\"}', '2026-04-23 19:46:49', '2026-04-23 19:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_04_22_000001_create_admins_table', 1),
(4, '2026_04_22_000002_create_anggota_perpustakaan_table', 1),
(5, '2026_04_22_000003_create_genres_table', 1),
(6, '2026_04_22_000004_create_bukus_table', 1),
(7, '2026_04_22_000005_create_buku_genre_table', 1),
(8, '2026_04_22_000006_create_peminjamans_table', 1),
(9, '2026_04_22_000007_create_pengembalians_table', 1),
(10, '2026_04_22_000008_create_pengaturan_denda_table', 1),
(11, '2026_04_22_000009_create_log_aktivitas_table', 1),
(12, '2026_04_22_000010_create_password_resets_table', 1),
(13, '2026_04_22_235501_create_sessions_table', 2),
(14, '2026_04_23_013120_add_uuid_and_denda_columns_to_tables', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_user` enum('admin','anggota') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `username`, `token`, `tipe_user`, `is_used`, `expired_at`, `created_at`) VALUES
(1, 'siswa2', '$2y$12$7Rj9PxDRACYSF7ywBk8E1OcNWnK69d2PkNBoPlnwKxlwrSNTT0iZa', 'anggota', 1, '2026-04-23 09:59:54', '2026-04-23 08:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_anggota` bigint UNSIGNED NOT NULL,
  `id_buku` bigint UNSIGNED NOT NULL,
  `id_admin_pinjam` bigint UNSIGNED DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL DEFAULT '2026-04-22',
  `tanggal_harus_kembali` date NOT NULL,
  `status_peminjaman` enum('MENUNGGU_KONFIRMASI','DIPINJAM','DIKEMBALIKAN','DITOLAK','HILANG','RUSAK') COLLATE utf8mb4_unicode_ci DEFAULT 'MENUNGGU_KONFIRMASI',
  `catatan_peminjaman` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjamans`
--

INSERT INTO `peminjamans` (`id_peminjaman`, `uuid`, `id_anggota`, `id_buku`, `id_admin_pinjam`, `tanggal_pinjam`, `tanggal_harus_kembali`, `status_peminjaman`, `catatan_peminjaman`, `created_at`, `updated_at`) VALUES
(1, '8fcc3d78-3182-47e2-bbad-07a8a172fe8d', 1, 8, 1, '2026-04-23', '2026-04-24', 'DIKEMBALIKAN', NULL, '2026-04-22 19:21:33', '2026-04-22 21:28:52'),
(2, 'd2c69d93-9948-4d66-a8b6-48e55d243afb', 1, 9, 1, '2026-04-23', '2026-04-24', 'DIKEMBALIKAN', NULL, '2026-04-22 21:56:15', '2026-04-22 23:53:49'),
(3, '45b2ca58-e881-4e58-931f-8a1f385205c0', 2, 11, 1, '2026-04-23', '2026-04-26', 'DIKEMBALIKAN', NULL, '2026-04-23 09:02:22', '2026-04-23 19:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_denda`
--

CREATE TABLE `pengaturan_denda` (
  `id_pengaturan` bigint UNSIGNED NOT NULL,
  `denda_per_hari` decimal(10,2) NOT NULL DEFAULT '1000.00' COMMENT 'Nominal denda per hari keterlambatan (Rupiah)',
  `maks_hari_pinjam` int NOT NULL DEFAULT '7' COMMENT 'Maksimal hari peminjaman',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan_denda`
--

INSERT INTO `pengaturan_denda` (`id_pengaturan`, `denda_per_hari`, `maks_hari_pinjam`, `is_active`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 10000.00, 7, 1, 1, '2026-04-22 05:32:25', '2026-04-22 23:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id_pengembalian` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_peminjaman` bigint UNSIGNED NOT NULL,
  `tanggal_kembali` date NOT NULL DEFAULT '2026-04-22',
  `kondisi_buku_kembali` enum('BAIK','RUSAK') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BAIK',
  `denda_keterlambatan` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Denda otomatis dari keterlambatan',
  `denda_kondisi` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Denda manual dari kondisi buku rusak',
  `denda_total` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Total semua denda',
  `status_denda` enum('LUNAS','BELUM_LUNAS','TIDAK_ADA','MENUNGGU_KONFIRMASI','DITOLAK') COLLATE utf8mb4_unicode_ci DEFAULT 'TIDAK_ADA',
  `metode_pembayaran` enum('TUNAI','TRANSFER') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran` longtext COLLATE utf8mb4_unicode_ci,
  `id_petugas_kembali` bigint UNSIGNED NOT NULL,
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengembalians`
--

INSERT INTO `pengembalians` (`id_pengembalian`, `uuid`, `id_peminjaman`, `tanggal_kembali`, `kondisi_buku_kembali`, `denda_keterlambatan`, `denda_kondisi`, `denda_total`, `status_denda`, `metode_pembayaran`, `bukti_pembayaran`, `id_petugas_kembali`, `catatan_petugas`, `created_at`, `updated_at`) VALUES
(1, '39036983-a534-4522-966c-9cefe3c1c785', 1, '2026-04-25', 'RUSAK', -1000.00, 20000.00, 19000.00, 'LUNAS', NULL, NULL, 1, NULL, '2026-04-22 21:28:52', '2026-04-22 23:36:58'),
(2, 'aead1429-c925-41fb-b909-a166c8407247', 2, '2026-04-30', 'RUSAK', 60000.00, 80000.00, 140000.00, 'LUNAS', 'TRANSFER', 'bukti/8d995899-5ad5-4f1f-9b60-c9750d0d3a57.jpg', 1, NULL, '2026-04-22 23:53:49', '2026-04-23 00:08:38'),
(3, '5077c94f-846e-4a0d-ac5c-f4d5b0b53859', 3, '2026-04-26', 'BAIK', 0.00, 0.00, 0.00, 'TIDAK_ADA', NULL, NULL, 1, NULL, '2026-04-23 19:46:49', '2026-04-23 19:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2ui0VoY9l8GnmYWByB5euhIg1lCCgffGchUx4uDe', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiI0Uks5WG9tODl1MGxIenJvbDZURkJyYnN4eTVOVXFuOGNtTzhsRWpvIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9zaXN3YVwvZGFzaGJvYXJkIiwicm91dGUiOiJzaXN3YS5kYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl9hbmdnb3RhXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjZ9', 1776961685),
('cMZlK7DoQABmhvhBI1OdA75QsaXmiIL8zJDc55qJ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJIU3hqcXQ1aFk5bWVNeVVjRGZNYVNRdFlBcFJJdThQZ3ZEYU02TFM2IiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wZW5nZW1iYWxpYW4iLCJyb3V0ZSI6ImFkbWluLnBlbmdlbWJhbGlhbi5pbmRleCJ9LCJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==', 1776998810),
('pW0ZjAQ4imHEbalhGYeSkbBZFQNXrfXJTXP9qADT', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIwQzZUR1lmN0R3c1QwU3RyVE1WRkVSR2FqaWd1eVFIakNxN1dNWmJaIiwiZXJyb3IiOiJTaWxha2FuIGxvZ2luIHNlYmFnYWkgc2lzd2EgdGVybGViaWggZGFodWx1LiIsIl9mbGFzaCI6eyJuZXciOltdLCJvbGQiOlsiZXJyb3IiXX0sIl9wcmV2aW91cyI6eyJ1cmwiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvc2lzd2FcL2RlbmRhIiwicm91dGUiOiJzaXN3YS5kZW5kYS5pbmRleCJ9fQ==', 1776959955),
('uDM6K6Gvhcm8QjbPbTpCTURpFwUEqCXPoN9O9UFn', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJXT01WYXRONEtncXd4anZ2aGhCUmk0TVpnaFVZRkxXN0tXd081QXYwIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9wcm9maWxlIiwicm91dGUiOiJhZG1pbi5wcm9maWxlIn0sImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1776962711);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `anggota_perpustakaan`
--
ALTER TABLE `anggota_perpustakaan`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `anggota_perpustakaan_username_unique` (`username`),
  ADD UNIQUE KEY `anggota_perpustakaan_nis_unique` (`nis`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `anggota_perpustakaan_email_unique` (`email`),
  ADD KEY `idx_anggota_admin` (`id_admin`),
  ADD KEY `idx_anggota_status` (`status_anggota`);

--
-- Indexes for table `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `bukus_kode_buku_unique` (`kode_buku`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_buku_jenis` (`jenis_buku`),
  ADD KEY `idx_buku_status` (`status_buku`);

--
-- Indexes for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD PRIMARY KEY (`id_buku`,`id_genre`),
  ADD KEY `idx_buku_genre_genre` (`id_genre`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genre`),
  ADD UNIQUE KEY `genres_nama_genre_unique` (`nama_genre`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `idx_log_admin` (`id_admin`),
  ADD KEY `idx_log_aksi` (`aksi`),
  ADD KEY `idx_log_modul` (`modul`),
  ADD KEY `idx_log_waktu` (`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reset_username` (`username`),
  ADD KEY `idx_reset_token` (`token`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_peminjaman_anggota` (`id_anggota`),
  ADD KEY `idx_peminjaman_buku` (`id_buku`),
  ADD KEY `idx_peminjaman_admin` (`id_admin_pinjam`),
  ADD KEY `idx_peminjaman_status` (`status_peminjaman`),
  ADD KEY `idx_peminjaman_composite` (`id_anggota`,`id_buku`,`tanggal_pinjam`);

--
-- Indexes for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  ADD PRIMARY KEY (`id_pengaturan`),
  ADD KEY `pengaturan_denda_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD UNIQUE KEY `pengembalians_id_peminjaman_unique` (`id_peminjaman`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `idx_pengembalian_petugas` (`id_petugas_kembali`),
  ADD KEY `idx_pengembalian_tgl` (`tanggal_kembali`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `anggota_perpustakaan`
--
ALTER TABLE `anggota_perpustakaan`
  MODIFY `id_anggota` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id_buku` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genre` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id_log` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id_peminjaman` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  MODIFY `id_pengaturan` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id_pengembalian` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota_perpustakaan`
--
ALTER TABLE `anggota_perpustakaan`
  ADD CONSTRAINT `anggota_perpustakaan_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `buku_genre`
--
ALTER TABLE `buku_genre`
  ADD CONSTRAINT `buku_genre_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `bukus` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `buku_genre_id_genre_foreign` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_id_admin_pinjam_foreign` FOREIGN KEY (`id_admin_pinjam`) REFERENCES `admins` (`id_admin`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjamans_id_anggota_foreign` FOREIGN KEY (`id_anggota`) REFERENCES `anggota_perpustakaan` (`id_anggota`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjamans_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `bukus` (`id_buku`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `pengaturan_denda`
--
ALTER TABLE `pengaturan_denda`
  ADD CONSTRAINT `pengaturan_denda_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD CONSTRAINT `pengembalians_id_peminjaman_foreign` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjamans` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pengembalians_id_petugas_kembali_foreign` FOREIGN KEY (`id_petugas_kembali`) REFERENCES `admins` (`id_admin`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
