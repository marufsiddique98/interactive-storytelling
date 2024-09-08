-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2024 at 06:42 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stroytelling`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

CREATE TABLE IF NOT EXISTS `analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_reads` int(11) DEFAULT 0,
  `average_time_spent` float DEFAULT 0,
  `completion_rate` float DEFAULT 0,
  `popular_choice_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  KEY `popular_choice_id` (`popular_choice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `analytics`
--

INSERT INTO `analytics` (`id`, `story_id`, `date`, `total_reads`, `average_time_spent`, `completion_rate`, `popular_choice_id`) VALUES
(7, 1, '2024-09-01', 5000, 12, 75, 1),
(8, 1, '2024-09-02', 4500, 11.5, 70, 2),
(9, 2, '2024-09-01', 3000, 15, 80, 3);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `story_id`, `title`, `content`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 'The Beginning', 'You arrive at the edge of the jungle, your heart racing as you take the first step into the dense foliage.', 1, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(2, 1, 'The Fork in the Road', 'After hours of traveling, you find yourself at a fork in the road. The left path leads deeper into the jungle, while the right path follows a river.', 2, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(3, 1, 'The Hidden Cave', 'You venture deeper into the jungle. After an hour of walking, you find a hidden cave that seems to beckon you inside.', 3, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(4, 1, 'The River’s Edge', 'Following the river, you come across a small village that wasn’t on your map. The villagers seem suspicious.', 4, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(5, 2, 'The Dark Forest', 'As night falls, you enter a dark forest. Strange sounds fill the air, and you feel a presence watching you.', 1, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(6, 2, 'The Mysterious Light', 'A mysterious light appears in the distance. Should you investigate or keep moving forward?', 2, '2024-09-08 15:52:25', '2024-09-08 15:52:25'),
(7, 3, 'The Old Tower', 'You reach an old tower. Legends say it holds great treasure, but it’s guarded by dangerous traps.', 1, '2024-09-08 15:52:25', '2024-09-08 15:52:25');

-- --------------------------------------------------------

--
-- Table structure for table `choices`
--

CREATE TABLE IF NOT EXISTS `choices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_id` int(11) DEFAULT NULL,
  `text` varchar(255) NOT NULL,
  `next_chapter_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `next_chapter_id` (`next_chapter_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choices`
--

INSERT INTO `choices` (`id`, `chapter_id`, `text`, `next_chapter_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Explore the Cave', NULL, '2024-09-08 16:33:13', '2024-09-08 16:33:13'),
(2, 1, 'Follow the River', NULL, '2024-09-08 16:33:13', '2024-09-08 16:33:13'),
(3, 2, 'Investigate the Ruins', NULL, '2024-09-08 16:33:13', '2024-09-08 16:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `choice_analytics`
--

CREATE TABLE IF NOT EXISTS `choice_analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `choice_id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_selections` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `choice_id` (`choice_id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `choice_analytics`
--

INSERT INTO `choice_analytics` (`id`, `choice_id`, `story_id`, `date`, `total_selections`) VALUES
(1, 1, 1, '2024-09-01', 1500),
(2, 2, 1, '2024-09-01', 2000),
(3, 3, 2, '2024-09-01', 1200);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `story_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `story_id`, `title`, `content`) VALUES
(1, 1, 'The Jungle Entrance', 'You stand at the edge of a dense jungle. The trees are thick, and the sounds of wildlife surround you. It’s your first challenge in finding the lost treasure.'),
(2, 1, 'The Hidden Cave', 'After taking the left path, you discover a hidden cave. It’s dark and damp, but you notice faint markings on the walls. There might be clues here.'),
(3, 1, 'The River Path', 'Choosing the right path, you follow the river. The sound of flowing water is calming, but you must stay alert for any dangers that might arise.'),
(4, 2, 'The Grand Mansion', 'You arrive at the grand mansion known for its haunting. The mansion is old with creaky floors and dusty furniture. Something doesn’t feel right.'),
(5, 2, 'The Mysterious Light', 'You notice a strange light coming from the attic. It flickers and seems to move as if trying to guide you. What could it be?'),
(6, 3, 'The Spacecraft Arrival', 'Your spacecraft lands on the edge of an uncharted planet. The surface is rocky and barren. You detect a signal coming from the planet’s surface.'),
(7, 3, 'The Alien Signal', 'The signal is identified as a distress call from an alien civilization. You must decide whether to investigate further or send a probe first.');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE IF NOT EXISTS `stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `genre` varchar(100) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `title`, `author_id`, `description`, `created_at`, `updated_at`, `genre`, `tags`, `rating`) VALUES
(1, 'The Lost Treasure', 1, 'You are an adventurer searching for hidden treasure in a mysterious jungle. After days of traveling, you arrive at a fork in the road...', '2024-09-08 11:21:21', '2024-09-08 11:21:21', NULL, NULL, NULL),
(2, 'The Haunted Mansion', 2, 'You have been invited to stay in a grand mansion that is rumored to be haunted. As night falls, eerie sounds echo through the halls...', '2024-09-08 11:21:21', '2024-09-08 11:21:21', NULL, NULL, NULL),
(3, 'The Space Voyage', 3, 'You are an astronaut on a mission to explore a distant galaxy. As you approach an uncharted planet, you receive an unexpected signal...', '2024-09-08 11:21:21', '2024-09-08 11:21:21', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `story_analytics`
--

CREATE TABLE IF NOT EXISTS `story_analytics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `story_id` int(11) DEFAULT NULL,
  `chapter_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `story_id` (`story_id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'john_doe', 'john.doe@example.com', 'password123', '2024-09-08 11:19:56', '2024-09-08 11:19:56'),
(2, 'jane_smith', 'jane.smith@example.com', 'password456', '2024-09-08 11:19:56', '2024-09-08 11:19:56'),
(3, 'alice_jones', 'alice.jones@example.com', 'password789', '2024-09-08 11:19:56', '2024-09-08 11:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `user_interactions`
--

CREATE TABLE IF NOT EXISTS `user_interactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `story_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `time_spent` float DEFAULT 0,
  `interaction_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `story_id` (`story_id`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_interactions`
--

INSERT INTO `user_interactions` (`id`, `user_id`, `story_id`, `section_id`, `time_spent`, `interaction_date`) VALUES
(1, 1, 1, 1, 5, '2024-09-01'),
(2, 2, 1, 2, 7.5, '2024-09-01'),
(3, 1, 2, 3, 6, '2024-09-02'),
(4, 3, 1, 1, 4, '2024-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `user_stories`
--

CREATE TABLE IF NOT EXISTS `user_stories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `story_id` int(11) DEFAULT NULL,
  `last_read_chapter_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `story_id` (`story_id`),
  KEY `last_read_chapter_id` (`last_read_chapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics`
--
ALTER TABLE `analytics`
  ADD CONSTRAINT `analytics_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`),
  ADD CONSTRAINT `analytics_ibfk_2` FOREIGN KEY (`popular_choice_id`) REFERENCES `choices` (`id`);

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `choices`
--
ALTER TABLE `choices`
  ADD CONSTRAINT `choices_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `choices_ibfk_2` FOREIGN KEY (`next_chapter_id`) REFERENCES `chapters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `choice_analytics`
--
ALTER TABLE `choice_analytics`
  ADD CONSTRAINT `choice_analytics_ibfk_1` FOREIGN KEY (`choice_id`) REFERENCES `choices` (`id`),
  ADD CONSTRAINT `choice_analytics_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`);

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `story_analytics`
--
ALTER TABLE `story_analytics`
  ADD CONSTRAINT `story_analytics_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `story_analytics_ibfk_2` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `story_analytics_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_interactions`
--
ALTER TABLE `user_interactions`
  ADD CONSTRAINT `user_interactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_interactions_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`),
  ADD CONSTRAINT `user_interactions_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `chapters` (`id`);

--
-- Constraints for table `user_stories`
--
ALTER TABLE `user_stories`
  ADD CONSTRAINT `user_stories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_stories_ibfk_2` FOREIGN KEY (`story_id`) REFERENCES `stories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_stories_ibfk_3` FOREIGN KEY (`last_read_chapter_id`) REFERENCES `chapters` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
