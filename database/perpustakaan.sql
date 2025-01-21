-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jan 2022 pada 14.03
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `kode_anggota` char(10) NOT NULL,
  `nama_anggota` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL DEFAULT 'foto_default.png',
  `no_telp` char(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `jenis_kelamin` int(11) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `kode_anggota`, `nama_anggota`, `foto`, `no_telp`, `email`, `alamat`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`) VALUES
(69, 'A001', 'Marshel', 'foto_default.png', '08743938434', 'marshel@gmail.com', 'Jl Batu no 55', 1, 'Dobo', '2021-02-23'),
(73, 'A070', 'Fitri Ayu', 'user1.png', '08634343934', 'fitri@gmail.com', 'Jl. Magelang km 89', 2, 'Yogyakarta', '1997-01-12'),
(74, 'A074', 'Bayu', 'user5.png', '0893473434', 'bayu@gmail.com', 'Jl batu angus no 66', 1, 'Ternate', '1998-01-09'),
(75, 'A075', 'Erik', 'dimas.png', '0893434734834', 'erik@gmail.com', 'Jl Jendral Sudirman no 55', 1, 'Jakarta', '1999-12-23');
FF
-- --------------------------------------------------------

--
-- Struktur dari tabel `aturan_perpustakaan`
--

CREATE TABLE `aturan_perpustakaan` (
  `id` int(11) NOT NULL,
  `waktu_peminjaman` int(11) NOT NULL,
  `maksimal_peminjaman` int(11) NOT NULL,
  `denda_keterlambatan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aturan_perpustakaan`
--

INSERT INTO `aturan_perpustakaan` (`id`, `waktu_peminjaman`, `maksimal_peminjaman`, `denda_keterlambatan`) VALUES
(0, 7, 3, 500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail_peminjaman` int(11) NOT NULL,
  `kode_peminjaman` varchar(10) NOT NULL,
  `kode_pustaka` varchar(10) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` int(11) NOT NULL,
  `jenis_denda` int(11) NOT NULL,
  `denda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `kode_karyawan` char(9) NOT NULL,
  `nip` char(10) NOT NULL,
  `nama_karyawan` varchar(50) NOT NULL,
  `jk` char(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `alamat` varchar(60) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `kode_karyawan`, `nip`, `nama_karyawan`, `jk`, `email`, `alamat`, `no_telp`, `foto`) VALUES
(27, 'K001', '2102001', 'Admin', '1', 'admin@gmail.com', 'Jl Solo km 89', '08394348347', 'user5.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pustaka`
--

CREATE TABLE `kategori_pustaka` (
  `id_kategori_pustaka` int(11) NOT NULL,
  `kode_kategori_pustaka` varchar(10) NOT NULL,
  `nama_kategori_pustaka` varchar(50) NOT NULL,
  `gambar_kategori_pustaka` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori_pustaka`
--

INSERT INTO `kategori_pustaka` (`id_kategori_pustaka`, `kode_kategori_pustaka`, `nama_kategori_pustaka`, `gambar_kategori_pustaka`) VALUES
(11, 'K001', 'Bisnis', ''),
(12, 'K012', 'Komputer', ''),
(13, 'K013', 'Pariwisata', ''),
(14, 'K014', 'Pendidikan', ''),
(15, 'K015', 'Novel', ''),
(16, 'K016', 'Agama', ''),
(17, 'K017', 'Kesehatan', ''),
(18, 'K018', 'Sosial', ''),
(19, 'K019', 'Politik', ''),
(20, 'K020', 'Sejarah', ''),
(21, 'K021', 'Psikologi', ''),
(22, 'K022', 'Komik', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `kode_peminjaman` varchar(10) NOT NULL,
  `kode_anggota` varchar(10) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `kode_penerbit` varchar(10) NOT NULL,
  `nama_penerbit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `kode_penerbit`, `nama_penerbit`) VALUES
(3, 'U003', 'Andistar'),
(5, 'U004', 'Elex Media Komputindo'),
(6, 'U006', 'Informatika'),
(7, 'U007', 'Andi'),
(8, 'U008', 'Penebar Plus+'),
(9, 'U009', 'Gramedia Pustaka Utama'),
(10, 'U010', 'Padang Makhsyar Press/Padma'),
(11, 'U011', 'Cable Book'),
(12, 'U012', 'Real Books'),
(13, 'U013', 'Change Publication'),
(15, 'U014', 'Mizan'),
(17, 'U016', 'Kompas'),
(18, 'U018', 'Elex Media Komputindo'),
(19, 'U019', 'Zikrul Hakim'),
(20, 'U020', 'Marjin Kiri'),
(21, 'U021', 'Sahima');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `kode_pengguna` char(9) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `level` varchar(20) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `kode_pengguna`, `username`, `password`, `level`, `status`) VALUES
(37, 'K001', 'admin', '12345', 'Karyawan', 1),
(81, 'A001', 'marshel', '2c9520f0e5d91a843ac72aab4c1a810b', 'Anggota', 1),
(86, 'A070', '', '', 'Anggota', 1),
(87, 'A074', '', '', 'Anggota', 1),
(88, 'A075', '', '', 'Anggota', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penulis`
--

CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL,
  `kode_penulis` varchar(10) NOT NULL,
  `nama_penulis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penulis`
--

INSERT INTO `penulis` (`id_penulis`, `kode_penulis`, `nama_penulis`) VALUES
(6, 'P001', 'Didip Diandra'),
(7, 'P007', 'Paul Sloane'),
(8, 'P008', 'Febriana Werdiningsih'),
(9, 'P009', 'Tim Ems'),
(10, 'P010', 'Hendi Hendratman'),
(11, 'P011', 'Madcoms'),
(12, 'P012', 'Rina Dewi Lina,mm.cfp,luf'),
(13, 'P013', 'Yudha Eris Setiawan'),
(14, 'P014', 'Didip Diandra'),
(15, 'P015', 'Agus Mustofa'),
(16, 'P016', 'Afin Murtie'),
(17, 'P017', 'M.nur Aini, M.kes'),
(18, 'P018', 'Ralp Epperson'),
(19, 'P019', 'Steven J. Martin'),
(20, 'P020', 'Tere Liye'),
(23, 'P021', 'Rhenald Kasali'),
(24, 'P024', 'Kaiu Shirai, Posuka Demizu'),
(25, 'P025', 'Kak Adah, Abang Kerel'),
(26, 'P026', 'Agus Sudibyo'),
(27, 'P027', 'Gadisturatea');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_aplikasi`
--

CREATE TABLE `profil_aplikasi` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(30) NOT NULL,
  `nama_pimpinan` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_telp` char(14) NOT NULL,
  `website` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `profil_aplikasi`
--

INSERT INTO `profil_aplikasi` (`id`, `nama_aplikasi`, `nama_pimpinan`, `alamat`, `no_telp`, `website`, `logo`) VALUES
(0, 'Perpustakaan Umum Daerah', 'Etik Darmawati S.Si, M.Cs', 'Jl Ahmad Yani No 56, Tegalrejo, Yogyakarta', '(021)7316876', 'www.perpustakaan.com', 'icon aplikasi.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pustaka`
--

CREATE TABLE `pustaka` (
  `id_pustaka` int(11) NOT NULL,
  `kode_pustaka` varchar(10) NOT NULL,
  `judul_pustaka` varchar(100) NOT NULL,
  `kategori_pustaka` int(11) NOT NULL,
  `penerbit` int(11) NOT NULL,
  `penulis` int(11) NOT NULL,
  `tahun` char(4) NOT NULL,
  `gambar_pustaka` varchar(100) NOT NULL,
  `halaman` int(11) NOT NULL,
  `dimensi` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `rak` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pustaka`
--

INSERT INTO `pustaka` (`id_pustaka`, `kode_pustaka`, `judul_pustaka`, `kategori_pustaka`, `penerbit`, `penulis`, `tahun`, `gambar_pustaka`, `halaman`, `dimensi`, `stok`, `rak`) VALUES
(7, 'P0007', 'How To Be A Brillian Thinker', 11, 3, 7, '2020', 'How To Be A Brillian Thinker.PNG', 230, '-', 12, 'R001'),
(9, 'P0009', 'Pemrograman Android Dalam Sehari', 12, 5, 9, '2015', 'Pemrograman Android Dalam Sehari.PNG', 168, '-', 7, 'R001'),
(10, 'P0010', 'The Magic of Adobe Photoshop Edisi Revisi 2', 12, 6, 10, '2017', 'The Magic of Adobe Photoshop Edisi Revisi 2.PNG', 752, '-', 10, 'ROO3'),
(11, 'P0011', 'Microsoft Visual Basic 6.0 Untuk Pemula', 12, 7, 11, '2008', 'Microsoft Visual Basic 6.0 Untuk Pemula.PNG', 230, '-', 8, 'ROO3'),
(12, 'P0012', 'Bisa Investasi Dengan Gaji', 11, 3, 12, '2016', 'Bisa Investasi Dengan Gaji.PNG', 231, '-', 15, 'R002'),
(13, 'P0013', 'Cara Mudah Buka Bisnis Travel', 11, 9, 13, '2016', 'Cara Mudah Buka Bisnis Travel.PNG', 162, '14 x 21 cm', 5, 'ROO1'),
(14, 'P0014', 'Strategi Membangun Bisnis Mandiri', 11, 9, 6, '2016', 'Strategi Membangun Bisnis Mandiri.PNG', 129, '-', 8, 'R002'),
(16, 'P0015', 'Dzikir Tauhid', 16, 10, 15, '2006', 'Dzikir Tauhid.PNG', 0, '13 x 20 cm', 8, 'B005'),
(17, 'P0017', 'Hujan', 15, 9, 20, '2016', 'Hujan.PNG', 318, '14 x 21 Cm', 10, 'B006'),
(18, 'P0018', 'Aneka Buah Berkhasiat Obat', 17, 12, 17, '2015', 'Aneka Buah Berkhasiat Obat.PNG', 162, '14 x 20 Cm', 10, 'B006'),
(19, 'P0019', 'Invisible Hand', 20, 13, 18, '2013', 'Invisible Hand.PNG', 492, '-', 10, 'B007'),
(25, 'P0020', 'The Small Big', 11, 9, 19, '2016', 'The Small Big.PNG', 246, '14 x 21 Cm', 9, 'R009'),
(29, 'P0026', 'Self Driving', 11, 15, 23, '2014', 'Self Driving.PNG', 272, '14 x 21 Cm', 10, 'R005'),
(31, 'P0030', 'The Promised Neverland 16', 22, 18, 24, '2021', 'The Promised Neverland 16.PNG', 208, '11 x 17 Cm', 10, 'R009'),
(32, 'P0032', 'Jujutsu Kaisen 1', 22, 3, 24, '2021', 'Jujutsu Kaisen 1.PNG', 0, '11 x 17 Cm', 4, 'R009'),
(33, 'P0033', 'Seri Sweet Ana Salehah 2 Ida & Kecoak', 22, 19, 25, '2019', 'Seri Sweet Ana Salehah  Ida & Kecoak.PNG', 92, '13 x 18 Cm', 4, 'R009'),
(34, 'P0034', 'Demokrasi dan Kedaruratan Memahami Filsafat Politik Giorgio Agamben', 19, 20, 26, '2019', 'Demokrasi dan Kedaruratan Memahami Filsafat Politik Giorgio Agamben.PNG', 0, '14 x 21 Cm', 6, 'R008'),
(35, 'P0035', 'Menjemput Jodoh Impian', 18, 21, 27, '2020', 'Menjemput Jodoh Impian.PNG', 208, '14 x 21 Cm', 4, 'R005');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `kode_pelanggan` (`kode_anggota`);

--
-- Indeks untuk tabel `aturan_perpustakaan`
--
ALTER TABLE `aturan_perpustakaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail_peminjaman`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `kode_karyawan` (`kode_karyawan`);

--
-- Indeks untuk tabel `kategori_pustaka`
--
ALTER TABLE `kategori_pustaka`
  ADD PRIMARY KEY (`id_kategori_pustaka`),
  ADD UNIQUE KEY `kode_kategori_pustaka` (`kode_kategori_pustaka`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD UNIQUE KEY `kode_peminjaman` (`kode_peminjaman`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id_penulis`);

--
-- Indeks untuk tabel `profil_aplikasi`
--
ALTER TABLE `profil_aplikasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pustaka`
--
ALTER TABLE `pustaka`
  ADD PRIMARY KEY (`id_pustaka`),
  ADD UNIQUE KEY `kode_pustaka` (`kode_pustaka`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `kategori_pustaka`
--
ALTER TABLE `kategori_pustaka`
  MODIFY `id_kategori_pustaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1147;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id_penulis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `pustaka`
--
ALTER TABLE `pustaka`
  MODIFY `id_pustaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
