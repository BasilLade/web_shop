-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 18, 2018 at 02:31 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
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
('Connector_2D6C4BB4A389A76B1C93DFBB30959E05', 'Product_EAB2FC2347281D7482D51F3C8D9A89A2', 'Tag_A45D8FE0AAEB732D009B27334EFF512F'),
('Connector_962D517E1D89139F440C3DAA199EFE8D', 'Product_EAB2FC2347281D7482D51F3C8D9A89A2', 'Tag_08BACE4E89ACC87E39B9DA773A276F31'),
('Connector_ABD51250E2F98D2F6B7476F062BAF6AC', 'Product_70B3B37EF0B862F0D8CC4A8EEA9D3C35', 'Tag_08BACE4E89ACC87E39B9DA773A276F31');

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
('Picture_EF7602FCC06144D7F061A27D85D90320', 'assets/img/img.png', 'Product_EAB2FC2347281D7482D51F3C8D9A89A2');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `price` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`) VALUES
('Product_70B3B37EF0B862F0D8CC4A8EEA9D3C35', 'Sony Fernseher', 'das ist ein Fernseh', '773'),
('Product_EAB2FC2347281D7482D51F3C8D9A89A2', 'Sony-Handy', 'das ist ein Handy', '424');

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
('Tag_08BACE4E89ACC87E39B9DA773A276F31', 'Android'),
('Tag_A45D8FE0AAEB732D009B27334EFF512F', 'Handy'),
('Tag_851B3F0E68059665785BA835FC491D66', 'TV');

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
  ADD UNIQUE KEY `picturepath_UNIQUE` (`picturepath`),
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
