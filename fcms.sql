-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-11-10 15:52:12
-- 服务器版本： 10.4.14-MariaDB
-- PHP 版本： 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `fcms`
--

-- --------------------------------------------------------

--
-- 表的结构 `orderdb`
--

CREATE TABLE `orderdb` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `deliveryTime` time NOT NULL,
  `deliveryDate` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `totalAmount` decimal(7,2) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL,
  `paymentMethod` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `orderdb`
--

INSERT INTO `orderdb` (`orderID`, `userID`, `deliveryTime`, `deliveryDate`, `address`, `totalAmount`, `paymentStatus`, `paymentMethod`) VALUES
(1, 2, '13:28:00', '2020-11-12', 'This is abraham address.', '1000.00', 'pending', 'online_banking');

-- --------------------------------------------------------

--
-- 表的结构 `userdb`
--

CREATE TABLE `userdb` (
  `userID` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNo` varchar(255) NOT NULL,
  `totalPurchased` int(11) NOT NULL,
  `membershipRank` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `userdb`
--

INSERT INTO `userdb` (`userID`, `type`, `username`, `password`, `email`, `phoneNo`, `totalPurchased`, `membershipRank`) VALUES
(1, 2, 'admin', '$2y$10$VobEpmkrNUOOSCSrf9Q2KeZxoEKvvSfrrEaKMJ.1OHDS41dvtTFwK', 'admin@admin.com', '012-3456789', 0, NULL),
(2, 1, 'abraham', '$2y$10$CjEROZxreAxNwd3.bjoFeuzLJMkcNtlc5k1r1p5ARqY.R4P5UR7du', 'abraham@gmail.com', '012-3456789', 0, NULL);

--
-- 转储表的索引
--

--
-- 表的索引 `orderdb`
--
ALTER TABLE `orderdb`
  ADD PRIMARY KEY (`orderID`);

--
-- 表的索引 `userdb`
--
ALTER TABLE `userdb`
  ADD PRIMARY KEY (`userID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `orderdb`
--
ALTER TABLE `orderdb`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `userdb`
--
ALTER TABLE `userdb`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
