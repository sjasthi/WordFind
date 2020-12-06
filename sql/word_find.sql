-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2020 at 11:08 PM
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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(1, 'Cat1'),
(2, 'Cat2'),
(66, 'Two Words'),
(67, 'Category');

-- --------------------------------------------------------

--
-- Table structure for table `puzzles`
--

CREATE TABLE `puzzles` (
  `puzzle_id` int(11) NOT NULL,
  `cat_id` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `language` varchar(255) NOT NULL,
  `word_direction` varchar(255) NOT NULL,
  `height` int(11) NOT NULL DEFAULT 10,
  `width` int(11) NOT NULL DEFAULT 10,
  `share_chars` tinyint(1) NOT NULL,
  `filler_char_types` varchar(255) NOT NULL,
  `char_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`char_bank`)),
  `word_bank` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`word_bank`)),
  `board` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`board`)),
  `solution_directions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`solution_directions`)),
  `answer_coordinates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`answer_coordinates`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `puzzles`
--

INSERT INTO `puzzles` (`puzzle_id`, `cat_id`, `title`, `description`, `user_id`, `created_on`, `language`, `word_direction`, `height`, `width`, `share_chars`, `filler_char_types`, `char_bank`, `word_bank`, `board`, `solution_directions`, `answer_coordinates`) VALUES
(336, '1', 'Animals', 'Description', 1, '2020-12-05 14:24:41', 'English', 'all', 10, 10, 1, 'Consonants', '[[\"D\",\"O\",\"G\"],[\"C\",\"A\",\"T\"],[\"F\",\"O\",\"X\"]]', '[\"DOG\",\"CAT\",\"FOX\"]', '[[\"Y\",\"F\",\"N\",\"Y\",\"J\",\"C\",\"B\",\"T\",\"A\",\"C\"],[\"Z\",\"M\",\"F\",\"R\",\"V\",\"X\",\"S\",\"L\",\"N\",\"G\"],[\"J\",\"L\",\"X\",\"H\",\"F\",\"F\",\"M\",\"G\",\"G\",\"K\"],[\"J\",\"K\",\"Y\",\"Q\",\"F\",\"X\",\"B\",\"H\",\"G\",\"P\"],[\"V\",\"T\",\"V\",\"H\",\"X\",\"P\",\"W\",\"M\",\"K\",\"S\"],[\"Q\",\"G\",\"M\",\"S\",\"H\",\"O\",\"K\",\"C\",\"F\",\"V\"],[\"W\",\"T\",\"V\",\"L\",\"Q\",\"H\",\"F\",\"G\",\"O\",\"D\"],[\"X\",\"Y\",\"K\",\"S\",\"R\",\"G\",\"W\",\"C\",\"W\",\"K\"],[\"B\",\"D\",\"P\",\"N\",\"R\",\"R\",\"S\",\"N\",\"V\",\"S\"],[\"F\",\"Y\",\"K\",\"Q\",\"L\",\"K\",\"D\",\"L\",\"J\",\"K\"]]', '[\"W\",\"W\",\"NW\"]', '[[[6,9],[6,8],[6,7]],[[0,9],[0,8],[0,7]],[[6,6],[5,5],[4,4]]]'),
(337, '1', 'Farm Animals', 'Animals found on the farm', 1, '2020-12-05 14:26:21', 'English', 'all', 10, 10, 1, 'Vowels', '[[\"C\",\"A\",\"T\",\"T\",\"L\",\"E\"],[\"C\",\"H\",\"I\",\"C\",\"K\",\"E\",\"N\"],[\"S\",\"H\",\"E\",\"E\",\"P\"],[\"H\",\"O\",\"R\",\"S\",\"E\"],[\"G\",\"O\",\"A\",\"T\"],[\"P\",\"I\",\"G\"]]', '[\"CATTLE\",\"CHICKEN\",\"SHEEP\",\"HORSE\",\"GOAT\",\"PIG\"]', '[[\"S\",\"A\",\"E\",\"I\",\"E\",\"L\",\"T\",\"T\",\"A\",\"C\"],[\"H\",\"E\",\"I\",\"E\",\"U\",\"I\",\"T\",\"I\",\"A\",\"U\"],[\"E\",\"A\",\"I\",\"U\",\"A\",\"U\",\"A\",\"N\",\"A\",\"I\"],[\"E\",\"U\",\"U\",\"A\",\"U\",\"E\",\"O\",\"E\",\"E\",\"A\"],[\"P\",\"A\",\"I\",\"G\",\"U\",\"S\",\"G\",\"K\",\"U\",\"U\"],[\"A\",\"U\",\"I\",\"U\",\"E\",\"R\",\"I\",\"C\",\"U\",\"U\"],[\"A\",\"P\",\"I\",\"U\",\"U\",\"O\",\"I\",\"I\",\"A\",\"A\"],[\"E\",\"I\",\"E\",\"A\",\"I\",\"H\",\"I\",\"H\",\"E\",\"A\"],[\"I\",\"E\",\"E\",\"E\",\"E\",\"A\",\"I\",\"C\",\"E\",\"A\"],[\"I\",\"E\",\"U\",\"A\",\"U\",\"I\",\"A\",\"U\",\"E\",\"A\"]]', '[\"W\",\"N\",\"S\",\"N\",\"N\",\"NE\"]', '[[[0,9],[0,8],[0,7],[0,6],[0,5],[0,4]],[[8,7],[7,7],[6,7],[5,7],[4,7],[3,7],[2,7]],[[0,0],[1,0],[2,0],[3,0],[4,0]],[[7,5],[6,5],[5,5],[4,5],[3,5]],[[4,6],[3,6],[2,6],[1,6]],[[6,1],[5,2],[4,3]]]'),
(338, '2', 'GameMode', 'Testing game mode', 1, '2020-12-05 14:27:04', 'English', 'horizontal', 5, 5, 1, 'Consonants', '[[\"P\",\"L\",\"A\",\"Y\"],[\"G\",\"A\",\"M\",\"E\"]]', '[\"PLAY\",\"GAME\"]', '[[\"L\",\"D\",\"B\",\"C\",\"T\"],[\"P\",\"L\",\"A\",\"Y\",\"B\"],[\"Z\",\"J\",\"H\",\"L\",\"L\"],[\"G\",\"A\",\"M\",\"E\",\"T\"],[\"V\",\"D\",\"Y\",\"T\",\"H\"]]', '[\"E\",\"E\"]', '[[[1,0],[1,1],[1,2],[1,3]],[[3,0],[3,1],[3,2],[3,3]]]'),
(339, '66', 'English', 'Testing 2 words', 1, '2020-12-05 14:28:34', 'English', 'horizontal', 10, 10, 1, 'Consonants', '[[\"B\",\"A\",\"T\",\"M\",\"A\",\"N\"],[\"S\",\"P\",\"I\",\"D\",\"E\",\"R\",\"M\",\"A\",\"N\"]]', '[\"BATMAN\",\"SPIDERMAN\"]', '[[\"S\",\"P\",\"I\",\"D\",\"E\",\"R\",\"M\",\"A\",\"N\",\"F\"],[\"H\",\"X\",\"P\",\"F\",\"N\",\"W\",\"K\",\"Y\",\"Y\",\"G\"],[\"W\",\"G\",\"G\",\"V\",\"P\",\"K\",\"N\",\"R\",\"V\",\"D\"],[\"L\",\"Z\",\"J\",\"P\",\"Z\",\"K\",\"G\",\"D\",\"X\",\"G\"],[\"B\",\"J\",\"H\",\"F\",\"W\",\"J\",\"R\",\"H\",\"F\",\"R\"],[\"B\",\"A\",\"T\",\"M\",\"A\",\"N\",\"K\",\"K\",\"T\",\"R\"],[\"H\",\"C\",\"Q\",\"K\",\"N\",\"N\",\"K\",\"J\",\"R\",\"S\"],[\"W\",\"L\",\"G\",\"D\",\"F\",\"Q\",\"Y\",\"L\",\"Y\",\"D\"],[\"B\",\"S\",\"F\",\"B\",\"D\",\"C\",\"Z\",\"G\",\"Y\",\"Q\"],[\"M\",\"V\",\"G\",\"G\",\"Q\",\"Q\",\"X\",\"B\",\"Q\",\"W\"]]', '[\"E\",\"E\"]', '[[[5,0],[5,1],[5,2],[5,3],[5,4],[5,5]],[[0,0],[0,1],[0,2],[0,3],[0,4],[0,5],[0,6],[0,7],[0,8]]]'),
(340, '66', 'Telegu', 'Description', 1, '2020-12-05 14:30:07', 'Telugu', 'horizontal', 10, 10, 1, 'Consonants', '[[\"మె\",\"క్\",\"డొ\",\"నా\",\"ల్డ్\"],[\"బ\",\"ర్లిం\",\"గ్\",\"ట\",\"న్\"],[\"బ\",\"ర్గ\",\"ర్\",\"కిం\",\"గ్\"],[\"పీ\",\"ట\",\"ర్\",\"పా\",\"ర్క\",\"ర్\"]]', '[\"మెక్ ‌డొనాల్డ్\",\"బర్లింగ్‌ టన్\",\"బర్గర్ కింగ్\",\"పీటర్ పార్కర్\"]', '[[\"మ\",\"ఫ\",\"ఖ\",\"మ\",\"జ\",\"బ\",\"ఝ\",\"జ\",\"ణ\",\"మ\"],[\"జ\",\"య\",\"హ\",\"ళ\",\"ఢ\",\"గ్\",\"కిం\",\"ర్\",\"ర్గ\",\"బ\"],[\"పీ\",\"ట\",\"ర్\",\"పా\",\"ర్క\",\"ర్\",\"డ\",\"య\",\"మ\",\"ఫ\"],[\"ఖ\",\"ల\",\"ద\",\"ఖ\",\"ఘ\",\"వ\",\"ల\",\"క్ష\",\"గ\",\"ఛ\"],[\"ఖ\",\"ఫ\",\"ఝ\",\"ర\",\"ఢ\",\"భ\",\"ద\",\"ప\",\"ఝ\",\"ఢ\"],[\"బ\",\"ఝ\",\"మె\",\"క్\",\"డొ\",\"నా\",\"ల్డ్\",\"భ\",\"ణ\",\"థ\"],[\"ణ\",\"న్\",\"ట\",\"గ్\",\"ర్లిం\",\"బ\",\"ఖ\",\"జ\",\"జ\",\"ప\"],[\"ల\",\"చ\",\"ర\",\"హ\",\"క\",\"జ\",\"మ\",\"క\",\"ఠ\",\"య\"],[\"ళ\",\"న\",\"ఠ\",\"ఝ\",\"ఝ\",\"ఢ\",\"ల\",\"ణ\",\"ప\",\"బ\"],[\"బ\",\"న\",\"ల\",\"ఫ\",\"ష\",\"చ\",\"బ\",\"న\",\"య\",\"య\"]]', '[\"E\",\"W\",\"W\",\"E\"]', '[[[5,2],[5,3],[5,4],[5,5],[5,6]],[[6,5],[6,4],[6,3],[6,2],[6,1]],[[1,9],[1,8],[1,7],[1,6],[1,5]],[[2,0],[2,1],[2,2],[2,3],[2,4],[2,5]]]'),
(341, '2', 'Another Puzzle', 'Just another puzzle', 1, '2020-12-05 14:32:14', 'English', 'all', 8, 8, 1, 'Consonants', '[[\"A\",\"N\",\"O\",\"T\",\"H\",\"E\",\"R\"],[\"P\",\"U\",\"Z\",\"Z\",\"L\",\"E\"],[\"T\",\"O\"],[\"T\",\"E\",\"S\",\"T\"]]', '[\"ANOTHER\",\"PUZZLE\",\"TO\",\"TEST\"]', '[[\"K\",\"M\",\"H\",\"W\",\"V\",\"R\",\"W\",\"L\"],[\"D\",\"F\",\"Q\",\"V\",\"R\",\"V\",\"K\",\"R\"],[\"S\",\"D\",\"F\",\"O\",\"L\",\"B\",\"T\",\"E\"],[\"D\",\"K\",\"T\",\"N\",\"M\",\"B\",\"E\",\"H\"],[\"F\",\"G\",\"P\",\"R\",\"T\",\"J\",\"S\",\"T\"],[\"N\",\"N\",\"X\",\"V\",\"Y\",\"P\",\"T\",\"O\"],[\"Q\",\"V\",\"M\",\"D\",\"Y\",\"L\",\"X\",\"N\"],[\"C\",\"P\",\"U\",\"Z\",\"Z\",\"L\",\"E\",\"A\"]]', '[\"N\",\"E\",\"NE\",\"S\"]', '[[[7,7],[6,7],[5,7],[4,7],[3,7],[2,7],[1,7]],[[7,1],[7,2],[7,3],[7,4],[7,5],[7,6]],[[3,2],[2,3]],[[2,6],[3,6],[4,6],[5,6]]]'),
(342, '67', 'Some Title', 'Description', 1, '2020-12-05 14:32:32', 'English', 'all', 7, 7, 1, 'Consonants', '[[\"M\",\"O\",\"R\",\"E\"],[\"W\",\"O\",\"R\",\"D\",\"S\"],[\"A\",\"R\",\"E\"],[\"H\",\"E\",\"R\",\"E\"]]', '[\"MORE\",\"WORDS\",\"ARE\",\"HERE\"]', '[[\"F\",\"N\",\"N\",\"M\",\"H\",\"V\",\"R\"],[\"E\",\"W\",\"O\",\"R\",\"D\",\"S\",\"K\"],[\"R\",\"Q\",\"A\",\"F\",\"C\",\"E\",\"X\"],[\"O\",\"C\",\"R\",\"K\",\"R\",\"G\",\"C\"],[\"M\",\"M\",\"E\",\"E\",\"Y\",\"W\",\"F\"],[\"N\",\"Q\",\"H\",\"R\",\"W\",\"K\",\"D\"],[\"K\",\"K\",\"C\",\"J\",\"F\",\"D\",\"Z\"]]', '[\"N\",\"E\",\"S\",\"NE\"]', '[[[4,0],[3,0],[2,0],[1,0]],[[1,1],[1,2],[1,3],[1,4],[1,5]],[[2,2],[3,2],[4,2]],[[5,2],[4,3],[3,4],[2,5]]]'),
(343, '67', '3 words', 'Description', 1, '2020-12-05 14:35:49', 'English', 'all', 14, 14, 1, 'Consonants', '[[\"M\",\"Y\",\"L\",\"I\",\"T\",\"T\",\"L\",\"E\",\"P\",\"O\",\"N\",\"E\",\"Y\"]]', '[\"MY LITTLE PONEY\"]', '[[\"B\",\"W\",\"Y\",\"T\",\"D\",\"X\",\"D\",\"V\",\"Y\",\"G\",\"G\",\"W\",\"F\",\"N\"],[\"S\",\"Q\",\"R\",\"V\",\"T\",\"Y\",\"M\",\"Q\",\"B\",\"P\",\"G\",\"X\",\"W\",\"V\"],[\"H\",\"T\",\"M\",\"Q\",\"R\",\"F\",\"V\",\"X\",\"J\",\"J\",\"V\",\"Z\",\"N\",\"P\"],[\"W\",\"J\",\"Y\",\"L\",\"P\",\"Q\",\"C\",\"L\",\"Z\",\"W\",\"W\",\"Q\",\"Z\",\"J\"],[\"C\",\"F\",\"L\",\"R\",\"M\",\"S\",\"N\",\"S\",\"W\",\"G\",\"V\",\"L\",\"F\",\"P\"],[\"W\",\"J\",\"H\",\"J\",\"N\",\"D\",\"V\",\"H\",\"N\",\"H\",\"G\",\"H\",\"F\",\"Z\"],[\"M\",\"Y\",\"L\",\"I\",\"T\",\"T\",\"L\",\"E\",\"P\",\"O\",\"N\",\"E\",\"Y\",\"H\"],[\"Z\",\"Y\",\"P\",\"F\",\"G\",\"T\",\"R\",\"R\",\"C\",\"Y\",\"S\",\"D\",\"D\",\"W\"],[\"L\",\"S\",\"X\",\"Z\",\"Z\",\"W\",\"C\",\"V\",\"S\",\"M\",\"H\",\"B\",\"Y\",\"D\"],[\"C\",\"S\",\"K\",\"J\",\"P\",\"Q\",\"C\",\"R\",\"R\",\"J\",\"Y\",\"F\",\"F\",\"G\"],[\"D\",\"Q\",\"Z\",\"B\",\"Q\",\"R\",\"D\",\"G\",\"Z\",\"P\",\"T\",\"G\",\"S\",\"C\"],[\"T\",\"H\",\"N\",\"W\",\"R\",\"K\",\"H\",\"K\",\"P\",\"Y\",\"N\",\"Z\",\"R\",\"Z\"],[\"K\",\"J\",\"H\",\"R\",\"B\",\"F\",\"R\",\"V\",\"B\",\"B\",\"G\",\"Y\",\"Z\",\"G\"],[\"B\",\"J\",\"N\",\"F\",\"L\",\"Q\",\"M\",\"K\",\"C\",\"Z\",\"R\",\"M\",\"Z\",\"N\"]]', '[\"E\"]', '[[[6,0],[6,1],[6,2],[6,3],[6,4],[6,5],[6,6],[6,7],[6,8],[6,9],[6,10],[6,11],[6,12]]]'),
(347, '67', 'Title', 'Description', 1, '2020-12-06 21:59:42', 'English', 'all', 10, 10, 1, 'Consonants', '[[\"D\",\"O\",\"G\"]]', '[\"DOG\"]', '[[\"F\",\"W\",\"M\",\"B\",\"S\",\"C\",\"G\",\"S\",\"Q\",\"N\"],[\"B\",\"B\",\"Q\",\"Z\",\"G\",\"Q\",\"Q\",\"N\",\"Z\",\"G\"],[\"Z\",\"Y\",\"Y\",\"J\",\"F\",\"Y\",\"Q\",\"C\",\"S\",\"J\"],[\"M\",\"K\",\"Z\",\"Z\",\"Z\",\"M\",\"K\",\"Q\",\"J\",\"N\"],[\"F\",\"C\",\"S\",\"V\",\"J\",\"G\",\"G\",\"L\",\"C\",\"H\"],[\"K\",\"M\",\"X\",\"G\",\"H\",\"Z\",\"T\",\"C\",\"W\",\"D\"],[\"L\",\"S\",\"D\",\"W\",\"D\",\"X\",\"B\",\"P\",\"H\",\"J\"],[\"K\",\"X\",\"Y\",\"O\",\"F\",\"M\",\"Z\",\"M\",\"Q\",\"B\"],[\"L\",\"Q\",\"X\",\"V\",\"G\",\"N\",\"F\",\"C\",\"T\",\"N\"],[\"C\",\"X\",\"K\",\"P\",\"W\",\"B\",\"H\",\"S\",\"C\",\"K\"]]', '[\"SE\"]', '[[[6,2],[7,3],[8,4]]]');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(75) NOT NULL,
  `password` varchar(200) NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'yes',
  `role` varchar(20) NOT NULL DEFAULT 'student',
  `modified_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `active`, `role`, `modified_time`, `created_time`) VALUES
(1, 'Brandon', 'Hempel', 'brandonhempel@gmail.com', '$2y$10$Nt682vGqcaszQQTKiN7PjuvuUfcuOf6/UvnSnF7YBdHgw/l.Dv3Ny', 'yes', 'admin', '2020-11-14 06:00:00', '2020-11-14 06:00:00'),
(2, 'John', 'Calvin', 'john@gmail.com', '$2y$10$ojig5xeXvCi8qcQ9f8ygEehDdd8GrMplfympvBSfsm8J3BOwaydSe', 'yes', 'student', '2020-11-14 06:00:00', '2020-11-14 06:00:00'),
(81, 'Admin', 'User', 'admin', '$2y$10$V3lGmQO8vBpUJadk/r3CbumwsUQDETE/QB/aXSQJry4HOo3Vz/bkm', 'yes', 'admin', '2020-11-15 06:00:00', '2020-11-15 06:00:00'),
(82, 'John', 'Doe', 'test@gmail.com', '$2y$10$PhL7gipCbvffeglKZuhOD.VmFcOlfiAPskwTX1niFgfgkOaQuMeOW', 'yes', 'student', '2020-12-01 01:00:51', '2020-12-01 01:00:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `puzzles`
--
ALTER TABLE `puzzles`
  ADD PRIMARY KEY (`puzzle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `puzzles`
--
ALTER TABLE `puzzles`
  MODIFY `puzzle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=349;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
