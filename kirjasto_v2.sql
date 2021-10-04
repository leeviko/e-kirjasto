-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 28, 2021 at 12:10 PM
-- Server version: 10.5.10-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kirjasto_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `kayttajat`
--

CREATE TABLE `kayttajat` (
  `userID` varchar(13) NOT NULL,
  `username` varchar(60) NOT NULL,
  `userPwd` varchar(255) NOT NULL,
  `admin` bit(1) DEFAULT b'0',
  `email` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kayttajat`
--

INSERT INTO `kayttajat` (`userID`, `username`, `userPwd`, `admin`, `email`) VALUES
('60c9b863a3d87', 'admin', '$argon2id$v=19$m=65536,t=4,p=1$Vnpsa0JDRHFSay9ULnNhVA$iTdliR9DttpX0PaZqoznxAbRoCLqB1yUGnWpptGuwuA', b'1', 'admin@gmail.com'),
('60d9b9edcebe9', 'LEEVI', '$argon2id$v=19$m=65536,t=4,p=1$TDZ6WlF5SUgwTzNnT1pVeA$0cyCuP8T3trs668ouvOpzMrkDwTMrOlnmK2ku9/YJrw', b'0', 'dsalfjlas@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `kirjailijat`
--

CREATE TABLE `kirjailijat` (
  `kirjailijaID` varchar(13) NOT NULL,
  `etunimi` varchar(255) NOT NULL,
  `sukunimi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kirjailijat`
--

INSERT INTO `kirjailijat` (`kirjailijaID`, `etunimi`, `sukunimi`) VALUES
('60b5e3e0cc1a9', 'Suzanne', 'Collins'),
('60b5e42419b77', 'George', 'Martin'),
('60b5e4407ddf8', 'Stephen', 'King'),
('60b5f392be53c', 'joku', 'kirjailija'),
('60b71be5a7b56', 'Marrku', 'lol'),
('60b742b4b350e', 'testi', 'testi'),
('60b7466b35145', 'joku', 'sadf'),
('60c85e36806d4', 'Joanne', 'Rowling'),
('60c85e6a430ea', 'Frank', 'Herbert'),
('60c85f4c92f7a', 'Väinö', 'Linna');

-- --------------------------------------------------------

--
-- Table structure for table `kirjat`
--

CREATE TABLE `kirjat` (
  `kirjaID` varchar(13) NOT NULL,
  `nimi` varchar(255) NOT NULL,
  `julkaisuVuosi` int(4) NOT NULL,
  `sivuMaara` int(8) DEFAULT NULL,
  `fk_kirjailijaID` varchar(13) DEFAULT NULL,
  `lukuMaara` int(4) DEFAULT NULL,
  `genret` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kirjat`
--

INSERT INTO `kirjat` (`kirjaID`, `nimi`, `julkaisuVuosi`, `sivuMaara`, `fk_kirjailijaID`, `lukuMaara`, `genret`) VALUES
('60c85e3d3444a', 'Harry Potter ja viisasten kivi', 1997, 223, '60c85e36806d4', 10, 'Fantasia, Fiktio'),
('60c85e913f283', 'Dyyni', 1965, 500, '60c85e6a430ea', 5, 'SciFi, Fiktio'),
('60c85ffc3a2ff', 'Tuntematon Sotilas', 1954, 477, '60c85f4c92f7a', 4, 'Sotakirjallisuus'),
('60c8611ef371a', 'Hohto', 1977, 447, '60b5e4407ddf8', 1, 'Kauhu, Fiktio');

-- --------------------------------------------------------

--
-- Table structure for table `lainatut`
--

CREATE TABLE `lainatut` (
  `lainausID` varchar(13) NOT NULL,
  `eraPaiva` date DEFAULT NULL,
  `fk_kirjaID` varchar(13) NOT NULL,
  `fk_userID` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lainatut`
--

INSERT INTO `lainatut` (`lainausID`, `eraPaiva`, `fk_kirjaID`, `fk_userID`) VALUES
('60d9bc01da021', '2021-07-28', '60c85ffc3a2ff', '60d9b9edcebe9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `kirjailijat`
--
ALTER TABLE `kirjailijat`
  ADD PRIMARY KEY (`kirjailijaID`);

--
-- Indexes for table `kirjat`
--
ALTER TABLE `kirjat`
  ADD PRIMARY KEY (`kirjaID`),
  ADD KEY `fk_kirjailijaID` (`fk_kirjailijaID`);

--
-- Indexes for table `lainatut`
--
ALTER TABLE `lainatut`
  ADD PRIMARY KEY (`lainausID`),
  ADD KEY `fk_kirjaID` (`fk_kirjaID`),
  ADD KEY `fk_userID` (`fk_userID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kirjat`
--
ALTER TABLE `kirjat`
  ADD CONSTRAINT `kirjat_ibfk_1` FOREIGN KEY (`fk_kirjailijaID`) REFERENCES `kirjailijat` (`kirjailijaID`);

--
-- Constraints for table `lainatut`
--
ALTER TABLE `lainatut`
  ADD CONSTRAINT `lainatut_ibfk_1` FOREIGN KEY (`fk_kirjaID`) REFERENCES `kirjat` (`kirjaID`),
  ADD CONSTRAINT `lainatut_ibfk_2` FOREIGN KEY (`fk_userID`) REFERENCES `kayttajat` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
