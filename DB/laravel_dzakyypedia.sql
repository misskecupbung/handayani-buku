-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jul 15, 2019 at 10:29 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_dzakyypedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_04_14_060543_create_tbl_admin', 1),
(2, '2019_04_14_060627_create_tbl_pengguna', 1),
(3, '2019_04_14_060652_create_tbl_kategori', 1),
(4, '2019_04_14_060716_create_tbl_penerbit', 1),
(5, '2019_04_14_060734_create_tbl_buku', 1),
(6, '2019_04_14_060804_create_tbl_keranjang', 1),
(7, '2019_04_14_060944_create_tbl_pesanan', 1),
(10, '2019_04_14_061127_create_tbl_invoice', 2),
(11, '2019_04_14_061054_create_tbl_pembayaran', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `superadmin` tinyint(1) NOT NULL DEFAULT '0',
  `diblokir` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_bergabung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nama_lengkap`, `email`, `password`, `foto`, `superadmin`, `diblokir`, `tanggal_bergabung`) VALUES
('ADM004', 'Dzakyypedia', 'dzakyypedia@gmail.com', '$2y$10$sOqDJK1xroWE/G5iLPwiFuQsvmc9r1A270UOsC6mZMw40CXghUwm6', 'ADM004.png', 1, 0, '2019-05-15 13:46:19'),
('ADM005', 'Kasir Satu', 'kasirsatu@gmail.com', '$2y$10$38NEgVyo.AFoSVkQTjZ01OAt.MdaR3NcgvgdL7JKOR22YBEi6lP/m', 'ADM005.png', 0, 0, '2019-05-15 13:47:47'),
('ADM006', 'Kasir Dua', 'kasirdua@gmail.com', '$2y$10$FWS2Fqqsy/hGUcMrbPMPF.BNKsHagxqDkI5Lp0UaMOgHqWrD6iJz2', 'ADM006.png', 0, 1, '2019-05-15 13:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `id_buku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul_buku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis_buku` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_penerbit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_buku` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_halaman` int(11) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `ISBN` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahasa_buku` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `format_buku` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat_buku` double NOT NULL,
  `dimensi_buku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `stok_buku` int(11) NOT NULL,
  `foto_buku` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`id_buku`, `judul_buku`, `penulis_buku`, `id_kategori`, `id_penerbit`, `deskripsi_buku`, `jumlah_halaman`, `tanggal_terbit`, `ISBN`, `bahasa_buku`, `format_buku`, `berat_buku`, `dimensi_buku`, `harga_satuan`, `stok_buku`, `foto_buku`, `tanggal_masuk`) VALUES
('BKU001', 'The Human Story', 'James C. Davis', 'KTG002', 'PNB006', '<p>Sejarah umat manusia sungguh mempesona. Dalam The Human Story, James C. Davis dengan cepat dan jernih menceritakan bagaimana orang-orang zaman dulu mulai menetap dan mendirikan kota-kota, menaklukkan tetangga dan membangun agama, serta belakangan mengobarkan perang dunia dan menjangkau antariksa.</p>', 610, '2018-08-02', '9786026486226', 'indonesia', 'Soft Cover', 700, '15 x 23', 159000, 30, 'BKU001.jpg', '2019-05-10 23:23:51'),
('BKU002', 'Sebuah Seni untuk Bersikap Bodo Amat', 'Mark Manson', 'KTG005', 'PNB005', '<p>Buku ini tidak berbicara bagaimana cara meringankan masalah atau rasa sakit. Bukan juga panduan untuk mencapai sesuatu. Namun, sebaliknya buku ini akan mengubah rasa sakit menjadi kekuatan, dan mengubah masalah menjadi masalah yang lebih baik. Khususnya, buku ini akan mengajari untuk peduli lebih sedikit.</p>', 256, '2018-02-05', '9786024526986', 'Indonesia', 'Soft Cover', 35, '14 x 21', 67000, 39, 'BKU002.jpg', '2019-04-17 20:50:53'),
('BKU003', '47 Ronin', 'John Allyn', 'KTG001', 'PNB001', '<p>Kisah Klasik Tentang Kesetiaan, Keberanian, dan Pembalasan Dendam Samurai Pada tahun 1701, dalam luapan amarah, Lord Asano menyerang seorang pejabat di istana Jepang. Sebagai hukuman, Lord Asano diperintahkan untuk melakukan seppuku, tanahnya disita, keluarganya diasingkan, dan para samurai-nya dibubarkan&ndash;menjadi ronin, samurai tak bertuan.</p>', 224, '2015-11-30', '9786020321622', 'Indonesia', 'Soft Cover', 200, '13 x 20', 59800, 20, 'BKU003.jpg', '2019-04-17 21:54:17'),
('BKU004', 'Crazy Rich Asians', 'Kevin Kwan', 'KTG001', 'PNB001', '<p>Crazy Rich Asians berkisah tentang perjuangan Rachel Chu mendapatkan pengakuan dari ibu Nick Young, ibu kekasihnya yang super kaya. Novel ini sudah diangkat ke layar lebar dan mendapat respon yang positif dari banyak kalangan.</p>', 480, '2016-06-20', '9786020314433', 'Indonesia', 'Soft Cover', 500, '15 x 23', 105000, 20, 'BKU004.jpg', '2019-04-17 22:00:59'),
('BKU005', 'Muhammad dan Umat Beriman', 'Fred M. Donner', 'KTG003', 'PNB001', '<p>Buku ini memberikan reinterpretasi yang provokatif dan komprehensif dengan argumentasi bahwa agama yang sekarang kita kenal dengan nama Islam muncul secara bertahap selama beberapa dekade.</p>', 298, '2015-10-07', '9786020321875', 'Indonesia', 'Soft Cover', 350, '15 x 23', 78000, 18, 'BKU005.jpg', '2019-04-17 23:07:50'),
('BKU006', 'Kisah Tanah Jawa', '@kisahtanahjawa', 'KTG001', 'PNB002', '<p>Tanah Jawa menyimpan banyak kisah misteri yang takkan habis diceritakan dalam semalam. Sosok misterius, ritual mistis, dan tempat angker, selalu membuat kita penasaran. Buku Kisah Tanah Jawa mengajak pembaca membuka selubung mitos dan mistis yang selama ini hanya menjadi kasak-kusuk di masyarakat.</p>', 250, '2019-01-02', '9789797809331', 'Indonesia', 'Soft Cover', 300, '14 x 20', 99000, 20, 'BKU006.jpg', '2019-05-10 23:42:21'),
('BKU007', 'Timaeus dan Critias: Awal Mula Kisah Atlantis', 'Plato', 'KTG002', 'PNB003', '<p>Timaeus dan Critias, dua dari dialog-dialog karya Plato, adalah satu-satunya catatan tertulis yang tersedia dan secara spesiflk membahas tentang Atlantis. Kedua dialog berikut ditulis oleh Plato pada sekitar 360 SM dan diterjemahkan ke dalam bahasa lnggris oleh Benjamin Jowett.</p>', 252, '2018-01-10', '9786025783296', 'Indonesia', 'Soft Cover', 200, '14 x 20', 70000, 15, 'BKU007.jpg', '2019-05-11 20:35:56'),
('BKU008', 'Republik', 'Cicero', 'KTG006', 'PNB003', '<p>Republik Cicero amat dikagumi oleh mereka yang hidup pada masa itu. Akan tetapi, tak lama setelah karya ini ditulis, para tiran menguasai Roma, sehingga Horace, Virgil, Seneca, Quintilian, Pliny, dan bahkan Tacitus tidak berani memujinya. Di tengah kekacauan pemerintahan dan republik, jelas sekali Cicero mengupayakan tindakan patriotik.</p>', 122, '2019-03-12', '9788476342657', 'Indonesia', 'Soft Cover', 150, '14 x 20', 58000, 15, 'BKU008.jpg', '2019-05-11 20:44:56'),
('BKU009', 'Grit: Kekuatan Passion dan Kegigihan', 'Angela Duckworth', 'KTG005', 'PNB001', '<p>Dalam Grit: Kekuatan Passion dan Kegigihan, Angela Duckworth menunjukkan bahwa rahasia untuk pencapaian yang luar biasa bukanlah bakat, tetapi perpaduan istimewa antara hasrat dan kegigihan yang ia sebut ketabahan.</p>', 440, '2018-05-07', '9786020620930', 'Indonesia', 'Soft Cover', 500, '15 x 23', 128000, 20, 'BKU009.jpg', '2019-05-11 21:03:41'),
('BKU010', 'Noura', 'Tom Hanks', 'KTG001', 'PNB004', '<p>Untuk pertama kalinya, aktor pemenang dua Piala Oscar ini berbagi kisahnya kepada dunia bukan melalui media film&mdash;sebuah kesempatan untuk menyelami pikiran dan pandangannya tentang persahabatan, keluarga, cinta, dan keseharian manusia.</p>', 500, '2019-01-16', '9786023856282', 'Indonesia', 'Soft Cover', 500, '14 x 21', 110000, 10, 'BKU010.jpg', '2019-05-11 21:13:41'),
('BKU011', 'Hello Goodbye', 'Ditta Amelia Saraswati', 'KTG001', 'PNB004', '<p>Semua isi dari buku ini memang hampir tidak pernah saya posting di internet, semuanya mengendap di folder laptop, hanya beberapa orang saja yang sempat saya beri draft pertama buku ini. Draft yang sama sekali belum saya ubah sejak 7 tahun lalu.</p>', 168, '2018-03-08', '9786023855841', 'Indonesia', 'Hard Cover', 200, '13 x 19', 119000, 11, 'BKU011.jpg', '2019-05-11 21:22:19'),
('BKU012', 'Jejak-Jejak Islam', 'Ahmad Rofi\' Usmani', 'KTG003', 'PNB007', '<p>Melalui kamus sejarah dan peradaban Islam ini, pembaca dapat mengetahui dan memahami sejarah Islam secara ringkas dan kontribusi masyarakat Muslim di pelbagai penjuru dunia dengan segala kelebihan, kekurangan, dan jasa-jasa mereka. Data-data tersebut direkam ke dalam 700 entri yang dijelaskan secara sistematis dan detail dalam kamus ini.</p>', 448, '2016-03-24', '9786027888791', 'Indonesia', 'Soft Cover', 500, '15 x 23', 99000, 9, 'BKU012.jpg', '2019-05-11 21:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_pesanan`
--

CREATE TABLE `tbl_detail_pesanan` (
  `id_pesanan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_buku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `subtotal_berat` double NOT NULL,
  `subtotal_biaya` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_detail_pesanan`
--

INSERT INTO `tbl_detail_pesanan` (`id_pesanan`, `id_buku`, `jumlah_beli`, `subtotal_berat`, `subtotal_biaya`) VALUES
('PSN001', 'BKU002', 1, 35, 67000),
('PSN003', 'BKU002', 1, 35, 67000),
('PSN006', 'BKU004', 2, 1000, 210000),
('PSN007', 'BKU003', 1, 200, 59800),
('PSN008', 'BKU011', 1, 200, 119000),
('PSN009', 'BKU011', 1, 200, 119000),
('PSN010', 'BKU010', 2, 1000, 220000),
('PSN010', 'BKU012', 1, 500, 99000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `id_invoice` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pesanan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_dibuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`id_invoice`, `id_pesanan`, `id_pengguna`, `tanggal_dibuat`) VALUES
('INV001', 'PSN001', 'PGN002', '2019-05-10 08:15:30'),
('INV002', 'PSN003', 'PGN002', '2019-05-10 13:38:38'),
('INV003', 'PSN002', 'PGN002', '2019-05-11 15:43:36'),
('INV004', 'PSN008', 'PGN001', '2019-05-11 15:56:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`) VALUES
('KTG001', 'Fiksi'),
('KTG002', 'Sejarah'),
('KTG003', 'Agama'),
('KTG005', 'Motivasi'),
('KTG006', 'Filsafat');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keranjang`
--

CREATE TABLE `tbl_keranjang` (
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_buku` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_beli` int(11) NOT NULL,
  `subtotal_biaya` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_keranjang`
--

INSERT INTO `tbl_keranjang` (`id_pengguna`, `id_buku`, `jumlah_beli`, `subtotal_biaya`) VALUES
('PGN002', 'BKU011', 2, 238000);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id_pesanan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `atas_nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_rekening` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_bukti` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` tinyint(1) NOT NULL DEFAULT '0',
  `batas_pembayaran` date NOT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `selesai` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_pesanan`, `id_pengguna`, `bank`, `atas_nama`, `no_rekening`, `foto_bukti`, `status_pembayaran`, `batas_pembayaran`, `tanggal_upload`, `selesai`) VALUES
('PSN001', 'PGN002', 'Mandiri', 'Jon Snow', '12345678910', 'PSN001.png', 1, '2019-05-11', '2019-05-10 15:14:47', 1),
('PSN003', 'PGN002', 'BCA', 'Jon Snow', '738034789212', 'PSN003.png', 1, '2019-05-11', '2019-05-10 20:37:45', 1),
('PSN006', 'PGN002', 'BRI', 'Jon Snow', '73678267364', NULL, 0, '2019-05-11', '2019-05-10 20:22:55', 0),
('PSN007', 'PGN002', 'BRI', 'Jon Snow', '2321323123123', NULL, 0, '2019-05-11', '2019-05-10 20:27:55', 0),
('PSN008', 'PGN001', 'BRI', 'Pengguna Satu', '23341123232132', 'PSN008.png', 1, '2019-05-12', '2019-05-11 22:45:19', 1),
('PSN009', 'PGN003', 'BRI', 'Arya Stark', '9829937877632', NULL, 0, '2019-05-14', '2019-05-13 08:04:09', 0),
('PSN010', 'PGN002', 'Mandiri', 'Jon Snow', '32321231312', NULL, 0, '2019-05-17', '2019-05-16 09:40:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penerbit`
--

CREATE TABLE `tbl_penerbit` (
  `id_penerbit` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerbit` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_penerbit`
--

INSERT INTO `tbl_penerbit` (`id_penerbit`, `nama_penerbit`) VALUES
('PNB001', 'Gramedia Pustaka Utama'),
('PNB002', 'Gagas Media'),
('PNB003', 'Basa Basi'),
('PNB004', 'Noura'),
('PNB005', 'Grasindo'),
('PNB006', 'BACA'),
('PNB007', 'Bentang Pustaka');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengguna`
--

CREATE TABLE `tbl_pengguna` (
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat_rumah` text COLLATE utf8mb4_unicode_ci,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `diblokir` tinyint(1) NOT NULL DEFAULT '0',
  `foto_pengguna` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_bergabung` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pengguna`
--

INSERT INTO `tbl_pengguna` (`id_pengguna`, `email`, `password`, `nama_lengkap`, `jenis_kelamin`, `alamat_rumah`, `no_telepon`, `diblokir`, `foto_pengguna`, `tanggal_bergabung`) VALUES
('PGN001', 'pengguna1@mail.com', '$2y$10$poEFcPpp8unnCTWqz/ScyuCz1nrheozvXd5tOZsChWF4fT1DzsUbO', 'Pengguna Satu', 'Wanita', 'Jl. Pengguna no 1', '089765879098', 0, 'PGN001.png', '2019-04-16 00:50:00'),
('PGN002', 'jonsnow@mail.com', '$2y$10$WKbgrdlBA4mI4PKx7wy/N.qB84iixzPm.jA.Th1iVA.9rymdYCkRy', 'Jon Snow', 'Pria', 'Winter town,  Winterfell region, Westeros continent.', '098123678123', 0, 'PGN002.jpg', '2019-04-17 20:27:59'),
('PGN003', 'aryastark@mail.com', '$2y$10$hMCjQ9ZLkdXGm.Hf5nV3u.uG27PfR9T.ayoDBOF60XeGsg9SP1hb.', 'Arya Stark', 'Wanita', 'Winter town, Winterfell region, Westeros continent.', '089765839123', 0, 'PGN003.png', '2019-05-08 21:11:40'),
('PGN004', 'pengguna2@mail.com', '$2y$10$LfitXXp6L5bMwoIaQ9kKN.rG0bHSfD9KwUoNPW7/762Cg8KWdnjyu', 'Pengguna Dua', 'Pria', 'jl pengguna', '089726937123', 1, 'PGN004.png', '2019-05-10 08:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pesanan`
--

CREATE TABLE `tbl_pesanan` (
  `id_pesanan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pengguna` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_penerima` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `layanan` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ongkos_kirim` double NOT NULL,
  `total_bayar` double NOT NULL,
  `no_resi` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pesanan` tinyint(4) NOT NULL DEFAULT '0',
  `dibatalkan` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_dikirim` datetime DEFAULT NULL,
  `tanggal_diterima` datetime DEFAULT NULL,
  `tanggal_pesanan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pesanan`
--

INSERT INTO `tbl_pesanan` (`id_pesanan`, `id_pengguna`, `nama_penerima`, `no_telepon`, `alamat_tujuan`, `keterangan`, `layanan`, `ongkos_kirim`, `total_bayar`, `no_resi`, `status_pesanan`, `dibatalkan`, `tanggal_dikirim`, `tanggal_diterima`, `tanggal_pesanan`) VALUES
('PSN001', 'PGN002', 'Jon Snow', '098123678123', 'Winter town,  Winterfell region, Westeros continent.|Kota. Tarakan, Kalimantan Utara', 'Tolong Kirim Secepatnya !', 'OKE', 66000, 67000, '3213123212', 5, 0, '2019-05-10 15:05:20', '2019-05-10 15:18:52', '2019-05-10 15:13:38'),
('PSN003', 'PGN002', 'Jon Snow', '098123678123', 'Winter town,  Winterfell region, Westeros continent.|Kab. Bantul, DI Yogyakarta', 'Bungkus rapi ya gan.', 'OKE', 5000, 67000, '434234333', 5, 0, '2019-05-10 20:05:04', '2019-05-10 20:41:59', '2019-05-10 20:15:27'),
('PSN006', 'PGN002', 'Jon Snow', '098123678123', 'Winter town,  Winterfell region, Westeros continent.|Kab. Blora, Jawa Tengah', 'Kirim hari ini gan', 'OKE', 16000, 210000, NULL, 0, 0, NULL, NULL, '2019-05-10 20:22:54'),
('PSN007', 'PGN002', 'Jon Snow', '098123678123', 'Winter town,  Winterfell region, Westeros continent.|Kab. Tabanan, Bali', 'Kirim gan !', 'OKE', 32000, 59800, NULL, 0, 0, NULL, NULL, '2019-05-10 20:27:55'),
('PSN008', 'PGN001', 'Pengguna Satu', '089765879098', 'Jl. Pengguna no 1|Kota. Surabaya, Jawa Timur', 'Packing rapi mas.', 'OKE', 13000, 119000, '3213123212', 5, 0, '2019-05-11 23:05:09', '2019-05-11 23:45:17', '2019-05-11 22:36:30'),
('PSN009', 'PGN003', 'Arya Stark', '089765839123', 'Winter town, Winterfell region, Westeros continent.|Kab. Sukoharjo, Jawa Tengah', 'Kirim hari ini ya mas', 'OKE', 12000, 119000, NULL, 0, 0, NULL, NULL, '2019-05-13 08:04:08'),
('PSN010', 'PGN002', 'Jon Snow', '098123678123', 'Winter town,  Winterfell region, Westeros continent.|Kota. Cilegon, Banten', 'Kirim sekarang', 'OKE', 28000, 319000, NULL, 1, 1, NULL, NULL, '2019-05-16 09:40:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `tbl_admin_email_unique` (`email`);

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `tbl_buku_isbn_unique` (`ISBN`),
  ADD KEY `tbl_buku_id_kategori_foreign` (`id_kategori`),
  ADD KEY `tbl_buku_id_penerbit_foreign` (`id_penerbit`);

--
-- Indexes for table `tbl_detail_pesanan`
--
ALTER TABLE `tbl_detail_pesanan`
  ADD KEY `tbl_detail_pesanan_id_pesanan_foreign` (`id_pesanan`),
  ADD KEY `tbl_detail_pesanan_id_buku_foreign` (`id_buku`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD KEY `tbl_keranjang_id_pengguna_foreign` (`id_pengguna`),
  ADD KEY `tbl_keranjang_id_buku_foreign` (`id_buku`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD KEY `tbl_pembayaran_id_pesanan_foreign` (`id_pesanan`);

--
-- Indexes for table `tbl_penerbit`
--
ALTER TABLE `tbl_penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `tbl_pengguna`
--
ALTER TABLE `tbl_pengguna`
  ADD PRIMARY KEY (`id_pengguna`),
  ADD UNIQUE KEY `tbl_pengguna_email_unique` (`email`);

--
-- Indexes for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `tbl_pesanan_id_pengguna_foreign` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD CONSTRAINT `tbl_buku_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_buku_id_penerbit_foreign` FOREIGN KEY (`id_penerbit`) REFERENCES `tbl_penerbit` (`id_penerbit`) ON UPDATE CASCADE;

--
-- Constraints for table `tbl_detail_pesanan`
--
ALTER TABLE `tbl_detail_pesanan`
  ADD CONSTRAINT `tbl_detail_pesanan_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_detail_pesanan_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `tbl_pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_keranjang`
--
ALTER TABLE `tbl_keranjang`
  ADD CONSTRAINT `tbl_keranjang_id_buku_foreign` FOREIGN KEY (`id_buku`) REFERENCES `tbl_buku` (`id_buku`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_keranjang_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD CONSTRAINT `tbl_pembayaran_id_pesanan_foreign` FOREIGN KEY (`id_pesanan`) REFERENCES `tbl_pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_pesanan`
--
ALTER TABLE `tbl_pesanan`
  ADD CONSTRAINT `tbl_pesanan_id_pengguna_foreign` FOREIGN KEY (`id_pengguna`) REFERENCES `tbl_pengguna` (`id_pengguna`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
