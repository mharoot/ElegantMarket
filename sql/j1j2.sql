-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 04, 2017 at 02:55 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `j2`
--

CREATE TABLE `j2` (
  `id` int(2) NOT NULL,
  `thing` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `j2`
--

INSERT INTO `j2` (`id`, `thing`) VALUES
(1, 'bye'),
(3, 'tschau'),
(4, ' au revoir'),
(6, 'so long'),
(7, 'tschuessi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `j2`
--
ALTER TABLE `j2`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `j2`
--
ALTER TABLE `j2`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


  -- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 04, 2017 at 02:55 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `j1`
--

CREATE TABLE `j1` (
  `id` int(2) NOT NULL,
  `thing` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `j1`
--

INSERT INTO `j1` (`id`, `thing`) VALUES
(1, 'hi'),
(2, 'hello'),
(3, 'guten tag'),
(4, 'ciao'),
(5, 'buongiorno');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `j1`
--
ALTER TABLE `j1`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `j1`
--
ALTER TABLE `j1`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;