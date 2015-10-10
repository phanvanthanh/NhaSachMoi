-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4913
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for nha_sach
CREATE DATABASE IF NOT EXISTS `nha_sach` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nha_sach`;


-- Dumping structure for table nha_sach.barcode
CREATE TABLE IF NOT EXISTS `barcode` (
  `id_barcode` int(11) NOT NULL AUTO_INCREMENT,
  `ten_barcode` varchar(255) NOT NULL,
  `length` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL COMMENT '1 là mặc đinh sử dụng, 0 là không mặc định sử dụng, 2 là không hiển thị lên',
  PRIMARY KEY (`id_barcode`),
  UNIQUE KEY `ten_barcode` (`ten_barcode`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.barcode: ~6 rows (approximately)
/*!40000 ALTER TABLE `barcode` DISABLE KEYS */;
INSERT INTO `barcode` (`id_barcode`, `ten_barcode`, `length`, `state`) VALUES
	(1, 'Code128', 0, 1),
	(2, 'Codabar', 1, 0),
	(3, 'Code25', NULL, 0),
	(4, 'Ean13', 12, 0),
	(5, 'Code39', NULL, 0),
	(6, '0', NULL, 0);
/*!40000 ALTER TABLE `barcode` ENABLE KEYS */;


-- Dumping structure for table nha_sach.cong_no_khach_hang
CREATE TABLE IF NOT EXISTS `cong_no_khach_hang` (
  `id_cong_no` int(11) NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int(11) NOT NULL,
  `ki` date NOT NULL,
  `no_dau_ki` bigint(20) NOT NULL,
  `no_phat_sinh` bigint(20) NOT NULL,
  `du_no` bigint(20) NOT NULL,
  PRIMARY KEY (`id_cong_no`),
  KEY `fk_cong_no_doi_tac` (`id_khach_hang`),
  CONSTRAINT `FK_cong_no_khach_hang_khach_hang` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id_khach_hang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.cong_no_khach_hang: ~0 rows (approximately)
/*!40000 ALTER TABLE `cong_no_khach_hang` DISABLE KEYS */;
/*!40000 ALTER TABLE `cong_no_khach_hang` ENABLE KEYS */;


-- Dumping structure for table nha_sach.cong_no_nha_cung_cap
CREATE TABLE IF NOT EXISTS `cong_no_nha_cung_cap` (
  `id_cong_no` int(11) NOT NULL AUTO_INCREMENT,
  `id_nha_cung_cap` int(11) NOT NULL,
  `ki` date NOT NULL,
  `no_dau_ki` bigint(20) NOT NULL,
  `no_phat_sinh` bigint(20) NOT NULL,
  `du_no` bigint(20) NOT NULL,
  PRIMARY KEY (`id_cong_no`),
  KEY `fk_cong_no_doi_tac` (`id_nha_cung_cap`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.cong_no_nha_cung_cap: ~0 rows (approximately)
/*!40000 ALTER TABLE `cong_no_nha_cung_cap` DISABLE KEYS */;
/*!40000 ALTER TABLE `cong_no_nha_cung_cap` ENABLE KEYS */;


-- Dumping structure for table nha_sach.ct_hoa_don
CREATE TABLE IF NOT EXISTS `ct_hoa_don` (
  `id_ct_hoa_don` int(11) NOT NULL AUTO_INCREMENT,
  `id_hoa_don` int(11) NOT NULL,
  `id_san_pham` int(11) NOT NULL,
  `gia` float NOT NULL,
  `so_luong` int(11) NOT NULL,
  `gia_nhap` float NOT NULL,
  PRIMARY KEY (`id_ct_hoa_don`),
  KEY `fk_cthoadon_hoadon` (`id_hoa_don`),
  KEY `fk_cthoadon_sanpham` (`id_san_pham`),
  CONSTRAINT `FK_ct_hoa_don_hoa_don` FOREIGN KEY (`id_hoa_don`) REFERENCES `hoa_don` (`id_hoa_don`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ct_hoa_don_san_pham` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id_san_pham`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.ct_hoa_don: ~0 rows (approximately)
/*!40000 ALTER TABLE `ct_hoa_don` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_hoa_don` ENABLE KEYS */;


-- Dumping structure for table nha_sach.ct_phieu_nhap
CREATE TABLE IF NOT EXISTS `ct_phieu_nhap` (
  `id_ct_phieu_nhap` int(11) NOT NULL AUTO_INCREMENT,
  `id_san_pham` int(11) NOT NULL,
  `id_phieu_nhap` int(11) NOT NULL,
  `gia_nhap` float NOT NULL,
  `so_luong` int(11) NOT NULL,
  PRIMARY KEY (`id_ct_phieu_nhap`),
  KEY `fk_ctphieunhap_sanpham` (`id_san_pham`),
  KEY `fk_ctphieunhap_phieunhap` (`id_phieu_nhap`),
  CONSTRAINT `FK_ct_phieu_nhap_phieu_nhap` FOREIGN KEY (`id_phieu_nhap`) REFERENCES `phieu_nhap` (`id_phieu_nhap`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ct_phieu_nhap_san_pham` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id_san_pham`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.ct_phieu_nhap: ~0 rows (approximately)
/*!40000 ALTER TABLE `ct_phieu_nhap` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_phieu_nhap` ENABLE KEYS */;


-- Dumping structure for table nha_sach.don_vi_tinh
CREATE TABLE IF NOT EXISTS `don_vi_tinh` (
  `id_don_vi_tinh` int(11) NOT NULL AUTO_INCREMENT,
  `id_kho` int(11) DEFAULT NULL,
  `don_vi_tinh` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_don_vi_tinh`),
  UNIQUE KEY `don_vi_tinh` (`don_vi_tinh`,`id_kho`),
  KEY `FK_don_vi_tinh_kho` (`id_kho`),
  CONSTRAINT `FK_don_vi_tinh_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.don_vi_tinh: ~0 rows (approximately)
/*!40000 ALTER TABLE `don_vi_tinh` DISABLE KEYS */;
INSERT INTO `don_vi_tinh` (`id_don_vi_tinh`, `id_kho`, `don_vi_tinh`) VALUES
	(1, 1, 'Cái');
/*!40000 ALTER TABLE `don_vi_tinh` ENABLE KEYS */;


-- Dumping structure for table nha_sach.gia_xuat
CREATE TABLE IF NOT EXISTS `gia_xuat` (
  `id_gia_xuat` int(11) NOT NULL AUTO_INCREMENT,
  `id_san_pham` int(11) NOT NULL,
  `id_kenh_phan_phoi` int(11) unsigned NOT NULL,
  `gia_xuat` float NOT NULL,
  PRIMARY KEY (`id_gia_xuat`),
  KEY `fk_giaxuat_sanpham` (`id_san_pham`),
  KEY `fk_gia_xuat_term_taxonomy` (`id_kenh_phan_phoi`),
  CONSTRAINT `FK_gia_xuat_kenh_phan_phoi` FOREIGN KEY (`id_kenh_phan_phoi`) REFERENCES `kenh_phan_phoi` (`id_kenh_phan_phoi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_gia_xuat_san_pham` FOREIGN KEY (`id_san_pham`) REFERENCES `san_pham` (`id_san_pham`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.gia_xuat: ~0 rows (approximately)
/*!40000 ALTER TABLE `gia_xuat` DISABLE KEYS */;
/*!40000 ALTER TABLE `gia_xuat` ENABLE KEYS */;


-- Dumping structure for table nha_sach.hoa_don
CREATE TABLE IF NOT EXISTS `hoa_don` (
  `id_hoa_don` int(11) NOT NULL AUTO_INCREMENT,
  `id_khach_hang` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `ma_hoa_don` char(255) NOT NULL,
  `ngay_xuat` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_hoa_don`),
  UNIQUE KEY `ma_hoa_don` (`ma_hoa_don`),
  KEY `fk_hoadon_doitac` (`id_khach_hang`),
  KEY `fk_hoadon_user` (`id_user`),
  CONSTRAINT `FK_hoa_don_khach_hang` FOREIGN KEY (`id_khach_hang`) REFERENCES `khach_hang` (`id_khach_hang`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_hoa_don_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.hoa_don: ~0 rows (approximately)
/*!40000 ALTER TABLE `hoa_don` DISABLE KEYS */;
/*!40000 ALTER TABLE `hoa_don` ENABLE KEYS */;


-- Dumping structure for table nha_sach.jos_admin_resource
CREATE TABLE IF NOT EXISTS `jos_admin_resource` (
  `resource_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Resource ID',
  `parent_id` int(11) NOT NULL COMMENT 'Resource Parent',
  `resource` varchar(255) NOT NULL COMMENT 'Resource',
  `resource_name` varchar(255) NOT NULL DEFAULT 'Resource New' COMMENT 'Resource Name',
  `resource_type` varchar(20) NOT NULL COMMENT 'Type resource',
  `resource_object` varchar(50) NOT NULL DEFAULT 'ACL' COMMENT 'White list or ACL',
  `is_white_list` int(11) DEFAULT '0',
  `is_hidden` int(11) DEFAULT '0',
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8 COMMENT='Admin Resource Table';

-- Dumping data for table nha_sach.jos_admin_resource: ~31 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_resource` DISABLE KEYS */;
INSERT INTO `jos_admin_resource` (`resource_id`, `parent_id`, `resource`, `resource_name`, `resource_type`, `resource_object`, `is_white_list`, `is_hidden`) VALUES
	(149, 0, 'Permission', 'Permission Module', 'Module', 'ACL', 0, 0),
	(150, 149, 'Permission\\Controller\\Permission', 'Permission\\Controller\\Permission Controller', 'Controller', 'ACL', 0, 0),
	(151, 150, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(152, 150, 'permissionOfUser', 'permissionOfUser Action', 'Action', 'ACL', 0, 0),
	(153, 150, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(154, 150, 'changeWhiteList', 'changeWhiteList Action', 'Action', 'ACL', 0, 0),
	(155, 150, 'update', 'update Action', 'Action', 'ACL', 0, 0),
	(156, 150, 'login', 'login Action', 'Action', 'ACL', 1, 0),
	(157, 150, 'logout', 'logout Action', 'Action', 'ACL', 1, 0),
	(158, 0, 'Application', 'Application Module', 'Module', 'ACL', 0, 0),
	(159, 158, 'Application\\Controller\\Index', 'Application\\Controller\\Index Controller', 'Controller', 'ACL', 0, 0),
	(160, 159, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(161, 158, 'Application\\Controller\\HangHoa', 'Application\\Controller\\HangHoa Controller', 'Controller', 'ACL', 0, 0),
	(162, 161, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(164, 161, 'themSanPham', 'themSanPham Action', 'Action', 'ACL', 0, 0),
	(165, 158, 'Application\\Controller\\DoiTac', 'Application\\Controller\\DoiTac Controller', 'Controller', 'ACL', 0, 0),
	(166, 165, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(167, 158, 'Application\\Controller\\ChinhSach', 'Application\\Controller\\ChinhSach Controller', 'Controller', 'ACL', 0, 0),
	(168, 167, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(169, 158, 'Application\\Controller\\ThanhToan', 'Application\\Controller\\ThanhToan Controller', 'Controller', 'ACL', 0, 0),
	(170, 169, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(171, 158, 'Application\\Controller\\BanHang', 'Application\\Controller\\BanHang Controller', 'Controller', 'ACL', 0, 0),
	(172, 171, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(173, 158, 'Application\\Controller\\ChiNhanh', 'Application\\Controller\\ChiNhanh Controller', 'Controller', 'ACL', 0, 0),
	(174, 173, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(175, 158, 'Application\\Controller\\TaiKhoan', 'Application\\Controller\\TaiKhoan Controller', 'Controller', 'ACL', 0, 0),
	(176, 175, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(177, 158, 'Application\\Controller\\ThongBao', 'Application\\Controller\\ThongBao Controller', 'Controller', 'ACL', 0, 0),
	(178, 177, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(179, 161, 'bangGia', 'bangGia Action', 'Action', 'ACL', 0, 0),
	(181, 161, 'suaSanPham', 'suaSanPham Action', 'Action', 'ACL', 0, 0),
	(182, 161, 'xoaSanPham', 'xoaSanPham Action', 'Action', 'ACL', 0, 0),
	(183, 165, 'createDataKhachHang', 'createDataKhachHang Action', 'Action', 'ACL', 0, 0);
/*!40000 ALTER TABLE `jos_admin_resource` ENABLE KEYS */;


-- Dumping structure for table nha_sach.jos_admin_role
CREATE TABLE IF NOT EXISTS `jos_admin_role` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Role ID',
  `role_name` varchar(50) DEFAULT NULL COMMENT 'Role Name Is UserType In Jos_Users',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Role table';

-- Dumping data for table nha_sach.jos_admin_role: ~2 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_role` DISABLE KEYS */;
INSERT INTO `jos_admin_role` (`role_id`, `role_name`) VALUES
	(1, 'admin'),
	(2, 'user');
/*!40000 ALTER TABLE `jos_admin_role` ENABLE KEYS */;


-- Dumping structure for table nha_sach.jos_admin_rule
CREATE TABLE IF NOT EXISTS `jos_admin_rule` (
  `rule_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rule ID',
  `role_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Role ID',
  `resource_id` int(11) unsigned NOT NULL COMMENT 'Resource ID',
  PRIMARY KEY (`rule_id`),
  KEY `IDX_JOS_RULE_RESOURCE_ID_ROLE_ID` (`resource_id`,`role_id`),
  KEY `IDX_JOS_RULE_ROLE_ID_RESOURCE_ID` (`role_id`,`resource_id`),
  CONSTRAINT `FK_jos_admin_rule_jos_admin_resource` FOREIGN KEY (`resource_id`) REFERENCES `jos_admin_resource` (`resource_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JOS_RULE_ROLE_ID_JOS_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `jos_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=536 DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

-- Dumping data for table nha_sach.jos_admin_rule: ~66 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_rule` DISABLE KEYS */;
INSERT INTO `jos_admin_rule` (`rule_id`, `role_id`, `resource_id`) VALUES
	(470, 1, 149),
	(503, 2, 149),
	(471, 1, 150),
	(504, 2, 150),
	(472, 1, 151),
	(505, 2, 151),
	(473, 1, 152),
	(506, 2, 152),
	(474, 1, 153),
	(507, 2, 153),
	(475, 1, 154),
	(508, 2, 154),
	(476, 1, 155),
	(509, 2, 155),
	(477, 1, 156),
	(510, 2, 156),
	(478, 1, 157),
	(511, 2, 157),
	(479, 1, 158),
	(512, 2, 158),
	(480, 1, 159),
	(513, 2, 159),
	(481, 1, 160),
	(514, 2, 160),
	(482, 1, 161),
	(515, 2, 161),
	(483, 1, 162),
	(516, 2, 162),
	(484, 1, 164),
	(517, 2, 164),
	(488, 1, 165),
	(521, 2, 165),
	(489, 1, 166),
	(522, 2, 166),
	(491, 1, 167),
	(524, 2, 167),
	(492, 1, 168),
	(525, 2, 168),
	(493, 1, 169),
	(526, 2, 169),
	(494, 1, 170),
	(527, 2, 170),
	(495, 1, 171),
	(528, 2, 171),
	(496, 1, 172),
	(529, 2, 172),
	(497, 1, 173),
	(530, 2, 173),
	(498, 1, 174),
	(531, 2, 174),
	(499, 1, 175),
	(532, 2, 175),
	(500, 1, 176),
	(533, 2, 176),
	(501, 1, 177),
	(534, 2, 177),
	(502, 1, 178),
	(535, 2, 178),
	(485, 1, 179),
	(518, 2, 179),
	(486, 1, 181),
	(519, 2, 181),
	(487, 1, 182),
	(520, 2, 182),
	(490, 1, 183),
	(523, 2, 183);
/*!40000 ALTER TABLE `jos_admin_rule` ENABLE KEYS */;


-- Dumping structure for table nha_sach.kenh_phan_phoi
CREATE TABLE IF NOT EXISTS `kenh_phan_phoi` (
  `id_kenh_phan_phoi` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_kho` int(11) NOT NULL,
  `kenh_phan_phoi` varchar(250) NOT NULL DEFAULT '0',
  `chiet_khau` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_kenh_phan_phoi`),
  UNIQUE KEY `id_kho_kenh_phan_phoi` (`id_kho`,`kenh_phan_phoi`),
  KEY `id_kho` (`id_kho`),
  CONSTRAINT `FK_kenh_phan_phoi_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.kenh_phan_phoi: ~10 rows (approximately)
/*!40000 ALTER TABLE `kenh_phan_phoi` DISABLE KEYS */;
INSERT INTO `kenh_phan_phoi` (`id_kenh_phan_phoi`, `id_kho`, `kenh_phan_phoi`, `chiet_khau`) VALUES
	(1, 1, 'Điểm bán', 0.00),
	(2, 1, 'Trường học', 0.00),
	(3, 1, 'Cơ quan', 0.00),
	(4, 1, 'Cửa hàng', 0.00),
	(5, 1, 'Bán lẻ', 0.00),
	(6, 2, 'Điểm bán', 0.00),
	(7, 2, 'Trường học', 0.00),
	(8, 2, 'Cơ quan', 0.00),
	(9, 2, 'Cửa hàng', 0.00),
	(10, 2, 'Bán lẻ', 0.00);
/*!40000 ALTER TABLE `kenh_phan_phoi` ENABLE KEYS */;


-- Dumping structure for table nha_sach.khach_hang
CREATE TABLE IF NOT EXISTS `khach_hang` (
  `id_khach_hang` int(11) NOT NULL AUTO_INCREMENT,
  `id_kenh_phan_phoi` int(11) unsigned NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mo_ta` longtext,
  `dien_thoai_co_dinh` int(11) DEFAULT NULL,
  `di_dong` int(11) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `ngay_dang_ky` date NOT NULL,
  `state` int(11) DEFAULT '1',
  PRIMARY KEY (`id_khach_hang`),
  KEY `ho_ten` (`ho_ten`),
  KEY `id_kenh_phan_phoi` (`id_kenh_phan_phoi`),
  CONSTRAINT `FK_khach_hang_kenh_phan_phoi` FOREIGN KEY (`id_kenh_phan_phoi`) REFERENCES `kenh_phan_phoi` (`id_kenh_phan_phoi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.khach_hang: ~2 rows (approximately)
/*!40000 ALTER TABLE `khach_hang` DISABLE KEYS */;
INSERT INTO `khach_hang` (`id_khach_hang`, `id_kenh_phan_phoi`, `ho_ten`, `dia_chi`, `email`, `mo_ta`, `dien_thoai_co_dinh`, `di_dong`, `hinh_anh`, `ngay_dang_ky`, `state`) VALUES
	(1, 1, 'Lưu Kium Loan', 'Trà cú', NULL, NULL, NULL, 987048095, NULL, '0000-00-00', NULL),
	(2, 6, 'Lưu Kium Loan', 'Trà cú', NULL, NULL, NULL, 987048095, NULL, '0000-00-00', NULL);
/*!40000 ALTER TABLE `khach_hang` ENABLE KEYS */;


-- Dumping structure for table nha_sach.kho
CREATE TABLE IF NOT EXISTS `kho` (
  `id_kho` int(11) NOT NULL AUTO_INCREMENT,
  `ten_kho` varchar(255) NOT NULL,
  `dia_chi_kho` varchar(255) NOT NULL,
  PRIMARY KEY (`id_kho`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tạo kho phải tạo luôn kênh phân phối. Mặc định có 5 kênh phân phối.';

-- Dumping data for table nha_sach.kho: ~2 rows (approximately)
/*!40000 ALTER TABLE `kho` DISABLE KEYS */;
INSERT INTO `kho` (`id_kho`, `ten_kho`, `dia_chi_kho`) VALUES
	(1, 'Nhà Sách', 'Đường Phạm Ngũ Lão, TP. Trà Vinh'),
	(2, 'Nhà Sách 2', 'Đường Kho Dầu, TP. Trà Vinh');
/*!40000 ALTER TABLE `kho` ENABLE KEYS */;


-- Dumping structure for table nha_sach.loai_san_pham
CREATE TABLE IF NOT EXISTS `loai_san_pham` (
  `id_loai_san_pham` int(11) NOT NULL AUTO_INCREMENT,
  `id_kho` int(11) DEFAULT NULL,
  `loai_san_pham` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_loai_san_pham`),
  UNIQUE KEY `id_kho_loai_san_pham` (`id_kho`,`loai_san_pham`),
  CONSTRAINT `FK_loai_san_pham_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.loai_san_pham: ~0 rows (approximately)
/*!40000 ALTER TABLE `loai_san_pham` DISABLE KEYS */;
INSERT INTO `loai_san_pham` (`id_loai_san_pham`, `id_kho`, `loai_san_pham`) VALUES
	(1, 1, 'Dụng cụ học sinh');
/*!40000 ALTER TABLE `loai_san_pham` ENABLE KEYS */;


-- Dumping structure for table nha_sach.nha_cung_cap
CREATE TABLE IF NOT EXISTS `nha_cung_cap` (
  `id_nha_cung_cap` int(11) NOT NULL AUTO_INCREMENT,
  `id_kho` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dia_chi` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mo_ta` longtext,
  `dien_thoai_co_dinh` int(11) DEFAULT NULL,
  `di_dong` int(11) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `ngay_dang_ky` date NOT NULL,
  `state` int(11) DEFAULT '1',
  PRIMARY KEY (`id_nha_cung_cap`),
  KEY `ho_ten` (`ho_ten`),
  KEY `FK_nha_cung_cap_kho` (`id_kho`),
  CONSTRAINT `FK_nha_cung_cap_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.nha_cung_cap: ~0 rows (approximately)
/*!40000 ALTER TABLE `nha_cung_cap` DISABLE KEYS */;
/*!40000 ALTER TABLE `nha_cung_cap` ENABLE KEYS */;


-- Dumping structure for table nha_sach.phieu_chi
CREATE TABLE IF NOT EXISTS `phieu_chi` (
  `id_phieu_chi` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_cong_no` int(11) NOT NULL,
  `ma_phieu_chi` char(20) DEFAULT NULL,
  `ly_do` longtext,
  `so_tien` bigint(20) NOT NULL,
  `ngay_thanh_toan` date NOT NULL,
  PRIMARY KEY (`id_phieu_chi`),
  KEY `fk_phieuchi_user` (`id_user`),
  KEY `fk_phieuchi_congno` (`id_cong_no`),
  CONSTRAINT `FK_phieu_chi_cong_no_nha_cung_cap` FOREIGN KEY (`id_cong_no`) REFERENCES `cong_no_nha_cung_cap` (`id_cong_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_phieu_chi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.phieu_chi: ~0 rows (approximately)
/*!40000 ALTER TABLE `phieu_chi` DISABLE KEYS */;
/*!40000 ALTER TABLE `phieu_chi` ENABLE KEYS */;


-- Dumping structure for table nha_sach.phieu_nhap
CREATE TABLE IF NOT EXISTS `phieu_nhap` (
  `id_phieu_nhap` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_nha_cung_cap` int(11) NOT NULL,
  `ma_phieu_nhap` char(255) NOT NULL,
  `ngay_nhap` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_phieu_nhap`),
  KEY `fk_phieunhap_user` (`id_user`),
  KEY `fk_phieunhap_doitac` (`id_nha_cung_cap`),
  CONSTRAINT `FK_phieu_nhap_nha_cung_cap` FOREIGN KEY (`id_nha_cung_cap`) REFERENCES `nha_cung_cap` (`id_nha_cung_cap`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_phieu_nhap_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.phieu_nhap: ~0 rows (approximately)
/*!40000 ALTER TABLE `phieu_nhap` DISABLE KEYS */;
/*!40000 ALTER TABLE `phieu_nhap` ENABLE KEYS */;


-- Dumping structure for table nha_sach.phieu_thu
CREATE TABLE IF NOT EXISTS `phieu_thu` (
  `id_phieu_thu` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_cong_no` int(11) NOT NULL,
  `ma_phieu_thu` char(20) DEFAULT NULL,
  `ly_do` longtext,
  `so_tien` bigint(20) NOT NULL,
  `ngay_thanh_toan` date NOT NULL,
  PRIMARY KEY (`id_phieu_thu`),
  KEY `fk_phieuthu_user` (`id_user`),
  KEY `fk_phieuthu_congno` (`id_cong_no`),
  CONSTRAINT `FK_phieu_thu_cong_no_khach_hang` FOREIGN KEY (`id_cong_no`) REFERENCES `cong_no_khach_hang` (`id_cong_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_phieu_thu_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.phieu_thu: ~0 rows (approximately)
/*!40000 ALTER TABLE `phieu_thu` DISABLE KEYS */;
/*!40000 ALTER TABLE `phieu_thu` ENABLE KEYS */;


-- Dumping structure for table nha_sach.san_pham
CREATE TABLE IF NOT EXISTS `san_pham` (
  `id_san_pham` int(11) NOT NULL AUTO_INCREMENT,
  `id_kho` int(11) NOT NULL,
  `id_don_vi_tinh` int(11) DEFAULT NULL,
  `id_barcode` int(11) NOT NULL,
  `id_loai_san_pham` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1' COMMENT 'Id user cập nhật lần cuối cùng',
  `ma_san_pham` char(255) NOT NULL,
  `ma_vach` varchar(255) NOT NULL,
  `ten_san_pham` varchar(255) NOT NULL,
  `mo_ta` longtext,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `nhan` varchar(255) DEFAULT NULL,
  `ton_kho` float NOT NULL,
  `loai_gia` int(11) DEFAULT '0',
  `gia_nhap` float DEFAULT '0',
  `gia_bia` float DEFAULT '0',
  `chiet_khau` decimal(10,2) DEFAULT '0.00',
  `state` int(11) NOT NULL DEFAULT '1' COMMENT 'Sản phẩm có bị xóa chưa, nếu xóa thì bằng 0, đang sử dụng thì bằng 1',
  PRIMARY KEY (`id_san_pham`),
  KEY `fk_sanpham_termtaxonomy` (`id_don_vi_tinh`),
  KEY `fk_sanpham_zftermtaxonomy` (`id_loai_san_pham`),
  KEY `kho` (`id_kho`),
  KEY `ma_san_pham` (`ma_san_pham`),
  KEY `id_barcode` (`id_barcode`),
  KEY `ma_vach` (`ma_vach`),
  KEY `FK_san_pham_user` (`user_id`),
  CONSTRAINT `FK_san_pham_barcode` FOREIGN KEY (`id_barcode`) REFERENCES `barcode` (`id_barcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_san_pham_don_vi_tinh` FOREIGN KEY (`id_don_vi_tinh`) REFERENCES `don_vi_tinh` (`id_don_vi_tinh`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_san_pham_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_san_pham_loai_san_pham` FOREIGN KEY (`id_loai_san_pham`) REFERENCES `loai_san_pham` (`id_loai_san_pham`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_san_pham_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6766 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.san_pham: ~3 rows (approximately)
/*!40000 ALTER TABLE `san_pham` DISABLE KEYS */;
INSERT INTO `san_pham` (`id_san_pham`, `id_kho`, `id_don_vi_tinh`, `id_barcode`, `id_loai_san_pham`, `user_id`, `ma_san_pham`, `ma_vach`, `ten_san_pham`, `mo_ta`, `hinh_anh`, `nhan`, `ton_kho`, `loai_gia`, `gia_nhap`, `gia_bia`, `chiet_khau`, `state`) VALUES
	(6763, 1, 1, 1, 1, 2, '254602174117996', '254602174117996', 'sản phẩm 1', '', '/img/orther/product/1/a3ec8860430e6add9c9a51f468c354c3_girl.jpg', 'Dụng cụ học sinh', 0, 0, 0, 0, 0.00, 1),
	(6764, 1, 1, 1, 1, 2, '149184668472868', '149184668472868', 'sản phẩm 2', '', '/img/orther/product/1/40cfcc51942bea80e872c17f8ff75561_girl.jpg', 'Dụng cụ học sinh', 0, 0, 0, 0, 0.00, 1),
	(6765, 1, 1, 1, 1, 2, '665262746941555', '665262746941555', 'sản phẩm 3', '', '/img/default/product/default.png', 'Dụng cụ học sinh', 0, 0, 0, 0, 0.00, 0);
/*!40000 ALTER TABLE `san_pham` ENABLE KEYS */;


-- Dumping structure for table nha_sach.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL,
  `id_kho` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `display_name` varchar(50) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `state` smallint(6) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `mo_ta` varchar(255) DEFAULT NULL,
  `dien_thoai_co_dinh` varchar(12) DEFAULT NULL,
  `di_dong` varchar(12) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `kho` (`id_kho`),
  KEY `FK_user_jos_admin_role` (`role_id`),
  CONSTRAINT `FK_user_jos_admin_role` FOREIGN KEY (`role_id`) REFERENCES `jos_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_kho` FOREIGN KEY (`id_kho`) REFERENCES `kho` (`id_kho`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table nha_sach.user: ~0 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `role_id`, `id_kho`, `username`, `email`, `display_name`, `password`, `state`, `ho_ten`, `dia_chi`, `mo_ta`, `dien_thoai_co_dinh`, `di_dong`, `twitter`) VALUES
	(1, 1, 1, 'admin', 'admin@gmail.com', NULL, 'd6b0ab7f1c8ab8f514db9a6d85de160a', 0, '', NULL, NULL, NULL, NULL, NULL),
	(2, 1, 1, 'user', 'user@gmail.com', NULL, 'd6b0ab7f1c8ab8f514db9a6d85de160a', 0, '', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
