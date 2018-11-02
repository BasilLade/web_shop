-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2018 at 10:41 AM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.11-2+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webshop`
--
DROP DATABASE IF EXISTS `webshop`;
CREATE DATABASE `webshop`;
USE `webshop`;

-- --------------------------------------------------------

--
-- Table structure for table `connector`
--

CREATE TABLE `connector` (
  `id` varchar(255) NOT NULL,
  `left_entity` varchar(255) NOT NULL,
  `right_entity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `connector`
--

INSERT INTO `connector` (`id`, `left_entity`, `right_entity`) VALUES
('Connector_3C4804AD752621156B7DED2EC044B7FA', 'Product_0D0C1F8F976F08B28D7E0DD24272AE7E', 'Tag_CDD4906DDD922643D3BA39787D388563'),
('Connector_57B5CCCA8A77C99CBAC913A97A5A5ACB', 'Product_0D0C1F8F976F08B28D7E0DD24272AE7E', 'Tag_AE7BC1CEB8DD12A23A5651416A81210B'),
('Connector_7B693E2970616F30B0115D5B11677FD9', 'Product_96B17DC61A808E98ECB7677E930BC812', 'Tag_CDD4906DDD922643D3BA39787D388563'),
('Connector_AEE776A99E26875B515758159B8D6696', 'Product_96B17DC61A808E98ECB7677E930BC812', 'Tag_66176B8BDD592276A3D88E863B731B1E');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `age` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` varchar(255) NOT NULL,
  `orderdate` datetime NOT NULL,
  `fk_customer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `picture`
--

CREATE TABLE `picture` (
  `id` varchar(255) NOT NULL,
  `picturepath` varchar(100) NOT NULL,
  `fk_product` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picture`
--

INSERT INTO `picture` (`id`, `picturepath`, `fk_product`) VALUES
('Picture_6997F7ACFA31D04411F35FC7B9C9FEBA', 'assets/img/img.png', 'Product_96B17DC61A808E98ECB7677E930BC812'),
('Picture_B26A252E26EB3D240364845137CAD027', 'assets/img/img.png', 'Product_96B17DC61A808E98ECB7677E930BC812'),
('Picture_B641EA6E555F42D84E4446AFE24E5149', 'assets/img/img.png', 'Product_0D0C1F8F976F08B28D7E0DD24272AE7E');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`) VALUES
('Product_0D0C1F8F976F08B28D7E0DD24272AE7E', 'Sony-Handy', 'das ist ein Handy', '424.95'),
('Product_96B17DC61A808E98ECB7677E930BC812', 'Sony Fernseher', 'das ist ein Fernseh', '773');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
('Tag_CDD4906DDD922643D3BA39787D388563', 'Android'),
('Tag_AE7BC1CEB8DD12A23A5651416A81210B', 'Handy'),
('Tag_66176B8BDD592276A3D88E863B731B1E', 'TV');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `connector`
--
ALTER TABLE `connector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bestellungen_kunde1_idx` (`fk_customer`);

--
-- Indexes for table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bilder_produkt1_idx` (`fk_product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_bestellungen_kunde1` FOREIGN KEY (`fk_customer`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `fk_bilder_produkt1` FOREIGN KEY (`fk_product`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
