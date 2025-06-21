-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 22, 2025 at 12:08 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizyowszystkim`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answer_options`
--

CREATE TABLE `answer_options` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_text` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `quiz_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answer_options`
--

INSERT INTO `answer_options` (`id`, `question_id`, `option_text`, `is_correct`, `quiz_id`) VALUES
(16, 7, 'Berlin', 0, 4),
(17, 7, 'Rzym', 0, 4),
(18, 7, 'Paryż', 1, 4),
(19, 7, 'Madryt', 0, 4),
(20, 8, 'Lizbona', 0, 4),
(21, 8, 'Rzym', 0, 4),
(22, 8, 'Florencja', 0, 4),
(23, 8, 'Madryt', 1, 4),
(24, 9, 'Mediolan', 1, 4),
(25, 9, 'Warszawa', 0, 4),
(26, 9, 'Florencja', 0, 4),
(27, 9, 'Wenecja', 0, 4),
(28, 10, 'Berlin', 1, 4),
(29, 10, 'Monachium', 0, 4),
(30, 10, 'Dortmund', 0, 4),
(31, 10, 'Hamburg', 0, 4),
(32, 11, 'Oslo', 0, 4),
(33, 11, 'Kopenhaga', 0, 4),
(34, 11, 'Helsinki', 0, 4),
(35, 11, 'Sztokholm', 1, 4),
(36, 12, 'Sewilla', 0, 4),
(37, 12, 'Madryt', 0, 4),
(38, 12, 'Lizbona', 1, 4),
(39, 12, 'Porto', 0, 4),
(40, 13, '2005', 0, 5),
(41, 13, '2006', 1, 5),
(42, 13, '2007', 0, 5),
(43, 13, '2008', 0, 5),
(44, 14, '7', 0, 5),
(45, 14, '88', 1, 5),
(46, 14, '4', 0, 5),
(47, 14, '98', 0, 5),
(48, 15, 'Monaco', 0, 5),
(49, 15, 'Silverstone', 0, 5),
(50, 15, 'Montreal', 1, 5),
(51, 15, 'Monza', 0, 5),
(52, 16, 'Sauber BMW', 1, 5),
(53, 16, 'Renault F1 Team', 0, 5),
(54, 16, 'Williams', 0, 5),
(55, 16, 'Toro Rosso', 0, 5),
(56, 17, '2010', 0, 5),
(57, 17, '2011', 1, 5),
(58, 17, '2012', 0, 5),
(59, 17, '2013', 0, 5),
(60, 18, 'DTM', 0, 5),
(61, 18, 'WEC (World Endurance Championship)', 0, 5),
(62, 18, 'WRC (World Rally Championship)', 1, 5),
(63, 18, 'Formuła E', 0, 5),
(64, 19, 'Fluor', 0, 6),
(65, 19, 'Fosfor', 0, 6),
(66, 19, 'Żelazo', 1, 6),
(67, 19, 'Cyna', 0, 6),
(68, 20, 'Wenus', 0, 6),
(69, 20, 'Mars', 1, 6),
(70, 20, 'Jowisz', 0, 6),
(71, 20, 'Saturn', 0, 6),
(72, 21, 'Isaac Newton', 0, 6),
(73, 21, 'Albert Einstein', 1, 6),
(74, 21, 'Stephen Hawking', 0, 6),
(75, 21, 'Nikołaj Kopernik', 0, 6),
(76, 22, 'Komórka', 0, 6),
(77, 22, 'Molekuła', 0, 6),
(78, 22, 'Gen', 1, 6),
(79, 22, 'Białko', 0, 6),
(80, 23, 'Dyfrakcja', 0, 6),
(81, 23, 'Polaryzacja', 0, 6),
(82, 23, 'Dyspersja światła', 1, 6),
(83, 23, 'Interferencja', 0, 6),
(84, 24, 'Węch', 0, 6),
(85, 24, 'Dotyk', 0, 6),
(86, 24, 'Smak', 1, 6),
(87, 24, 'Słuch', 0, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `correct_answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `question_text`, `image_path`, `correct_answer`) VALUES
(7, 4, 'Stolicą Francji jest:', NULL, ''),
(8, 4, 'Stolicą Hiszpanii jest:', NULL, ''),
(9, 4, 'Stolicą Włoch jest:', NULL, ''),
(10, 4, 'Stolicą Niemiec jest:', NULL, ''),
(11, 4, 'Stolicą Szwecji jest:', NULL, ''),
(12, 4, 'Stolicą Portugalii jest:', NULL, ''),
(13, 5, 'W którym roku Robert Kubica zadebiutował w Formule 1?', NULL, ''),
(14, 5, 'Jaki numer startowy najczęściej kojarzony jest z Robertem Kubicą w Formule 1, zwłaszcza po jego powrocie?', NULL, ''),
(15, 5, 'Na jakim torze Robert Kubica odniósł swoje jedyne zwycięstwo w Formule 1?', NULL, ''),
(16, 5, 'W barwach którego zespołu Robert Kubica zadebiutował w Formule 1?', NULL, ''),
(17, 5, 'W którym roku Robert Kubica uległ poważnemu wypadkowi podczas rajdu, który na długo wykluczył go z Formuły 1?', NULL, ''),
(18, 5, 'Poza Formułą 1, w jakiej innej prestiżowej serii wyścigowej Robert Kubica również odnosił sukcesy, w tym zdobył mistrzostwo?', NULL, ''),
(19, 6, 'Jaki pierwiastek chemiczny ma symbol \'Fe\'?', NULL, ''),
(20, 6, 'Która planeta w Układzie Słonecznym jest znana jako \"Czerwona Planeta\"?', NULL, ''),
(21, 6, 'Kto sformułował teorię względności?', NULL, ''),
(22, 6, 'Co jest podstawową jednostką dziedziczności w organizmach żywych?', NULL, ''),
(23, 6, 'Jakie zjawisko fizyczne sprawia, że możemy widzieć kolory?', NULL, ''),
(24, 6, 'Którego zmysłu używasz, aby odczuwać smak?', NULL, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `question_type` enum('single_choice','multiple_choice','true_false','image_guess') NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `description`, `category`, `question_type`, `created_by`, `created_at`) VALUES
(4, 'Stolice Państw Europy', 'W tym quizie sprawdzisz swoje umiejętności zapamiętywania stolic podanych państw!', 'Geografia', 'single_choice', 2, '2025-06-21 21:44:14'),
(5, 'Test wiedzy o Robercie Kubicy', 'Sprawdź swoją wiedzę na temat jednego z największych legend polskiego motorsportu.', 'Rozrywka', 'single_choice', 2, '2025-06-21 21:47:56'),
(6, 'Świat Nauki', 'brak', 'Nauka', 'single_choice', 2, '2025-06-21 21:52:04');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `quiz_statistics`
--

CREATE TABLE `quiz_statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_statistics`
--

INSERT INTO `quiz_statistics` (`id`, `user_id`, `quiz_id`, `score`, `created_at`) VALUES
(1, 2, 2, 100.00, '2025-06-17 09:17:25'),
(2, 3, 1, 100.00, '2025-06-17 09:18:12'),
(3, 3, 2, 0.00, '2025-06-17 09:18:17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('user','moderator','admin') DEFAULT 'user',
  `avatar_path` varchar(255) DEFAULT 'default_avatar.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `avatar_path`, `created_at`) VALUES
(2, 'admin', 'admin@quizyowszystkim.pl', '$2y$10$Ady3T97p9.zKiAgUoTHFA.RaBU7ud.4rte6WyokiMHVZInojRqq0K', 'admin', 'default_avatar.png', '2025-06-14 10:50:16'),
(3, 'uzytkownik', 'uzytkownik@example.pl', '$2y$10$Se3iAwdknS4jIpyQ2LnBremdPeIY2vZZoI663ilb9SXPukHLw9ecC', 'user', 'default_avatar.png', '2025-06-14 10:55:52');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_stats`
--

CREATE TABLE `user_stats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_stats`
--

INSERT INTO `user_stats` (`id`, `user_id`, `quiz_id`, `score`, `completed_at`) VALUES
(1, 3, 2, 100, '2025-06-17 09:21:06'),
(2, 2, 1, 100, '2025-06-20 20:35:47'),
(3, 2, 2, 100, '2025-06-20 20:35:56'),
(4, 2, 4, 100, '2025-06-21 22:08:10');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `answer_options`
--
ALTER TABLE `answer_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `fk_quiz_id` (`quiz_id`);

--
-- Indeksy dla tabeli `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indeksy dla tabeli `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeksy dla tabeli `quiz_statistics`
--
ALTER TABLE `quiz_statistics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeksy dla tabeli `user_stats`
--
ALTER TABLE `user_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer_options`
--
ALTER TABLE `answer_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quiz_statistics`
--
ALTER TABLE `quiz_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_stats`
--
ALTER TABLE `user_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer_options`
--
ALTER TABLE `answer_options`
  ADD CONSTRAINT `answer_options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_quiz_id` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `quiz_statistics`
--
ALTER TABLE `quiz_statistics`
  ADD CONSTRAINT `quiz_statistics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `quiz_statistics_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);

--
-- Constraints for table `user_stats`
--
ALTER TABLE `user_stats`
  ADD CONSTRAINT `user_stats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_stats_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
