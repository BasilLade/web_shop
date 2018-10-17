-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2018 at 04:35 PM
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
-- Table structure for table `bestellung`
--

CREATE TABLE `bestellung` (
  `id` varchar(255) NOT NULL,
  `bestelldatum` datetime NOT NULL,
  `fk_kunde` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bild`
--

CREATE TABLE `bild` (
  `id` varchar(255) NOT NULL,
  `bildpfad` varchar(100) NOT NULL,
  `fk_produkt` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bild`
--

INSERT INTO `bild` (`id`, `bildpfad`, `fk_produkt`) VALUES
('Bild_2DC6CC071B302BCE2B5000CEC2F64184', 'img/img.png', 'Produkt_F362F2547981716C24F9EE6EF7BB11DA'),
('Bild_7FDDA984F27D26964DC79B4CC78AF5B1', 'img/img.png', 'Produkt_1E04EB990B8E62AF18AF9F4BED0D161B');

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
('Connector_6D4E8E62D704A3EC12232FE636614780', 'Produkt_1E04EB990B8E62AF18AF9F4BED0D161B', 'Tag_A59244B9E3C4A0DF4EAD15192DF6E402'),
('Connector_A3ACBEE3727E9EDCAE0F5AD2FBEDA3DB', 'Produkt_F362F2547981716C24F9EE6EF7BB11DA', 'Tag_A59244B9E3C4A0DF4EAD15192DF6E402'),
('Connector_F018C940DD1C42D5A8A577991231DE4A', 'Produkt_2AC1A1388CF180A6C9136FA45D7C7B18', 'Tag_E7C1F0474B508071146AAD8A24A0BC5C'),
('Connector_F2BEE1ADD47AAC0B7E0F21135D992BBA', 'Produkt_992B1D62805D9BC2FCC1B66EC400EDB2', 'Tag_E7C1F0474B508071146AAD8A24A0BC5C');

-- --------------------------------------------------------

--
-- Table structure for table `kunde`
--

CREATE TABLE `kunde` (
  `id` varchar(255) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `alter` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `produkt`
--

CREATE TABLE `produkt` (
  `id` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `beschreibung` varchar(250) DEFAULT NULL,
  `preis` decimal(10,0) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produkt`
--

INSERT INTO `produkt` (`id`, `name`, `beschreibung`, `preis`) VALUES
('Produkt_1E04EB990B8E62AF18AF9F4BED0D161B', 'Sony-Handy', 'das ist ein Handy', '423'),
('Produkt_2AC1A1388CF180A6C9136FA45D7C7B18', 'Sony Fernseher', 'das ist ein fernseher', '423'),
('Produkt_992B1D62805D9BC2FCC1B66EC400EDB2', 'Sony Fernseher', 'das ist ein fernseher', '423'),
('Produkt_F362F2547981716C24F9EE6EF7BB11DA', 'Sony-Handy', 'das ist ein Handy', '423');

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
('Tag_E7C1F0474B508071146AAD8A24A0BC5C', 'Fernseh'),
('Tag_A59244B9E3C4A0DF4EAD15192DF6E402', 'Handy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bestellung`
--
ALTER TABLE `bestellung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bestellungen_kunde1_idx` (`fk_kunde`);

--
-- Indexes for table `bild`
--
ALTER TABLE `bild`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bilder_produkt1_idx` (`fk_produkt`);

--
-- Indexes for table `connector`
--
ALTER TABLE `connector`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `produkt`
--
ALTER TABLE `produkt`
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
-- Constraints for table `bestellung`
--
ALTER TABLE `bestellung`
  ADD CONSTRAINT `fk_bestellungen_kunde1` FOREIGN KEY (`fk_kunde`) REFERENCES `kunde` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `bild`
--
ALTER TABLE `bild`
  ADD CONSTRAINT `fk_bilder_produkt1` FOREIGN KEY (`fk_produkt`) REFERENCES `produkt` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
