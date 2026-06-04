-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2026 at 12:56 PM
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
-- Database: `slms`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `published_year` year(4) NOT NULL,
  `publisher` varchar(150) NOT NULL,
  `status` enum('active','draft','unavailable') NOT NULL DEFAULT 'draft',
  `availability` enum('available','borrowed') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `category_id`, `title`, `author`, `description`, `published_year`, `publisher`, `status`, `availability`, `created_at`, `updated_at`) VALUES
(1, 1, 'The Great Gatsby (EDITED)', 'F. Scott Fitzgerald', 'A classic novel about wealth, love, and tragedy in the 1920s. (EDITTED)', '1925', 'Scribner', 'active', 'borrowed', '2026-04-30 18:08:46', '2026-06-02 23:57:46'),
(2, 7, 'Harry Potter and the Sorcerer’s Stone (EDIT)', 'J.K. Rowling', 'A young wizard discovers his magical identity. (EDIT)', '1997', 'Bloomsbury', 'active', 'available', '2026-04-30 18:24:25', '2026-06-02 23:47:28'),
(7, 1, 'awaasdas', 'asdasasd', 'sd', '2026', 'asdas', 'draft', 'available', '2026-06-02 16:43:24', '2026-06-02 18:07:09'),
(11, 1, 'asdasd', 'asdasdasdasd', 'asdasdadasd', '2026', 'asd', 'active', 'available', '2026-06-02 17:17:08', '2026-06-03 01:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` int(11) NOT NULL,
  `borrow_request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrowing_code` varchar(100) NOT NULL,
  `borrow_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `status` enum('borrowed','returned') NOT NULL DEFAULT 'borrowed',
  `issued_by` int(11) NOT NULL,
  `returned_to` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `borrow_request_id`, `user_id`, `book_id`, `borrowing_code`, `borrow_date`, `due_date`, `return_date`, `status`, `issued_by`, `returned_to`, `remarks`, `created_at`, `updated_at`) VALUES
(3, 25, 2, 2, 'BRW-2026-000003', '2026-05-14 01:16:47', '2026-05-21 01:16:47', '2026-05-14 22:07:51', 'returned', 1, 1, 'Book returned successfully.', '2026-05-13 17:16:47', '2026-05-14 14:07:51'),
(4, 27, 2, 1, 'BRW-2026-000004', '2026-05-14 22:13:46', '2026-05-21 22:13:46', '2026-05-14 22:14:04', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 14:13:46', '2026-05-14 14:14:04'),
(5, 26, 2, 2, 'BRW-2026-000005', '2026-05-14 22:14:17', '2026-05-21 22:14:17', '2026-05-14 22:14:21', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 14:14:17', '2026-05-14 14:14:21'),
(6, 28, 2, 1, 'BRW-2026-000006', '2026-05-14 22:15:34', '2026-06-23 22:15:34', '2026-05-15 01:34:09', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 14:15:34', '2026-05-14 17:34:09'),
(7, 30, 2, 1, 'BRW-2026-000007', '2026-05-15 01:42:18', '2026-05-22 01:42:18', '2026-05-15 01:43:33', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 17:42:18', '2026-05-14 17:43:33'),
(8, 29, 2, 2, 'BRW-2026-000008', '2026-05-15 01:43:49', '2026-05-22 01:43:49', '2026-05-15 01:44:30', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 17:43:49', '2026-05-14 17:44:30'),
(9, 31, 2, 2, 'BRW-2026-000009', '2026-05-15 01:43:55', '2026-05-22 01:43:55', '2026-05-15 01:44:18', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 17:43:55', '2026-05-14 17:44:18'),
(10, 32, 2, 1, 'BRW-2026-000010', '2026-05-15 01:46:47', '2026-09-02 01:46:47', '2026-05-15 01:55:25', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 17:46:47', '2026-05-14 17:55:25'),
(11, 33, 2, 2, 'BRW-2026-000011', '2026-05-15 01:55:29', '2026-06-01 01:55:29', '2026-05-15 01:55:40', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 17:55:29', '2026-05-14 17:55:40'),
(12, 34, 2, 1, 'BRW-2026-000012', '2026-05-15 03:06:14', '2026-05-25 03:06:14', '2026-05-15 03:06:23', 'returned', 1, 1, 'ddd', '2026-05-14 19:06:14', '2026-05-14 19:06:23'),
(13, 35, 2, 2, 'BRW-2026-000013', '2026-05-15 03:06:49', '2026-06-02 03:06:49', '2026-05-16 11:25:06', 'returned', 1, 1, 'Book returned successfully.', '2026-05-14 19:06:49', '2026-05-16 03:25:06'),
(14, 36, 2, 1, 'BRW-2026-000014', '2026-05-15 09:50:44', '2026-05-30 09:50:44', '2026-06-16 09:15:49', 'returned', 1, 1, 'Book returned successfully.', '2026-05-15 01:50:44', '2026-06-16 01:15:49'),
(15, 38, 2, 1, 'BRW-2026-000015', '2026-05-16 11:28:50', '2026-06-03 11:28:50', '2026-07-16 11:29:36', 'returned', 1, 1, 'Book returned successfully.', '2026-05-16 03:28:50', '2026-07-16 03:29:36'),
(16, 37, 2, 2, 'BRW-2026-000016', '2026-07-16 11:31:53', '2026-08-02 11:31:53', '2026-09-16 11:32:23', 'returned', 1, 1, 'Book returned successfully.', '2026-07-16 03:31:53', '2026-09-16 03:32:23'),
(17, 39, 4, 1, 'BRW-2026-000017', '2026-05-16 09:47:02', '2026-06-12 09:47:02', '2026-07-17 02:14:22', 'returned', 1, 1, 'Book returned successfully.', '2026-05-16 01:47:02', '2026-07-16 18:14:22'),
(18, 40, 4, 2, 'BRW-2026-000018', '2026-05-17 02:18:36', '2026-06-04 02:18:36', '2026-07-17 02:30:39', 'returned', 1, 1, 'Book returned successfully.', '2026-05-16 18:18:36', '2026-07-16 18:30:39'),
(19, 41, 2, 1, 'BRW-2026-000019', '2026-05-21 09:21:25', '2026-06-05 09:21:25', '2026-05-22 02:00:36', 'returned', 1, 1, 'Book returned successfully.', '2026-05-21 01:21:25', '2026-05-21 18:00:36'),
(20, 61, 4, 1, 'BRW-2026-000020', '2026-05-26 19:56:47', '2026-06-10 19:56:47', '2026-05-26 19:58:11', 'returned', 1, 1, 'Book returned successfully.', '2026-05-26 11:56:47', '2026-05-26 11:58:11'),
(21, 64, 4, 1, 'BRW-2026-000021', '2026-05-26 19:59:22', '2026-06-10 19:59:22', '2026-05-26 20:24:05', 'returned', 1, 1, 'Book returned successfully.', '2026-05-26 11:59:22', '2026-05-26 12:24:05'),
(22, 65, 4, 1, 'BRW-2026-000022', '2026-05-26 20:24:39', '2026-06-10 20:24:39', '2026-05-26 20:25:04', 'returned', 1, 1, 'Book returned successfully.', '2026-05-26 12:24:39', '2026-05-26 12:25:04'),
(23, 66, 6, 1, 'BRW-2026-000023', '2026-05-26 20:39:25', '2026-06-10 20:39:25', '2026-05-26 22:34:20', 'returned', 1, 1, 'Book returned successfully.', '2026-05-26 12:39:25', '2026-05-26 14:34:20'),
(24, 68, 2, 1, 'BRW-2026-000024', '2026-05-26 22:39:09', '2026-06-10 22:39:09', '2026-05-26 22:45:20', 'returned', 1, 1, 'Book returned successfully.', '2026-05-26 14:39:09', '2026-05-26 14:45:20'),
(25, 69, 4, 1, 'BRW-2026-000025', '2026-05-30 02:39:46', '2026-06-14 02:39:46', '2026-06-30 02:45:02', 'returned', 1, 1, 'Book returned successfully.', '2026-05-29 18:39:46', '2026-06-29 18:45:02'),
(26, 70, 4, 1, 'BRW-2026-000026', '2026-06-30 02:45:50', '2026-07-15 02:45:50', '2026-07-30 02:46:59', 'returned', 1, 1, 'Book returned successfully.', '2026-06-29 18:45:50', '2026-07-29 18:46:59'),
(27, 71, 4, 1, 'BRW-2026-000027', '2026-05-30 02:50:41', '2026-06-14 02:50:41', '2026-06-30 02:51:16', 'returned', 1, 1, 'Book returned successfully.', '2026-05-29 18:50:41', '2026-06-29 18:51:16'),
(28, 72, 4, 1, 'BRW-2026-000028', '2026-06-30 02:51:42', '2026-07-15 02:51:42', '2026-07-22 02:55:17', 'returned', 1, 1, 'Book returned successfully.', '2026-06-29 18:51:42', '2026-07-21 18:55:17'),
(29, 73, 4, 1, 'BRW-2026-000029', '2026-07-22 03:23:07', '2026-08-06 03:23:07', '2026-11-22 03:23:42', 'returned', 1, 1, 'Book returned successfully.', '2026-07-21 19:23:07', '2026-11-21 19:23:42'),
(30, 75, 4, 1, 'BRW-2026-000030', '2026-05-30 03:30:06', '2026-06-14 03:30:06', '2026-06-23 03:32:31', 'returned', 1, 1, 'Book returned successfully.', '2026-05-29 19:30:06', '2026-06-22 19:32:31'),
(31, 76, 4, 1, 'BRW-2026-000031', '2026-06-23 03:55:14', '2026-07-08 03:55:14', '2026-07-23 03:57:39', 'returned', 1, 1, 'Book returned successfully.', '2026-06-22 19:55:14', '2026-07-22 19:57:39'),
(32, 63, 5, 2, 'BRW-2026-000032', '2026-07-23 03:58:13', '2026-08-07 03:58:13', '2026-08-23 03:59:29', 'returned', 1, 1, 'Book returned successfully.', '2026-07-22 19:58:13', '2026-08-22 19:59:29'),
(33, 79, 5, 2, 'BRW-2026-000033', '2026-08-23 04:00:34', '2026-09-07 04:00:34', '2026-10-23 04:00:54', 'returned', 1, 1, 'Book returned successfully.', '2026-08-22 20:00:34', '2026-10-22 20:00:54'),
(34, 82, 2, 1, 'BRW-2026-000034', '2026-05-30 07:07:59', '2026-06-14 07:07:59', '2026-05-30 07:10:19', 'returned', 1, 1, 'Book returned successfully.', '2026-05-29 23:07:59', '2026-05-29 23:10:19'),
(35, 84, 4, 2, 'BRW-2026-000035', '2026-05-30 08:18:56', '2026-06-20 08:18:56', '2026-06-03 07:47:28', 'returned', 1, 1, 'Book returned successfully.', '2026-05-30 00:18:56', '2026-06-02 23:47:28'),
(36, 83, 4, 1, 'BRW-2026-000036', '2026-05-30 08:33:25', '2026-06-14 08:33:25', '2026-06-01 07:32:33', 'returned', 1, 1, 'Book returned successfully.', '2026-05-30 00:33:25', '2026-05-31 23:32:33'),
(37, 85, 5, 1, 'BRW-2026-000037', '2026-06-03 07:57:46', '2026-06-18 07:57:46', NULL, 'borrowed', 1, 0, 'Book marked as claimed successfully by Admin.', '2026-06-02 23:57:46', '2026-06-02 23:57:46');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_history`
--

CREATE TABLE `borrowing_history` (
  `id` int(11) NOT NULL,
  `borrowing_id` int(11) NOT NULL,
  `action` enum('claimed','extended','returned','overdue') NOT NULL,
  `previous_due_date` datetime DEFAULT NULL,
  `new_due_date` datetime DEFAULT NULL,
  `performed_at` datetime NOT NULL,
  `performed_by` int(11) NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowing_history`
--

INSERT INTO `borrowing_history` (`id`, `borrowing_id`, `action`, `previous_due_date`, `new_due_date`, `performed_at`, `performed_by`, `remarks`) VALUES
(1, 3, 'returned', NULL, NULL, '2026-05-14 22:07:51', 1, 'Book returned successfully.'),
(2, 4, 'returned', NULL, NULL, '2026-05-14 22:14:04', 1, 'Book returned successfully.'),
(3, 5, 'returned', NULL, NULL, '2026-05-14 22:14:21', 1, 'Book returned successfully.'),
(4, 6, 'extended', '2026-05-21 22:15:34', '2026-05-24 22:15:34', '2026-05-14 22:15:43', 1, 'Borrowing extended by 3 day(s).'),
(5, 6, 'extended', '2026-05-24 22:15:34', '2026-05-31 22:15:34', '2026-05-14 22:27:31', 1, 'Borrowing extended by 7 day(s).'),
(6, 6, 'extended', '2026-05-31 22:15:34', '2026-06-01 22:15:34', '2026-05-15 01:11:15', 1, 'Borrowing extended by 1 day(s).'),
(7, 6, 'extended', '2026-06-01 22:15:34', '2026-06-08 22:15:34', '2026-05-15 01:11:19', 1, 'Borrowing extended by 7 day(s).'),
(8, 6, 'extended', '2026-06-08 22:15:34', '2026-06-23 22:15:34', '2026-05-15 01:13:15', 1, 'Borrowing extended by 15 day(s).'),
(9, 6, 'returned', NULL, NULL, '2026-05-15 01:34:09', 1, 'Book returned successfully.'),
(10, 7, 'returned', NULL, NULL, '2026-05-15 01:43:33', 1, 'Book returned successfully.'),
(11, 9, 'returned', NULL, NULL, '2026-05-15 01:44:18', 1, 'Book returned successfully.'),
(12, 8, 'returned', NULL, NULL, '2026-05-15 01:44:30', 1, 'Book returned successfully.'),
(13, 10, 'extended', '2026-05-22 01:46:47', '2026-06-06 01:46:47', '2026-05-15 01:46:56', 1, 'Borrowing extended by 15 day(s).'),
(14, 10, 'extended', '2026-06-06 01:46:47', '2026-06-21 01:46:47', '2026-05-15 01:48:18', 1, 'Borrowing extended by 15 day(s).'),
(15, 10, 'extended', '2026-06-21 01:46:47', '2026-07-06 01:46:47', '2026-05-15 01:48:18', 1, 'Borrowing extended by 15 day(s).'),
(16, 10, 'extended', '2026-07-06 01:46:47', '2026-07-09 01:46:47', '2026-05-15 01:48:25', 1, 'Borrowing extended by 3 day(s).'),
(17, 10, 'extended', '2026-07-09 01:46:47', '2026-07-12 01:46:47', '2026-05-15 01:48:25', 1, 'Borrowing extended by 3 day(s).'),
(18, 10, 'extended', '2026-07-12 01:46:47', '2026-07-15 01:46:47', '2026-05-15 01:48:33', 1, 'Borrowing extended by 3 day(s).'),
(19, 10, 'extended', '2026-07-15 01:46:47', '2026-07-18 01:46:47', '2026-05-15 01:48:34', 1, 'Borrowing extended by 3 day(s).'),
(20, 10, 'extended', '2026-07-18 01:46:47', '2026-07-21 01:46:47', '2026-05-15 01:48:37', 1, 'Borrowing extended by 3 day(s).'),
(21, 10, 'extended', '2026-07-21 01:46:47', '2026-07-24 01:46:47', '2026-05-15 01:48:37', 1, 'Borrowing extended by 3 day(s).'),
(22, 10, 'extended', '2026-07-24 01:46:47', '2026-07-31 01:46:47', '2026-05-15 01:48:41', 1, 'Borrowing extended by 7 day(s).'),
(23, 10, 'extended', '2026-07-31 01:46:47', '2026-08-07 01:46:47', '2026-05-15 01:48:41', 1, 'Borrowing extended by 7 day(s).'),
(24, 10, 'extended', '2026-08-07 01:46:47', '2026-08-14 01:46:47', '2026-05-15 01:50:29', 1, 'Borrowing extended by 7 day(s).'),
(25, 10, 'extended', '2026-08-14 01:46:47', '2026-08-29 01:46:47', '2026-05-15 01:50:32', 1, 'Borrowing extended by 15 day(s).'),
(26, 10, 'extended', '2026-08-29 01:46:47', '2026-08-30 01:46:47', '2026-05-15 01:50:36', 1, 'Borrowing extended by 1 day(s).'),
(27, 10, 'extended', '2026-08-30 01:46:47', '2026-09-02 01:46:47', '2026-05-15 01:50:40', 1, 'Borrowing extended by 3 day(s).'),
(28, 10, 'returned', NULL, NULL, '2026-05-15 01:55:25', 1, 'Book returned successfully.'),
(29, 11, 'extended', '2026-05-22 01:55:29', '2026-05-29 01:55:29', '2026-05-15 01:55:32', 1, 'Borrowing extended by 7 day(s).'),
(30, 11, 'extended', '2026-05-29 01:55:29', '2026-06-01 01:55:29', '2026-05-15 01:55:36', 1, 'Borrowing extended by 3 day(s).'),
(31, 11, 'returned', NULL, NULL, '2026-05-15 01:55:40', 1, 'Book returned successfully.'),
(32, 12, 'extended', '2026-05-22 03:06:14', '2026-05-25 03:06:14', '2026-05-15 03:06:20', 1, 'Borrowing extended by 3 day(s).'),
(33, 12, 'returned', NULL, NULL, '2026-05-15 03:06:23', 1, 'ddd'),
(34, 13, 'extended', '2026-05-22 03:06:49', '2026-05-23 03:06:49', '2026-05-15 03:06:55', 1, 'Borrowing extended by 1 day(s).'),
(35, 13, 'extended', '2026-05-23 03:06:49', '2026-05-26 03:06:49', '2026-05-25 03:39:54', 1, 'Borrowing extended by 3 day(s).'),
(36, 13, 'extended', '2026-05-26 03:06:49', '2026-06-02 03:06:49', '2026-05-29 03:40:20', 1, 'Borrowing extended by 7 day(s).'),
(37, 14, 'returned', NULL, NULL, '2026-06-16 09:15:49', 1, 'Book returned successfully.'),
(38, 13, 'returned', NULL, NULL, '2026-05-16 11:25:06', 1, 'Book returned successfully.'),
(39, 15, 'extended', '2026-05-31 11:28:50', '2026-06-03 11:28:50', '2026-05-16 11:28:57', 1, 'Borrowing extended by 3 day(s).'),
(40, 15, 'returned', NULL, NULL, '2026-07-16 11:29:36', 1, 'Book returned successfully.'),
(41, 16, 'extended', '2026-07-31 11:31:53', '2026-08-01 11:31:53', '2026-07-16 11:32:12', 1, 'Borrowing extended by 1 day(s).'),
(42, 16, 'extended', '2026-08-01 11:31:53', '2026-08-02 11:31:53', '2026-07-16 11:32:18', 1, 'Borrowing extended by 1 day(s).'),
(43, 16, 'returned', NULL, NULL, '2026-09-16 11:32:23', 1, 'Book returned successfully.'),
(44, 17, 'extended', '2026-05-31 09:47:02', '2026-06-01 09:47:02', '2026-06-16 23:02:31', 1, 'Borrowing extended by 1 day(s).'),
(45, 17, 'extended', '2026-06-01 09:47:02', '2026-06-02 09:47:02', '2026-05-16 23:50:09', 1, 'Borrowing extended by 1 day(s).'),
(46, 17, 'extended', '2026-06-02 09:47:02', '2026-06-05 09:47:02', '2026-05-17 00:03:33', 1, 'Borrowing extended by 3 day(s).'),
(47, 17, 'extended', '2026-06-05 09:47:02', '2026-06-06 09:47:02', '2026-05-17 00:24:24', 1, 'Borrowing extended by 1 day(s).'),
(48, 17, 'extended', '2026-06-06 09:47:02', '2026-06-09 09:47:02', '2026-05-17 00:24:53', 1, 'Borrowing extended by 3 day(s).'),
(49, 17, 'extended', '2026-06-09 09:47:02', '2026-06-12 09:47:02', '2026-05-17 00:25:32', 1, 'Borrowing extended by 3 day(s).'),
(50, 17, 'returned', NULL, NULL, '2026-07-17 02:14:22', 1, 'Book returned successfully.'),
(51, 18, 'extended', '2026-06-01 02:18:36', '2026-06-04 02:18:36', '2026-05-17 02:18:41', 1, 'Borrowing extended by 3 day(s).'),
(52, 18, 'returned', NULL, NULL, '2026-07-17 02:30:39', 1, 'Book returned successfully.'),
(53, 21, 'returned', NULL, NULL, '2026-05-26 20:24:05', 1, 'Book returned successfully.'),
(54, 22, 'returned', NULL, NULL, '2026-05-26 20:25:04', 1, 'Book returned successfully.'),
(55, 23, 'returned', NULL, NULL, '2026-05-26 22:34:20', 1, 'Book returned successfully.'),
(56, 24, 'returned', NULL, NULL, '2026-05-26 22:45:20', 1, 'Book returned successfully.'),
(57, 25, 'returned', NULL, NULL, '2026-06-30 02:45:02', 1, 'Book returned successfully.'),
(58, 26, 'returned', NULL, NULL, '2026-07-30 02:46:59', 1, 'Book returned successfully.'),
(59, 27, 'returned', NULL, NULL, '2026-06-30 02:51:16', 1, 'Book returned successfully.'),
(60, 28, 'returned', NULL, NULL, '2026-07-22 02:55:17', 1, 'Book returned successfully.'),
(61, 29, 'returned', NULL, NULL, '2026-11-22 03:23:42', 1, 'Book returned successfully.'),
(62, 30, 'returned', NULL, NULL, '2026-06-23 03:32:31', 1, 'Book returned successfully.'),
(63, 31, 'returned', NULL, NULL, '2026-07-23 03:57:39', 1, 'Book returned successfully.'),
(64, 32, 'returned', NULL, NULL, '2026-08-23 03:59:29', 1, 'Book returned successfully.'),
(65, 33, 'returned', NULL, NULL, '2026-10-23 04:00:54', 1, 'Book returned successfully.'),
(66, 34, 'returned', NULL, NULL, '2026-05-30 07:10:19', 1, 'Book returned successfully.'),
(67, 36, 'returned', NULL, NULL, '2026-06-01 07:32:33', 1, 'Book returned successfully.'),
(68, 35, 'extended', '2026-06-14 08:18:56', '2026-06-15 08:18:56', '2026-06-03 02:04:41', 1, 'Borrowing extended by 1 day(s).'),
(69, 35, 'extended', '2026-06-15 08:18:56', '2026-06-16 08:18:56', '2026-06-03 02:08:03', 1, 'Borrowing extended by 1 day(s).'),
(70, 35, 'extended', '2026-06-16 08:18:56', '2026-06-17 08:18:56', '2026-06-03 02:08:43', 1, 'Borrowing extended by 1 day(s).'),
(71, 35, 'extended', '2026-06-17 08:18:56', '2026-06-18 08:18:56', '2026-06-03 02:08:59', 1, 'Borrowing extended by 1 day(s).'),
(72, 35, 'extended', '2026-06-18 08:18:56', '2026-06-19 08:18:56', '2026-06-03 02:08:59', 1, 'Borrowing extended by 1 day(s).'),
(73, 35, 'extended', '2026-06-19 08:18:56', '2026-06-20 08:18:56', '2026-06-03 02:09:49', 1, 'Borrowing extended by 1 day(s).'),
(74, 35, 'returned', NULL, NULL, '2026-06-03 07:47:28', 1, 'Book returned successfully.');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_requests`
--

CREATE TABLE `borrow_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `status` enum('pending','approved','claimed','rejected','cancelled','expired') NOT NULL DEFAULT 'pending',
  `request_date` datetime NOT NULL,
  `expires_at` datetime NOT NULL,
  `processed_at` datetime DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `borrow_request_code` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_requests`
--

INSERT INTO `borrow_requests` (`id`, `user_id`, `book_id`, `status`, `request_date`, `expires_at`, `processed_at`, `processed_by`, `remarks`, `borrow_request_code`, `created_at`, `updated_at`) VALUES
(21, 2, 1, 'cancelled', '2026-05-13 09:16:01', '0000-00-00 00:00:00', '2026-05-14 00:39:48', 1, 'kai mabaho hiya', 'REQ-2026-000021', '2026-05-13 01:16:01', '2026-05-13 16:39:48'),
(25, 2, 2, 'claimed', '2026-05-14 01:16:32', '0000-00-00 00:00:00', '2026-05-14 01:16:47', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000025', '2026-05-13 17:16:32', '2026-05-13 17:16:47'),
(26, 2, 2, 'claimed', '2026-05-14 22:13:22', '0000-00-00 00:00:00', '2026-05-14 22:14:17', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000026', '2026-05-14 14:13:22', '2026-05-14 14:14:17'),
(27, 2, 1, 'claimed', '2026-05-14 22:13:28', '0000-00-00 00:00:00', '2026-05-14 22:13:46', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000027', '2026-05-14 14:13:28', '2026-05-14 14:13:46'),
(28, 2, 1, 'claimed', '2026-05-14 22:15:15', '0000-00-00 00:00:00', '2026-05-14 22:15:34', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000028', '2026-05-14 14:15:15', '2026-05-14 14:15:34'),
(29, 2, 2, 'claimed', '2026-05-14 22:15:20', '0000-00-00 00:00:00', '2026-05-15 01:43:49', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000029', '2026-05-14 14:15:20', '2026-05-14 17:43:49'),
(30, 2, 1, 'claimed', '2026-05-15 01:41:46', '0000-00-00 00:00:00', '2026-05-15 01:42:18', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000030', '2026-05-14 17:41:46', '2026-05-14 17:42:18'),
(31, 2, 2, 'claimed', '2026-05-15 01:41:50', '0000-00-00 00:00:00', '2026-05-15 01:43:55', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000031', '2026-05-14 17:41:50', '2026-05-14 17:43:55'),
(32, 2, 1, 'claimed', '2026-05-15 01:46:13', '0000-00-00 00:00:00', '2026-05-15 01:46:47', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000032', '2026-05-14 17:46:13', '2026-05-14 17:46:47'),
(33, 2, 2, 'claimed', '2026-05-15 01:46:17', '0000-00-00 00:00:00', '2026-05-15 01:55:29', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000033', '2026-05-14 17:46:17', '2026-05-14 17:55:29'),
(34, 2, 1, 'claimed', '2026-05-15 03:05:55', '0000-00-00 00:00:00', '2026-05-15 03:06:14', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000034', '2026-05-14 19:05:55', '2026-05-14 19:06:14'),
(35, 2, 2, 'claimed', '2026-05-15 03:05:59', '0000-00-00 00:00:00', '2026-05-15 03:06:49', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000035', '2026-05-14 19:05:59', '2026-05-14 19:06:49'),
(36, 2, 1, 'claimed', '2026-05-15 09:50:05', '0000-00-00 00:00:00', '2026-05-15 09:50:44', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000036', '2026-05-15 01:50:05', '2026-05-15 01:50:44'),
(37, 2, 2, 'claimed', '2026-05-16 11:28:26', '0000-00-00 00:00:00', '2026-07-16 11:31:53', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000037', '2026-05-16 03:28:26', '2026-07-16 03:31:53'),
(38, 2, 1, 'claimed', '2026-05-16 11:28:29', '0000-00-00 00:00:00', '2026-05-16 11:28:50', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000038', '2026-05-16 03:28:29', '2026-05-16 03:28:50'),
(39, 4, 1, 'claimed', '2026-09-16 11:32:39', '0000-00-00 00:00:00', '2026-05-16 09:47:02', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000039', '2026-09-16 03:32:39', '2026-05-16 01:47:02'),
(40, 4, 2, 'claimed', '2026-09-16 11:32:44', '0000-00-00 00:00:00', '2026-05-17 02:18:36', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000040', '2026-09-16 03:32:44', '2026-05-16 18:18:36'),
(41, 2, 1, 'claimed', '2026-05-21 09:20:58', '0000-00-00 00:00:00', '2026-05-21 09:21:25', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000041', '2026-05-21 01:20:58', '2026-05-21 01:21:25'),
(42, 2, 2, 'expired', '2026-05-21 09:21:04', '0000-00-00 00:00:00', NULL, NULL, 'Automatically expired after reaching expiration date', 'REQ-2026-000042', '2026-05-21 01:21:04', '2026-05-21 15:23:45'),
(43, 2, 2, 'cancelled', '2026-05-22 01:31:17', '0000-00-00 00:00:00', '2026-05-22 01:40:04', 2, 'Cancelled by user', 'REQ-2026-000043', '2026-05-21 17:31:17', '2026-05-21 17:40:04'),
(44, 4, 2, 'cancelled', '2026-05-22 01:46:01', '0000-00-00 00:00:00', '2026-05-22 01:46:06', 4, 'Cancelled by user', 'REQ-2026-000044', '2026-05-21 17:46:01', '2026-05-21 17:46:06'),
(45, 2, 2, 'cancelled', '2026-05-22 01:47:17', '0000-00-00 00:00:00', '2026-05-22 01:47:20', 2, 'Cancelled by user', 'REQ-2026-000045', '2026-05-21 17:47:17', '2026-05-21 17:47:20'),
(46, 2, 1, 'expired', '2026-05-22 02:01:32', '0000-00-00 00:00:00', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000046', '2026-05-21 18:01:32', '2026-05-21 18:01:37'),
(47, 2, 1, 'expired', '2026-05-22 02:03:16', '0000-00-00 00:00:00', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000047', '2026-05-21 18:03:16', '2026-05-21 18:03:27'),
(48, 2, 1, 'expired', '2026-05-22 02:03:57', '0000-00-00 00:00:00', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000048', '2026-05-21 18:03:57', '2026-05-21 18:04:37'),
(49, 2, 1, 'expired', '2026-05-22 02:06:22', '0000-00-00 00:00:00', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000049', '2026-05-21 18:06:22', '2026-05-21 18:06:37'),
(50, 2, 1, 'cancelled', '2026-05-22 02:09:24', '2026-05-25 02:09:24', '2026-05-22 02:09:40', 2, 'Cancelled by user', 'REQ-2026-000050', '2026-05-21 18:09:24', '2026-05-21 18:09:40'),
(51, 5, 1, 'cancelled', '2026-05-22 02:39:10', '2026-05-25 02:39:10', '2026-05-22 02:45:58', 5, 'Cancelled by user', 'REQ-2026-000051', '2026-05-21 18:39:10', '2026-05-21 18:45:58'),
(52, 5, 1, 'cancelled', '2026-05-22 02:46:03', '2026-05-25 02:46:03', '2026-05-23 01:14:17', 5, 'Cancelled by user', 'REQ-2026-000052', '2026-05-21 18:46:03', '2026-05-22 17:14:17'),
(53, 5, 1, 'cancelled', '2026-05-23 00:29:13', '2026-05-26 00:29:13', '2026-05-23 01:14:58', 5, 'Cancelled by user', 'REQ-2026-000053', '2026-05-22 16:29:13', '2026-05-22 17:14:58'),
(54, 5, 2, 'cancelled', '2026-05-23 01:09:42', '2026-05-26 01:09:42', '2026-05-23 01:31:35', 5, 'Cancelled by user', 'REQ-2026-000054', '2026-05-22 17:09:42', '2026-05-22 17:31:35'),
(55, 6, 2, 'expired', '2026-05-23 01:10:15', '2026-05-26 01:10:15', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000055', '2026-05-22 17:10:15', '2026-05-26 11:56:42'),
(56, 5, 1, 'cancelled', '2026-05-23 01:15:39', '2026-05-26 01:15:39', '2026-05-23 01:15:48', 5, 'Cancelled by user', 'REQ-2026-000056', '2026-05-22 17:15:39', '2026-05-22 17:15:48'),
(57, 5, 1, 'cancelled', '2026-05-23 01:15:56', '2026-05-26 01:15:56', '2026-05-23 01:16:13', 5, 'Cancelled by user', 'REQ-2026-000057', '2026-05-22 17:15:56', '2026-05-22 17:16:13'),
(58, 5, 1, 'cancelled', '2026-05-23 01:28:44', '2026-05-26 01:28:44', '2026-05-23 01:29:00', 5, 'Cancelled by user', 'REQ-2026-000058', '2026-05-22 17:28:44', '2026-05-22 17:29:00'),
(59, 5, 1, 'cancelled', '2026-05-23 01:30:01', '2026-05-26 01:30:01', '2026-05-23 01:30:19', 5, 'Cancelled by user', 'REQ-2026-000059', '2026-05-22 17:30:01', '2026-05-22 17:30:19'),
(60, 5, 2, 'cancelled', '2026-05-23 01:31:48', '2026-05-26 01:31:48', '2026-05-23 01:32:59', 5, 'Cancelled by user', 'REQ-2026-000060', '2026-05-22 17:31:48', '2026-05-22 17:32:59'),
(61, 4, 1, 'claimed', '2026-05-23 01:32:24', '2026-05-26 01:32:24', '2026-05-26 19:56:47', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000061', '2026-05-22 17:32:24', '2026-05-26 11:56:47'),
(62, 4, 2, 'expired', '2026-05-23 01:32:29', '2026-05-26 01:32:29', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000062', '2026-05-22 17:32:29', '2026-05-26 11:56:42'),
(63, 5, 2, 'claimed', '2026-05-23 03:11:12', '2026-05-26 03:11:12', '2026-07-23 03:58:13', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000063', '2026-05-22 19:11:12', '2026-07-22 19:58:13'),
(64, 4, 1, 'claimed', '2026-05-26 19:58:50', '2026-05-29 19:58:50', '2026-05-26 19:59:22', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000064', '2026-05-26 11:58:50', '2026-05-26 11:59:22'),
(65, 4, 1, 'claimed', '2026-05-26 20:24:13', '2026-05-29 20:24:13', '2026-05-26 20:24:39', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000065', '2026-05-26 12:24:13', '2026-05-26 12:24:39'),
(66, 6, 1, 'claimed', '2026-05-26 20:25:09', '2026-05-29 20:25:09', '2026-05-26 20:39:25', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000066', '2026-05-26 12:25:09', '2026-05-26 12:39:25'),
(67, 5, 1, 'cancelled', '2026-05-26 22:37:34', '2026-05-29 22:37:34', '2026-05-26 22:37:38', 5, 'Cancelled by user', 'REQ-2026-000067', '2026-05-26 14:37:34', '2026-05-26 14:37:38'),
(68, 2, 1, 'claimed', '2026-05-26 22:38:54', '2026-05-29 22:38:54', '2026-05-26 22:39:09', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000068', '2026-05-26 14:38:54', '2026-05-26 14:39:09'),
(69, 4, 1, 'claimed', '2026-05-30 02:39:24', '2026-06-02 02:39:24', '2026-05-30 02:39:46', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000069', '2026-05-29 18:39:24', '2026-05-29 18:39:46'),
(70, 4, 1, 'claimed', '2026-06-30 02:45:39', '2026-07-03 02:45:39', '2026-06-30 02:45:50', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000070', '2026-06-29 18:45:39', '2026-06-29 18:45:50'),
(71, 4, 1, 'claimed', '2026-05-30 02:50:25', '2026-06-02 02:50:25', '2026-05-30 02:50:41', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000071', '2026-05-29 18:50:25', '2026-05-29 18:50:41'),
(72, 4, 1, 'claimed', '2026-06-30 02:51:31', '2026-07-03 02:51:31', '2026-06-30 02:51:42', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000072', '2026-06-29 18:51:31', '2026-06-29 18:51:42'),
(73, 4, 1, 'claimed', '2026-07-22 03:22:56', '2026-07-25 03:22:56', '2026-07-22 03:23:07', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000073', '2026-07-21 19:22:56', '2026-07-21 19:23:07'),
(74, 4, 1, 'cancelled', '2026-11-22 03:29:07', '2026-11-25 03:29:07', '2026-11-22 03:29:11', 4, 'Cancelled by user', 'REQ-2026-000074', '2026-11-21 19:29:07', '2026-11-21 19:29:11'),
(75, 4, 1, 'claimed', '2026-05-30 03:29:54', '2026-06-02 03:29:54', '2026-05-30 03:30:06', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000075', '2026-05-29 19:29:54', '2026-05-29 19:30:06'),
(76, 4, 1, 'claimed', '2026-06-23 03:54:58', '2026-06-26 03:54:58', '2026-06-23 03:55:14', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000076', '2026-06-22 19:54:58', '2026-06-22 19:55:14'),
(77, 4, 2, 'expired', '2026-06-23 03:56:58', '2026-06-26 03:56:58', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000077', '2026-06-22 19:56:58', '2026-07-22 19:58:09'),
(78, 2, 1, 'expired', '2026-07-23 03:58:37', '2026-07-26 03:58:37', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000078', '2026-07-22 19:58:37', '2026-08-22 20:00:29'),
(79, 5, 2, 'claimed', '2026-08-23 04:00:27', '2026-08-26 04:00:27', '2026-08-23 04:00:34', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000079', '2026-08-22 20:00:27', '2026-08-22 20:00:34'),
(80, 2, 1, 'cancelled', '2026-05-30 06:42:15', '2026-06-02 06:42:15', '2026-05-30 06:45:40', 2, 'Cancelled by user', 'REQ-2026-000080', '2026-05-29 22:42:15', '2026-05-29 22:45:40'),
(81, 2, 1, 'cancelled', '2026-05-30 06:45:43', '2026-06-02 06:45:43', '2026-05-30 06:45:46', 2, 'Cancelled by user', 'REQ-2026-000081', '2026-05-29 22:45:43', '2026-05-29 22:45:46'),
(82, 2, 1, 'claimed', '2026-05-30 06:45:49', '2026-06-02 06:45:49', '2026-05-30 07:07:59', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000082', '2026-05-29 22:45:49', '2026-05-29 23:07:59'),
(83, 4, 1, 'claimed', '2026-05-30 07:10:29', '2026-06-02 07:10:29', '2026-05-30 08:33:25', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000083', '2026-05-29 23:10:29', '2026-05-30 00:33:25'),
(84, 4, 2, 'claimed', '2026-05-30 08:18:40', '2026-06-02 08:18:40', '2026-05-30 08:18:56', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000084', '2026-05-30 00:18:40', '2026-05-30 00:18:56'),
(85, 5, 1, 'claimed', '2026-06-01 07:32:47', '2026-06-04 07:32:47', '2026-06-03 07:57:46', 1, 'Book marked as claimed successfully by Admin.', 'REQ-2026-000085', '2026-05-31 23:32:47', '2026-06-02 23:57:46'),
(86, 2, 1, 'expired', '2026-06-03 02:37:18', '2026-06-06 02:37:18', '2026-06-03 09:15:43', 1, 'Automatically expired after reaching expiration date.', 'REQ-2026-000086', '2026-06-02 18:37:18', '2026-06-06 14:53:42'),
(87, 2, 11, 'expired', '2026-06-03 09:53:30', '2026-06-06 09:53:30', NULL, NULL, 'Automatically expired after reaching expiration date.', 'REQ-2026-000087', '2026-06-03 01:53:30', '2026-06-06 14:43:24'),
(88, 2, 11, 'rejected', '2026-06-06 23:06:02', '0000-00-00 00:00:00', '2026-06-06 23:10:07', 1, '', NULL, '2026-06-06 15:06:02', '2026-06-06 15:10:07'),
(89, 4, 11, 'cancelled', '2026-06-06 23:10:21', '2026-06-09 23:20:13', '2026-06-08 23:29:09', 1, 'Approved request cancelled by Admin.', 'REQ-2026-000089', '2026-06-06 15:10:21', '2026-06-08 15:29:09'),
(90, 4, 11, 'cancelled', '2026-06-08 23:29:35', '2026-06-11 23:29:53', '2026-06-09 07:32:57', 4, 'Cancelled by user', 'REQ-2026-000090', '2026-06-08 15:29:35', '2026-06-08 23:32:57'),
(91, 4, 11, 'expired', '2026-06-08 23:34:05', '2026-06-11 23:59:59', '2026-06-08 23:34:21', 1, 'Automatically expired after reaching expiration date.', 'REQ-2026-000091', '2026-06-08 15:34:05', '2026-06-18 14:49:21'),
(92, 2, 11, 'expired', '2026-06-08 23:34:46', '2026-06-11 23:59:59', '2026-06-08 23:35:01', 1, 'Automatically expired after reaching expiration date.', 'REQ-2026-000092', '2026-06-08 15:34:46', '2026-06-18 14:49:21'),
(93, 5, 11, 'pending', '2026-06-18 22:46:07', '0000-00-00 00:00:00', NULL, NULL, NULL, 'REQ-2026-000093', '2026-06-18 14:46:07', '2026-06-18 14:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `borrow_request_history`
--

CREATE TABLE `borrow_request_history` (
  `id` int(11) NOT NULL,
  `borrow_request_id` int(11) NOT NULL,
  `action` enum('approved','rejected','cancelled','claimed') NOT NULL,
  `performed_at` datetime DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow_request_history`
--

INSERT INTO `borrow_request_history` (`id`, `borrow_request_id`, `action`, `performed_at`, `performed_by`, `remarks`) VALUES
(1, 21, 'approved', '2026-05-13 09:43:07', 1, 'Approved by Admin'),
(2, 21, 'cancelled', '2026-05-14 00:39:48', 1, 'kai mabaho hiya'),
(9, 25, 'approved', '2026-05-14 01:16:43', 1, 'Approved by Admin'),
(10, 25, 'claimed', '2026-05-14 01:16:47', 1, 'Book marked as claimed successfully by Admin.'),
(11, 27, 'approved', '2026-05-14 22:13:42', 1, 'Approved by Admin'),
(12, 27, 'claimed', '2026-05-14 22:13:46', 1, 'Book marked as claimed successfully by Admin.'),
(13, 26, 'approved', '2026-05-14 22:14:13', 1, 'Approved by Admin'),
(14, 26, 'claimed', '2026-05-14 22:14:17', 1, 'Book marked as claimed successfully by Admin.'),
(15, 28, 'approved', '2026-05-14 22:15:31', 1, 'Approved by Admin'),
(16, 28, 'claimed', '2026-05-14 22:15:34', 1, 'Book marked as claimed successfully by Admin.'),
(17, 29, 'approved', '2026-05-15 01:30:42', 1, 'Approved by Admin'),
(18, 30, 'approved', '2026-05-15 01:42:12', 1, 'Approved by Admin'),
(19, 31, 'approved', '2026-05-15 01:42:14', 1, 'Approved by Admin'),
(20, 30, 'claimed', '2026-05-15 01:42:18', 1, 'Book marked as claimed successfully by Admin.'),
(21, 29, 'claimed', '2026-05-15 01:43:49', 1, 'Book marked as claimed successfully by Admin.'),
(22, 31, 'claimed', '2026-05-15 01:43:55', 1, 'Book marked as claimed successfully by Admin.'),
(23, 32, 'approved', '2026-05-15 01:46:41', 1, 'Approved by Admin'),
(24, 32, 'approved', '2026-05-15 01:46:41', 1, 'Approved by Admin'),
(25, 33, 'approved', '2026-05-15 01:46:43', 1, 'Approved by Admin'),
(26, 32, 'claimed', '2026-05-15 01:46:47', 1, 'Book marked as claimed successfully by Admin.'),
(27, 33, 'claimed', '2026-05-15 01:55:29', 1, 'Book marked as claimed successfully by Admin.'),
(28, 34, 'approved', '2026-05-15 03:06:11', 1, 'Approved by Admin'),
(29, 34, 'claimed', '2026-05-15 03:06:14', 1, 'Book marked as claimed successfully by Admin.'),
(30, 35, 'approved', '2026-05-15 03:06:46', 1, 'Approved by Admin'),
(31, 35, 'claimed', '2026-05-15 03:06:49', 1, 'Book marked as claimed successfully by Admin.'),
(32, 36, 'approved', '2026-05-15 09:50:39', 1, 'Approved by Admin'),
(33, 36, 'claimed', '2026-05-15 09:50:44', 1, 'Book marked as claimed successfully by Admin.'),
(34, 37, 'approved', '2026-05-16 11:28:44', 1, 'Approved by Admin'),
(35, 38, 'approved', '2026-05-16 11:28:45', 1, 'Approved by Admin'),
(36, 38, 'claimed', '2026-05-16 11:28:50', 1, 'Book marked as claimed successfully by Admin.'),
(37, 37, 'claimed', '2026-07-16 11:31:53', 1, 'Book marked as claimed successfully by Admin.'),
(38, 39, 'approved', '2026-09-16 11:33:18', 1, 'Approved by Admin'),
(39, 40, 'approved', '2026-09-16 11:33:20', 1, 'Approved by Admin'),
(40, 40, 'approved', '2026-09-16 11:33:20', 1, 'Approved by Admin'),
(41, 39, 'claimed', '2026-05-16 09:47:02', 1, 'Book marked as claimed successfully by Admin.'),
(42, 40, 'claimed', '2026-05-17 02:18:36', 1, 'Book marked as claimed successfully by Admin.'),
(43, 41, 'approved', '2026-05-21 09:21:22', 1, 'Approved by Admin'),
(44, 41, 'claimed', '2026-05-21 09:21:25', 1, 'Book marked as claimed successfully by Admin.'),
(45, 43, 'cancelled', '2026-05-22 01:40:04', 2, 'Cancelled by user'),
(46, 44, 'cancelled', '2026-05-22 01:46:06', 4, 'Cancelled by user'),
(47, 45, 'cancelled', '2026-05-22 01:47:20', 2, 'Cancelled by user'),
(48, 50, 'cancelled', '2026-05-22 02:09:40', 2, 'Cancelled by user'),
(49, 51, 'cancelled', '2026-05-22 02:45:58', 5, 'Cancelled by user'),
(50, 52, 'approved', '2026-05-22 02:52:55', 1, 'Approved by Admin'),
(51, 53, 'approved', '2026-05-23 00:30:02', 1, 'Approved by Admin'),
(52, 52, 'cancelled', '2026-05-23 01:14:17', 5, 'Cancelled by user'),
(53, 53, 'cancelled', '2026-05-23 01:14:58', 5, 'Cancelled by user'),
(54, 54, 'approved', '2026-05-23 01:15:26', 1, 'Approved by Admin'),
(55, 56, 'approved', '2026-05-23 01:15:44', 1, 'Approved by Admin'),
(56, 56, 'cancelled', '2026-05-23 01:15:48', 5, 'Cancelled by user'),
(57, 57, 'approved', '2026-05-23 01:16:00', 1, 'Approved by Admin'),
(58, 57, 'cancelled', '2026-05-23 01:16:13', 5, 'Cancelled by user'),
(59, 58, 'approved', '2026-05-23 01:28:51', 1, 'Approved by Admin'),
(60, 58, 'cancelled', '2026-05-23 01:29:00', 5, 'Cancelled by user'),
(61, 59, 'approved', '2026-05-23 01:30:07', 1, 'Approved by Admin'),
(62, 59, 'cancelled', '2026-05-23 01:30:19', 5, 'Cancelled by user'),
(63, 54, 'cancelled', '2026-05-23 01:31:35', 5, 'Cancelled by user'),
(64, 60, 'approved', '2026-05-23 01:31:55', 1, 'Approved by Admin'),
(65, 61, 'approved', '2026-05-23 01:32:55', 1, 'Approved by Admin'),
(66, 60, 'cancelled', '2026-05-23 01:32:59', 5, 'Cancelled by user'),
(67, 63, 'approved', '2026-05-23 03:11:42', 1, 'Approved by Admin'),
(68, 61, 'claimed', '2026-05-26 19:56:47', 1, 'Book marked as claimed successfully by Admin.'),
(69, 64, 'approved', '2026-05-26 19:59:02', 1, 'Approved by Admin'),
(70, 64, 'claimed', '2026-05-26 19:59:22', 1, 'Book marked as claimed successfully by Admin.'),
(71, 65, 'approved', '2026-05-26 20:24:20', 1, 'Approved by Admin'),
(72, 65, 'claimed', '2026-05-26 20:24:39', 1, 'Book marked as claimed successfully by Admin.'),
(73, 66, 'approved', '2026-05-26 20:38:59', 1, 'Approved by Admin'),
(74, 66, 'claimed', '2026-05-26 20:39:25', 1, 'Book marked as claimed successfully by Admin.'),
(75, 67, 'cancelled', '2026-05-26 22:37:38', 5, 'Cancelled by user'),
(76, 68, 'approved', '2026-05-26 22:39:00', 1, 'Approved by Admin'),
(77, 68, 'claimed', '2026-05-26 22:39:09', 1, 'Book marked as claimed successfully by Admin.'),
(78, 69, 'approved', '2026-05-30 02:39:34', 1, 'Approved by Admin'),
(79, 69, 'claimed', '2026-05-30 02:39:46', 1, 'Book marked as claimed successfully by Admin.'),
(80, 70, 'approved', '2026-06-30 02:45:43', 1, 'Approved by Admin'),
(81, 70, 'claimed', '2026-06-30 02:45:50', 1, 'Book marked as claimed successfully by Admin.'),
(82, 71, 'approved', '2026-05-30 02:50:31', 1, 'Approved by Admin'),
(83, 71, 'claimed', '2026-05-30 02:50:41', 1, 'Book marked as claimed successfully by Admin.'),
(84, 72, 'approved', '2026-06-30 02:51:38', 1, 'Approved by Admin'),
(85, 72, 'claimed', '2026-06-30 02:51:42', 1, 'Book marked as claimed successfully by Admin.'),
(86, 73, 'approved', '2026-07-22 03:23:03', 1, 'Approved by Admin'),
(87, 73, 'claimed', '2026-07-22 03:23:07', 1, 'Book marked as claimed successfully by Admin.'),
(88, 74, 'cancelled', '2026-11-22 03:29:11', 4, 'Cancelled by user'),
(89, 75, 'approved', '2026-05-30 03:30:03', 1, 'Approved by Admin'),
(90, 75, 'claimed', '2026-05-30 03:30:06', 1, 'Book marked as claimed successfully by Admin.'),
(91, 76, 'approved', '2026-06-23 03:55:05', 1, 'Approved by Admin'),
(92, 76, 'claimed', '2026-06-23 03:55:14', 1, 'Book marked as claimed successfully by Admin.'),
(93, 63, 'claimed', '2026-07-23 03:58:13', 1, 'Book marked as claimed successfully by Admin.'),
(94, 79, 'approved', '2026-08-23 04:00:31', 1, 'Approved by Admin'),
(95, 79, 'claimed', '2026-08-23 04:00:34', 1, 'Book marked as claimed successfully by Admin.'),
(96, 80, 'cancelled', '2026-05-30 06:45:40', 2, 'Cancelled by user'),
(97, 81, 'cancelled', '2026-05-30 06:45:46', 2, 'Cancelled by user'),
(98, 82, 'approved', '2026-05-30 07:07:50', 1, 'Approved by Admin'),
(99, 82, 'claimed', '2026-05-30 07:07:59', 1, 'Book marked as claimed successfully by Admin.'),
(100, 83, 'approved', '2026-05-30 08:18:45', 1, 'Approved by Admin'),
(101, 84, 'approved', '2026-05-30 08:18:51', 1, 'Approved by Admin'),
(102, 84, 'claimed', '2026-05-30 08:18:56', 1, 'Book marked as claimed successfully by Admin.'),
(103, 83, 'claimed', '2026-05-30 08:33:25', 1, 'Book marked as claimed successfully by Admin.'),
(104, 85, 'approved', '2026-06-01 07:50:30', 1, 'Approved by Admin'),
(105, 85, 'claimed', '2026-06-03 07:57:46', 1, 'Book marked as claimed successfully by Admin.'),
(106, 86, 'approved', '2026-06-03 09:15:43', 1, 'Approved by Admin'),
(107, 88, 'rejected', '2026-06-06 23:10:07', 1, ''),
(108, 89, 'approved', '2026-06-06 23:20:14', 1, 'Approved by Admin'),
(109, 89, 'cancelled', '2026-06-08 23:29:09', 1, 'Approved request cancelled by Admin.'),
(110, 90, 'approved', '2026-06-08 23:29:53', 1, 'Approved by Admin'),
(111, 90, 'cancelled', '2026-06-09 07:32:57', 4, 'Cancelled by user'),
(112, 91, 'approved', '2026-06-08 23:34:21', 1, 'Approved by Admin'),
(113, 92, 'approved', '2026-06-08 23:35:01', 1, 'Approved by Admin');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Fiction', '2026-04-30 17:34:49', '2026-05-21 01:26:38'),
(2, 'Non-Fiction', '2026-04-30 17:34:49', '2026-05-07 07:09:47'),
(3, 'Drama', '2026-04-30 17:35:21', '2026-05-08 04:00:52'),
(4, 'Mystery', '2026-04-30 17:35:21', NULL),
(5, 'Romance', '2026-04-30 17:35:41', NULL),
(6, 'Science Fiction', '2026-04-30 17:35:41', '2026-05-07 07:09:44'),
(7, 'Fantasy', '2026-04-30 17:35:58', '2026-05-07 07:26:09'),
(8, 'Horror', '2026-04-30 17:35:58', NULL),
(9, 'History', '2026-04-30 17:36:13', NULL),
(10, 'Philosophy', '2026-04-30 17:36:13', NULL),
(11, 'Religion', '2026-04-30 17:36:26', NULL),
(12, 'Politics', '2026-04-30 17:36:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fines`
--

CREATE TABLE `fines` (
  `id` int(11) NOT NULL,
  `borrowing_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fine_ref` varchar(100) NOT NULL,
  `daily_overdue_fine` int(11) NOT NULL,
  `max_fine_amount` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('paid','unpaid') NOT NULL DEFAULT 'unpaid',
  `issued_by` int(11) NOT NULL,
  `paid_at` datetime DEFAULT NULL,
  `paid_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fines`
--

INSERT INTO `fines` (`id`, `borrowing_id`, `user_id`, `fine_ref`, `daily_overdue_fine`, `max_fine_amount`, `amount`, `remarks`, `status`, `issued_by`, `paid_at`, `paid_by`, `created_at`, `updated_at`) VALUES
(1, 14, 2, 'FIN-2026-000001', 50, 1000, 850, 'Fine paid successfully.', 'paid', 1, '2026-05-30 02:01:28', 1, '2026-06-16 01:15:49', '2026-05-29 18:01:28'),
(2, 15, 2, 'FIN-2026-000002', 50, 1000, 1000, 'Fine paid successfully.', 'paid', 1, '2026-05-30 01:26:05', 1, '2026-07-16 03:29:36', '2026-05-29 17:26:05'),
(3, 16, 2, 'FIN-2026-000003', 50, 1000, 1000, '                        ', 'paid', 1, '2026-07-17 02:37:22', 1, '2026-09-16 03:32:23', '2026-07-16 18:37:22'),
(4, 18, 4, 'FIN-2026-000004', 40, 1500, 1500, 'Fine paid successfully.', 'paid', 1, '2026-07-17 02:45:56', 1, '2026-07-16 18:30:39', '2026-07-16 18:45:56'),
(5, 25, 4, 'FIN-2026-000005', 40, 1500, 640, 'Fine paid successfully.', 'paid', 1, '2026-07-22 03:01:10', 1, '2026-06-29 18:45:02', '2026-07-21 19:01:10'),
(6, 26, 4, 'FIN-2026-000006', 40, 1500, 600, 'Fine paid successfully.', 'paid', 1, '2026-07-22 03:01:00', 1, '2026-07-29 18:46:59', '2026-07-21 19:01:00'),
(7, 27, 4, 'FIN-2026-000007', 40, 1500, 680, 'Fine paid successfully.', 'paid', 1, '2026-07-22 03:01:05', 1, '2026-06-29 18:51:16', '2026-07-21 19:01:05'),
(8, 28, 4, 'FIN-2026-000008', 40, 1500, 320, 'Fine paid successfully.', 'paid', 1, '2026-07-22 03:01:02', 1, '2026-07-21 18:55:17', '2026-07-21 19:01:02'),
(9, 29, 4, 'FIN-2026-000009', 40, 1500, 1500, 'Fine paid successfully.', 'paid', 1, '2026-06-23 03:33:16', 1, '2026-11-21 19:23:42', '2026-06-22 19:33:16'),
(10, 30, 4, 'FIN-2026-000010', 40, 1500, 400, 'Fine paid successfully.', 'paid', 1, '2026-06-23 03:32:47', 1, '2026-06-22 19:32:31', '2026-06-22 19:32:47'),
(11, 31, 4, 'FIN-2026-000011', 40, 1500, 640, 'Overdue by 16 day(s).', 'unpaid', 1, NULL, NULL, '2026-07-22 19:57:39', '2026-07-22 19:57:39'),
(12, 32, 5, 'FIN-2026-000012', 40, 1500, 680, 'Overdue by 17 day(s).', 'unpaid', 1, NULL, NULL, '2026-08-22 19:59:29', '2026-08-22 19:59:29'),
(13, 33, 5, 'FIN-2026-000013', 40, 1500, 1500, 'Overdue by 47 day(s).', 'unpaid', 1, NULL, NULL, '2026-10-22 20:00:54', '2026-10-22 20:00:54');

-- --------------------------------------------------------

--
-- Table structure for table `library_settings`
--

CREATE TABLE `library_settings` (
  `id` int(11) NOT NULL,
  `borrow_days` int(11) NOT NULL,
  `max_borrow_books` int(11) NOT NULL,
  `max_reservation_books` int(11) NOT NULL,
  `reservation_expiry_days` int(11) NOT NULL,
  `daily_overdue_fine` int(11) NOT NULL,
  `max_fine_amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_settings`
--

INSERT INTO `library_settings` (`id`, `borrow_days`, `max_borrow_books`, `max_reservation_books`, `reservation_expiry_days`, `daily_overdue_fine`, `max_fine_amount`, `created_at`, `updated_at`) VALUES
(1, 15, 5, 5, 3, 40, 1500, '2026-05-08 12:10:45', '2026-07-16 18:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `status` enum('pending','fulfilled','cancelled','expired') NOT NULL DEFAULT 'pending',
  `processed_at` timestamp NULL DEFAULT NULL,
  `processed_by` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `book_id`, `reservation_date`, `expiration_date`, `status`, `processed_at`, `processed_by`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-05-22 01:05:29', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-21 17:05:29', '2026-05-21 17:14:05'),
(2, 2, 1, '2026-05-22 01:14:08', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-21 17:14:08', '2026-05-21 17:14:12'),
(3, 2, 1, '2026-05-22 01:14:44', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-21 17:14:44', '2026-05-21 17:14:50'),
(4, 4, 1, '2026-05-22 01:45:43', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-21 17:45:43', '2026-05-21 17:47:42'),
(5, 5, 1, '2026-05-22 01:46:40', NULL, 'cancelled', NULL, NULL, 'Book reserved successfully.', '2026-05-21 17:46:40', '2026-05-22 17:30:19'),
(6, 4, 1, '2026-05-22 01:47:45', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-21 17:47:45', '2026-05-22 17:09:03'),
(7, 6, 1, '2026-05-23 00:41:07', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-22 16:41:07', '2026-05-22 16:41:13'),
(8, 2, 1, '2026-05-23 00:41:50', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-22 16:41:50', '2026-05-22 16:41:53'),
(9, 4, 1, '2026-05-23 01:09:05', NULL, 'fulfilled', NULL, NULL, 'Book reserved successfully.', '2026-05-22 17:09:05', '2026-05-26 12:24:39'),
(10, 6, 1, '2026-05-23 01:10:24', NULL, 'fulfilled', NULL, NULL, 'Book reserved successfully.', '2026-05-22 17:10:24', '2026-05-26 12:39:25'),
(11, 5, 1, '2026-05-23 01:30:22', NULL, 'cancelled', NULL, NULL, 'Book reserved successfully.', '2026-05-22 17:30:22', '2026-05-26 14:37:38'),
(12, 2, 1, '2026-05-26 19:55:07', NULL, 'fulfilled', NULL, NULL, 'Book reserved successfully.', '2026-05-26 11:55:07', '2026-05-26 14:39:09'),
(13, 4, 1, '2026-05-26 22:38:24', NULL, 'fulfilled', NULL, NULL, 'Book reserved successfully.', '2026-05-26 14:38:24', '2026-05-29 18:39:46'),
(14, 2, 1, '2026-06-23 03:56:24', NULL, 'cancelled', NULL, NULL, 'Book reserved successfully.', '2026-06-22 19:56:24', '2026-05-29 22:45:40'),
(15, 4, 1, '2026-05-30 07:08:20', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-29 23:08:20', '2026-05-29 23:08:27'),
(16, 4, 1, '2026-05-30 07:08:29', NULL, 'fulfilled', NULL, NULL, 'Book reserved successfully.', '2026-05-29 23:08:29', '2026-05-30 00:33:25'),
(17, 2, 1, '2026-06-30 08:50:40', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-06-30 00:50:40', '2026-06-30 02:54:50'),
(18, 2, 2, '2026-06-30 10:54:37', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-06-30 02:54:37', '2026-05-31 23:23:14'),
(19, 2, 2, '2026-06-01 07:24:56', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-31 23:24:56', '2026-05-31 23:25:02'),
(20, 2, 2, '2026-06-01 07:25:05', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-31 23:25:05', '2026-05-31 23:27:54'),
(21, 5, 2, '2026-06-01 07:27:18', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-31 23:27:18', '2026-05-31 23:27:34'),
(22, 5, 2, '2026-06-01 07:28:48', NULL, 'cancelled', NULL, NULL, 'Cancelled by user', '2026-05-31 23:28:48', '2026-05-31 23:32:06'),
(23, 5, 2, '2026-06-01 07:32:15', NULL, 'pending', NULL, NULL, 'Book reserved successfully.', '2026-05-31 23:32:15', '2026-05-31 23:32:15'),
(24, 4, 2, '2026-06-04 09:21:47', NULL, 'pending', NULL, NULL, 'Book reserved successfully.', '2026-06-04 01:21:47', '2026-06-04 01:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '2026-04-29 00:00:34', NULL),
(2, 2, 'staff', '2026-04-29 00:00:34', NULL),
(3, 3, 'user', '2026-04-29 00:00:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `staff_level_id` int(11) DEFAULT NULL,
  `can_manage_users` tinyint(1) NOT NULL,
  `can_manage_books` tinyint(1) NOT NULL,
  `can_process_borrow_requests` tinyint(1) NOT NULL,
  `can_manage_borrowed_books` tinyint(1) NOT NULL,
  `can_extend_borrowings` tinyint(1) NOT NULL,
  `can_process_returns` tinyint(1) NOT NULL,
  `can_manage_fines` tinyint(1) NOT NULL,
  `can_manage_settings` tinyint(1) NOT NULL,
  `can_manage_roles_permissions` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `staff_level_id`, `can_manage_users`, `can_manage_books`, `can_process_borrow_requests`, `can_manage_borrowed_books`, `can_extend_borrowings`, `can_process_returns`, `can_manage_fines`, `can_manage_settings`, `can_manage_roles_permissions`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 1, 1, 0, 1, 1, 1, 0, 1, NULL, '2026-05-21 03:19:21'),
(2, 2, 4, 1, 1, 1, 1, 1, 0, 1, 0, 1, NULL, '2026-05-21 03:19:20'),
(3, 2, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, NULL, '2026-05-21 03:19:12'),
(4, 2, 2, 1, 1, 1, 1, 1, 0, 1, 0, 0, NULL, '2026-05-21 03:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `staff_levels`
--

CREATE TABLE `staff_levels` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_levels`
--

INSERT INTO `staff_levels` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Assistant Librarian', '2026-04-29 16:24:40', NULL),
(2, 'Librarian', '2026-04-29 16:24:40', NULL),
(4, 'Head Librarian', '2026-04-29 16:25:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `library_id` varchar(20) NOT NULL,
  `staff_level_id` int(11) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(5) NOT NULL,
  `status` enum('activated','deactivated') NOT NULL DEFAULT 'activated',
  `must_change_password` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `library_id`, `staff_level_id`, `full_name`, `email`, `contact_number`, `password`, `role_id`, `status`, `must_change_password`, `created_at`, `updated_at`) VALUES
(1, 'LIB-2026-0001', NULL, 'System Administrator', 'admin@librago.com', '00000000000', '$2y$10$iXO.1E9VvKzKOWRoNtdinOCW8ALpYVrlegQE3.5i.Tcx5i4bfvdJe', 1, 'activated', 0, '2026-04-29 16:43:45', NULL),
(2, 'LIB-2026-0002', NULL, 'James Emmanuel Palongpong Fernandez', 'james.fernandez1239@gmail.com', '09310241773', '$2y$10$7mltbXSs2yY8Zl7Nh/MGXu8rx.KwPuVvK6hk0mJSd6fSjmKe1B1Pm', 3, 'activated', 0, '2026-05-05 18:07:45', '2026-06-02 18:05:08'),
(4, 'LIB-2026-0004', NULL, 'James Emmanuel Palongpong Fernandez', 'james.fernandez1230@gmail.com', '09310241773', '$2y$10$zU0nLuw291hpziUc8iZMNO..58aQFn47m4nVM3TzOi3BbrSmt/y.y', 3, 'activated', 0, '2026-05-07 02:02:34', '2026-05-07 02:02:34'),
(5, 'LIB-2026-0005', NULL, 'James Emmanuel Palongpong Fernandez', 'james.fernandez1238@gmail.com', '09310241773', '$2y$10$ulKliSKUC0MHbGjn4c2QsOVYSt1FeV0ZfL2Alt7AvXpMLEEZoEjIG', 3, 'activated', 0, '2026-05-07 02:02:47', '2026-06-30 01:21:46'),
(6, 'LIB-2026-0006', NULL, 'James Emmanuel Palongpong Fernandez', 'james.fernandez1237@gmail.com', '09310241773', '$2y$10$//riO5ldYxqEeazn0jeqEea1uz8IZm2uA.gdbiRZnQAESSPoBvl4a', 3, 'activated', 0, '2026-05-07 02:03:24', '2026-06-02 01:39:58'),
(7, 'LIB-2026-4C9587', 1, 'Wakawaka', 'wakawaka@gmail.com', '09310241773', '$2y$10$1ABnfoUxl15aQ9BR17yo0u8W3oqdYteUqvE.4ZGXoXoGErweceqWq', 2, 'deactivated', 1, '2026-06-02 05:09:18', '2026-06-02 05:29:28'),
(8, 'LIB-2026-0008', 4, 'Wakawaka', 'wakawaka2@gmail.com', '09310241773', '$2y$10$iqybIckqA.Gsw00mf3PEr.DUfSUZmhqGSrI.H5Luj7L/t2paET3Cy', 2, 'activated', 1, '2026-06-02 05:29:54', '2026-06-02 05:29:54'),
(9, 'LIB-2026-0009', NULL, 'asdasda', 'sdasd@asda.com', 'asdasd', '$2y$10$8VOYx8fza5Ggt2LW/Z3gkusbosuCECEFpfc2Yck2p8rOqGOSfTKPW', 3, 'deactivated', 1, '2026-06-02 16:42:33', '2026-06-02 16:42:44'),
(10, 'LIB-2026-0010', NULL, 'asad', 'asdasd239@gmail.com', 'asd', '$2y$10$a1TcUBWU6ck3fVuyM.spgOr17PC8Q72QTHBXtakBbOuK5KuOdeuc6', 3, 'deactivated', 1, '2026-06-02 18:05:22', '2026-06-02 18:06:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `borrow_request_id` (`borrow_request_id`);

--
-- Indexes for table `borrowing_history`
--
ALTER TABLE `borrowing_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowing_id` (`borrowing_id`);

--
-- Indexes for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrow_requests_ibfk_1` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `borrow_request_history`
--
ALTER TABLE `borrow_request_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrow_request_id` (`borrow_request_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fines`
--
ALTER TABLE `fines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `borrowing_id` (`borrowing_id`);

--
-- Indexes for table `library_settings`
--
ALTER TABLE `library_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `processed_by` (`processed_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `staff_level_id` (`staff_level_id`);

--
-- Indexes for table `staff_levels`
--
ALTER TABLE `staff_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `library_id` (`library_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `staff_level_id` (`staff_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `borrowing_history`
--
ALTER TABLE `borrowing_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `borrow_request_history`
--
ALTER TABLE `borrow_request_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `fines`
--
ALTER TABLE `fines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `library_settings`
--
ALTER TABLE `library_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff_levels`
--
ALTER TABLE `staff_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowings_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `borrowings_ibfk_3` FOREIGN KEY (`borrow_request_id`) REFERENCES `borrow_requests` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `borrowing_history`
--
ALTER TABLE `borrowing_history`
  ADD CONSTRAINT `borrowing_history_ibfk_1` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `borrow_requests`
--
ALTER TABLE `borrow_requests`
  ADD CONSTRAINT `borrow_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `borrow_requests_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `borrow_request_history`
--
ALTER TABLE `borrow_request_history`
  ADD CONSTRAINT `borrow_request_history_ibfk_1` FOREIGN KEY (`borrow_request_id`) REFERENCES `borrow_requests` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `fines`
--
ALTER TABLE `fines`
  ADD CONSTRAINT `fines_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fines_ibfk_2` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`staff_level_id`) REFERENCES `staff_levels` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`staff_level_id`) REFERENCES `staff_levels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
