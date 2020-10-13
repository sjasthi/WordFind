-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2020 at 02:09 AM
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
  `author` varchar(255) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp(),
  `language` varchar(255) NOT NULL,
  `word_direction` varchar(255) NOT NULL,
  `height` int(11) NOT NULL DEFAULT 10,
  `width` int(11) NOT NULL DEFAULT 10,
  `share_chars` tinyint(1) NOT NULL DEFAULT 1,
  `filler_char_types` varchar(255) NOT NULL,
  `word_bank` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puzzles`
--

INSERT INTO `puzzles` (`puzzle_id`, `cat_id`, `title`, `description`, `author`, `created_on`, `language`, `word_direction`, `height`, `width`, `share_chars`, `filler_char_types`, `word_bank`) VALUES
(54, '19', 'Cat 1 Puzzle', 'This is a puzzle to test Category 1', 'Brandon', '2020-10-12', 'English', 'all', 10, 10, 0, 'Any', 'a:5:{i:0;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:1;a:3:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";}i:2;a:6:{i:0;s:1:\"P\";i:1;s:1:\"U\";i:2;s:1:\"Z\";i:3;s:1:\"Z\";i:4;s:1:\"L\";i:5;s:1:\"E\";}i:3;a:8:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";i:3;s:1:\"E\";i:4;s:1:\"G\";i:5;s:1:\"O\";i:6;s:1:\"R\";i:7;s:1:\"Y\";}i:4;a:3:{i:0;s:1:\"O\";i:1;s:1:\"N\";i:2;s:1:\"E\";}}'),
(55, '20', 'Cat 2 Puzzle', 'This is a puzzle to test Category 2', 'Brandon', '2020-10-12', 'English', 'all', 6, 6, 0, 'Any', 'a:3:{i:0;a:4:{i:0;s:1:\"F\";i:1;s:1:\"E\";i:2;s:1:\"A\";i:3;s:1:\"R\";}i:1;a:7:{i:0;s:1:\"W\";i:1;s:1:\"A\";i:2;s:1:\"R\";i:3;s:1:\"R\";i:4;s:1:\"I\";i:5;s:1:\"O\";i:6;s:1:\"R\";}i:2;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}}'),
(56, '21', 'Cat 3 Puzzle', 'This is a puzzle to test Category 3', 'John', '2020-10-12', 'English', 'all', 12, 12, 0, 'Consonants', 'a:4:{i:0;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:1;a:7:{i:0;s:1:\"P\";i:1;s:1:\"U\";i:2;s:1:\"Z\";i:3;s:1:\"Z\";i:4;s:1:\"L\";i:5;s:1:\"E\";i:6;s:1:\"S\";}i:2;a:8:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";i:3;s:1:\"E\";i:4;s:1:\"G\";i:5;s:1:\"O\";i:6;s:1:\"R\";i:7;s:1:\"Y\";}i:3;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}}'),
(57, '20', 'Another Puzzle Yo', 'This is another puzzle for Category 2!', 'Brandon', '2020-10-12', 'English', 'all', 10, 10, 0, 'Any', 'a:6:{i:0;a:4:{i:0;s:1:\"M\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"E\";}i:1;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:2;a:3:{i:0;s:1:\"F\";i:1;s:1:\"O\";i:2;s:1:\"R\";}i:3;a:3:{i:0;s:1:\"Y\";i:1;s:1:\"O\";i:2;s:1:\"U\";}i:4;a:2:{i:0;s:1:\"T\";i:1;s:1:\"O\";}i:5;a:3:{i:0;s:1:\"S\";i:1;s:1:\"E\";i:2;s:1:\"E\";}}'),
(58, '22', 'Cat 4 Puzzle', 'This is a puzzle to explain Category 4', 'Caitlin', '2020-10-12', 'English', 'vertical', 5, 5, 0, 'Vowels', 'a:3:{i:0;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:1;a:5:{i:0;s:1:\"A\";i:1;s:1:\"G\";i:2;s:1:\"A\";i:3;s:1:\"I\";i:4;s:1:\"N\";}i:2;a:4:{i:0;s:1:\"D\";i:1;s:1:\"U\";i:2;s:1:\"D\";i:3;s:1:\"E\";}}'),
(59, '23', 'Cat 5 Puzzle', 'This is another category!!', 'Zack Morris', '2020-10-12', 'English', 'vertical', 8, 8, 0, 'DCB', 'a:4:{i:0;a:4:{i:0;s:1:\"S\";i:1;s:1:\"A\";i:2;s:1:\"V\";i:3;s:1:\"E\";}i:1;a:2:{i:0;s:1:\"B\";i:1;s:1:\"Y\";}i:2;a:3:{i:0;s:1:\"T\";i:1;s:1:\"H\";i:2;s:1:\"E\";}i:3;a:4:{i:0;s:1:\"B\";i:1;s:1:\"E\";i:2;s:1:\"L\";i:3;s:1:\"L\";}}'),
(60, '24', 'Cat 6 Puzzle', 'This is another puzzle and I created a new category with it!', 'Josh', '2020-10-12', 'English', 'all', 10, 10, 0, 'Any', 'a:4:{i:0;a:6:{i:0;s:1:\"T\";i:1;s:1:\"U\";i:2;s:1:\"R\";i:3;s:1:\"T\";i:4;s:1:\"L\";i:5;s:1:\"E\";}i:1;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:2;a:3:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";}i:3;a:5:{i:0;s:1:\"M\";i:1;s:1:\"O\";i:2;s:1:\"U\";i:3;s:1:\"S\";i:4;s:1:\"E\";}}'),
(61, '24', 'Another Puzzle Test', 'This is just another example', 'Josh', '2020-10-12', 'English', 'vertical', 12, 12, 0, 'Consonants', 'a:4:{i:0;a:5:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";i:4;s:1:\"S\";}i:1;a:3:{i:0;s:1:\"A\";i:1;s:1:\"R\";i:2;s:1:\"E\";}i:2;a:3:{i:0;s:1:\"P\";i:1;s:1:\"U\";i:2;s:1:\"T\";}i:3;a:4:{i:0;s:1:\"H\";i:1;s:1:\"E\";i:2;s:1:\"R\";i:3;s:1:\"E\";}}'),
(62, '22', 'Puzzles HERE', 'Another Puzzle Example', 'Caitlin', '2020-10-10', 'English', 'vertical', 10, 10, 0, 'Any', 'a:6:{i:0;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:1;a:7:{i:0;s:1:\"B\";i:1;s:1:\"R\";i:2;s:1:\"A\";i:3;s:1:\"N\";i:4;s:1:\"D\";i:5;s:1:\"O\";i:6;s:1:\"N\";}i:2;a:5:{i:0;s:1:\"M\";i:1;s:1:\"O\";i:2;s:1:\"U\";i:3;s:1:\"S\";i:4;s:1:\"E\";}i:3;a:5:{i:0;s:1:\"H\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"S\";i:4;s:1:\"E\";}i:4;a:5:{i:0;s:1:\"T\";i:1;s:1:\"E\";i:2;s:1:\"R\";i:3;s:1:\"R\";i:4;s:1:\"Y\";}i:5;a:4:{i:0;s:1:\"W\";i:1;s:1:\"H\";i:2;s:1:\"A\";i:3;s:1:\"T\";}}'),
(63, '19', 'Testing AGAIN', 'Another Test', 'Martin', '2020-10-12', 'English', 'all', 14, 14, 0, 'Any', 'a:6:{i:0;a:8:{i:0;s:1:\"W\";i:1;s:1:\"H\";i:2;s:1:\"A\";i:3;s:1:\"T\";i:4;s:1:\"E\";i:5;s:1:\"V\";i:6;s:1:\"E\";i:7;s:1:\"R\";}i:1;a:4:{i:0;s:1:\"T\";i:1;s:1:\"H\";i:2;s:1:\"I\";i:3;s:1:\"S\";}i:2;a:2:{i:0;s:1:\"I\";i:1;s:1:\"S\";}i:3;a:7:{i:0;s:1:\"A\";i:1;s:1:\"N\";i:2;s:1:\"O\";i:3;s:1:\"T\";i:4;s:1:\"H\";i:5;s:1:\"E\";i:6;s:1:\"R\";}i:4;a:4:{i:0;s:1:\"W\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"D\";}i:5;a:4:{i:0;s:1:\"B\";i:1;s:1:\"A\";i:2;s:1:\"N\";i:3;s:1:\"K\";}}'),
(64, '22', 'Military', 'Military Branches', 'Brandon', '2020-10-12', 'English', 'all', 10, 10, 0, 'Any', 'a:6:{i:0;a:4:{i:0;s:1:\"A\";i:1;s:1:\"R\";i:2;s:1:\"M\";i:3;s:1:\"Y\";}i:1;a:10:{i:0;s:1:\"S\";i:1;s:1:\"P\";i:2;s:1:\"A\";i:3;s:1:\"C\";i:4;s:1:\"E\";i:5;s:1:\"F\";i:6;s:1:\"O\";i:7;s:1:\"R\";i:8;s:1:\"C\";i:9;s:1:\"E\";}i:2;a:7:{i:0;s:1:\"M\";i:1;s:1:\"A\";i:2;s:1:\"R\";i:3;s:1:\"I\";i:4;s:1:\"N\";i:5;s:1:\"E\";i:6;s:1:\"S\";}i:3;a:9:{i:0;s:1:\"A\";i:1;s:1:\"I\";i:2;s:1:\"R\";i:3;s:1:\" \";i:4;s:1:\"F\";i:5;s:1:\"O\";i:6;s:1:\"R\";i:7;s:1:\"C\";i:8;s:1:\"E\";}i:4;a:4:{i:0;s:1:\"N\";i:1;s:1:\"A\";i:2;s:1:\"V\";i:3;s:1:\"Y\";}i:5;a:12:{i:0;s:1:\"C\";i:1;s:1:\"O\";i:2;s:1:\"A\";i:3;s:1:\"S\";i:4;s:1:\"T\";i:5;s:1:\" \";i:6;s:1:\"G\";i:7;s:1:\"U\";i:8;s:1:\"A\";i:9;s:1:\"R\";i:10;s:1:\"D\";i:11;s:1:\"?\";}}'),
(65, '22', 'Testing Cat 4', 'This is a test', 'Brandon', '2020-10-12', 'English', 'all', 10, 10, 0, 'Any', 'a:4:{i:0;a:3:{i:0;s:1:\"D\";i:1;s:1:\"O\";i:2;s:1:\"G\";}i:1;a:3:{i:0;s:1:\"C\";i:1;s:1:\"A\";i:2;s:1:\"T\";}i:2;a:5:{i:0;s:1:\"M\";i:1;s:1:\"O\";i:2;s:1:\"U\";i:3;s:1:\"S\";i:4;s:1:\"E\";}i:3;a:5:{i:0;s:1:\"H\";i:1;s:1:\"O\";i:2;s:1:\"R\";i:3;s:1:\"S\";i:4;s:1:\"E\";}}'),
(66, '19', 'Testing', '', '', '2020-10-13', 'English', 'all', 10, 10, 0, 'Any', 'a:1:{i:0;a:0:{}}');

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
  MODIFY `puzzle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
