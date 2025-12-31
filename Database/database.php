-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2024 at 12:53 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yati foundation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `userId` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `usertype` varchar(6) NOT NULL,
  `isDel` int(11) NOT NULL,
  `datetime` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `userId`, `password`, `usertype`, `isDel`, `datetime`) VALUES
(1, 'admin@gmail.com', 'admin@123', 'admin', 1, '2024-02-19');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cId` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `addedOn` date NOT NULL,
  `isDel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cId`, `name`, `email`, `subject`, `message`, `addedOn`, `isDel`) VALUES
(1, 'John Devil', 'john@gmail.com', 'When establishing a foundation, the choice of subject or focus area is crucial to defining the organization mission and impact.', 'Hello World', '2024-02-20', b'0'),
(2, 'Devil ', 'devil@gmail.com', 'Charity', 'Nice ', '2024-02-24', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `donate`
--

CREATE TABLE `donate` (
  `dId` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(250) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `purposeofDonation` text NOT NULL,
  `address` text NOT NULL,
  `addedOn` date NOT NULL,
  `isDel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donate`
--

INSERT INTO `donate` (`dId`, `name`, `mobile`, `email`, `amount`, `purposeofDonation`, `address`, `addedOn`, `isDel`) VALUES
(1, 'John ', '7575757575', 'john@gmail.com', 500.00, 'The purpose of a donation is to contribute financial or material resources voluntarily to support a cause, organization, or individual in need. Donations play a crucial role in helping various entities, including charitable organizations, non-profits, educational institutions, and individuals facing hardships.', 'USA', '2024-02-20', b'0'),
(2, 'Devil', '8528528524', 'devil@gmail.com', 100.00, 'Education', 'USA', '2024-02-24', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gId` int(11) NOT NULL,
  `heading` varchar(250) NOT NULL,
  `image` varchar(250) NOT NULL,
  `addedOn` date NOT NULL,
  `isDel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`gId`, `heading`, `image`, `addedOn`, `isDel`) VALUES
(1, 'Free Charity', 'pexels-suraphat-nueaon-933624.jpg', '2024-02-20', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `nId` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `file` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `isDel` bit(1) NOT NULL,
  `addedOn` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`nId`, `title`, `file`, `description`, `isDel`, `addedOn`) VALUES
(1, 'title 1', 'pexels-suraphat-nueaon-933624.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus varius risus id eros fermentum, vitae posuere tortor bibendum. Fusce vel justo vel neque efficitur ullamcorper. Nulla facilisi. Ut vehicula, justo nec cursus ultrices, ligula felis efficitur lacus, vel gravida dolor nisi vitae purus. Nunc auctor bibendum urna, id sollicitudin orci sodales id. Nam nec sem id urna suscipit varius a non justo. Duis auctor massa a metus volutpat, id imperdiet ligula rhoncus.', b'1', '2024-02-19'),
(2, 'title 2', 'gettyimages-537311780-612x612.jpg', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.\n\nDuis dapibus, neque ac facilisis ultricies, dolor leo tristique tortor, vel rhoncus libero tellus in justo. Fusce euismod mi nec congue eleifend. Vestibulum sagittis quam in lacus tempor, vel varius urna gravida. Suspendisse eu efficitur lacus. Quisque at fermentum dui. Aenean imperdiet justo et tortor aliquam, sit amet tristique neque facilisis. Morbi congue vehicula risus, in laoreet odio. Suspendisse potenti. Proin euismod eros at vestibulum scelerisque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', b'1', '2024-02-19'),
(3, 'title 3', 'larm-rmah-AEaTUnvneik-unsplash.jpg', 'In hac habitasse platea dictumst. Ut bibendum arcu a mauris ullamcorper, at mattis augue bibendum. Sed fringilla, leo et scelerisque bibendum, mi justo vulputate nunc, a lacinia dui erat et purus. Fusce vel accumsan quam. Ut sodales enim vel turpis cursus, nec fermentum justo ultrices. Morbi lacinia sapien sit amet mi tempus, ac iaculis ligula tincidunt. Nullam ac quam eu metus sodales tristique a eu leo. Vivamus euismod finibus turpis, vel bibendum odio tempor vel. Curabitur a malesuada velit, ac malesuada nisl.\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fermentum justo a orci fermentum, nec scelerisque quam cursus. Integer ac convallis risus. Sed vel elit vel ligula hendrerit pharetra. Nunc commodo venenatis tortor in facilisis. Sed eu lacus eu eros consectetur bibendum. Nulla facilisi. Duis a magna a justo pellentesque varius.', b'0', '2024-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `sId` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `quots` varchar(250) NOT NULL,
  `file` varchar(250) NOT NULL,
  `addedOn` date NOT NULL,
  `isDel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`sId`, `title`, `quots`, `file`, `addedOn`, `isDel`) VALUES
(1, 'Education ', 'Education Foundation ', 'kaivalya-education-foundation-office.jpg', '2024-02-21', b'1'),
(2, 'Health and Wellness', 'Health and Wellness Foundation', 'wellness-icon-set-containing-massage-260nw-2247411817.jpg', '2024-02-21', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `vounteer`
--

CREATE TABLE `vounteer` (
  `vId` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `profile` text NOT NULL,
  `address` text NOT NULL,
  `addedOn` date NOT NULL,
  `gender` varchar(6) NOT NULL,
  `isDel` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vounteer`
--

INSERT INTO `vounteer` (`vId`, `name`, `email`, `mobile`, `profile`, `address`, `addedOn`, `gender`, `isDel`) VALUES
(1, 'john', 'john@gmail.com', '7575757575', 'f1f4b33210aa4bf2a3e0246c73beb2f3.jpg', 'USA', '2024-02-20', 'Male', b'0'),
(2, 'John', 'john@gmail.com', '8596523654', 'download (1).jpg', 'USA', '2024-02-24', 'Male', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `userId` (`userId`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cId`);

--
-- Indexes for table `donate`
--
ALTER TABLE `donate`
  ADD PRIMARY KEY (`dId`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gId`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`nId`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`sId`);

--
-- Indexes for table `vounteer`
--
ALTER TABLE `vounteer`
  ADD PRIMARY KEY (`vId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donate`
--
ALTER TABLE `donate`
  MODIFY `dId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `nId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `sId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vounteer`
--
ALTER TABLE `vounteer`
  MODIFY `vId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
