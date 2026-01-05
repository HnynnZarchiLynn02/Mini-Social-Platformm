-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2026 at 07:41 AM
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `postTitle` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `auther` varchar(25) NOT NULL,
  `catinfo` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `postTitle`, `description`, `content`, `post_date`, `auther`, `catinfo`) VALUES
(20, 'New Blog', 'Description', '<p><img src=\"data:image/jpeg;base64,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\" data-filename=\"comment3.jpg\" style=\"width: 225px;\"><br></p>', '2024-08-21 06:33:28', 'admin', 'Uncategorised'),
(21, 'Testing', 'Updating pic', '<p>This is the updating pic</p>', '2024-08-25 07:32:03', 'Admin', 'News'),
(22, 'Final Testing', 'unit testing', '<p>Black box testing and white box testing</p>', '2024-08-26 11:46:35', 'Kyi Sin Thant', 'Programming'),
(23, 'Testing', 'Hello', '<p>hello</p>', '2024-09-02 05:45:28', 'Admin', 'Uncategorised'),
(24, 'Hello', 'Hello WOrld', '<p><u style=\"background-color: rgb(255, 255, 0);\"><br></u></p><table class=\"table table-bordered\"><tbody><tr><td>uu</td><td>oo</td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr></tbody></table><p><u style=\"background-color: rgb(255, 255, 0);\"><br></u></p>', '2024-09-02 08:34:48', 'Admin', 'Technology'),
(25, 'Myo Myo', 'kkk', '<p><br></p><table class=\"table table-bordered\"><tbody><tr><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td></tr></tbody></table><p><br></p>', '2024-09-02 08:54:40', 'Ei Ei Phyo', 'News'),
(26, 'Hello', 'Hello', '<p><br></p><table class=\"table table-bordered\"><tbody><tr><td>Hi</td><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr></tbody></table><p><br></p>', '2024-09-04 05:07:10', 'Admin', 'Jobs Sharing'),
(27, 'Video', 'This is video', '<p><a href=\"https://www.youtube.com/watch?v=Nq4Mh_jTubA\" target=\"_blank\">video</a><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/Nq4Mh_jTubA\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><a href=\"https://www.youtube.com/watch?v=Nq4Mh_jTubA\">Video</a><br></p>', '2024-09-05 11:55:54', 'Kyi Sin Thant', 'Uncategorised'),
(28, 'tester', 'tester', '<ul><li><u><font face=\"Arial Black\" style=\"background-color: rgb(255, 156, 0);\"><br></font></u></li></ul><table class=\"table table-bordered\"><tbody><tr><td><br></td><td><br></td><td><br></td></tr><tr><td><p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p></td><td><br></td><td><br></td></tr></tbody></table><ul><li><u><font face=\"Arial Black\" style=\"background-color: rgb(255, 156, 0);\"><br></font></u></li></ul>', '2024-09-06 01:44:10', 'Admin', 'Technology'),
(29, 'testing1', 'dddd', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><a href=\"https://www.youtube.com/watch?v=nhbozauzVwM\" target=\"_blank\"></a><br></p><table class=\"table table-bordered\"><tbody><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr></tbody></table><p><br></p>', '2024-09-06 02:02:50', 'Admin', 'News'),
(30, 'Hello', 'hello', '<ul><li><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><a href=\"https://www.youtube.com/watch?v=nhbozauzVwM\" target=\"_blank\"></a><u><font face=\"Arial Black\" style=\"background-color: rgb(255, 156, 0);\"><br></font></u></li></ul><table class=\"table table-bordered\"><tbody><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr><tr><td><br></td><td><br></td><td><br></td><td><br></td></tr></tbody></table><ul><li><u><font face=\"Arial Black\" style=\"background-color: rgb(255, 156, 0);\"><br></font></u></li></ul>', '2024-09-06 02:18:15', 'Admin', 'Uncategorised'),
(31, 'HELLO', 'GTFFF', '<ul><li><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></li></ul>', '2024-09-06 02:23:58', 'Admin', 'Technology'),
(32, 'Hkk', 'hhh', '<p><br></p><p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 02:33:04', 'Admin', 'Uncategorised'),
(33, 'hell0', 'hello', '<p><u style=\"background-color: rgb(181, 214, 165);\">hhh</u><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></p>', '2024-09-06 03:59:27', 'Admin', 'News'),
(34, 'HELLO', 'JJJ', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><font face=\"Arial Black\" style=\"background-color: rgb(148, 189, 123);\"></font></p>', '2024-09-06 04:17:04', 'Phyo', 'News'),
(35, 'kkk', 'kkk', '<p><span style=\"background-color: rgb(255, 231, 156);\"><font face=\"Courier New\">ffff</font></span><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></p>', '2024-09-06 04:25:24', 'Admin', 'Jobs Sharing'),
(36, 'Dear x', 'hhhhh', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 04:38:52', 'Admin', 'Uncategorised'),
(37, 'vvv', 'ffff', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 04:45:21', 'Admin', 'Uncategorised'),
(38, 'Testing', 'fff', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><font face=\"Arial Black\"></font></p>', '2024-09-06 04:59:45', 'Admin', 'Jobs Sharing'),
(39, 'ffff', 'vvv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><font face=\"Comic Sans MS\" style=\"background-color: rgb(255, 0, 0);\"></font></p>', '2024-09-06 05:13:57', 'Admin', 'Jobs Sharing'),
(40, 'vvvv', 'cccccc', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><font face=\"Arial Black\"></font></p>', '2024-09-06 05:22:30', 'Admin', 'News'),
(41, 'hhh', 'ggggg', '<p>hhhh<iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></p>', '2024-09-06 05:28:59', 'Admin', 'Programming'),
(42, 'gggg', 'nnnn', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 05:31:45', 'Admin', 'Jobs Sharing'),
(43, 'gggg', 'vvv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 05:46:09', 'Admin', 'Jobs Sharing'),
(44, 'ggggg', 'gggggggggg', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><font face=\"Comic Sans MS\"></font></p>', '2024-09-06 06:02:50', 'Admin', 'Jobs Sharing'),
(45, 'bbb', 'dddd', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:19:20', 'Admin', 'Jobs Sharing'),
(46, 'vvvfff', 'fffff', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:28:58', 'Admin', 'News'),
(47, 'vvvvv', 'vvvv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:36:18', 'Admin', 'Jobs Sharing'),
(48, 'Video', 'ggggg', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:42:42', 'Admin', 'News'),
(49, 'nmmm', 'nnnn', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:52:43', 'Admin', 'Programming'),
(50, 'bbb', 'ffff', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 06:58:44', 'Admin', 'Jobs Sharing'),
(51, 'vvv', 'bbbbb', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:05:22', 'Admin', 'News'),
(52, 'nnnn', 'ggg', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:10:07', 'Admin', 'Jobs Sharing'),
(53, 'yyy', 'hhh', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:17:17', 'Admin', 'Technology'),
(54, 'nnn', 'vvv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:24:03', 'Admin', 'Jobs Sharing'),
(55, 'nnnn', 'nn', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:28:16', 'Admin', 'News'),
(56, 'bbb', 'vv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:35:51', 'Admin', 'Technology'),
(57, 'bbb', 'bbb', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:44:12', 'Admin', 'Technology'),
(58, 'hh', 'hhh', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 07:54:17', 'Admin', 'News'),
(59, 'vvv', 'vv', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 08:11:03', 'Admin', 'Jobs Sharing'),
(60, 'bb', 'gg', '<p><iframe frameborder=\"0\" src=\"//www.youtube.com/embed/nhbozauzVwM\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe><br></p>', '2024-09-06 08:20:54', 'Admin', 'Jobs Sharing');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cid` int(11) NOT NULL,
  `auther` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `auther`, `id`, `comment`, `comment_date`) VALUES
(24, 'Kyi Sin Thant', 21, 'Hello', '2024-08-25 20:16:13'),
(25, 'Kyi Sin Thant', 21, 'Wow', '2024-08-26 16:03:34'),
(26, 'Kyi Sin Thant', 21, 'Today', '2024-08-26 16:21:30'),
(29, 'Admin', 22, 'This is really amazing', '2024-08-27 17:38:50'),
(30, 'Kyi Sin Thant', 22, 'Hello', '2024-08-29 06:51:51'),
(31, 'Kyi Sin Thant', 21, 'Hello', '2024-08-29 06:52:51'),
(32, 'Admin', 22, 'Hello', '2024-09-01 15:00:30'),
(33, 'Kyi Sin Thant', 21, 'Testing', '2024-09-01 15:09:03'),
(34, 'Admin', 22, 'Rhis is new', '2024-09-01 15:10:06'),
(35, 'Admin', 23, 'Hi', '2024-09-02 12:15:44'),
(36, 'Ei Ei Phyo', 25, 'Hello', '2024-09-02 15:24:52'),
(37, 'Admin', 26, 'Hello', '2024-09-04 11:38:01'),
(38, 'Admin', 27, 'Hello', '2024-09-06 05:45:15'),
(39, 'Admin', 28, 'Hekk', '2024-09-06 08:14:26'),
(40, 'Admin', 27, 'hello', '2024-09-06 08:30:53'),
(41, 'Admin', 27, 'Hi', '2024-09-06 08:46:15'),
(42, 'Admin', 27, 'HI', '2024-09-06 08:54:59'),
(43, 'Admin', 32, 'nnn', '2024-09-06 09:03:38'),
(44, 'Admin', 33, 'hello', '2024-09-06 10:30:13'),
(45, 'Phyo', 34, 'HELLO', '2024-09-06 10:47:25'),
(46, 'Kyi Sin Thant', 35, 'hello', '2024-09-06 11:02:46'),
(47, 'Admin', 35, 'I luv hnin hnin', '2024-09-06 11:06:49'),
(48, 'Admin', 37, 'hello', '2024-09-06 11:16:46'),
(49, 'Admin', 27, 'keee', '2024-09-06 11:17:07'),
(50, 'Admin', 38, 'nnn', '2024-09-06 11:30:57'),
(51, 'Admin', 39, 'bbbbbbbb', '2024-09-06 11:44:43'),
(52, 'Admin', 40, 'vvvvvv', '2024-09-06 11:53:10'),
(53, 'Admin', 41, 'ggggg', '2024-09-06 11:59:20'),
(54, 'Admin', 42, 'fffff', '2024-09-06 12:02:21'),
(55, 'Admin', 28, 'ffff', '2024-09-06 12:18:39'),
(56, 'Admin', 44, 'yyyyyyyyyy', '2024-09-06 12:33:30'),
(57, 'Admin', 45, 'vvvvv', '2024-09-06 12:49:39'),
(58, 'Admin', 46, 'nnnnn', '2024-09-06 12:59:45'),
(59, 'Admin', 47, 'bbbbb', '2024-09-06 13:07:04'),
(60, 'Admin', 48, 'ccccccccc', '2024-09-06 13:13:24'),
(61, 'Admin', 50, 'nnnnn', '2024-09-06 13:30:12'),
(62, 'Kyi Sin Thant', 53, 'nnnnn', '2024-09-06 13:49:01'),
(63, 'Admin', 55, 'fffff', '2024-09-06 13:59:19'),
(64, 'Admin', 56, 'bbbb', '2024-09-06 14:06:37'),
(65, 'Admin', 57, 'ggggg', '2024-09-06 14:14:51'),
(66, 'Admin', 56, 'hi', '2024-09-06 15:11:53'),
(67, 'lynn', 60, 'hello', '2026-01-05 11:17:06'),
(68, 'lynn', 60, 'hi', '2026-01-05 11:17:18'),
(69, 'lynn', 60, 'Hll', '2026-01-05 11:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `comment_views`
--

CREATE TABLE `comment_views` (
  `cv_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `last_viewed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `notice_id` int(5) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`notice_id`, `title`, `description`, `date`) VALUES
(4, 'Essay', 'Essay2.2.2', '2.2.45'),
(5, 'Project Show', 'To register the form', '8.8.24'),
(8, 'Welcome 2025', 'Arraging the event', '6.9.2024'),
(9, 'Youth Organization', 'Disscussion Group', '10.9.2024');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `commenter` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `last_login` datetime NOT NULL,
  `currunt_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `otp` varchar(10) NOT NULL,
  `pic` longblob DEFAULT NULL,
  `last_viewed` datetime DEFAULT NULL,
  `otp_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `name`, `email`, `username`, `password`, `role`, `last_login`, `currunt_login`, `otp`, `pic`, `last_viewed`, `otp_expiration`) VALUES
(1, 'Admin', 'hnynnzarchilinn18@ucsmgy.edu.mm', 'Admin', 'Admin123', 'President', '2024-09-06 14:53:57', '2024-09-06 08:42:46', '389531', 0x696d67732f363663643365366664376263662e6a7067, '2024-09-06 15:12:46', NULL),
(4, 'Kyi Sin Thant', 'kyisinthant@ucsmgy.edu.mm', 'Kyi Sin Thant', 'Abcd1234', '1st yr', '2025-05-05 10:14:53', '2025-05-05 07:34:15', '82225656', 0x696d67732f363831383333643536623131392e6a7067, '2025-05-05 14:04:15', '2024-08-28 15:11:36'),
(5, 'Hnynn Zarchi Lynn', 'lynn@ucsmgy.edu.mm', 'Lynn', 'Abcd1234', ' 2nd yr', '2024-09-04 12:28:06', '2026-01-05 06:12:39', '', 0x696d67732f757365722e706e67, '2026-01-05 12:42:39', NULL),
(7, 'zarchi', 'zc@ucsmgy.edu.mm', 'Zarchi', 'Abcd1234', ' Final', '2024-08-11 07:35:44', '2024-09-04 05:58:37', '', 0x696d67732f757365722e706e67, NULL, NULL),
(8, 'Wine', 'wine@ucsmgy.edu.mm', 'Wine', 'Abcd1234', 'Member Management', '2024-09-04 12:28:53', '2024-09-06 02:07:19', '', 0x696d67732f757365722e706e67, '2024-09-06 08:37:19', NULL),
(9, 'Wai Yan', 'waiyanunimgy@ucsmgy.edu.mm', 'Wai Yan', 'WaiYan23', 'final', '2024-08-28 20:15:00', '2024-09-04 10:31:02', '99426036', 0x696d67732f757365722e706e67, '2024-08-28 20:15:24', '2024-09-04 12:41:02'),
(10, 'Ei Ei Phyo', 'eieip1379@ucsmgy.edu.mm', 'Ei Ei Phyo', 'Eep12345', 'third', '2024-09-02 15:21:15', '2024-09-04 05:59:48', '', 0x696d67732f757365722e706e67, '2024-09-02 15:26:39', NULL),
(13, 'Zin Zin Naing', 'zinzinnaing17@ucsmgy.edu.mm', 'Zin Zin Naing', 'Abcd1234', 'third', '0000-00-00 00:00:00', '2024-09-05 11:45:39', '43024508', 0x696d67732f757365722e706e67, NULL, '2024-09-05 13:55:39'),
(14, 'Khaing Su Mon', 'khaingsumon23@ucsmgy.edu.mm', 'Khaing Su Mon', 'Abcd1234', 'first', '2024-09-06 08:57:11', '2024-09-06 02:28:57', '50196808', 0x696d67732f757365722e706e67, '2024-09-06 08:58:36', '2024-09-06 04:38:57'),
(15, 'Phyo', 'phyomyatthu23@ucsmgy.edu.mm', 'Phyo', 'Abcd1234', 'first', '2024-09-06 10:44:58', '2024-09-06 04:18:42', '31107473', 0x696d67732f757365722e706e67, '2024-09-06 10:48:07', '2024-09-06 06:28:42'),
(16, '', '', '', '', 'SELECT', '0000-00-00 00:00:00', '2024-09-06 04:46:28', '', 0x696d67732f757365722e706e67, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `comment_views`
--
ALTER TABLE `comment_views`
  ADD PRIMARY KEY (`cv_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `comment_views`
--
ALTER TABLE `comment_views`
  MODIFY `cv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `notice_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_views`
--
ALTER TABLE `comment_views`
  ADD CONSTRAINT `comment_views_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `comment_views_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`),
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`cid`);

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `blog_posts` (`id`),
  ADD CONSTRAINT `post_likes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `userinfo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
