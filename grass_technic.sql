-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2022 at 07:43 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grass_technic`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_barang` varchar(30) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `status_delete` enum('0','1') NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_kategori`, `kode_barang`, `nama_barang`, `id_suplier`, `harga_beli`, `harga_jual`, `stok`, `status_delete`, `delete_at`, `created_at`) VALUES
(1, 2, 'BR-001', 'VGA Nvidia', 0, 5000000, 5500000, 0, '0', NULL, '2022-09-07 01:11:19'),
(2, 2, 'BR-002', 'Monitor LG 19\'', 0, 2000000, 2200000, 3, '0', NULL, '2022-09-07 01:12:10'),
(3, 1, 'BR-003', 'Keyoboard Laptop Asus', 0, 150000, 200000, 1, '0', NULL, '2022-09-07 01:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `jasa`
--

CREATE TABLE `jasa` (
  `id` int(11) NOT NULL,
  `kode_jasa` varchar(30) NOT NULL,
  `nama_jasa` varchar(80) NOT NULL,
  `tarif` int(11) NOT NULL,
  `status_delete` enum('0','1') NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jasa`
--

INSERT INTO `jasa` (`id`, `kode_jasa`, `nama_jasa`, `tarif`, `status_delete`, `delete_at`, `created_at`) VALUES
(2, 'JS-001', 'Instal OS', 60000, '0', NULL, '2022-09-07 00:41:11'),
(3, 'JS-002', 'Perbaikan Monitor', 100000, '0', NULL, '2022-09-07 00:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `status_delete` enum('0','1') NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`, `status_delete`, `delete_at`, `created_at`) VALUES
(1, 'Spare Part Laptop', '0', NULL, '2022-09-07 00:37:21'),
(2, 'Spare Part Komputer', '0', NULL, '2022-09-07 00:38:10'),
(3, 'Spare Part HP', '0', NULL, '2022-09-07 00:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `no_pb_auto`
--

CREATE TABLE `no_pb_auto` (
  `id` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `kode_transaksi` varchar(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `no_pb_auto`
--

INSERT INTO `no_pb_auto` (`id`, `id_pembelian`, `kode_transaksi`, `tanggal`) VALUES
(2, 2, 'PB07092201', '2022-09-07 02:34:28');

-- --------------------------------------------------------

--
-- Table structure for table `no_pj_auto`
--

CREATE TABLE `no_pj_auto` (
  `id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `kode_transaksi` varchar(10) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `no_pj_auto`
--

INSERT INTO `no_pj_auto` (`id`, `id_penjualan`, `kode_transaksi`, `tanggal`) VALUES
(3, 1, '070922001', '2022-09-07 07:06:40'),
(4, 2, '070922002', '2022-09-07 07:07:47'),
(5, 3, '080922001', '2022-09-08 01:55:35');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id` int(11) NOT NULL,
  `no_pembelian` varchar(20) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `grand_total` int(11) NOT NULL DEFAULT 0,
  `status` enum('Proses','Selesai') NOT NULL DEFAULT 'Proses',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id`, `no_pembelian`, `id_suplier`, `tanggal`, `grand_total`, `status`, `created_at`) VALUES
(2, 'PB07092201', 1, '2022-09-07', 2300000, 'Selesai', '2022-09-07 02:34:28');

--
-- Triggers `pembelian`
--
DELIMITER $$
CREATE TRIGGER `delete_detail_beli` AFTER DELETE ON `pembelian` FOR EACH ROW BEGIN
DELETE FROM pembelian_detail WHERE id_pembelian = old.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_no_pb_auto` AFTER DELETE ON `pembelian` FOR EACH ROW BEGIN
DELETE FROM no_pb_auto WHERE id_pembelian = old.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_detail`
--

CREATE TABLE `pembelian_detail` (
  `id` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(80) NOT NULL,
  `no_pembelian` varchar(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `hg_satuan` int(11) NOT NULL,
  `hg_total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembelian_detail`
--

INSERT INTO `pembelian_detail` (`id`, `id_pembelian`, `id_suplier`, `id_barang`, `kode_barang`, `nama_barang`, `no_pembelian`, `jumlah`, `hg_satuan`, `hg_total`, `created_at`) VALUES
(4, 2, 1, 2, 'BR-002', 'Monitor LG 19\'', 'PB07092201', 1, 2000000, 2000000, '2022-09-07 02:34:36'),
(5, 2, 1, 3, 'BR-003', 'Keyoboard Laptop Asus', 'PB07092201', 2, 150000, 300000, '2022-09-07 02:35:10');

--
-- Triggers `pembelian_detail`
--
DELIMITER $$
CREATE TRIGGER `add_barang_beli` AFTER INSERT ON `pembelian_detail` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + NEW.jumlah WHERE id = NEW.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_barang_beli` AFTER DELETE ON `pembelian_detail` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - OLD.jumlah WHERE id = OLD.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id` int(11) NOT NULL,
  `no_penjualan` varchar(20) NOT NULL,
  `nama_pembeli` varchar(50) NOT NULL,
  `alamat_pembeli` varchar(60) NOT NULL,
  `no_telp_pembeli` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `grand_tarif_jasa` int(11) NOT NULL,
  `grand_beli` int(11) NOT NULL DEFAULT 0,
  `grand_total_barang` int(11) NOT NULL,
  `grand_total` int(11) NOT NULL DEFAULT 0,
  `grand_laba` int(11) NOT NULL DEFAULT 0,
  `jumlah_bayar` int(11) NOT NULL,
  `jumlah_kembalian` int(11) NOT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `no_penjualan`, `nama_pembeli`, `alamat_pembeli`, `no_telp_pembeli`, `tanggal`, `grand_tarif_jasa`, `grand_beli`, `grand_total_barang`, `grand_total`, `grand_laba`, `jumlah_bayar`, `jumlah_kembalian`, `status`, `created_at`) VALUES
(1, '070922001', 'krisna', 'blitar', '0857305465', '2022-09-07', 60000, 150000, 200000, 260000, 50000, 300000, 40000, 'Selesai', '2022-09-07 07:07:21'),
(2, '070922002', 'bayuy', 'doko', '08784548458', '2022-09-07', 0, 5000000, 5500000, 5500000, 500000, 5500000, 0, 'Selesai', '2022-09-07 07:08:01'),
(3, '080922001', 'again', 'alamaat', '08573565265', '2022-09-08', 0, 150000, 200000, 200000, 50000, 200000, 0, 'Selesai', '2022-09-08 01:55:58');

--
-- Triggers `penjualan`
--
DELIMITER $$
CREATE TRIGGER `delete_detail_jual` AFTER DELETE ON `penjualan` FOR EACH ROW BEGIN
DELETE FROM penjualan_detail WHERE id_penjualan = old.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_jasa_jual` AFTER DELETE ON `penjualan` FOR EACH ROW BEGIN
DELETE FROM penjualan_jasa WHERE id_penjualan = old.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_no_pj_auto` AFTER DELETE ON `penjualan` FOR EACH ROW BEGIN
DELETE FROM no_pj_auto WHERE id_penjualan = old.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_detail`
--

CREATE TABLE `penjualan_detail` (
  `id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `no_penjualan` varchar(20) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(80) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `hg_beli` int(11) NOT NULL,
  `hg_total_beli` int(11) NOT NULL,
  `hg_satuan` int(11) NOT NULL,
  `hg_total` int(11) NOT NULL,
  `laba_total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_detail`
--

INSERT INTO `penjualan_detail` (`id`, `id_penjualan`, `no_penjualan`, `id_barang`, `kode_barang`, `nama_barang`, `jumlah`, `hg_beli`, `hg_total_beli`, `hg_satuan`, `hg_total`, `laba_total`, `created_at`) VALUES
(1, 1, '070922001', 3, 'BR-003', 'Keyoboard Laptop Asus', 1, 150000, 150000, 200000, 200000, 50000, '2022-09-07 07:07:02'),
(2, 2, '070922002', 1, 'BR-001', 'VGA Nvidia', 1, 5000000, 5000000, 5500000, 5500000, 500000, '2022-09-07 07:07:52'),
(3, 3, '080922001', 3, 'BR-003', 'Keyoboard Laptop Asus', 1, 150000, 150000, 200000, 200000, 50000, '2022-09-08 01:55:49');

--
-- Triggers `penjualan_detail`
--
DELIMITER $$
CREATE TRIGGER `add_barang_jual` AFTER INSERT ON `penjualan_detail` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok - NEW.jumlah WHERE id = NEW.id_barang;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_barang_jual` AFTER DELETE ON `penjualan_detail` FOR EACH ROW BEGIN
UPDATE barang SET stok = stok + OLD.jumlah WHERE id = OLD.id_barang;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_jasa`
--

CREATE TABLE `penjualan_jasa` (
  `id` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `no_penjualan` varchar(20) NOT NULL,
  `kode_jasa` varchar(20) NOT NULL,
  `id_jasa` int(11) NOT NULL,
  `nama_jasa` varchar(80) NOT NULL,
  `tarif` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_jasa`
--

INSERT INTO `penjualan_jasa` (`id`, `id_penjualan`, `no_penjualan`, `kode_jasa`, `id_jasa`, `nama_jasa`, `tarif`, `created_at`) VALUES
(1, 1, '070922001', 'JS-001', 2, 'Instal OS', 60000, '2022-09-07 07:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `profil_toko`
--

CREATE TABLE `profil_toko` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `keterangan` varchar(80) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `alamat` varchar(250) NOT NULL,
  `logo` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profil_toko`
--

INSERT INTO `profil_toko` (`id`, `nama`, `keterangan`, `telepon`, `alamat`, `logo`) VALUES
(1, 'Grass Technic', 'Service and Sparepart Elektronik', '08512312312', 'Brongkos, Kesamben, Blitar', '656687762128f5ed1ff54f0e099093a7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `suplier`
--

CREATE TABLE `suplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `status_delete` enum('0','1') NOT NULL,
  `delete_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suplier`
--

INSERT INTO `suplier` (`id`, `nama`, `alamat`, `no_telp`, `status_delete`, `delete_at`, `created_at`) VALUES
(1, 'Laptop Malang', 'Malang', '08576451265', '0', NULL, '2022-09-07 00:42:52'),
(2, 'Blitar Comp', 'Blitar', '081746985458', '0', NULL, '2022-09-07 00:43:13');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_user` varchar(50) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama_user`, `id_role`) VALUES
(1, 'krisna', 'krisna', 'Admin Krisna', 1),
(2, 'karyawan', '12345', 'Karyawan', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `id_user`, `id_menu`) VALUES
(1, 1, 19),
(2, 1, 1),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 8),
(7, 1, 9),
(8, 1, 14),
(9, 1, 17),
(10, 1, 16),
(11, 1, 18),
(12, 1, 26),
(13, 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `icon` varchar(20) NOT NULL,
  `sidebar` enum('yes','no') NOT NULL,
  `datamaster` enum('yes','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `judul`, `url`, `icon`, `sidebar`, `datamaster`) VALUES
(1, 'Dashboard', 'dashboard', 'home', 'yes', 'no'),
(3, 'Lihat Barang', 'lihatbarang', 'shopping-bag', 'yes', 'no'),
(4, 'Master Barang', 'masterbarang', 'package', 'no', 'yes'),
(5, 'Master Kategori Barang', 'kategori', 'folder-minus', 'no', 'yes'),
(8, 'Master Jasa', 'masterjasa', 'package', 'no', 'yes'),
(9, 'Master Suplier', 'suplier', 'users', 'no', 'yes'),
(14, 'Data Master', 'masterdata', 'folder-minus', 'yes', 'no'),
(16, 'Pembelian', 'pembelian', 'arrow-down-circle', 'yes', 'no'),
(17, 'Penjualan', 'penjualan', 'arrow-up-circle', 'yes', 'no'),
(18, 'Laporan', 'laporan', 'activity', 'yes', 'no'),
(19, 'Pengaturan', 'pengaturan', 'sliders', 'yes', 'no'),
(26, 'Laporan Penjualan', 'laporanpenjualan', '-', 'no', 'no'),
(27, 'Laporan Pembelian', 'laporanpembelian', '-', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `no_pb_auto`
--
ALTER TABLE `no_pb_auto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `no_pj_auto`
--
ALTER TABLE `no_pj_auto`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penjualan_jasa`
--
ALTER TABLE `penjualan_jasa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_toko`
--
ALTER TABLE `profil_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suplier`
--
ALTER TABLE `suplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jasa`
--
ALTER TABLE `jasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `no_pb_auto`
--
ALTER TABLE `no_pb_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `no_pj_auto`
--
ALTER TABLE `no_pj_auto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian_detail`
--
ALTER TABLE `pembelian_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan_detail`
--
ALTER TABLE `penjualan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan_jasa`
--
ALTER TABLE `penjualan_jasa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `profil_toko`
--
ALTER TABLE `profil_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suplier`
--
ALTER TABLE `suplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
