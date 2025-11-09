-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 12:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klp1`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `nim` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `asal_sekolah` varchar(50) NOT NULL,
  `motto` varchar(50) NOT NULL,
  `pengalaman` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`nim`, `nama`, `kelas`, `alamat`, `asal_sekolah`, `motto`, `pengalaman`, `gambar`) VALUES
('240209501084', 'Andi Nurrizqah Hamdana', 'PTIK F', 'Jl. Mallengkeri Raya', 'MAN 1 BONE', 'Apa yang kuusahakan hari ini, itu yang akan aku tu', 'Sebuah pengalaman yang tak pernah terduga bisa berkuliah di jurusan sekarang ini dan mendapat kelas di PTIK F. Di semester awal saya merasa kesulitan untuk adaptasi dengan lingkungan dan matkul yang dipelajari. Kesulitan ini ada, mungkin salah satu alasannya karena background saya yang merupakan alumni Madrasah. Dan memang tidak ada planning untuk ambil jurusan ini. Tapi setelah menjalani semester satu dibersamai oleh teman-teman yang saling suport dan akhirnya saya bisa survive di dunia perkuliahan.\n\nSemester dua pun datang dengan berbagai tugasnya tetapi masih lebih ringan dibanding semester satu. Selama berkuliah di dua semester lalu terasa sangat singkat, mungkin rotasi bulan yang berputar begitu cepat yang menyebabkan perputaran jarumnya tak terasa. Oh iya, selama semester satu anak-anak PTIK berkuliah secara daring dikarenakan ruang belajar yang tidak ada. Tapi memasuki semester dua perkualihan mulai dilaksankan secara offline dan lokasinya di Lamacca. Vibes perkualihan lebih terasa selama offline karena bisa lebih banyak interaksi dengan teman-teman. Semoga semester tiga ini bisa terjalani dengan baik dan tuntas. SEMANGAT KULIAH!!!', 'Rizqah.jpg'),
('240209501085', 'Nadine Patulak', 'PTIK F', 'Rantepao, Jl. Sawerigading No.15, Jl. Perumahan Do', 'SMA Negeri 2 Toraja Utara', 'Kamu tidak akan tahu kalau kamu tidak pernah menco', 'Selama saya kuliah di PTIK, saya bertemu dengan banyak teman yang memiliki pemikiran berbeda-beda karena kami berasal dari daerah yang beragam. Dari situ saya belajar untuk lebih terbuka, menghargai pendapat orang lain, dan beradaptasi dengan berbagai karakter.\r\n\r\nSelain itu, saya mendapatkan banyak pengalaman melalui kegiatan praktikum, kerja kelompok, dan presentasi di kelas. Dari pengalaman tersebut, saya belajar meningkatkan kemampuan komunikasi, bekerja sama dalam tim, dan menjadi lebih percaya diri ketika berbicara di depan banyak orang.', 'mhs_690ff5e1d5277.jpg'),
('240209501089', 'Fransisca Gabriela', 'PTIK F', 'Jl. Tidung 7 stp 6 No. 215', 'SMAN 9 Makasssar', '\"Carilah kesibukan ditengah kesibukan\"', 'Masa kuliah merupakan awal dari tantangan yang lebih nyata dalam hidup saya. Di tahap ini, saya mulai belajar untuk mengambil keputusan sendiri, mengatur waktu dengan lebih bijak, dan bertanggung jawab atas berbagai hal yang saya pilih. Sistem pembelajaran yang lebih terbuka serta lingkungan yang dinamis menuntut saya untuk cepat beradaptasi dan lebih aktif dalam memahami materi, tidak hanya menghafal. Tantangan demi tantangan datang silih berganti, tetapi semuanya menjadi bagian dari proses pembelajaran yang penting.\n\nSelain kegiatan perkuliahan, saya mulai mengikuti berbagai aktivitas di luar kelas. Keterlibatan dalam organisasi dan acara kampus memberi saya pengalaman baru dalam bekerja sama dengan orang lain, mengatur acara, dan menyumbangkan ide dalam tim. Aktivitas ini menjadi wadah yang membantu saya tumbuh-tidak hanya secara akademik, tapi juga dalam cara saya berkomunikasi dan berinteraksi dengan lingkungan.', 'ela.jpg'),
('240209501093', 'Sherlina Muliadi', 'PTIK F', 'Jl. Urip Sumaharjo, Makassar', 'SMA Negeri 2 Bone', 'Setiap kebaikan yang kita tabur, sekecil apa pun, ', 'Pada awal perkuliahan, saya merasa kesulitan karena berasal dari SMA yang tidak memiliki banyak pengalaman di bidang komputer. Namun, dengan bimbingan dosen dan kerjasama dengan teman-teman, saya mulai memahami dasar-dasar pemrograman dan jaringan. Seiring berjalannya waktu, saya mulai menikmati pembelajaran di PTIK. Setiap tugas dan proyek memberi pengalaman baru yang bermanfaat untuk mengasah kemampuan saya dalam dunia teknologi. Salah satu pengalaman yang paling berkesan saya adalah saat berhasil menyelesaikan program sederhana menggunakan C++. Walaupun awalnya sulit, rasa puas yang saya dapatkan membuat saya lebih semangat untuk belajar lebih dalam lagi.', 'sherli.jpeg'),
('240209501094', 'Nirwana', 'PTIK F', 'Jln. Turatea', 'SMKN 1 Selayar', 'Belajar bukan untuk hari ini saja, tetapi untuk ma', 'Selama mengikuti kuliah di PTIK, saya mendapatkan banyak pengalaman baru. Saya belajar berbagai mata kuliah yang berkaitan dengan teknologi informasi, pemrograman, dan pendidikan. Hal ini menambah wawasan dan pengetahuan saya terutama dalam bidang komputer dan jaringan.\n\nTidak hanya materi kuliah, saya juga belajar bagaimana bekerja dalam tim, mengerjakan tugas kelompok bersama, dan mempresentasikan hasil kerja. Semua pengalaman ini membuat saya lebih percaya diri dan siap menghadapi tantangan di masa depan.', 'Nirwana.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakurikuler`
--

CREATE TABLE `ekstrakurikuler` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekstrakurikuler`
--

INSERT INTO `ekstrakurikuler` (`id`, `nama`, `deskripsi`, `gambar`, `created_at`) VALUES
(1, 'OSIS (Organisasi Siswa Intra Sekolah)', 'OSIS adalah wadah utama bagi siswa untuk belajar berorganisasi, memimpin, serta melatih tanggung jawab dalam berbagai kegiatan sekolah.', 'osis.jpg', '2025-11-08 06:53:50'),
(2, 'Palang Merah Remaja (PMR)', 'PMR berfokus pada kegiatan kemanusiaan, pelatihan pertolongan pertama, serta pengembangan empati dan solidaritas sosial antar siswa.', 'uks.jpg', '2025-11-08 06:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `ekstra_kegiatan`
--

CREATE TABLE `ekstra_kegiatan` (
  `id` int(11) NOT NULL,
  `ekstrakurikuler_id` int(11) NOT NULL,
  `kegiatan` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekstra_kegiatan`
--

INSERT INTO `ekstra_kegiatan` (`id`, `ekstrakurikuler_id`, `kegiatan`, `created_at`) VALUES
(1, 1, 'Peringatan Hari Besar Nasional', '2025-11-08 06:53:50'),
(2, 1, 'Pensi dan Class Meeting', '2025-11-08 06:53:50'),
(3, 1, 'Program Bakti Sosial', '2025-11-08 06:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `ekstra_prestasi`
--

CREATE TABLE `ekstra_prestasi` (
  `id` int(11) NOT NULL,
  `ekstrakurikuler_id` int(11) NOT NULL,
  `prestasi` varchar(255) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekstra_prestasi`
--

INSERT INTO `ekstra_prestasi` (`id`, `ekstrakurikuler_id`, `prestasi`, `gambar`, `tahun`, `created_at`) VALUES
(1, 2, 'Juara 1 PP YRCC', 'prestasi_pmr_2023.jpg', '2023', '2025-11-08 06:53:50'),
(2, 2, 'Juara Umum 1 Wirafest', 'prestasi_pmr_2022.jpg', '2022', '2025-11-08 06:53:50'),
(3, 2, 'Juara Favorit 1 PP YRCC', 'prestasi_pmr_2024.jpg', '2024', '2025-11-08 06:53:50'),
(4, 2, 'Juara 1 PP YRCC', 'prestasi_pmr_2023.jpg', '2023', '2025-11-08 07:06:40');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `id` int(11) NOT NULL,
  `nama_fasilitas` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`id`, `nama_fasilitas`, `keterangan`, `jumlah`, `gambar`, `created_at`) VALUES
(1, 'Laboratorium Kimia', 'Ruang praktik Kimia lengkap dengan alat eksperimen.', 1, 'lab kimia.jpg', '2025-11-08 06:45:20'),
(2, 'Laboratorium Komputer', 'Untuk praktik pemrograman dan multimedia.', 1, 'labkom.jpg', '2025-11-08 06:45:20'),
(3, 'Perpustakaan', 'Koleksi buku pelajaran dan ruang baca nyaman.', 1, 'perpustakaan.jpg', '2025-11-08 06:45:20'),
(4, 'Lapangan Olahraga', 'Serbaguna untuk basket, futsal, dan upacara.', 1, 'lapangan.jpg', '2025-11-08 06:45:20'),
(5, 'UKS', 'Layanan kesehatan dasar dan pertolongan pertama.', 1, 'uks.jpg', '2025-11-08 06:45:20'),
(6, 'Kantin', 'Menyediakan makanan sehat dan bergizi untuk siswa dan guru.', 1, 'kantin.jpg', '2025-11-08 06:45:20'),
(7, 'Masjid', 'Tempat ibadah bagi siswa, guru, dan staf sekolah.', 1, 'masjid.jpg', '2025-11-08 06:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `Nama_Lengkap` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`Nama_Lengkap`, `email`, `pesan`) VALUES
('udin', 'udin@gmail.com', 'udin'),
('nadin', 'nadin@gmail.com', 'Saya suka matcha dan Ray'),
('nadin', 'nadin@gmail.com', 'Saya suka matcha dan Ray'),
('nad', 'adi@gmail.com', 'halloww'),
('aaa', 'aaa@gmail.com', 'aoidh'),
('nadine', 'adine@gmail.com', 'halooo');

-- --------------------------------------------------------

--
-- Table structure for table `matkul_favorit`
--

CREATE TABLE `matkul_favorit` (
  `id` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `nama_matkul` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matkul_favorit`
--

INSERT INTO `matkul_favorit` (`id`, `nim`, `nama_matkul`, `created_at`) VALUES
(1, '240209501084', 'Perkembangan Peserta Didik', '2025-11-07 06:52:07'),
(2, '240209501084', 'Struktur Data', '2025-11-07 06:52:07'),
(3, '240209501084', 'Algoritma dan Pemrograman Dasar', '2025-11-07 06:52:07'),
(4, '240209501084', 'Pemrograman Web', '2025-11-07 06:52:07'),
(5, '240209501084', 'Matematika Dasar', '2025-11-07 06:52:07'),
(6, '240209501085', 'Perkembangan Peserta Didik', '2025-11-07 06:53:33'),
(7, '240209501085', 'Struktur Data', '2025-11-07 06:53:33'),
(8, '240209501085', 'Algoritma dan Pemrograman Dasar', '2025-11-07 06:53:33'),
(9, '240209501085', 'Pemrograman Web', '2025-11-07 06:53:33'),
(10, '240209501085', 'Matematika Dasar', '2025-11-07 06:53:33'),
(11, '240209501089', 'Keamanan Komputer', '2025-11-07 06:58:42'),
(12, '240209501089', 'Pemrograman Web', '2025-11-07 06:58:42'),
(13, '240209501089', 'Jaringan Komputer', '2025-11-07 06:58:42'),
(14, '240209501089', 'Struktur Data', '2025-11-07 06:58:42'),
(15, '240209501089', 'Strategi Pembelajaran', '2025-11-07 06:58:42'),
(16, '240209501094', 'Jaringan Komputer', '2025-11-07 06:58:51'),
(17, '240209501094', 'Profesi Kependidikan', '2025-11-07 06:58:51'),
(18, '240209501094', 'Pemrograman Web', '2025-11-07 06:58:51'),
(19, '240209501094', 'Keamanan Komputer', '2025-11-07 06:58:51'),
(20, '240209501094', 'Strategi Pembelajaran', '2025-11-07 06:58:51'),
(21, '240209501094', 'Struktur Data', '2025-11-07 06:58:51'),
(22, '240209501094', 'Inovasi Teknologi', '2025-11-07 06:58:51'),
(23, '240209501094', 'Kecerdasan Buatan', '2025-11-07 06:58:51'),
(24, '240209501093', 'Pemrograman Web', '2025-11-07 07:00:10'),
(25, '240209501093', 'Keamanan Komputer', '2025-11-07 07:00:10'),
(26, '240209501093', 'Struktur Data', '2025-11-07 07:00:10'),
(27, '240209501093', 'Jaringan Komputer', '2025-11-07 07:00:10'),
(28, '240209501093', 'Strategi Pembelajaran', '2025-11-07 07:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi_siswa`
--

CREATE TABLE `prestasi_siswa` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `judul_prestasi` varchar(255) NOT NULL,
  `tingkat` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi_siswa`
--

INSERT INTO `prestasi_siswa` (`id`, `nama_siswa`, `judul_prestasi`, `tingkat`, `tahun`, `deskripsi`, `gambar`, `created_at`) VALUES
(1, 'Tim Puisi SMAN 9 Makassar', 'Juara 3 Lomba Puisi', 'Sekolah', '2024', 'Prestasi dalam lomba puisi tingkat sekolah.', 'prestasi.jpg', '2025-11-08 07:12:21'),
(2, 'Tim Esai SMAN 9 Makassar', 'Juara 3 Lomba Esai \"Peringatan Hari Jadi Sul-Sel\"', 'Provinsi', '2024', 'Lomba esai memperingati Hari Jadi Sulawesi Selatan.', 'prestasi.jpg', '2025-11-08 07:12:21'),
(3, 'Tim Podcast SMAN 9 Makassar', 'Juara 1 Podcast EBS Fair Competition', 'Nasional', '2022', 'Kompetisi podcast tingkat nasional.', 'prestasi.jpg', '2025-11-08 07:12:21'),
(4, 'Salwa Nabilah', 'Best Intelegensia Duta Remaja Sulawesi Selatan', 'Provinsi', '2022', 'Penghargaan Duta Remaja Sulsel.', 'prestasi.jpg', '2025-11-08 07:12:21'),
(5, 'Salwa Nabilah', 'Runner-Up 1 Puteri Duta Pelajar Makassar', 'Kota', '2022', 'Kompetisi Duta Pelajar tingkat Kota Makassar.', 'prestasi.jpg', '2025-11-08 07:12:21'),
(6, 'Tim Jurnalistik SMAN 9 Makassar', 'Juara 1 Marinesia Journalist Competition', 'Nasional', '2022', 'Kompetisi jurnalistik nasional.', 'prestasi.jpg', '2025-11-08 07:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nim` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nim`, `password`, `created_at`) VALUES
(1, '240209501084', '12345', '2025-11-08 05:15:06'),
(2, '240209501085', '12345', '2025-11-08 05:15:06'),
(3, '240209501089', '12345', '2025-11-08 05:15:06'),
(4, '240209501093', '12345', '2025-11-08 05:15:06'),
(5, '240209501094', '12345', '2025-11-08 05:15:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ekstra_kegiatan`
--
ALTER TABLE `ekstra_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kegiatan_ekstra` (`ekstrakurikuler_id`);

--
-- Indexes for table `ekstra_prestasi`
--
ALTER TABLE `ekstra_prestasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_prestasi_ekstra` (`ekstrakurikuler_id`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matkul_favorit`
--
ALTER TABLE `matkul_favorit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_matkul_anggota` (`nim`);

--
-- Indexes for table `prestasi_siswa`
--
ALTER TABLE `prestasi_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ekstrakurikuler`
--
ALTER TABLE `ekstrakurikuler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ekstra_kegiatan`
--
ALTER TABLE `ekstra_kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ekstra_prestasi`
--
ALTER TABLE `ekstra_prestasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `matkul_favorit`
--
ALTER TABLE `matkul_favorit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `prestasi_siswa`
--
ALTER TABLE `prestasi_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ekstra_kegiatan`
--
ALTER TABLE `ekstra_kegiatan`
  ADD CONSTRAINT `fk_ekstra_kegiatan_ekstra` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_kegiatan_ekstra` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ekstra_prestasi`
--
ALTER TABLE `ekstra_prestasi`
  ADD CONSTRAINT `fk_ekstra_prestasi_ekstra` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_prestasi_ekstra` FOREIGN KEY (`ekstrakurikuler_id`) REFERENCES `ekstrakurikuler` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `matkul_favorit`
--
ALTER TABLE `matkul_favorit`
  ADD CONSTRAINT `fk_matkul_anggota` FOREIGN KEY (`nim`) REFERENCES `anggota` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_login_anggota` FOREIGN KEY (`nim`) REFERENCES `anggota` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
