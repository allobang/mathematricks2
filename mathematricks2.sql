-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2024 at 02:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mathematricks2`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer_attempts`
--

CREATE TABLE `answer_attempts` (
  `attempt_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer_attempts`
--

INSERT INTO `answer_attempts` (`attempt_id`, `session_id`, `question_id`, `selected_answer`, `is_correct`, `attempt_time`) VALUES
(1, 1, 1, '5', 1, '2024-02-24 02:03:35'),
(2, 1, 2, '7', 1, '2024-02-24 02:03:43'),
(3, 1, 3, '8', 1, '2024-02-24 02:03:47'),
(4, 3, 1, '5', 1, '2024-02-24 03:01:37'),
(5, 3, 3, '8', 1, '2024-02-24 03:01:44'),
(6, 3, 2, '7', 1, '2024-02-24 03:01:45'),
(7, 3, 4, '3', 1, '2024-02-24 03:01:50'),
(8, 3, 5, '1', 0, '2024-02-24 03:01:55'),
(9, 11, 1, '4', 0, '2024-02-24 03:56:28'),
(10, 11, 2, '7', 1, '2024-02-24 03:56:31'),
(11, 11, 3, '8', 1, '2024-02-24 03:56:33'),
(12, 11, 4, '3', 1, '2024-02-24 03:56:37'),
(13, 15, 1, '5', 1, '2024-02-24 06:20:16'),
(14, 15, 2, '7', 1, '2024-02-24 06:20:21'),
(15, 15, 3, '8', 1, '2024-02-24 06:20:23'),
(16, 15, 4, '2', 0, '2024-02-24 06:20:32'),
(17, 17, 1, '5', 1, '2024-02-24 06:21:56'),
(18, 17, 2, '7', 1, '2024-02-24 06:21:59'),
(19, 17, 3, '12', 0, '2024-02-24 06:22:02'),
(20, 17, 4, '4', 0, '2024-02-24 06:22:09'),
(21, 18, 1, '5', 1, '2024-02-24 06:23:34'),
(22, 18, 2, '7', 1, '2024-02-24 06:23:36'),
(23, 18, 3, '8', 1, '2024-02-24 06:23:39'),
(24, 18, 4, '2', 0, '2024-02-24 06:23:42'),
(25, 18, 6, '10', 0, '2024-02-24 06:23:49'),
(26, 18, 7, '8', 0, '2024-02-24 06:23:55'),
(27, 19, 2, '7', 1, '2024-02-24 06:32:46'),
(28, 19, 1, '5', 1, '2024-02-24 06:32:47'),
(29, 19, 3, '8', 1, '2024-02-24 06:32:50'),
(30, 19, 4, '2', 0, '2024-02-24 06:32:56'),
(31, 19, 5, '1', 0, '2024-02-24 06:32:59'),
(32, 19, 6, '10', 0, '2024-02-24 06:33:01'),
(33, 19, 7, '8', 0, '2024-02-24 06:33:06'),
(34, 21, 1, '5', 1, '2024-02-24 06:33:34'),
(35, 21, 2, '7', 1, '2024-02-24 06:33:35'),
(36, 21, 3, '8', 1, '2024-02-24 06:33:38'),
(37, 21, 4, '3', 1, '2024-02-24 06:33:40'),
(38, 21, 6, '20', 0, '2024-02-24 06:33:44'),
(39, 21, 7, '4', 1, '2024-02-24 06:33:46'),
(40, 22, 1, '5', 1, '2024-02-24 06:35:01'),
(41, 22, 2, '9', 0, '2024-02-24 06:35:03'),
(42, 22, 3, '8', 1, '2024-02-24 06:35:05'),
(43, 22, 4, '3', 1, '2024-02-24 06:35:07'),
(44, 22, 6, '20', 0, '2024-02-24 06:35:11'),
(45, 22, 7, '4', 1, '2024-02-24 06:35:13'),
(46, 22, 8, '10', 1, '2024-02-24 06:35:16'),
(47, 23, 1, '4', 0, '2024-02-26 07:11:54'),
(48, 23, 2, '8', 0, '2024-02-26 07:12:00'),
(49, 23, 3, '8', 1, '2024-02-26 07:12:04'),
(50, 23, 4, '2', 0, '2024-02-26 07:12:10'),
(51, 23, 5, '10', 0, '2024-02-26 07:12:15'),
(52, 23, 6, '10', 0, '2024-02-26 07:12:24'),
(53, 23, 7, '6', 0, '2024-02-26 07:12:28'),
(54, 23, 8, '8', 0, '2024-02-26 07:12:33'),
(55, 24, 1, '6', 0, '2024-02-29 08:08:49'),
(56, 24, 3, '4', 0, '2024-02-29 08:08:52'),
(57, 24, 4, '2', 0, '2024-02-29 08:08:54'),
(58, 24, 5, '20', 0, '2024-02-29 08:08:55'),
(59, 24, 6, '20', 0, '2024-02-29 08:08:57'),
(60, 24, 7, '4', 1, '2024-02-29 08:08:59'),
(61, 24, 8, '10', 1, '2024-02-29 08:09:00'),
(62, 29, 1, '4', 0, '2024-03-02 22:20:54'),
(63, 29, 2, '7', 1, '2024-03-02 22:20:56'),
(64, 29, 3, '2', 0, '2024-03-02 22:20:58'),
(65, 29, 4, '2', 0, '2024-03-02 22:21:00'),
(66, 29, 5, '10', 0, '2024-03-02 22:21:02'),
(67, 29, 6, '10', 0, '2024-03-02 22:21:04'),
(68, 29, 7, '4', 1, '2024-03-02 22:21:05'),
(69, 29, 8, '8', 0, '2024-03-02 22:21:06');

-- --------------------------------------------------------

--
-- Table structure for table `player_sessions`
--

CREATE TABLE `player_sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration` int(11) GENERATED ALWAYS AS (timestampdiff(SECOND,`start_time`,`end_time`)) VIRTUAL,
  `correct_answers` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `player_sessions`
--

INSERT INTO `player_sessions` (`session_id`, `user_id`, `score`, `start_time`, `end_time`, `correct_answers`, `total_questions`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2024-02-24 10:03:28', '2024-02-24 10:03:48', 3, 3, '2024-02-24 02:03:28', '2024-02-24 02:03:48'),
(2, 1, NULL, '2024-02-24 10:40:49', NULL, NULL, 3, '2024-02-24 02:40:49', '2024-02-24 02:40:49'),
(3, 1, 4, '2024-02-24 11:01:21', '2024-02-24 11:01:56', 4, 5, '2024-02-24 03:01:21', '2024-02-24 03:01:56'),
(4, 1, NULL, '2024-02-24 11:13:18', NULL, NULL, 5, '2024-02-24 03:13:18', '2024-02-24 03:13:18'),
(5, 1, NULL, '2024-02-24 11:13:48', NULL, NULL, 5, '2024-02-24 03:13:48', '2024-02-24 03:13:48'),
(6, 1, NULL, '2024-02-24 11:13:52', NULL, NULL, 5, '2024-02-24 03:13:52', '2024-02-24 03:13:52'),
(7, 1, NULL, '2024-02-24 11:40:58', NULL, NULL, 5, '2024-02-24 03:40:58', '2024-02-24 03:40:58'),
(8, 1, NULL, '2024-02-24 11:44:21', NULL, NULL, 5, '2024-02-24 03:44:21', '2024-02-24 03:44:21'),
(9, 1, NULL, '2024-02-24 11:53:56', NULL, NULL, 5, '2024-02-24 03:53:56', '2024-02-24 03:53:56'),
(10, 1, NULL, '2024-02-24 11:54:02', NULL, NULL, 5, '2024-02-24 03:54:02', '2024-02-24 03:54:02'),
(11, 1, 3, '2024-02-24 11:56:25', '2024-02-24 11:56:40', 3, 5, '2024-02-24 03:56:25', '2024-02-24 03:56:40'),
(12, 1, NULL, '2024-02-24 11:57:14', NULL, NULL, 5, '2024-02-24 03:57:14', '2024-02-24 03:57:14'),
(13, 1, NULL, '2024-02-24 13:20:49', NULL, NULL, 5, '2024-02-24 05:20:49', '2024-02-24 05:20:49'),
(14, 1, NULL, '2024-02-24 13:20:52', NULL, NULL, 5, '2024-02-24 05:20:52', '2024-02-24 05:20:52'),
(15, 1, 3, '2024-02-24 14:20:06', '2024-02-24 14:20:37', 3, 5, '2024-02-24 06:20:06', '2024-02-24 06:20:37'),
(16, 1, NULL, '2024-02-24 14:21:31', NULL, NULL, 6, '2024-02-24 06:21:31', '2024-02-24 06:21:31'),
(17, 1, 2, '2024-02-24 14:21:51', '2024-02-24 14:22:14', 2, 6, '2024-02-24 06:21:51', '2024-02-24 06:22:14'),
(18, 1, 3, '2024-02-24 14:23:26', '2024-02-24 14:23:57', 3, 7, '2024-02-24 06:23:26', '2024-02-24 06:23:57'),
(19, 4, 3, '2024-02-24 14:32:36', '2024-02-24 14:33:07', 3, 7, '2024-02-24 06:32:36', '2024-02-24 06:33:07'),
(20, 4, NULL, '2024-02-24 14:33:19', NULL, NULL, 7, '2024-02-24 06:33:19', '2024-02-24 06:33:19'),
(21, 4, 5, '2024-02-24 14:33:31', '2024-02-24 14:33:47', 5, 7, '2024-02-24 06:33:31', '2024-02-24 06:33:47'),
(22, 1, 5, '2024-02-24 14:34:58', '2024-02-24 14:35:16', 5, 8, '2024-02-24 06:34:58', '2024-02-24 06:35:16'),
(23, 1, 1, '2024-02-26 15:11:45', '2024-02-26 15:12:34', 1, 8, '2024-02-26 07:11:45', '2024-02-26 07:12:34'),
(24, 1, 2, '2024-02-29 16:08:43', '2024-02-29 16:09:00', 2, 8, '2024-02-29 08:08:43', '2024-02-29 08:09:00'),
(25, 1, NULL, '2024-02-29 16:09:39', NULL, NULL, 8, '2024-02-29 08:09:39', '2024-02-29 08:09:39'),
(26, 1, NULL, '2024-02-29 16:10:04', NULL, NULL, 8, '2024-02-29 08:10:04', '2024-02-29 08:10:04'),
(27, 1, NULL, '2024-02-29 16:10:20', NULL, NULL, 8, '2024-02-29 08:10:20', '2024-02-29 08:10:20'),
(28, 1, 0, '2024-02-29 16:11:02', '2024-02-29 16:23:36', 0, 8, '2024-02-29 08:11:02', '2024-02-29 08:23:36'),
(29, 1, 2, '2024-03-03 06:20:02', '2024-03-03 06:21:08', 2, 8, '2024-03-02 22:20:02', '2024-03-02 22:21:08'),
(30, 1, 0, '2024-03-03 07:33:59', '2024-03-03 07:34:04', 0, 8, '2024-03-02 23:33:59', '2024-03-02 23:34:04'),
(31, 1, NULL, '2024-03-03 16:40:24', NULL, NULL, 8, '2024-03-03 08:40:24', '2024-03-03 08:40:24'),
(32, 1, 0, '2024-03-03 16:40:45', '2024-03-03 16:41:06', 0, 8, '2024-03-03 08:40:45', '2024-03-03 08:41:06'),
(33, 1, NULL, '2024-03-03 18:31:03', NULL, NULL, 8, '2024-03-03 10:31:03', '2024-03-03 10:31:03'),
(34, 1, NULL, '2024-03-06 08:19:54', NULL, NULL, 8, '2024-03-06 00:19:54', '2024-03-06 00:19:54'),
(35, 1, NULL, '2024-03-06 14:14:12', NULL, NULL, 8, '2024-03-06 06:14:12', '2024-03-06 06:14:12'),
(36, 1, NULL, '2024-03-06 14:17:33', NULL, NULL, 8, '2024-03-06 06:17:33', '2024-03-06 06:17:33'),
(37, 1, NULL, '2024-03-06 14:18:01', NULL, NULL, 8, '2024-03-06 06:18:01', '2024-03-06 06:18:01'),
(38, 1, NULL, '2024-03-06 14:21:39', NULL, NULL, 8, '2024-03-06 06:21:39', '2024-03-06 06:21:39'),
(39, 1, NULL, '2024-03-06 14:27:54', NULL, NULL, 8, '2024-03-06 06:27:54', '2024-03-06 06:27:54'),
(40, 1, NULL, '2024-03-06 14:28:04', NULL, NULL, 8, '2024-03-06 06:28:04', '2024-03-06 06:28:04');

-- --------------------------------------------------------

--
-- Table structure for table `quizquestions`
--

CREATE TABLE `quizquestions` (
  `id` int(11) NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `question` text DEFAULT NULL,
  `choice1` varchar(255) DEFAULT NULL,
  `choice2` varchar(255) DEFAULT NULL,
  `choice3` varchar(255) DEFAULT NULL,
  `choice4` varchar(255) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizquestions`
--

INSERT INTO `quizquestions` (`id`, `grade`, `subject`, `difficulty`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `answer`, `explanation`, `image_url`, `created_at`, `updated_at`) VALUES
(1, '1', 'Math', 'Easy', '', '4', '5', '6', '7', '5', '2 + 3 = 5', 'assets/img/65d94cb4ca831.png', '2024-02-24 01:55:45', '2024-02-24 01:56:04'),
(2, '1', 'Math', 'Easy', '', '5', '7', '8', '9', '7', '', 'assets/img/65d94d102dfb5.png', '2024-02-24 01:57:28', '2024-02-24 01:57:36'),
(3, '1', 'Math', 'Easy', '', '2', '4', '8', '12', '8', '', 'assets/img/65d94e3215163.png', '2024-02-24 01:58:10', '2024-02-24 02:02:49'),
(4, '1', 'Math', 'Easy', 'How many sides does a triangle have?', '1', '2', '3', '4', '3', '', 'assets/img/65d95bac93539.png', '2024-02-24 02:59:23', '2024-02-24 02:59:56'),
(5, '1', 'Math', 'Easy', '5.	What is 10 - 10?', '0', '10', '20', '1', '0', '', 'assets/img/65d95bf194034.png', '2024-02-24 03:00:48', '2024-02-24 03:01:05'),
(6, '1', 'Math', 'Easy', 'asdfa', '0', '10', '20', '1', '0', 'asdgad', 'assets/img/65d98ae1aff56.png', '2024-02-24 06:21:10', '2024-02-24 06:21:21'),
(7, '1', 'Math', 'Medium', 'What is the half of 8?', '2', '4', '6', '8', '4', 'half of 8 is 4', 'assets/img/65d98b59849dd.png', '2024-02-24 06:23:00', '2024-02-24 06:23:21'),
(8, '1', 'Math', 'Easy', 'what is next to 9?', '7', '8', '9', '10', '10', 'cause 12345678910', NULL, '2024-02-24 06:34:51', '2024-02-24 06:34:51');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_settings`
--

CREATE TABLE `quiz_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_settings`
--

INSERT INTO `quiz_settings` (`setting_id`, `setting_name`, `setting_value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'quiz_duration', '122', 'Default quiz duration in minutes', '2024-03-06 02:44:03', '2024-03-06 02:44:03'),
(2, 'quiz_duration', '120', 'Default quiz duration in minutes', '2024-03-06 06:17:54', '2024-03-06 06:17:54'),
(3, 'quiz_duration', '59', 'Default quiz duration in minutes', '2024-03-06 06:27:49', '2024-03-06 06:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `usertype` varchar(20) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `grade`, `section`, `usertype`, `username`, `password`) VALUES
(1, 'Macky', 'horlador', '1', 'a', 'admin', 'mac', '$2y$10$MtD0U8.jzwya1RV5ir2b...a0XCLittWmi7vVewFhnmSQXhieaYkS'),
(3, 'allo', 'bang', '1', 'Atis', 'student', 'allo', '$2y$10$fiufIu/9pYp8ddyG3MqPf.PYrg3C75xRxrD1TZPpssL/xDYYCgh1m'),
(4, 'Rowel', 'Leonen', '1', 'Atis', 'student', 'owel', '$2y$10$EShF2E7fcOUsGcwWD21qUeL27nRffo5TM40MCB9vZV4hfbrPnd27K');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer_attempts`
--
ALTER TABLE `answer_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `player_sessions`
--
ALTER TABLE `player_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quizquestions`
--
ALTER TABLE `quizquestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_attempts`
--
ALTER TABLE `answer_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `player_sessions`
--
ALTER TABLE `player_sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `quizquestions`
--
ALTER TABLE `quizquestions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `quiz_settings`
--
ALTER TABLE `quiz_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_attempts`
--
ALTER TABLE `answer_attempts`
  ADD CONSTRAINT `answer_attempts_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `player_sessions` (`session_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_attempts_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `quizquestions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `player_sessions`
--
ALTER TABLE `player_sessions`
  ADD CONSTRAINT `player_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
