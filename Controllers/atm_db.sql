-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 10, 2023 at 11:57 AM
-- Server version: 8.0.33
-- PHP Version: 7.4.3-4ubuntu2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Account`
--

CREATE TABLE `Account` (
  `ID` int NOT NULL,
  `SSN` varchar(20) NOT NULL,
  `Balance` bigint NOT NULL DEFAULT '0',
  `Type` enum('Saving','Gold','Current') NOT NULL,
  `State` enum('Running','Blocked') NOT NULL DEFAULT 'Running',
  `numberOfWithdraws` int DEFAULT NULL,
  `totalWithdraws` int DEFAULT NULL,
  `numberTransfer` int DEFAULT NULL,
  `totalTransfer` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Account`
--

INSERT INTO `Account` (`ID`, `SSN`, `Balance`, `Type`, `State`, `numberOfWithdraws`, `totalWithdraws`, `numberTransfer`, `totalTransfer`) VALUES
(112703, '303025254545', 139014, 'Gold', 'Running', 3, 62000, 2, 2200),
(1151510522, '303025254545', 6800, 'Gold', 'Running', 1, 500, 1, 2000),
(1151510535, '30201128800476', 1500, 'Current', 'Running', NULL, NULL, NULL, NULL),
(1151510536, '30306062103937', 59986, 'Gold', 'Running', 4, 85000, 7, 20015),
(1151510540, '30207040105296', 4360, 'Current', 'Running', 1, 200, NULL, NULL),
(1151510542, '30207040105296', 0, 'Saving', 'Running', NULL, NULL, NULL, NULL),
(1151510544, '30308160105397', 0, 'Current', 'Running', 1, 200, NULL, NULL),
(1151510547, '30306062103937', 0, 'Saving', 'Running', NULL, NULL, NULL, NULL),
(1151510548, '303025254545', 0, 'Saving', 'Running', NULL, NULL, NULL, NULL),
(1151510549, '12345', 0, 'Current', 'Running', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ATM`
--

CREATE TABLE `ATM` (
  `ID` int NOT NULL,
  `City` varchar(30) NOT NULL,
  `Street` varchar(30) DEFAULT NULL,
  `Area` varchar(30) DEFAULT NULL,
  `Balance` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ATM`
--

INSERT INTO `ATM` (`ID`, `City`, `Street`, `Area`, `Balance`) VALUES
(1267, 'Cairo', 'Cairo', 'El Maadi', 30545),
(1268, 'ALEX', 'Cairo', 'El Maadi', 238000),
(1270, 'Cairo', 'Cairo', 'El Maadi', 37445),
(1271, 'Cairo', 'Cairo', 'El Maadi', 37445),
(1272, 'Cairo', 'Cairo', 'El Maadi', 37395),
(1273, 'Cairo', 'Cairo', 'El Maadi', 37445),
(1274, 'Cairo', 'Cairo', 'El Maadi', 58940),
(1275, 'Cairo', 'Cairo', 'El Maadi', 58940),
(1276, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1278, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1279, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1280, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1281, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1282, 'ALEX', 'ALEX', 'El Maadi', 37545),
(1284, 'city', 'street', 'area', 0),
(1285, 'c', 'cia', 'ci', 0);

-- --------------------------------------------------------

--
-- Table structure for table `CreditCard`
--

CREATE TABLE `CreditCard` (
  `ID` bigint NOT NULL,
  `ExpDate` date NOT NULL,
  `CVV` varchar(3) NOT NULL,
  `State` enum('Running','Blocked') NOT NULL DEFAULT 'Running'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `CreditCard`
--

INSERT INTO `CreditCard` (`ID`, `ExpDate`, `CVV`, `State`) VALUES
(123, '2023-05-31', '111', 'Running'),
(1545105165, '2023-05-09', '123', 'Running'),
(1105528037413027, '2026-05-07', '182', 'Running'),
(1125181639656528, '2026-05-08', '334', 'Running'),
(1233197277453160, '2026-05-10', '370', 'Running'),
(1531146286630696, '2026-05-08', '657', 'Running'),
(1662774767276905, '2026-05-10', '651', 'Running'),
(1708804482106902, '2026-05-08', '176', 'Running'),
(2009878019639796, '2026-05-08', '358', 'Running'),
(2054830358138897, '2026-05-09', '705', 'Running'),
(2059180440946221, '2026-05-09', '385', 'Running'),
(2111548512522781, '2026-05-08', '778', 'Running'),
(2225758192734694, '2023-05-11', '168', 'Running'),
(2237673155995879, '2026-05-08', '808', 'Running'),
(2278726262393010, '2026-05-09', '785', 'Running'),
(2493650176125085, '2026-05-07', '756', 'Running'),
(2683946989743675, '2026-05-08', '409', 'Running'),
(2709130576617983, '2026-05-08', '490', 'Running'),
(3145632639129478, '2026-05-08', '428', 'Running'),
(3406300686542155, '2026-05-09', '876', 'Running'),
(3474984846080329, '2026-05-06', '780', 'Running'),
(3503019545765172, '2026-05-09', '161', 'Running'),
(3701181908986054, '2026-05-09', '811', 'Running'),
(3755128000531371, '2026-05-09', '119', 'Running'),
(3835410345965981, '2026-05-08', '390', 'Running'),
(4083226360829969, '2026-05-08', '271', 'Running'),
(4796401253875419, '2026-05-09', '250', 'Blocked'),
(5016806045571875, '2026-05-08', '643', 'Running'),
(5035837458032777, '2026-05-10', '617', 'Running'),
(5103324543056007, '2026-05-08', '435', 'Running'),
(5343274913894765, '2026-05-07', '165', 'Running'),
(5426587412032548, '2023-05-08', '146', 'Running'),
(5498893077087133, '2026-05-08', '405', 'Running'),
(5561499600647022, '2026-05-08', '513', 'Running'),
(5726687015917335, '2026-05-09', '483', 'Running'),
(5746513048061105, '2026-05-08', '794', 'Running'),
(5834052493040043, '2026-05-08', '573', 'Running'),
(5955304970375520, '2026-05-08', '923', 'Running'),
(6065552926492967, '2026-05-08', '756', 'Running'),
(6128943178103029, '2026-05-08', '454', 'Running'),
(6153764881531334, '2026-05-10', '518', 'Running'),
(6346254286082608, '2026-05-07', '928', 'Running'),
(6390451886151382, '2026-05-10', '696', 'Running'),
(6498298714772717, '2026-05-08', '321', 'Running'),
(6558480598300578, '2026-05-07', '880', 'Running'),
(6721588954956359, '2026-05-09', '876', 'Running'),
(6745479221913792, '2026-05-08', '796', 'Blocked'),
(6937814956371308, '2026-05-08', '740', 'Running'),
(7080822200339014, '2026-05-09', '349', 'Running'),
(7113361736773394, '2026-05-08', '615', 'Running'),
(7333394211677367, '2026-05-07', '892', 'Running'),
(7414493448436934, '2026-05-08', '305', 'Running'),
(7417519163098269, '2026-05-08', '623', 'Running'),
(7429231576129333, '2026-05-07', '565', 'Running'),
(7765079765765899, '2026-05-08', '793', 'Running'),
(7897553425938622, '2026-05-08', '215', 'Running'),
(8260019846036468, '2026-05-09', '980', 'Running'),
(8342354805234468, '2026-05-08', '449', 'Running'),
(8506150476854815, '2026-05-09', '911', 'Running'),
(8686477331086983, '2026-05-08', '527', 'Running'),
(8842903529528819, '2026-05-08', '587', 'Running'),
(9016233723058169, '2026-05-08', '681', 'Running'),
(9317198083768589, '2026-05-08', '499', 'Running'),
(9411043294821290, '2026-05-08', '745', 'Running');

-- --------------------------------------------------------

--
-- Table structure for table `Employee`
--

CREATE TABLE `Employee` (
  `ID` int NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(150) NOT NULL,
  `Role` enum('Admin','Technician') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Employee`
--

INSERT INTO `Employee` (`ID`, `FirstName`, `LastName`, `UserName`, `Password`, `Role`) VALUES
(450, 'Omar', 'youssef', 'omar_335', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Technician'),
(1001, 'Omar', 'youu', 'omar_400', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Technician'),
(2171, 'Amr', 'Khaled', 'Amr_123', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Admin'),
(2174, 'Omar', 'Younis', 'oyounis', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Admin'),
(2175, 'khaled', 'ashraf', 'khaled_ashraf', '8c244b370747c1930a4e0967254778ddbb69f6a409e62beebe5f92191a09a3a1', 'Admin'),
(2176, 'Omar', 'Magdy', 'Omar_Magdy', '6865ef4a7b1598734b83f38c38fea437be25ee7b2698b63dbaf89a3132304373', 'Admin'),
(2180, 'Omar', 'Magdy', 'Omar_Magdy66', '6865ef4a7b1598734b83f38c38fea437be25ee7b2698b63dbaf89a3132304373', 'Admin'),
(2182, 'Omar', 'Magdy', 'Omar_Magdy6', '6865ef4a7b1598734b83f38c38fea437be25ee7b2698b63dbaf89a3132304373', 'Admin'),
(2183, '1', '1', '1', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `Phone`
--

CREATE TABLE `Phone` (
  `SSN` varchar(50) NOT NULL,
  `PhoneNo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transaction`
--

CREATE TABLE `Transaction` (
  `ID` int NOT NULL,
  `AccountID` int NOT NULL,
  `SSN` varchar(50) NOT NULL,
  `AtmID` int NOT NULL,
  `Amount` int NOT NULL,
  `Date` date NOT NULL,
  `State` enum('Approved','Denied') DEFAULT NULL,
  `Type` enum('Withdraw','Transfer','Deposit') NOT NULL,
  `receiverId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Transaction`
--

INSERT INTO `Transaction` (`ID`, `AccountID`, `SSN`, `AtmID`, `Amount`, `Date`, `State`, `Type`, `receiverId`) VALUES
(10112, 112703, '303025254545', 1268, 500, '2023-05-09', 'Approved', 'Deposit', NULL),
(10113, 1151510522, '303025254545', 1272, 50, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10114, 112703, '303025254545', 1268, 500, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10116, 112703, '303025254545', 1268, 100, '2023-05-09', 'Approved', 'Deposit', NULL),
(10118, 1151510522, '303025254545', 1268, 100, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10119, 1151510522, '303025254545', 1268, 2000, '2023-05-09', 'Approved', 'Deposit', NULL),
(10120, 112703, '303025254545', 1268, 100, '2023-05-09', 'Approved', 'Deposit', NULL),
(10121, 112703, '303025254545', 1268, 100, '2023-05-09', 'Approved', 'Deposit', NULL),
(10122, 112703, '303025254545', 1268, 100, '2023-05-09', 'Approved', 'Deposit', NULL),
(10123, 112703, '303025254545', 1268, 2000, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10124, 112703, '303025254545', 1268, 30000, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10125, 112703, '303025254545', 1268, 30000, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10126, 112703, '303025254545', 1268, 30000, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10127, 112703, '303025254545', 1268, 30000, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10128, 112703, '303025254545', 1268, 30000, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10129, 112703, '303025254545', 1268, 2000, '2023-05-09', 'Approved', 'Deposit', NULL),
(10130, 112703, '303025254545', 1268, 20900, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10131, 112703, '303025254545', 1268, 20900, '2023-05-09', 'Denied', 'Withdraw', NULL),
(10132, 112703, '303025254545', 1268, 20900, '2023-05-09', 'Approved', 'Withdraw', NULL),
(10133, 1151510522, '303025254545', 1268, 500, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10134, 112703, '303025254545', 1268, 10000, '2023-05-10', 'Denied', 'Withdraw', NULL),
(10135, 112703, '303025254545', 1268, 30000, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10136, 112703, '303025254545', 1268, 2000, '2023-05-10', 'Approved', 'Transfer', 1151510522),
(10137, 112703, '303025254545', 1268, 2000, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10138, 112703, '303025254545', 1268, 30000, '2023-05-10', 'Approved', 'Deposit', NULL),
(10139, 112703, '303025254545', 1268, 30000, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10140, 1151510522, '303025254545', 1268, 2000, '2023-05-10', 'Approved', 'Transfer', 112703),
(10141, 1151510540, '30207040105296', 1268, 200, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10142, 1151510536, '30306062103937', 1268, 2000, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10143, 1151510536, '30306062103937', 1268, 90000, '2023-05-10', 'Approved', 'Deposit', NULL),
(10144, 1151510536, '30306062103937', 1268, 99999, '2023-05-10', 'Denied', 'Transfer', 1151510536),
(10146, 1151510536, '30306062103937', 1268, 3000, '2023-05-10', 'Approved', 'Transfer', 1151510536),
(10147, 1151510536, '30306062103937', 1268, 3000, '2023-05-10', 'Approved', 'Transfer', 1151510536),
(10148, 1151510536, '30306062103937', 1268, 3000, '2023-05-10', 'Approved', 'Transfer', 1151510536),
(10149, 1151510536, '30306062103937', 1268, 90000, '2023-05-10', 'Denied', 'Withdraw', NULL),
(10150, 1151510536, '30306062103937', 1268, 50, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10151, 1151510536, '30306062103937', 1268, 80950, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10152, 1151510536, '30306062103937', 1268, 200, '2023-05-10', 'Approved', 'Deposit', NULL),
(10153, 1151510536, '30306062103937', 1268, 5000, '2023-05-10', 'Approved', 'Deposit', NULL),
(10154, 1151510536, '30306062103937', 1268, 5000, '2023-05-10', 'Approved', 'Deposit', NULL),
(10155, 1151510544, '30308160105397', 1268, 200, '2023-05-10', 'Denied', 'Withdraw', NULL),
(10156, 1151510544, '30308160105397', 1268, 200, '2023-05-10', 'Approved', 'Deposit', NULL),
(10157, 1151510544, '30308160105397', 1268, 200, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10158, 1151510536, '30306062103937', 1268, 200, '2023-05-10', 'Approved', 'Transfer', 1151510536),
(10159, 1151510536, '30306062103937', 1268, 3000, '2023-05-10', 'Approved', 'Transfer', 112703),
(10160, 1151510536, '30306062103937', 1268, 2000, '2023-05-10', 'Approved', 'Withdraw', NULL),
(10161, 1151510536, '30306062103937', 1268, 90000, '2023-05-10', 'Approved', 'Deposit', NULL),
(10162, 1151510536, '30306062103937', 1268, 99999, '2023-05-10', 'Approved', 'Transfer', 112703),
(10163, 1151510536, '30306062103937', 1268, 8000, '2023-05-10', 'Approved', 'Transfer', 112703),
(10164, 1151510536, '30306062103937', 1268, 10000, '2023-05-10', 'Approved', 'Transfer', 112703),
(10165, 1151510536, '30306062103937', 1268, 15, '2023-05-10', 'Approved', 'Transfer', 112703);

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `SSN` varchar(20) NOT NULL,
  `CardID` bigint NOT NULL,
  `Fingerprint` varchar(150) NOT NULL,
  `PIN` varchar(150) NOT NULL,
  `FirstName` varchar(25) NOT NULL,
  `LastName` varchar(25) NOT NULL,
  `Street` varchar(30) DEFAULT NULL,
  `Area` varchar(30) DEFAULT NULL,
  `City` varchar(30) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNo` varchar(17) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`SSN`, `CardID`, `Fingerprint`, `PIN`, `FirstName`, `LastName`, `Street`, `Area`, `City`, `Email`, `PhoneNo`) VALUES
('12345', 1662774767276905, 'f9a81053bed7e1daad95ead7483b639c', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1', '1', '8', 'u', '8', 'amrkalledsaleh1@gmail.com', '123'),
('234315', 2278726262393010, 'c2b3ddf70cf5e6096ebf4201df10a898', 'aa13fda43018c393de7088225497fee24270d428a9de0d2f8d0cc899f6687e69', 'ahmed', 'ebrahim', 'asd', 'aaas', 'asdasd', 'ahmem3242ed@gmail.com', '123'),
('234567890863', 5103324543056007, '2d664a01ffa8bc12ca956e41160b42b4', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'ahmed', 'ebrahim', 'asd', 'asd', 'asdasd', 'ahmemesssd@gmail.com', '3123123123'),
('30201128800476', 7414493448436934, '36aaf86fcb681453c0e51fe23cf5b742', 'a1fb4e703a9ef1fa4936801721ff285a97ac85330856674412e054892afe6972', 'Omar', 'Hamouda', '103', 'Maadi', 'Cairo', 'omarhamouda4@gmail.com', '01023358851'),
('30207040105296', 8260019846036468, 'c5af69a99329b6e7602612e64ade5433', '7b0838c2af7e6b1f3fe5a49c32dd459d997a931cee349ca6869f3c17cc838394', 'khaled', 'ashraf', 'Yehia', 'Zawya', 'cairo', 'khaled.20210298@gmail.com', '01158099715'),
('303025254545', 2225758192734694, '861b2282684d4156308eae103b531c3b', 'c1f330d0aff31c1c87403f1e4347bcc21aff7c179908723535f2b31723702525', 'Omar', 'Younis', '32 salah salem st', 'Maadi', 'Cairo', 'oyounis19@gmail.com', ''),
('30306062103937', 3406300686542155, '502ab32eb44c7a1673873b6e2d9ad279', '77459b9b941bcb4714d0c121313c900ecf30541d158eb2b9b178cdb8eca6457e', 'Omar', 'Magdy', 'Athar Sqara', 'Mit Rahina', 'Giza', 'omarmagdy.omar000@gmail.com', '01153681635'),
('30308160105397', 6721588954956359, '3af7119f0808ddab43560ea8dba51640', '81cb2c83cfca1e0f3af853d7f3b12911f69c394ba8426dc48a6e17b485398646', 'Yousif', 'Elhelaly', 'Elsayada zeenaaaab', 'tant zeenab', 'Giza', 'Myoteam90@gmail.com', '01101255511');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Account`
--
ALTER TABLE `Account`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SSN` (`SSN`);

--
-- Indexes for table `ATM`
--
ALTER TABLE `ATM`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `CreditCard`
--
ALTER TABLE `CreditCard`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Employee`
--
ALTER TABLE `Employee`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- Indexes for table `Phone`
--
ALTER TABLE `Phone`
  ADD KEY `SSN` (`SSN`);

--
-- Indexes for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `AccountID` (`AccountID`),
  ADD KEY `SSN` (`SSN`),
  ADD KEY `AtmID` (`AtmID`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`SSN`),
  ADD UNIQUE KEY `CardID` (`CardID`),
  ADD UNIQUE KEY `Fingerprint` (`Fingerprint`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Account`
--
ALTER TABLE `Account`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1151510550;

--
-- AUTO_INCREMENT for table `ATM`
--
ALTER TABLE `ATM`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1286;

--
-- AUTO_INCREMENT for table `Employee`
--
ALTER TABLE `Employee`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2184;

--
-- AUTO_INCREMENT for table `Transaction`
--
ALTER TABLE `Transaction`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10166;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Account`
--
ALTER TABLE `Account`
  ADD CONSTRAINT `Account_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `User` (`SSN`) ON DELETE CASCADE;

--
-- Constraints for table `Phone`
--
ALTER TABLE `Phone`
  ADD CONSTRAINT `Phone_ibfk_1` FOREIGN KEY (`SSN`) REFERENCES `User` (`SSN`) ON DELETE CASCADE;

--
-- Constraints for table `Transaction`
--
ALTER TABLE `Transaction`
  ADD CONSTRAINT `Transaction_ibfk_1` FOREIGN KEY (`AccountID`) REFERENCES `Account` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Transaction_ibfk_2` FOREIGN KEY (`SSN`) REFERENCES `User` (`SSN`) ON DELETE CASCADE,
  ADD CONSTRAINT `Transaction_ibfk_3` FOREIGN KEY (`AtmID`) REFERENCES `ATM` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Transaction_ibfk_4` FOREIGN KEY (`receiverId`) REFERENCES `Account` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`CardID`) REFERENCES `CreditCard` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
