-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 09:52 AM
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
-- Database: `giaohang`
--

-- --------------------------------------------------------

--
-- Table structure for table `chitietdh`
--

CREATE TABLE `chitietdh` (
  `mactdh` int(11) NOT NULL,
  `madh` int(11) NOT NULL,
  `tenhang` varchar(100) NOT NULL,
  `soluong` int(11) NOT NULL,
  `donvitinh` varchar(10) NOT NULL,
  `dongia` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietdh`
--

INSERT INTO `chitietdh` (`mactdh`, `madh`, `tenhang`, `soluong`, `donvitinh`, `dongia`) VALUES
(1, 1, 'Bánh xe bò', 2, 'Cái', 100000),
(2, 1, 'Dùi cui', 1, 'Cái', 300000),
(3, 2, 'Quần đùi', 5, 'Cái', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `chucvu`
--

CREATE TABLE `chucvu` (
  `macv` int(11) NOT NULL,
  `tencv` varchar(50) NOT NULL,
  `mota` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chucvu`
--

INSERT INTO `chucvu` (`macv`, `tencv`, `mota`) VALUES
(1, 'Giao hàng', 'Nhân viên giao hàng thực hiện 2 công việc là nhận và giao hàng'),
(2, 'Điều phối', 'Nhân viên điều phối, phân công nhân viên đi lấy hàng, giao hàng'),
(3, 'Quản lý kho', 'Đảm nhận quản lý nhập xuất kho, kiểm tra đơn hàng tồn kho và phân công nhân viên giao hàng kịp thời');

-- --------------------------------------------------------

--
-- Table structure for table `donhang`
--

CREATE TABLE `donhang` (
  `madh` int(11) NOT NULL,
  `makh` int(11) NOT NULL,
  `ngaydat` date NOT NULL,
  `tennn` varchar(50) NOT NULL,
  `sdtnn` varchar(15) NOT NULL,
  `diachinn` text NOT NULL,
  `tinhtrangdh` varchar(20) NOT NULL,
  `trangthaigh` varchar(20) NOT NULL,
  `tongtien` decimal(10,0) NOT NULL,
  `cod` decimal(10,0) DEFAULT NULL,
  `manv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donhang`
--

INSERT INTO `donhang` (`madh`, `makh`, `ngaydat`, `tennn`, `sdtnn`, `diachinn`, `tinhtrangdh`, `trangthaigh`, `tongtien`, `cod`, `manv`) VALUES
(1, 1, '2025-04-03', 'Lê Đỗ Trung Kiên', '0334253546', '55/1/30 Nguyễn Văn Công P3 Gò Vấp TP.HCM', 'Chờ lấy', '', 500000, 525000, 1),
(2, 1, '2025-04-07', 'Kiên', '0984236476', 'Trần Bá Giao Gò Vấp', 'Nhập kho', '', 300000, 350000, 1),
(3, 1, '2025-04-19', 'Nguyễn Nhạc', '0345612312', 'Hồng Bàng', 'Chờ lấy', '', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `khachhang`
--

CREATE TABLE `khachhang` (
  `makh` int(11) NOT NULL,
  `tenkh` varchar(50) NOT NULL,
  `sdt` varchar(15) NOT NULL,
  `diachi` text NOT NULL,
  `hinhanh` varchar(20) NOT NULL,
  `matk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `khachhang`
--

INSERT INTO `khachhang` (`makh`, `tenkh`, `sdt`, `diachi`, `hinhanh`, `matk`) VALUES
(1, 'Trạng Quỳnh', '0697512123', 'Nguyễn Thái Sơn, Gò Vấp', 'avtkh1.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `loaitk`
--

CREATE TABLE `loaitk` (
  `maloaitk` int(11) NOT NULL,
  `mota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loaitk`
--

INSERT INTO `loaitk` (`maloaitk`, `mota`) VALUES
(1, 'Sử dụng cho quản lý, có thể có nhiều quản lý'),
(2, 'Sử dụng cho nhân viên, nhân viên chia ra làm nhiều chức vụ\r\n'),
(3, 'Sử dụng cho khách hàng, có nhiều khách hàng');

-- --------------------------------------------------------

--
-- Table structure for table `nhanvien`
--

CREATE TABLE `nhanvien` (
  `manv` int(11) NOT NULL,
  `tennv` varchar(100) NOT NULL,
  `sdt` varchar(15) NOT NULL,
  `hinhanh` varchar(50) NOT NULL,
  `matk` int(11) NOT NULL,
  `macv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nhanvien`
--

INSERT INTO `nhanvien` (`manv`, `tennv`, `sdt`, `hinhanh`, `matk`, `macv`) VALUES
(1, 'Lão Hạc', '0334555999', 'avt1.jpg', 2, 1),
(2, 'Chí Phèo', '0975123456', 'avt2.jpg', 4, 2),
(3, 'A Phủ', '0365114987', 'avt3.jpg', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `matk` int(11) NOT NULL,
  `tendn` varchar(20) NOT NULL,
  `matkhau` varchar(50) NOT NULL,
  `mota` text NOT NULL,
  `loaitk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`matk`, `tendn`, `matkhau`, `mota`, `loaitk`) VALUES
(1, 'admin', '123', 'Dành cho quản lý', 1),
(2, 'nhanvien1', '123', 'Dành cho nhân Nhân viên giao hàng', 2),
(3, 'user1', '123', 'Sử dụng cho khách hàng', 3),
(4, 'nhanvien2', '123', 'Nhân viên điều phối', 2),
(5, 'nhanvien3', '123', 'Quản lý kho', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chitietdh`
--
ALTER TABLE `chitietdh`
  ADD PRIMARY KEY (`mactdh`),
  ADD KEY `madh` (`madh`);

--
-- Indexes for table `chucvu`
--
ALTER TABLE `chucvu`
  ADD PRIMARY KEY (`macv`);

--
-- Indexes for table `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`madh`),
  ADD KEY `makh` (`makh`),
  ADD KEY `manv` (`manv`);

--
-- Indexes for table `khachhang`
--
ALTER TABLE `khachhang`
  ADD PRIMARY KEY (`makh`),
  ADD KEY `matk` (`matk`);

--
-- Indexes for table `loaitk`
--
ALTER TABLE `loaitk`
  ADD PRIMARY KEY (`maloaitk`);

--
-- Indexes for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`manv`),
  ADD KEY `matk` (`matk`),
  ADD KEY `macv` (`macv`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`matk`),
  ADD KEY `loaitk` (`loaitk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chitietdh`
--
ALTER TABLE `chitietdh`
  MODIFY `mactdh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chucvu`
--
ALTER TABLE `chucvu`
  MODIFY `macv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donhang`
--
ALTER TABLE `donhang`
  MODIFY `madh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `khachhang`
--
ALTER TABLE `khachhang`
  MODIFY `makh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loaitk`
--
ALTER TABLE `loaitk`
  MODIFY `maloaitk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `manv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `matk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_1` FOREIGN KEY (`matk`) REFERENCES `taikhoan` (`matk`),
  ADD CONSTRAINT `nhanvien_ibfk_2` FOREIGN KEY (`macv`) REFERENCES `chucvu` (`macv`);

--
-- Constraints for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD CONSTRAINT `taikhoan_ibfk_1` FOREIGN KEY (`loaitk`) REFERENCES `loaitk` (`maloaitk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
