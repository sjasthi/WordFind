-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 01:22 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `word_find`
--

-- --------------------------------------------------------

--
-- Table structure for table `puzzles`
--

CREATE TABLE `puzzles` (
  `puzzle_id` int(11) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `language` varchar(255) NOT NULL,
  `word_direction` varchar(255) NOT NULL,
  `height` int(11) NOT NULL DEFAULT 10,
  `width` int(11) NOT NULL DEFAULT 10,
  `share_chars` tinyint(1) NOT NULL DEFAULT 1,
  `filler_char_types` varchar(255) NOT NULL,
  `word_bank` text NOT NULL,
  `board` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puzzles`
--

INSERT INTO `puzzles` (`puzzle_id`, `cat_id`, `title`, `description`, `author_id`, `created_on`, `language`, `word_direction`, `height`, `width`, `share_chars`, `filler_char_types`, `word_bank`, `board`) VALUES
(67, '1', 'Category 1 Puzzle', 'Testing category 1', 1, '2020-10-17', 'English', 'all', 10, 10, 0, 'Any', 'a:4:{i:0;a:8:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";i:3;s:1:\"E\";i:4;s:1:\"G\";i:5;s:1:\"O\";i:6;s:1:\"R\";i:7;s:1:\"Y\";}i:1;a:3:{i:0;s:1:\"O\";i:1;s:1:\"N\";i:2;s:1:\"E\";}i:2;a:6:{i:0;s:1:\"P\";i:1;s:1:\"U\";i:2;s:1:\"Z\";i:3;s:1:\"Z\";i:4;s:1:\"L\";i:5;s:1:\"E\";}i:3;a:4:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"S\";i:3;s:1:\"T\";}}', ''),
(68, '2', 'Cat 2 Puzzle', 'Testing Category 2 Puzzle', 1, '2020-10-17', 'English', 'all', 5, 5, 0, 'Any', 'a:5:{i:0;a:4:{i:0;s:1:\"M\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"E\";}i:1;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:2;a:3:{i:0;s:1:\"A\";i:1;s:1:\"R\";i:2;s:1:\"E\";}i:3;a:5:{i:0;s:1:\"F\";i:1;s:1:\"O\";i:2;s:1:\"U\";i:3;s:1:\"N\";i:4;s:1:\"D\";}i:4;a:4:{i:0;s:1:\"H\";i:1;s:1:\"E\";i:2;s:1:\"R\";i:3;s:1:\"E\";}}', ''),
(69, '3', 'Cat 3 Puzzle', 'Testing Category 3', 1, '2020-10-17', 'English', 'all', 10, 10, 0, 'Any', 'a:4:{i:0;a:7:{i:0;s:1:\"A\";i:1;s:1:\"N\";i:2;s:1:\"O\";i:3;s:1:\"T\";i:4;s:1:\"H\";i:5;s:1:\"E\";i:6;s:1:\"R\";}i:1;a:4:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"S\";i:3;s:1:\"T\";}i:2;a:2:{i:0;s:1:\"I\";i:1;s:1:\"S\";}i:3;a:4:{i:0;s:1:\"T\";i:1;s:1:\"H\";i:2;s:1:\"I\";i:3;s:1:\"S\";}}', ''),
(70, '4', 'Cat 4 Puzzle', 'Testing Category 4', 1, '2020-10-17', 'English', 'all', 8, 8, 0, 'Any', 'a:5:{i:0;a:4:{i:0;s:1:\"T\";i:1;s:1:\"H\";i:2;s:1:\"I\";i:3;s:1:\"S\";}i:1;a:2:{i:0;s:1:\"I\";i:1;s:1:\"S\";}i:2;a:6:{i:0;s:1:\"S\";i:1;s:1:\"I\";i:2;s:1:\"M\";i:3;s:1:\"P\";i:4;s:1:\"L\";i:5;s:1:\"Y\";}i:3;a:7:{i:0;s:1:\"A\";i:1;s:1:\"N\";i:2;s:1:\"O\";i:3;s:1:\"T\";i:4;s:1:\"H\";i:5;s:1:\"E\";i:6;s:1:\"R\";}i:4;a:4:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"S\";i:3;s:1:\"T\";}}', ''),
(71, '5', 'Cat 5 Puzzle', 'Testing Category 5', 1, '2020-10-17', 'English', 'all', 12, 12, 0, 'Any', 'a:5:{i:0;a:7:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"S\";i:3;s:1:\"T\";i:4;s:1:\"I\";i:5;s:1:\"N\";i:6;s:1:\"G\";}i:1;a:8:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";i:3;s:1:\"E\";i:4;s:1:\"G\";i:5;s:1:\"O\";i:6;s:1:\"R\";i:7;s:1:\"Y\";}i:2;a:4:{i:0;s:1:\"F\";i:1;s:1:\"I\";i:2;s:1:\"V\";i:3;s:1:\"E\";}i:3;a:5:{i:0;s:1:\"R\";i:1;s:1:\"I\";i:2;s:1:\"G\";i:3;s:1:\"H\";i:4;s:1:\"T\";}i:4;a:3:{i:0;s:1:\"N\";i:1;s:1:\"O\";i:2;s:1:\"W\";}}', ''),
(72, '2', 'Another Test', 'This is another test for category 2', 1, '2020-10-17', 'English', 'all', 10, 10, 0, 'Any', 'a:2:{i:0;a:7:{i:0;s:1:\"A\";i:1;s:1:\"N\";i:2;s:1:\"O\";i:3;s:1:\"T\";i:4;s:1:\"H\";i:5;s:1:\"E\";i:6;s:1:\"R\";}i:1;a:4:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"S\";i:3;s:1:\"T\";}}', ''),
(73, '6', 'Cat 6 Test', 'Testing Cat6', 1, '2020-10-18', 'Telugu', 'all', 10, 10, 0, 'Any', 'a:4:{i:0;a:7:{i:0;s:1:\"t\";i:1;s:1:\"e\";i:2;s:1:\"s\";i:3;s:1:\"t\";i:4;s:1:\"i\";i:5;s:1:\"n\";i:6;s:1:\"g\";}i:1;a:5:{i:0;s:1:\"w\";i:1;s:1:\"o\";i:2;s:1:\"r\";i:3;s:1:\"d\";i:4;s:1:\"s\";}i:2;a:8:{i:0;s:1:\"c\";i:1;s:1:\"a\";i:2;s:1:\"t\";i:3;s:1:\"e\";i:4;s:1:\"g\";i:5;s:1:\"o\";i:6;s:1:\"r\";i:7;s:1:\"y\";}i:3;a:3:{i:0;s:1:\"s\";i:1;s:1:\"i\";i:2;s:1:\"x\";}}', ''),
(75, '1', 'Insert DATA', 'testing after updated to Data array', 1, '2020-10-19', 'English', 'all', 8, 8, 0, 'Any', 'a:3:{i:0;a:5:{i:0;s:1:\"C\";i:1;s:1:\"H\";i:2;s:1:\"A\";i:3;s:1:\"R\";i:4;s:1:\"S\";}i:1;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:2;a:3:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";}}', ''),
(76, '1', 'Test WordBank', 'Testing $wordBank', 1, '2020-10-19', 'English', 'all', 6, 6, 0, 'Any', 'a:5:{i:0;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:1;a:3:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";}i:2;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:3;a:3:{i:0;s:1:\"A\";i:1;s:1:\"R\";i:2;s:1:\"E\";}i:4;a:4:{i:0;s:1:\"H\";i:1;s:1:\"E\";i:2;s:1:\"R\";i:3;s:1:\"E\";}}', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `puzzles`
--
ALTER TABLE `puzzles`
  ADD PRIMARY KEY (`puzzle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `puzzles`
--
ALTER TABLE `puzzles`
  MODIFY `puzzle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
