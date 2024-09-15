-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： localhost:3306
-- 生成日期： 2024-02-21 02:53:11
-- 服务器版本： 10.5.20-MariaDB
-- PHP 版本： 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `id21592411_degree`
--

-- --------------------------------------------------------

--
-- 表的结构 `brand`
--

CREATE TABLE `brand` (
  `brand_id` int(9) NOT NULL,
  `brand_name` varchar(200) DEFAULT NULL,
  `brand_img` varchar(200) DEFAULT NULL,
  `brand_chart` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `brand`
--

INSERT INTO `brand` (`brand_id`, `brand_name`, `brand_img`, `brand_chart`) VALUES
(800000001, 'ADLV', 'adlvdesc.jpg', 'chart.jpg'),
(800000002, 'BAPE', 'bapeedesc.png', 'bapesize.png'),
(800000003, 'Custom', 'cCustom.png', 'chart.jpg'),
(800000004, 'RickyisClown', 'rickylogooo.jpeg', 'rickyic.webp');

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(9) NOT NULL,
  `uid` int(9) DEFAULT NULL,
  `quantity` int(4) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `item` int(9) DEFAULT NULL,
  `paid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

CREATE TABLE `contact` (
  `conID` int(9) NOT NULL,
  `conName` varchar(255) DEFAULT NULL,
  `conEmail` varchar(255) DEFAULT NULL,
  `conPH` varchar(255) DEFAULT NULL,
  `conMsg` varchar(255) DEFAULT NULL,
  `reply` varchar(255) DEFAULT NULL,
  `conDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `contact`
--

INSERT INTO `contact` (`conID`, `conName`, `conEmail`, `conPH`, `conMsg`, `reply`, `conDate`) VALUES
(400000001, 'Jie', 'liyuguangjie@gmail.com', '60123456789', 'Your product is perfect', 'closed', '2023-05-04 22:03:42'),
(400000003, 'yshen6954', 'liyuguangjie@gmail.com', '60123608370', 'hehe boiboi', 'closed', '2023-06-04 22:03:42'),
(400000004, 'yfyf', 'liyuguangjie@gmail.com', '60123608370', 'qweqweqweqweqwe', 'closed', '2023-07-04 22:03:42'),
(400000005, 'test', 'liyuguangjie@gmail.com', '60123608370', 'test', 'closed', '2023-08-04 22:03:42'),
(400000006, 'Liyu Guang Jie', 'liyuguangjie@gmail.com', '60123608370', 'hehe trymail', 'closed', '2023-09-04 22:03:42'),
(400000007, 'Liyu Guang Jie', 'liyuguangjie@gmail.com', '60123608370', 'wewewewewe', 'closed', '2023-10-04 22:03:42'),
(400000008, 'cakes', 'liyuguangjie@gmail.com', '+6012312323', '  123123132123', 'closed', '2023-11-04 22:03:42'),
(400000009, 'Liyu Guang Jie', 'liyuguangjie@gmail.com', '+60123608370', 'Test msg', 'closed', '2023-11-30 22:03:42'),
(400000010, 'Liyu Guang Jie', 'liyuguangjie@gmail.com', '+601159905921', 'testest', 'pending', '2023-12-04 21:03:42'),
(400000011, 'JiaJia', 'liyuguangjie@gmail.com', '+60126511763', 'heihei test date', 'pending', '2023-12-04 22:03:42');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(9) NOT NULL,
  `recipient_name` varchar(255) DEFAULT NULL,
  `phoneNo` varchar(255) DEFAULT NULL,
  `total` varchar(255) DEFAULT NULL,
  `addresses` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `methods` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` varchar(255) DEFAULT NULL,
  `UID` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`order_id`, `recipient_name`, `phoneNo`, `total`, `addresses`, `postcode`, `methods`, `status`, `created`, `UID`) VALUES
(300000023, 'Guang Jie', '60123456789', '570', 'dad, california', '1wd1wd', 'Direct Bank Transfer', 'Completed', '2023-08-01 20:29:38', 100000037),
(300000024, 'Adelene', '60123608370', '500', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Receive', '2023-08-09 20:29:38', 100000037),
(300000025, 'Huya inc', '+123456789', '850', 'Kuala Lumpuer 123', '66661', 'Cash On Delivery', 'Completed', '2023-08-10 20:29:38', 100000037),
(300000026, 'siccai', '+60123456789', '2770', 'melaka state', '123332', 'Cash On Delivery', 'Completed', '2023-08-20 20:29:38', 100000045),
(300000027, 'jie', '0123608370', '105', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'Completed', '2023-08-26 20:29:38', 100000045),
(300000028, 'gjgjee', '0123608370', '630', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-08-27 20:29:38', 100000037),
(300000029, 'wwww', '0123608370', '105', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Direct Bank Transfer', 'To Ship', '2023-08-28 20:29:38', 100000037),
(300000030, 'jie', '60123608370', '115', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Direct Bank Transfer', 'To Ship', '2023-08-29 20:29:38', 100000037),
(300000031, 'jie', '60123608370', '125', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Direct Bank Transfer', 'To Ship', '2023-08-30 20:29:38', 100000037),
(300000032, 'jie', '60123608370', '105', '12, Lorong Seri Wangsa 7/2, Kampung Teerendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-08-31 23:29:38', 100000037),
(300000033, 'jie ', '60123123123', '600', 'Taman Bunga', '123123', 'Cash On Delivery', 'To Ship', '2023-08-31 22:29:38', 100000037),
(300000034, 'yshen666', '60123123123', '980', 'Bukit Jalil', '12344', 'Direct Bank Transfer', 'To Ship', '2023-08-31 21:29:38', 100000037),
(300000035, 'tete', '123123123', '125', '123, Melaka', '123', 'Direct Bank Transfer', 'To Ship', '2023-08-31 20:29:38', 100000037),
(300000036, '123', '123123123', '330', '123123', '123123', 'Cash On Delivery', 'To Ship', '2023-09-09 20:29:38', 100000037),
(300000037, '6666666', '66666666666', '1485', '666666666', '66661', 'Cash On Delivery', 'To Ship', '2023-09-10 20:29:38', 100000037),
(300000038, 'wewe', '123123123', '1120', 'qwe21e23r', '123123', 'Cash On Delivery', 'To Ship', '2023-09-28 20:29:38', 100000037),
(300000039, 'bearsignbaby', '123123123', '430', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-10-20 20:29:38', 100000037),
(300000040, 'error', '66666666666', '760', 'error', '6666666', 'Cash On Delivery', 'To Ship', '2023-10-27 20:29:38', 100000037),
(300000041, 'errrrr', '123123123', '1095', '123123', 'errrrr', 'Cash On Delivery', 'To Ship', '2023-10-28 20:29:38', 100000037),
(300000042, 'comp', '60123608370', '5035', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'Completed', '2023-11-18 20:29:38', 100000037),
(300000043, 'erer', '0123608370', '685', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-11-20 20:29:38', 100000037),
(300000044, 'jie', '0123608370', '1120', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-11-22 20:29:38', 100000037),
(300000045, 'jie', '0123608370', '2210', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-11-24 20:29:38', 100000037),
(300000046, 'jiege', '0123608370', '2360', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Direct Bank Transfer', 'To Ship', '2023-11-25 20:29:38', 100000037),
(300000047, ' hehe', ' +60123608370', '125', ' Thailand', ' ', 'Cash On Delivery', 'To Ship', '2023-11-27 20:29:38', 100000037),
(300000048, 'yshen', '+60123608370', '105', 'Kuala Lumpur ', '12345', 'Direct Bank Transfer', 'To Ship', '2023-11-26 20:29:38', 100000037),
(300000049, 'jie', '+60123608370', '215', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-11-27 20:29:38', 100000037),
(300000050, 'jie', '+60123608370', '520', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'Completed', '2023-11-28 20:29:38', 100000037),
(300000051, 'jie', '+60123608370', '880', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-12-01 20:29:38', 100000037),
(300000052, 'gjgj', '+60123608370', '800', 'Shah Alam Malaysia', '12345', 'Direct Bank Transfer', 'To Ship', '2023-12-02 20:29:38', 100000037),
(300000053, 'YenShen', '+60123608370', '910', 'Kuala Lumpuer', '66456', 'Direct Bank Transfer', 'To Ship', '2023-12-03 20:29:38', 100000037),
(300000054, 'jiakai', '+60123608370', '245', 'Bertam Setia Melaka', '75359', 'Direct Bank Transfer', 'To Ship', '2023-12-04 20:29:38', 100000037),
(300000055, 'hiehie', '+60123608370', '125', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-12-04 20:55:00', 100000037),
(300000056, 'jie', '+61023608370', '125', 'Shah Kepang', '75350', 'Cash On Delivery', 'To Ship', '2023-12-04 20:58:21', 100000037),
(300000057, 'ZzzzLIM', '+601128733034', '105', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-01-03 06:39:10', 100000053),
(300000058, 'ZzzzLIM', '+601128733034', '155', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-07-03 16:51:43', 100000053),
(300000059, 'ZzzzLIM', '+601128733034', '155', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-09-04 23:48:39', 100000053),
(300000060, 'ZzzzLIM', '+601128733034', '140', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Direct Bank Transfer', 'To Ship', '2023-02-19 19:04:31', 100000053),
(300000061, 'ZzzzLIM', '+601128733034', '295', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Direct Bank Transfer', 'To Ship', '2023-02-05 08:09:16', 100000053),
(300000062, 'TYS1123', '+601128733034', '140', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Direct Bank Transfer', 'To Ship', '2022-11-16 23:43:11', 100000053),
(300000063, 'TYS1123', '+601128733034', '205', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Cash On Delivery', 'To Ship', '2022-07-21 18:17:56', 100000053),
(300000064, 'TYS1123', '+601128733034', '940', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Cash On Delivery', 'Completed', '2023-06-22 03:32:26', 100000053),
(300000065, 'TYS1123', '+601128733034', '1100', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Cash On Delivery', 'To Receive', '2022-06-29 02:52:10', 100000053),
(300000066, 'TYS1123', '+601128733034', '450', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Cash On Delivery', 'To Ship', '2022-05-16 13:25:51', 100000053),
(300000067, 'Sher', '+60123456789', '3015', 'MMU Ixora', '75123', 'Cash On Delivery', 'Completed', '2022-02-19 03:48:49', 100000054),
(300000068, 'BryanHoo', '+601233232323', '300', 'MMU Cyberjaya', '12345', 'Direct Bank Transfer', 'To Ship', '2023-01-18 00:43:18', 100000054),
(300000069, 'SongXing', '+6016211827', '1752', 'Taman Melaka Baru', '12345', 'Direct Bank Transfer', 'To Receive', '2023-01-15 18:05:39', 100000054),
(300000070, 'Ex', '+601234567890', '105', '12,Jalan Ali, Taman Orang, Johor Bahru', '80120', 'Direct Bank Transfer', 'To Receive', '2022-09-17 10:12:32', 100000055),
(300000071, 'ade', '+60182929555', '140', 'Jalan GG 9, Taman GG', '76450', 'Cash On Delivery', 'To Receive', '2022-11-08 01:37:40', 100000056),
(300000072, 'Alex', '+60123456723', '915', 'UK, Aell', '32345', 'Cash On Delivery', 'To Ship', '2022-12-31 10:35:34', 100000037),
(300000073, 'Jasmine Bong', '+60123232353', '300', 'Shah Alam, Seksyen 12', '45457', 'Direct Bank Transfer', 'Completed', '2022-10-24 02:53:35', 100000037),
(300000074, 'Rexx Liyu', '+60123459712', '400', 'Melaka, Taman Asri', '65150', 'Cash On Delivery', 'To Ship', '2023-01-15 19:41:07', 100000037),
(300000075, 'Karthi A/L Murugan', '+60123434343', '930', 'Melaka, Taman Sin Chew', '75350', 'Direct Bank Transfer', 'To Ship', '2022-11-30 20:06:35', 100000037),
(300000076, 'Adelene Lim', '+60123456789', '1405', 'Paya Rumput GJH', '12345', 'Cash On Delivery', 'To Ship', '2023-09-25 05:43:38', 100000037),
(300000077, 'Johnny', '+65123123123', '990', 'SengKang, Singapore', '12345', 'Cash On Delivery', 'To Ship', '2022-07-23 06:18:30', 100000037),
(300000078, 'Jay Kew', '+60182933412', '1000', 'MMU, Cyberjaya', '65629', 'Cash On Delivery', 'To Ship', '2022-08-15 06:54:23', 100000037),
(300000079, 'ZzzzLIM', '+601128733034', '105', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-10-13 15:55:11', 100000053),
(300000080, 'TYS1123', '+601128733034', '140', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-01-12 10:01:53', 100000053),
(300000081, 'TYS1123', '+601128733034', '550', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-02-24 13:50:19', 100000053),
(300000082, 'TYS1123', '+601128733034', '155', '11 Wisma Jernih Jln Sultan Ismail', '45678', 'Cash On Delivery', 'To Ship', '2022-12-31 21:01:32', 100000053),
(300000083, 'TYS1123', '+601128733034', '155', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-02-12 06:35:21', 100000053),
(300000084, 'TYS1123', '+601128733034', '580', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-06-30 02:16:33', 100000053),
(300000085, 'ZzzzLIM', '+601128733034', '140', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2023-03-19 08:47:46', 100000053),
(300000086, 'TYS1123', '+601128733034', '500', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-05-14 22:04:15', 100000053),
(300000087, 'TYS1123', '+601128733034', '275', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-09-07 07:58:09', 100000053),
(300000088, 'TYS1123', '+601128733034', '940', '11 Wisma Jernih Jln Sultan Ismail', '12345', 'Cash On Delivery', 'To Ship', '2022-12-30 03:35:18', 100000053),
(300000089, 'adelene ee', '+60182929555', '105', 'No 26. jalana eepeiying', '76450', 'Cash On Delivery', 'To Ship', '2022-03-31 21:32:56', 100000056),
(300000090, 'adelene ee', '+60182929555', '125', 'No 26. jalana eepeiying', '76450', 'Direct Bank Transfer', 'To Ship', '2023-10-05 12:52:04', 100000056),
(300000091, 'adelene', '+60182929555', '155', 'No 26, Jalan Dahlia 9, Taman Paya Rumput Perdana', '76450', 'Cash On Delivery', 'To Ship', '2023-12-15 04:53:36', 100000056),
(300000092, 'woot woot', '+60182929555', '500', 'no 26, jalan 123', '76450', 'Direct Bank Transfer', 'To Ship', '2022-01-25 17:24:47', 100000056),
(300000093, 'weee', '+60182929555', '140', 'no 1, jalan 234', '76450', 'Direct Bank Transfer', 'To Ship', '2023-10-20 20:14:46', 100000056),
(300000094, 'rachel', '+60182929555', '550', 'no 1, jalan 345', '76450', 'Cash On Delivery', 'To Ship', '2022-07-14 09:58:22', 100000056),
(300000095, 'ricky', '+60182929555', '295', 'no 3, jalan 456', '76450', 'Cash On Delivery', 'To Ship', '2022-01-15 23:22:30', 100000056),
(300000096, 'samantha', '+60182929555', '193', 'no 4, jalan 567', '76450', 'Direct Bank Transfer', 'To Ship', '2022-10-15 13:42:12', 100000056),
(300000097, 'alex', '+60182929555', '155', 'no 5, jalan 678', '76450', 'Direct Bank Transfer', 'To Ship', '2023-11-22 18:06:16', 100000056),
(300000098, 'sensei', '+60182929555', '105', 'no 6, jalan 789', '76450', 'Cash On Delivery', 'To Receive', '2023-10-30 06:30:00', 100000056),
(300000099, 'Guang Guang', '+60123506825', '300', '123, Taman Baru', '12333', 'Cash On Delivery', 'To Ship', '2022-07-07 06:06:07', 100000037),
(300000100, 'disney', '+60182929555', '400', 'no 9, jalan 67', '76450', 'Cash On Delivery', 'To Receive', '2022-06-08 22:50:34', 100000056),
(300000101, 'guangjie', '+60123608370', '300', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2023-09-03 07:26:02', 100000037),
(300000102, 'Teng Sher', '+60187738138', '1000', 'No 1, Jalan Ros Merah, Taman Bunga Raya, 81790, Johor', '81790', 'Direct Bank Transfer', 'Completed', '2023-04-18 10:33:45', 100000054),
(300000103, 'guangjie', '+60123608370', '300', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2022-10-16 14:33:22', 100000037),
(300000104, 'tetejies', '+60123608370', '140', '12, Lorong Seri Wangsa 7/2, Kampung Tengah, 75350 Melaka, Malaysia Batu Berendam 75350 Melaka', '75350', 'Cash On Delivery', 'To Ship', '2024-01-29 15:57:31', 100000037);

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `item_id` int(9) NOT NULL,
  `item` varchar(200) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `images` varchar(200) DEFAULT NULL,
  `imgs` varchar(200) DEFAULT NULL,
  `brand_id` int(9) DEFAULT NULL,
  `userID` int(9) DEFAULT NULL,
  `active` varchar(255) DEFAULT NULL,
  `cSold` int(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`item_id`, `item`, `cost`, `images`, `imgs`, `brand_id`, `userID`, `active`, `cSold`) VALUES
(600000001, 'ADLV Teddy Bear', 110, 'adlvbear.jpg', 'adlvbearbehind.jpg', 800000001, NULL, 'no', 9),
(600000002, 'ADLV Signature', 100, 'adlv.jpg', 'adlvbehind.jpg', 800000001, NULL, NULL, 26),
(600000003, 'ADLV Baby Tiger', 120, 'tiger.jpg', 'tigerbehind.jpg', 800000001, NULL, NULL, 25),
(600000004, 'ADLV Pokémon Mew', 150, 'mew.jpg', 'mewbehind.jpg', 800000001, NULL, NULL, 12),
(600000005, 'Bape Shark Camo Tee', 500, 'bape.webp', 'bapeB.webp', 800000002, NULL, NULL, 11),
(600000008, 'No1', 100, 'screenshot (15).png', 'screenshot (17).png', 800000003, 100000001, NULL, 6),
(600000009, 'Huya', 100, 'screenshot.png', 'screenshot (1).png', 800000003, 100000037, NULL, 8),
(600000010, 'ADLV Baby Face', 135, 'donutf.jpg', 'donutr.jpg', 800000001, NULL, NULL, 22),
(600000014, 'Classic Baby Milo Shark Tee', 550, 'milosharkf.jpg', 'milosharkr.jpg', 800000002, NULL, NULL, 7),
(600000015, 'PinkAnya', 100, 'screenshot (2).png', 'screenshot (3).png', 800000003, 100000037, NULL, 1),
(600000017, 'RickyisClown Nebula Joker Smiley', 290, 'ricsmileyf.jpeg', 'ricsmiletr.jpeg', 800000004, NULL, NULL, 25),
(600000020, 'ADLV GOLD CHAIN BEAR DOLL', 188, 'goldchainf.jpg', 'goldchainr.jpg', 800000001, NULL, NULL, 12),
(600000021, 'MMU T-Shirt', 100, 'screenshot (6).png', 'screenshot (7).png', 800000003, 100000037, NULL, 7),
(600000022, 'ADLV TEDDY BEAR (BlueDOLL)', 150, 'teddybearblue.jpg', 'teddybearbluer.jpg', 800000001, NULL, NULL, 19),
(600000023, 'MMU', 100, 'screenshot (6).png', 'screenshot (7).png', 800000003, 100000037, NULL, 3),
(600000024, 'haikyuu', 100, 'screenshot (1).png', 'screenshot (1).png', 800000003, 100000056, NULL, 1),
(600000026, 'me', 100, 'screenshot (2).png', 'screenshot (1).png', 800000003, 100000056, NULL, NULL),
(600000027, 'MMU T-Shirt', 100, 'screenshot (10).png', 'screenshot (11).png', 800000003, 100000037, NULL, 3),
(600000028, 'Mmu Shirt', 100, 'screenshot (12).png', 'screenshot (13).png', 800000003, 100000037, NULL, 3);

-- --------------------------------------------------------

--
-- 表的结构 `receipt`
--

CREATE TABLE `receipt` (
  `receipt_id` int(9) NOT NULL,
  `order_id` int(9) DEFAULT NULL,
  `item_id` int(9) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `receipt`
--

INSERT INTO `receipt` (`receipt_id`, `order_id`, `item_id`, `quantity`) VALUES
(200000011, 300000023, 600000001, '3'),
(200000012, 300000023, 600000003, '2'),
(200000013, 300000024, 600000005, '1'),
(200000014, 300000025, 600000009, '3'),
(200000015, 300000025, 600000001, '5'),
(200000016, 300000026, 600000001, '4'),
(200000017, 300000026, 600000005, '4'),
(200000018, 300000026, 600000001, '3'),
(200000019, 300000027, 600000002, '1'),
(200000020, 300000028, 600000001, '3'),
(200000021, 300000028, 600000015, '3'),
(200000022, 300000029, 600000002, '1'),
(200000023, 300000030, 600000001, '1'),
(200000024, 300000031, 600000003, '1'),
(200000025, 300000032, 600000002, '1'),
(200000026, 300000033, 600000003, '5'),
(200000027, 300000034, 600000001, '1'),
(200000028, 300000034, 600000017, '3'),
(200000029, 300000035, 600000003, '1'),
(200000030, 300000036, 600000003, '1'),
(200000031, 300000036, 600000001, '1'),
(200000032, 300000037, 600000003, '3'),
(200000033, 300000037, 600000004, '3'),
(200000034, 300000038, 600000003, '2'),
(200000035, 300000038, 600000001, '3'),
(200000036, 300000039, 600000001, '1'),
(200000037, 300000039, 600000002, '2'),
(200000038, 300000040, 600000001, '2'),
(200000039, 300000040, 600000004, '2'),
(200000040, 300000041, 600000001, '1'),
(200000041, 300000041, 600000002, '3'),
(200000042, 300000041, 600000010, '1'),
(200000043, 300000041, 600000014, '1'),
(200000044, 300000042, 600000001, '1'),
(200000045, 300000042, 600000003, '5'),
(200000046, 300000043, 600000004, '1'),
(200000047, 300000043, 600000001, '1'),
(200000048, 300000043, 600000010, '1'),
(200000049, 300000043, 600000017, '1'),
(200000050, 300000044, 600000005, '1'),
(200000051, 300000044, 600000005, '1'),
(200000052, 300000044, 600000003, '1'),
(200000053, 300000045, 600000002, '1'),
(200000054, 300000045, 600000001, '1'),
(200000055, 300000045, 600000005, '4'),
(200000056, 300000046, 600000001, '1'),
(200000057, 300000046, 600000004, '4'),
(200000058, 300000046, 600000005, '2'),
(200000059, 300000046, 600000002, '1'),
(200000060, 300000046, 600000014, '1'),
(200000061, 300000047, 600000003, '1'),
(200000062, 300000048, 600000002, '1'),
(200000063, 300000049, 600000002, '1'),
(200000064, 300000049, 600000001, '1'),
(200000065, 300000050, 600000001, '2'),
(200000066, 300000050, 600000021, '3'),
(200000067, 300000051, 600000001, '6'),
(200000068, 300000051, 600000001, '2'),
(200000069, 300000052, 600000005, '1'),
(200000070, 300000052, 600000022, '2'),
(200000071, 300000053, 600000001, '1'),
(200000072, 300000053, 600000005, '1'),
(200000073, 300000053, 600000022, '2'),
(200000074, 300000054, 600000003, '2'),
(200000075, 300000055, 600000003, '1'),
(200000076, 300000056, 600000003, '1'),
(200000077, 300000057, 600000002, '1'),
(200000078, 300000058, 600000004, '1'),
(200000079, 300000059, 600000022, '1'),
(200000080, 300000060, 600000010, '1'),
(200000081, 300000061, 600000017, '1'),
(200000082, 300000062, 600000010, '1'),
(200000083, 300000063, 600000002, '2'),
(200000084, 300000064, 600000020, '5'),
(200000085, 300000065, 600000014, '2'),
(200000086, 300000066, 600000022, '3'),
(200000087, 300000067, 600000010, '5'),
(200000088, 300000067, 600000003, '2'),
(200000089, 300000067, 600000014, '3'),
(200000090, 300000067, 600000004, '3'),
(200000091, 300000068, 600000022, '2'),
(200000092, 300000069, 600000005, '2'),
(200000093, 300000069, 600000020, '4'),
(200000094, 300000070, 600000002, '1'),
(200000095, 300000071, 600000010, '1'),
(200000096, 300000072, 600000010, '5'),
(200000097, 300000072, 600000003, '2'),
(200000098, 300000073, 600000022, '2'),
(200000099, 300000074, 600000004, '2'),
(200000100, 300000074, 600000002, '1'),
(200000101, 300000075, 600000010, '2'),
(200000102, 300000075, 600000002, '3'),
(200000103, 300000075, 600000003, '3'),
(200000104, 300000076, 600000002, '1'),
(200000105, 300000076, 600000004, '2'),
(200000106, 300000076, 600000010, '3'),
(200000107, 300000076, 600000022, '4'),
(200000108, 300000077, 600000003, '3'),
(200000109, 300000077, 600000003, '4'),
(200000110, 300000077, 600000004, '1'),
(200000111, 300000078, 600000005, '2'),
(200000112, 300000079, 600000002, '1'),
(200000113, 300000080, 600000010, '1'),
(200000114, 300000081, 600000014, '1'),
(200000115, 300000082, 600000022, '1'),
(200000116, 300000083, 600000004, '1'),
(200000117, 300000084, 600000017, '2'),
(200000118, 300000085, 600000010, '1'),
(200000119, 300000086, 600000005, '1'),
(200000120, 300000087, 600000003, '1'),
(200000121, 300000087, 600000004, '1'),
(200000122, 300000088, 600000022, '1'),
(200000123, 300000088, 600000005, '1'),
(200000124, 300000088, 600000017, '1'),
(200000125, 300000089, 600000002, '1'),
(200000126, 300000090, 600000003, '1'),
(200000127, 300000091, 600000004, '1'),
(200000128, 300000092, 600000005, '1'),
(200000129, 300000093, 600000010, '1'),
(200000130, 300000094, 600000014, '1'),
(200000131, 300000095, 600000017, '1'),
(200000132, 300000096, 600000020, '1'),
(200000133, 300000097, 600000022, '1'),
(200000134, 300000098, 600000024, '1'),
(200000135, 300000099, 600000002, '1'),
(200000136, 300000099, 600000023, '2'),
(200000137, 300000100, 600000002, '4'),
(200000138, 300000101, 600000027, '3'),
(200000139, 300000102, 600000005, '2'),
(200000140, 300000103, 600000028, '3'),
(200000141, 300000104, 600000010, '1');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(9) NOT NULL,
  `pw` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mode` varchar(10) DEFAULT NULL,
  `uname` varchar(255) DEFAULT NULL,
  `codes` varchar(255) DEFAULT NULL,
  `verify` varchar(255) DEFAULT NULL,
  `registrationDate` varchar(255) DEFAULT NULL,
  `lastLogin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `pw`, `email`, `mode`, `uname`, `codes`, `verify`, `registrationDate`, `lastLogin`) VALUES
(100000001, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', '123@gmail.com', 'cust', '123', NULL, NULL, '2023-09-02', '2023-10-01 21:42:27'),
(100000037, '$2y$10$smDA2wTsmgwf.zyEh6rTYeKCa/jnsvkZXkT7FobGKiNCNJMDFMEMi', 'liyuguangjie@gmail.com', 'cust', 'Guang Jie', '652436', 'yes', '2023-10-04', '2024-01-29 15:55:17'),
(100000038, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', 'ade@gmail.com', 'cust', '1234', NULL, NULL, '2023-10-06', '2023-10-01 21:42:27'),
(100000041, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', 'ade2@gmail.com', 'cust', 'ade', NULL, NULL, '2023-10-07', '2023-10-01 21:42:27'),
(100000042, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', 'ys@gmail.com', 'cust', 'tys666', NULL, NULL, '2023-10-08', '2023-12-01 22:45:26'),
(100000043, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', 'hagan@gmail.com', 'cust', 'hagan', NULL, NULL, '2023-10-09', '2023-10-01 21:42:27'),
(100000044, '$2y$10$xwmuIkYQA5mN77JsRniauOLoTvpaWukoXW/2ik.nHOejd0E5PEyiC', 'ahjie@gmail.com', 'cust', 'jie', NULL, NULL, '2023-11-24', '2023-10-01 21:42:27'),
(100000045, '$2y$10$Tr8dmg31m43rQzG8LLLq9.W961qguYyvHJTQOhlyYvAmt.Hd1oNd.', 'adelene@gmail.com', 'cust', 'ade', NULL, 'yes', '2023-11-24', '2023-10-01 21:42:27'),
(100000046, '$2y$10$3k7wEqR1Z6RRY4vXqFKy8..JX8zIE.U2ew3nIkl8WQaSKq/G2nLLi', 'jackson@gmail.com', 'cust', 'jack', NULL, NULL, '2023-11-26', '2023-09-29 21:42:27'),
(100000047, '$2y$10$UoQQNrHpBVu2Tqof479KAuAdLxyF8pO1YhSvfLxGF7.cuRg2xf1Ne', 'admin@gmail.com', 'admin', 'Rex', NULL, 'yes', '2023-11-29', '2024-01-22 11:46:32'),
(100000052, '$2y$10$rqETfHW7o7JyQrTlPRZaWe/CSWZT2sAcZCZiCKOv3YZ7Q9DeMzrf2', 'hehe@gmail.com', 'cust', 'Masd', NULL, NULL, '2023-12-01', '2023-12-01 22:06:50'),
(100000053, '$2y$10$AhdPNKHm6VXHcyamw70mu.zDEhrUVTEL1RG9zi02N.5p3TkujQMAC', 'sxing822@gmail.com', 'cust', 'Xing2001', '572277', 'yes', '2023-12-11', '2023-12-21 21:51:37'),
(100000054, '$2y$10$XU.D7ZB4GURm7GXvSjws/.g53GEComArlNqeDZ1uxYEMBHDlaxkCS', 'sherteng871@gmail.com', 'cust', 'handsometeng', '50722', 'yes', '2023-12-11', '2024-01-22 11:53:38'),
(100000055, '$2y$10$ydKRWNM8y/ncLBEojXfZwerHtawcxOcL2WxurtrdLXHgR8.o264wu', 'shiyao1089@gmail.com', 'cust', 'rexx123', '93824', 'yes', '2023-12-15', '2023-12-15 09:52:17'),
(100000056, '$2y$10$r1HFlCUUxmXEZtiP36ptT.Q1RzXfCSVe3w.b/Ce9XJhJ967BztDYu', 'eepeiying@gmail.com', 'cust', 'adelene', '495027', 'yes', '2023-12-15', '2023-12-21 22:44:54');

-- --------------------------------------------------------

--
-- 表的结构 `userlogs`
--

CREATE TABLE `userlogs` (
  `logID` int(9) NOT NULL,
  `userid` int(9) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `times` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `userlogs`
--

INSERT INTO `userlogs` (`logID`, `userid`, `activity`, `times`) VALUES
(500000001, 100000037, 'logged in', '2023-10-01 21:42:27'),
(500000002, 100000037, 'logged in', '2023-12-21 22:15:18'),
(500000003, 100000037, 'logged in', '2023-12-21 22:41:15'),
(500000004, 100000037, 'uploaded an customize image', '2023-12-21 22:41:37'),
(500000005, 100000037, 'have place an order 300000099', '2023-12-21 22:42:12'),
(500000006, 100000037, 'logged in', '2023-12-21 22:44:39'),
(500000007, 100000056, 'logged in', '2023-12-21 22:44:54'),
(500000008, 100000056, 'have place an order 300000100', '2023-12-21 22:45:39'),
(500000009, 100000056, 'uploaded an customize image', '2023-12-21 22:46:32'),
(500000010, 100000037, 'logged in', '2023-12-22 00:32:21'),
(500000011, 100000037, 'logged in', '2023-12-27 14:17:08'),
(500000012, 100000037, 'logged in', '2024-01-21 16:36:26'),
(500000013, 100000037, 'logged in', '2024-01-21 16:40:12'),
(500000014, 100000037, 'logged in', '2024-01-21 16:41:02'),
(500000015, 100000037, 'uploaded an customize image', '2024-01-21 16:44:02'),
(500000016, 100000037, 'have place an order 300000101', '2024-01-21 16:45:53'),
(500000017, 100000054, 'logged in', '2024-01-22 11:53:38'),
(500000018, 100000054, 'have place an order 300000102', '2024-01-22 11:59:16'),
(500000019, 100000037, 'logged in', '2024-01-24 18:04:08'),
(500000020, 100000037, 'logged in', '2024-01-24 18:05:01'),
(500000021, 100000037, 'logged in', '2024-01-24 18:08:47'),
(500000022, 100000037, 'uploaded an customize image', '2024-01-24 18:10:10'),
(500000023, 100000037, 'have place an order 300000103', '2024-01-24 18:11:17'),
(500000024, 100000037, 'logged in', '2024-01-29 15:55:17'),
(500000025, 100000037, 'have place an order 300000104', '2024-01-29 15:57:31');

--
-- 转储表的索引
--

--
-- 表的索引 `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `item` (`item`);

--
-- 表的索引 `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`conID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `UID` (`UID`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `userID` (`userID`);

--
-- 表的索引 `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`receipt_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `userlogs`
--
ALTER TABLE `userlogs`
  ADD PRIMARY KEY (`logID`),
  ADD KEY `userid` (`userid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `brand`
--
ALTER TABLE `brand`
  MODIFY `brand_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=800000005;

--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=700000277;

--
-- 使用表AUTO_INCREMENT `contact`
--
ALTER TABLE `contact`
  MODIFY `conID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400000012;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300000105;

--
-- 使用表AUTO_INCREMENT `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=600000029;

--
-- 使用表AUTO_INCREMENT `receipt`
--
ALTER TABLE `receipt`
  MODIFY `receipt_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200000142;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100000057;

--
-- 使用表AUTO_INCREMENT `userlogs`
--
ALTER TABLE `userlogs`
  MODIFY `logID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500000026;

--
-- 限制导出的表
--

--
-- 限制表 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`item`) REFERENCES `product` (`item_id`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `user` (`id`);

--
-- 限制表 `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`brand_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);

--
-- 限制表 `receipt`
--
ALTER TABLE `receipt`
  ADD CONSTRAINT `receipt_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `receipt_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `product` (`item_id`);

--
-- 限制表 `userlogs`
--
ALTER TABLE `userlogs`
  ADD CONSTRAINT `userlogs_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
