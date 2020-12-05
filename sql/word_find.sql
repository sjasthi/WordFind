-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2020 at 03:33 PM
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
(339, '66', 'English', 'Testing 2 words', 1, '2020-12-05 14:28:34', 'English', 'horizontal', 12, 12, 1, 'Consonants', '[[\"B\",\"U\",\"R\",\"G\",\"E\",\"R\",\"K\",\"I\",\"N\",\"G\"],[\"P\",\"E\",\"T\",\"E\",\"R\",\"P\",\"A\",\"R\",\"K\",\"E\",\"R\"]]', '[\"BURGER KING\",\"PETER PARKER\"]', '[[\"T\",\"H\",\"C\",\"M\",\"R\",\"B\",\"R\",\"Y\",\"T\",\"T\",\"R\",\"L\"],[\"F\",\"G\",\"F\",\"J\",\"W\",\"F\",\"G\",\"J\",\"W\",\"Y\",\"K\",\"L\"],[\"T\",\"Q\",\"J\",\"G\",\"M\",\"W\",\"Y\",\"W\",\"S\",\"D\",\"K\",\"X\"],[\"P\",\"E\",\"T\",\"E\",\"R\",\"P\",\"A\",\"R\",\"K\",\"E\",\"R\",\"Z\"],[\"Y\",\"S\",\"S\",\"T\",\"B\",\"J\",\"K\",\"Q\",\"Z\",\"M\",\"Y\",\"T\"],[\"N\",\"G\",\"N\",\"I\",\"K\",\"R\",\"E\",\"G\",\"R\",\"U\",\"B\",\"G\"],[\"G\",\"C\",\"R\",\"P\",\"B\",\"H\",\"X\",\"W\",\"W\",\"R\",\"H\",\"J\"],[\"Y\",\"C\",\"L\",\"J\",\"J\",\"C\",\"D\",\"K\",\"L\",\"D\",\"B\",\"T\"],[\"H\",\"D\",\"J\",\"S\",\"S\",\"W\",\"N\",\"Q\",\"W\",\"D\",\"K\",\"Q\"],[\"S\",\"Y\",\"Z\",\"Y\",\"J\",\"F\",\"F\",\"F\",\"S\",\"R\",\"F\",\"C\"],[\"D\",\"S\",\"N\",\"Q\",\"C\",\"X\",\"N\",\"N\",\"S\",\"R\",\"J\",\"S\"],[\"F\",\"M\",\"T\",\"N\",\"M\",\"W\",\"S\",\"K\",\"S\",\"S\",\"J\",\"Y\"]]', '[\"W\",\"E\"]', '[[[5,10],[5,9],[5,8],[5,7],[5,6],[5,5],[5,4],[5,3],[5,2],[5,1]],[[3,0],[3,1],[3,2],[3,3],[3,4],[3,5],[3,6],[3,7],[3,8],[3,9],[3,10]]]'),
(340, '66', 'Telegu', 'Description', 1, '2020-12-05 14:30:07', 'Telugu', 'all', 10, 10, 1, 'Consonants', '[[\"మె\",\"క్\",\"డొ\",\"నా\",\"ల్డ్\"],[\"బ\",\"ర్లిం\",\"గ్\",\"ట\",\"న్\"],[\"బ\",\"ర్గ\",\"ర్\",\"కిం\",\"గ్\"],[\"పీ\",\"ట\",\"ర్\",\"పా\",\"ర్క\",\"ర్\"]]', '[\"మెక్ ‌డొనాల్డ్\",\"బర్లింగ్‌ టన్\",\"బర్గర్ కింగ్\",\"పీటర్ పార్కర్\"]', '[[\"స\",\"ళ\",\"ల\",\"ఖ\",\"న\",\"బ\",\"ఠ\",\"హ\",\"ణ\",\"డ\"],[\"ధ\",\"ష\",\"త\",\"ఛ\",\"ళ\",\"ర్గ\",\"క్ష\",\"ట\",\"ఢ\",\"బ\"],[\"ళ\",\"ప\",\"శ\",\"ఫ\",\"బ\",\"ర్\",\"శ\",\"ఖ\",\"ర్లిం\",\"ఘ\"],[\"క్ష\",\"ఢ\",\"మె\",\"ట\",\"ళ\",\"కిం\",\"ఫ\",\"గ్\",\"భ\",\"ణ\"],[\"ప\",\"న\",\"క్ష\",\"క్\",\"జ\",\"గ్\",\"ట\",\"య\",\"ట\",\"ట\"],[\"ఖ\",\"ళ\",\"స\",\"ఫ\",\"డొ\",\"న్\",\"క\",\"ల\",\"క్ష\",\"మ\"],[\"మ\",\"ఠ\",\"ద\",\"ధ\",\"ర\",\"నా\",\"వ\",\"గ\",\"ళ\",\"ఛ\"],[\"య\",\"గ\",\"క్ష\",\"క్ష\",\"గ\",\"భ\",\"ల్డ్\",\"వ\",\"ఖ\",\"త\"],[\"చ\",\"ల\",\"పీ\",\"ట\",\"ర్\",\"పా\",\"ర్క\",\"ర్\",\"చ\",\"ళ\"],[\"ళ\",\"క\",\"ధ\",\"ర\",\"ఖ\",\"ఛ\",\"ద\",\"డ\",\"ఖ\",\"ళ\"]]', '[\"SE\",\"SW\",\"S\",\"E\"]', '[[[3,2],[4,3],[5,4],[6,5],[7,6]],[[1,9],[2,8],[3,7],[4,6],[5,5]],[[0,5],[1,5],[2,5],[3,5],[4,5]],[[8,2],[8,3],[8,4],[8,5],[8,6],[8,7]]]'),
(341, '2', 'Another Puzzle', 'Just another puzzle', 1, '2020-12-05 14:32:14', 'English', 'all', 8, 8, 1, 'Consonants', '[[\"A\",\"N\",\"O\",\"T\",\"H\",\"E\",\"R\"],[\"P\",\"U\",\"Z\",\"Z\",\"L\",\"E\"],[\"T\",\"O\"],[\"T\",\"E\",\"S\",\"T\"]]', '[\"ANOTHER\",\"PUZZLE\",\"TO\",\"TEST\"]', '[[\"K\",\"M\",\"H\",\"W\",\"V\",\"R\",\"W\",\"L\"],[\"D\",\"F\",\"Q\",\"V\",\"R\",\"V\",\"K\",\"R\"],[\"S\",\"D\",\"F\",\"O\",\"L\",\"B\",\"T\",\"E\"],[\"D\",\"K\",\"T\",\"N\",\"M\",\"B\",\"E\",\"H\"],[\"F\",\"G\",\"P\",\"R\",\"T\",\"J\",\"S\",\"T\"],[\"N\",\"N\",\"X\",\"V\",\"Y\",\"P\",\"T\",\"O\"],[\"Q\",\"V\",\"M\",\"D\",\"Y\",\"L\",\"X\",\"N\"],[\"C\",\"P\",\"U\",\"Z\",\"Z\",\"L\",\"E\",\"A\"]]', '[\"N\",\"E\",\"NE\",\"S\"]', '[[[7,7],[6,7],[5,7],[4,7],[3,7],[2,7],[1,7]],[[7,1],[7,2],[7,3],[7,4],[7,5],[7,6]],[[3,2],[2,3]],[[2,6],[3,6],[4,6],[5,6]]]'),
(342, '67', 'Title', 'Description', 1, '2020-12-05 14:32:32', 'English', 'all', 7, 7, 1, 'Consonants', '[[\"M\",\"O\",\"R\",\"E\"],[\"W\",\"O\",\"R\",\"D\",\"S\"],[\"A\",\"R\",\"E\"],[\"H\",\"E\",\"R\",\"E\"]]', '[\"MORE\",\"WORDS\",\"ARE\",\"HERE\"]', '[[\"F\",\"N\",\"N\",\"M\",\"H\",\"V\",\"R\"],[\"E\",\"W\",\"O\",\"R\",\"D\",\"S\",\"K\"],[\"R\",\"Q\",\"A\",\"F\",\"C\",\"E\",\"X\"],[\"O\",\"C\",\"R\",\"K\",\"R\",\"G\",\"C\"],[\"M\",\"M\",\"E\",\"E\",\"Y\",\"W\",\"F\"],[\"N\",\"Q\",\"H\",\"R\",\"W\",\"K\",\"D\"],[\"K\",\"K\",\"C\",\"J\",\"F\",\"D\",\"Z\"]]', '[\"N\",\"E\",\"S\",\"NE\"]', '[[[4,0],[3,0],[2,0],[1,0]],[[1,1],[1,2],[1,3],[1,4],[1,5]],[[2,2],[3,2],[4,2]],[[5,2],[4,3],[3,4],[2,5]]]');

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
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `puzzles`
--
ALTER TABLE `puzzles`
  MODIFY `puzzle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=343;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
