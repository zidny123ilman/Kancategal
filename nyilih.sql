-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 09, 2026 at 07:11 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nyilih`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `action`, `details`, `created_at`, `updated_at`) VALUES
(1, 'MEMBER CREATED', 'Admin created member Ahmad Dani', '2026-06-26 01:42:17', '2026-06-26 01:42:17'),
(2, 'ACCESS REVOKED', 'Admin disabled borrowing access for Ahmad Dani', '2026-06-26 01:46:31', '2026-06-26 01:46:31'),
(3, 'ACCESS GRANTED', 'Admin enabled borrowing access for Ahmad Dani', '2026-06-26 01:47:09', '2026-06-26 01:47:09'),
(4, 'ACCESS GRANTED', 'Admin enabled borrowing access for Riana Kusuma', '2026-06-26 01:47:11', '2026-06-26 01:47:11'),
(5, 'ACCESS GRANTED', 'Admin enabled article upload access for Riana Kusuma', '2026-06-26 01:47:12', '2026-06-26 01:47:12'),
(6, 'ACCESS REVOKED', 'Admin disabled article upload access for Riana Kusuma', '2026-06-26 01:47:30', '2026-06-26 01:47:30'),
(7, 'DATA EXPORT', 'Admin exported member list to CSV file members_export_20260626_084753.csv', '2026-06-26 01:47:53', '2026-06-26 01:47:53'),
(8, 'MEMBER DELETED', 'Admin deleted member Ahmad Dani', '2026-06-26 01:52:03', '2026-06-26 01:52:03'),
(9, 'DATA EXPORT', 'Admin exported member list to CSV file members_export_20260626_085322.csv', '2026-06-26 01:53:22', '2026-06-26 01:53:22'),
(10, 'DATA EXPORT', 'Admin exported member list to CSV file members_export_20260626_085518.csv', '2026-06-26 01:55:18', '2026-06-26 01:55:18'),
(11, 'MEMBER STATUS CHANGED', 'Admin changed status of Riana Kusuma from ACTIVE to SUSPENDED', '2026-06-26 01:59:35', '2026-06-26 01:59:35'),
(12, 'MEMBER STATUS CHANGED', 'Admin changed status of Riana Kusuma from SUSPENDED to ACTIVE', '2026-06-26 01:59:50', '2026-06-26 01:59:50'),
(13, 'MEMBER STATUS CHANGED', 'Admin changed status of Riana Kusuma from ACTIVE to SUSPENDED', '2026-06-26 02:00:29', '2026-06-26 02:00:29'),
(14, 'MEMBER STATUS CHANGED', 'Admin changed status of Riana Kusuma from SUSPENDED to ACTIVE', '2026-06-26 02:00:54', '2026-06-26 02:00:54'),
(15, 'CONTENT_HERO_TITLE', 'Admin updated Hero Title to: KANCA\r\nTEGAL\r\nBARU', '2026-06-26 10:11:56', '2026-06-26 10:11:56'),
(16, 'CONTENT_HERO_SUBTITLE', 'Admin updated Hero Subtitle to: A creative community that dedicated to the preservation of l...', '2026-06-26 10:11:56', '2026-06-26 10:11:56'),
(17, 'CONTENT_SCHEDULE', 'Admin updated Schedule Info to: Kanca Tegal open 10.00-22.00 everyday', '2026-06-26 10:11:56', '2026-06-26 10:11:56'),
(18, 'CONTENT_MAP_LABEL', 'Admin updated Map Label to: LAPAK KAMI: Taman Kota Tegal', '2026-06-26 10:11:56', '2026-06-26 10:11:56'),
(19, 'CONTENT_MAP_EMBED', 'Admin updated Map Embed Url to: https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.0...', '2026-06-26 10:11:56', '2026-06-26 10:11:56'),
(20, 'CONTENT_HERO_TITLE', 'Admin updated Hero Title to: NYILIH | KANCA TEGAL', '2026-06-26 10:28:43', '2026-06-26 10:28:43'),
(21, 'CONTENT_HERO_SUBTITLE', 'Admin updated Hero Subtitle to: NETWORKED YIELDING INFORMATION FOR LITERACY HUB -  Menghubun...', '2026-06-26 10:28:43', '2026-06-26 10:28:43'),
(22, 'CONTENT_SCHEDULE', 'Admin updated Schedule Info to: Kanca Tegal open 20.00 - Ngantuk!!', '2026-06-26 10:28:43', '2026-06-26 10:28:43'),
(23, 'CONTENT_MAP_LABEL', 'Admin updated Map Label to: LAPAK KAMI: Alun-alun Kota Tegal Sebelah Utara', '2026-06-26 10:28:43', '2026-06-26 10:28:43'),
(24, 'CONTENT_MAP_EMBED', 'Admin updated Map Embed Url to: https://maps.app.goo.gl/KRA6Ppw1dcxXeDeMA', '2026-06-26 10:28:43', '2026-06-26 10:28:43'),
(25, 'CONTENT_MAP_EMBED', 'Admin updated Map Embed Url to: @-6.8674333,109.1353434,16z/data=!3m1!4b1!4m6!3m5!1s0x2e6fb7...', '2026-06-26 10:31:04', '2026-06-26 10:31:04'),
(26, 'CONTENT_MAP_EMBED', 'Admin updated Map Embed Url to: https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7922.3...', '2026-06-26 10:33:36', '2026-06-26 10:33:36'),
(27, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings, Admin Credentials, Borrowing Rules, WhatsApp Integration', '2026-06-26 11:34:57', '2026-06-26 11:34:57'),
(28, 'DATABASE_BACKUP', 'Admin downloaded database backup SQL file.', '2026-06-26 11:36:19', '2026-06-26 11:36:19'),
(29, 'SYSTEM_MAINTENANCE', 'Admin cleared the application cache (views, config, cache).', '2026-06-26 11:37:09', '2026-06-26 11:37:09'),
(30, 'DATABASE_BACKUP', 'Admin downloaded database backup SQL file.', '2026-06-26 11:37:42', '2026-06-26 11:37:42'),
(31, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 11:38:38', '2026-06-26 11:38:38'),
(32, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 11:39:16', '2026-06-26 11:39:16'),
(33, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 11:39:40', '2026-06-26 11:39:40'),
(34, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 11:39:49', '2026-06-26 11:39:49'),
(35, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 11:39:57', '2026-06-26 11:39:57'),
(36, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: Borrowing Rules', '2026-06-26 11:40:15', '2026-06-26 11:40:15'),
(37, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-26 11:46:50', '2026-06-26 11:46:50'),
(38, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-26 11:47:22', '2026-06-26 11:47:22'),
(39, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: Admin Credentials', '2026-06-26 11:48:25', '2026-06-26 11:48:25'),
(40, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-26 11:49:22', '2026-06-26 11:49:22'),
(41, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-26 11:50:16', '2026-06-26 11:50:16'),
(42, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-26 12:05:19', '2026-06-26 12:05:19'),
(43, 'SYSTEM_MAINTENANCE', 'Admin cleared the application cache (views, config, cache).', '2026-06-26 12:05:33', '2026-06-26 12:05:33'),
(44, 'DATABASE_BACKUP', 'Admin downloaded database backup SQL file.', '2026-06-26 12:05:41', '2026-06-26 12:05:41'),
(45, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: Borrowing Rules', '2026-06-26 12:07:21', '2026-06-26 12:07:21'),
(46, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 12:07:39', '2026-06-26 12:07:39'),
(47, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 12:07:55', '2026-06-26 12:07:55'),
(48, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-26 12:15:34', '2026-06-26 12:15:34'),
(49, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-26 12:16:21', '2026-06-26 12:16:21'),
(50, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-26 12:16:54', '2026-06-26 12:16:54'),
(51, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP ::1', '2026-06-26 12:17:55', '2026-06-26 12:17:55'),
(52, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings, WhatsApp Integration', '2026-06-26 12:18:44', '2026-06-26 12:18:44'),
(53, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: General Settings', '2026-06-26 12:19:16', '2026-06-26 12:19:16'),
(54, 'ACCESS GRANTED', 'Admin enabled article upload access for zidny', '2026-06-26 13:12:33', '2026-06-26 13:12:33'),
(55, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-29 08:22:17', '2026-06-29 08:22:17'),
(56, 'MEMBER DELETED', 'Admin deleted member Budi Santoso', '2026-06-29 08:24:45', '2026-06-29 08:24:45'),
(57, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-29 09:20:25', '2026-06-29 09:20:25'),
(58, 'LOAN APPROVED', 'Admin menyetujui peminjaman buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-06-29 09:28:09', '2026-06-29 09:28:09'),
(59, 'RETURN APPROVED', 'Admin menyetujui pengembalian buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-06-29 09:28:50', '2026-06-29 09:28:50'),
(60, 'LOAN APPROVED', 'Admin menyetujui peminjaman buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-06-29 09:32:04', '2026-06-29 09:32:04'),
(61, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-29 09:32:32', '2026-06-29 09:32:32'),
(62, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-29 09:34:28', '2026-06-29 09:34:28'),
(63, 'ACCESS REVOKED', 'Admin disabled borrowing access for Riana Kusuma', '2026-06-29 09:34:47', '2026-06-29 09:34:47'),
(64, 'ACCESS GRANTED', 'Admin enabled borrowing access for Riana Kusuma', '2026-06-29 09:35:14', '2026-06-29 09:35:14'),
(65, 'ADMIN_LOGIN_SUCCESS', 'Admin successfully logged in from IP 127.0.0.1', '2026-06-29 11:12:40', '2026-06-29 11:12:40'),
(66, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: Borrowing Rules', '2026-06-29 11:39:27', '2026-06-29 11:39:27'),
(67, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-29 12:05:54', '2026-06-29 12:05:54'),
(68, 'ADMIN_LOGIN_SUCCESS', 'Admin 2 (admin2) successfully logged in from IP 127.0.0.1', '2026-06-29 12:06:26', '2026-06-29 12:06:26'),
(69, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin@gmail.com', '2026-06-29 12:06:54', '2026-06-29 12:06:54'),
(70, 'ADMIN_LOGIN_SUCCESS', 'Admin (admin) successfully logged in from IP 127.0.0.1', '2026-06-29 12:07:05', '2026-06-29 12:07:05'),
(71, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin', '2026-06-29 12:07:30', '2026-06-29 12:07:30'),
(72, 'SETTINGS_UPDATE', 'Admin updated system settings. Sections changed: Admin Credentials', '2026-06-29 12:09:02', '2026-06-29 12:09:02'),
(73, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-06-29 12:09:32', '2026-06-29 12:09:32'),
(74, 'ADMIN_LOGIN_SUCCESS', 'Irfan Maulana (admin2) successfully logged in from IP 127.0.0.1', '2026-06-29 12:09:56', '2026-06-29 12:09:56'),
(75, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin1', '2026-06-29 12:33:30', '2026-06-29 12:33:30'),
(76, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: admin1', '2026-06-29 12:33:34', '2026-06-29 12:33:34'),
(77, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-06-29 12:34:36', '2026-06-29 12:34:36'),
(78, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-06-30 02:13:55', '2026-06-30 02:13:55'),
(79, 'RETURN REJECTED', 'Admin (Zidny Ilman) menolak pengembalian buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-06-30 02:17:19', '2026-06-30 02:17:19'),
(80, 'RETURN APPROVED', 'Admin (Zidny Ilman) menyetujui pengembalian buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-06-30 02:17:56', '2026-06-30 02:17:56'),
(81, 'CONTENT_HERO_IMAGE', 'Zidny Ilman uploaded a new Hero Background image (1782812149_6a438df5b3d6d.jpg).', '2026-06-30 02:35:49', '2026-06-30 02:35:49'),
(82, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-06-30 10:27:18', '2026-06-30 10:27:18'),
(83, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-06-30 10:44:16', '2026-06-30 10:44:16'),
(84, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-06-30 10:44:53', '2026-06-30 10:44:53'),
(85, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-06-30 10:47:21', '2026-06-30 10:47:21'),
(86, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: Borrowing Rules', '2026-06-30 10:49:01', '2026-06-30 10:49:01'),
(87, 'SYSTEM_MAINTENANCE', 'Zidny Ilman cleared the application cache (views, config, cache).', '2026-06-30 10:49:13', '2026-06-30 10:49:13'),
(88, 'SYSTEM_MAINTENANCE', 'Zidny Ilman cleared the application cache (views, config, cache).', '2026-06-30 10:54:13', '2026-06-30 10:54:13'),
(89, 'ACCESS REVOKED', 'Admin (Zidny Ilman) disabled borrowing access for zidny', '2026-06-30 10:58:24', '2026-06-30 10:58:24'),
(90, 'ACCESS REVOKED', 'Admin (Zidny Ilman) disabled article upload access for zidny', '2026-06-30 10:58:25', '2026-06-30 10:58:25'),
(91, 'ACCESS GRANTED', 'Admin (Zidny Ilman) enabled borrowing access for zidny', '2026-06-30 10:58:30', '2026-06-30 10:58:30'),
(92, 'ACCESS GRANTED', 'Admin (Zidny Ilman) enabled article upload access for zidny', '2026-06-30 10:58:33', '2026-06-30 10:58:33'),
(93, 'MEMBER STATUS CHANGED', 'Admin (Zidny Ilman) changed status of zidny from ACTIVE to SUSPENDED', '2026-06-30 10:58:43', '2026-06-30 10:58:43'),
(94, 'MEMBER STATUS CHANGED', 'Admin (Zidny Ilman) changed status of zidny from SUSPENDED to ACTIVE', '2026-06-30 10:59:30', '2026-06-30 10:59:30'),
(95, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 00:15:55', '2026-07-08 00:15:55'),
(96, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-07-08 00:36:34', '2026-07-08 00:36:34'),
(97, 'LOAN APPROVED', 'Admin (Zidny Ilman) menyetujui peminjaman buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-07-08 01:36:24', '2026-07-08 01:36:24'),
(98, 'RETURN APPROVED', 'Admin (Zidny Ilman) menyetujui pengembalian buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-07-08 01:37:13', '2026-07-08 01:37:13'),
(99, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: administrator@kancategal.com', '2026-07-08 01:59:59', '2026-07-08 01:59:59'),
(100, 'ADMIN_LOGIN_FAILED', 'Failed admin login attempt using username: administrator@kancategal.com', '2026-07-08 02:00:34', '2026-07-08 02:00:34'),
(101, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: Popup Settings', '2026-07-08 03:03:50', '2026-07-08 03:03:50'),
(102, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: Popup Settings', '2026-07-08 03:04:31', '2026-07-08 03:04:31'),
(103, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: Popup Settings', '2026-07-08 03:05:20', '2026-07-08 03:05:20'),
(104, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: WhatsApp Integration', '2026-07-08 03:18:45', '2026-07-08 03:18:45'),
(105, 'LOAN APPROVED', 'Admin (Zidny Ilman) menyetujui peminjaman buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-07-08 03:37:30', '2026-07-08 03:37:30'),
(106, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 03:57:56', '2026-07-08 03:57:56'),
(107, 'LOAN APPROVED', 'Admin (Zidny Ilman) menyetujui peminjaman buku \"Bumi Manusia\" oleh member \"Annisa\"', '2026-07-08 03:58:07', '2026-07-08 03:58:07'),
(108, 'OVERDUE REMINDER SENT', 'Admin (Zidny Ilman) mengirim peringatan terlambat WhatsApp ke member \"zidny\" untuk buku \"Tegal Laka-Laka: Dialek dan Identitas\"', '2026-07-08 04:01:08', '2026-07-08 04:01:08'),
(109, 'RETURN APPROVED', 'Admin (Zidny Ilman) menyetujui pengembalian buku \"Bumi Manusia\" oleh member \"Annisa\"', '2026-07-08 04:01:28', '2026-07-08 04:01:28'),
(110, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 04:03:12', '2026-07-08 04:03:12'),
(111, 'RETURN APPROVED', 'Admin (Zidny Ilman) menyetujui pengembalian buku \"Tegal Laka-Laka: Dialek dan Identitas\" oleh member \"zidny\"', '2026-07-08 04:03:27', '2026-07-08 04:03:27'),
(112, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 07:47:04', '2026-07-08 07:47:04'),
(113, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 10:44:52', '2026-07-08 10:44:52'),
(114, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: Borrowing Rules', '2026-07-08 11:09:21', '2026-07-08 11:09:21'),
(115, 'LOAN APPROVED', 'Admin (Zidny Ilman) menyetujui peminjaman buku \"Bumi Manusia\" oleh member \"zidny\"', '2026-07-08 11:09:54', '2026-07-08 11:09:54'),
(116, 'ADMIN_LOGIN_SUCCESS', 'Zidny Ilman (admin1) successfully logged in from IP 127.0.0.1', '2026-07-08 21:27:47', '2026-07-08 21:27:47'),
(117, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-07-09 06:02:24', '2026-07-09 06:02:24'),
(118, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-07-09 06:02:49', '2026-07-09 06:02:49'),
(119, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-07-09 06:04:12', '2026-07-09 06:04:12'),
(120, 'SETTINGS_UPDATE', 'Zidny Ilman updated system settings. Sections changed: General Settings', '2026-07-09 06:08:31', '2026-07-09 06:08:31'),
(121, 'SYSTEM_MAINTENANCE', 'Zidny Ilman cleared the application cache (views, config, cache).', '2026-07-09 07:06:50', '2026-07-09 07:06:50'),
(122, 'DATABASE_BACKUP', 'Zidny Ilman downloaded database backup SQL file.', '2026-07-09 07:06:57', '2026-07-09 07:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `artikels`
--

CREATE TABLE `artikels` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_uploader` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `tanggal_upload` date NOT NULL,
  `foto_utama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto_pendukung` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikels`
--

INSERT INTO `artikels` (`id`, `judul`, `nama_uploader`, `user_id`, `tanggal_upload`, `foto_utama`, `isi`, `foto_pendukung`, `kategori`, `status`, `created_at`, `updated_at`, `views`, `keywords`) VALUES
(1, 'The Evolution of Sauto Tegal: A Culinary Odyssey', 'Budi Sudarsono', 2, '2023-10-24', 'https://images.unsplash.com/photo-1606131731446-5568d87113aa?auto=format&fit=crop&q=80&w=500', 'Sauto Tegal adalah variasi soto khas Tegal yang unik karena menggunakan tauco sebagai bumbu utamanya. Rasa gurih manis berpadu sedikit asam asam tauco menciptakan harmoni rasa pesisiran yang melegenda. Biasanya disajikan dengan mangkuk kecil, dipenuhi tauge, suwiran daging ayam atau sapi, dan jeroan garing.', 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=500', 'GASTRONOMY', 'approved', '2026-06-26 00:53:55', '2026-07-09 07:05:52', 2, NULL),
(2, 'Journalism in the age of Citizen Voices', 'Dewi Sartika', 1, '2023-10-22', 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&q=80&w=500', 'Di era digital saat ini, batasan jurnalisme arus utama kian memudar. Setiap warga dengan gawai pintar dapat meliput kejadian secara real-time. Hal ini menghidupkan ekosistem berita alternatif namun juga membawa tantangan berat berupa disinformasi. Kurasi dan integritas tetap menjadi pilar utama.', NULL, 'MEDIA', 'approved', '2026-06-26 00:53:55', '2026-07-09 06:58:06', 4, NULL),
(3, 'The Vanishing Architecture of Poci Houses', 'Adi Kusuma', 2, '2026-06-26', 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&q=80&w=500', 'Teh poci bukan sekadar minuman di Tegal, melainkan sebuah ritual sosial. Dulu, hampir setiap rumah memiliki ruang khusus untuk \"Moci\" dengan arsitektur jendela rendah dan beranda luas untuk bersantai. Kini, rumah-rumah poci tradisional tersebut lambat laun tergantikan oleh ruko-ruko minimalis modern.', NULL, 'HERITAGE & CULTURE', 'approved', '2026-06-26 00:53:55', '2026-06-26 02:02:33', 0, NULL),
(4, 'Poetry of the North Coast: A Resurgence', 'Maya Lestari', 1, '2026-06-26', 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&q=80&w=500', 'Sastra pesisir utara Jawa Tengah, khususnya Tegal, memiliki karakter blak-blakan (lugas) dan jenaka. Belakangan, anak-anak muda di Tegal mulai menghidupkan kembali sastra lokal melalui stand-up poetry dan stanzas digital di media sosial, membawa isu lingkungan pesisir dan abrasi.', NULL, 'LOCAL LITERATURES', 'approved', '2026-06-26 00:53:55', '2026-06-26 02:03:02', 0, NULL),
(6, 'Bunga Hitam', 'zidny', 7, '2026-07-09', 'uploads/articles/1783578124_main_6a4f3e0cd8450.jpg', 'Bunga Hitam adalah band punk asal Indonesia yang terbentuk di Jakarta pada tahun 2001 oleh para musisi dari generasi awal skena punk kota tersebut, termasuk anggota dari band The Idiots. Band ini lahir sebagai respons terhadap memudarnya semangat solidaritas dan meningkatnya komersialisasi dalam komunitas punk. Sejak awal, Bunga Hitam konsisten mengusung etika Do It Yourself (DIY) dengan merilis karya secara mandiri, terutama dalam format kaset, serta menghindari ketergantungan pada industri musik arus utama maupun media sosial resmi.\r\n\r\nSecara musikal, Bunga Hitam mengusung punk rock klasik dengan lirik berbahasa Indonesia yang lugas dan sarat kritik sosial. Tema-tema yang mereka angkat meliputi kebebasan, kesetaraan, anti-penindasan, kemiskinan, solidaritas, hingga kemanusiaan lintas agama. Lagu-lagu seperti Setara, Negaraku Penjaraku, Lawan Kemiskinan, dan Jual Idealismu menjadikan Bunga Hitam dikenal sebagai salah satu representasi penting gerakan anarko-punk di Indonesia, yang memandang musik bukan sekadar hiburan, melainkan media pendidikan, perlawanan, dan perubahan sosial.', NULL, 'MUSIK', 'approved', '2026-07-09 06:22:04', '2026-07-09 06:59:06', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artikel_favorites`
--

CREATE TABLE `artikel_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `artikel_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel_favorites`
--

INSERT INTO `artikel_favorites` (`id`, `user_id`, `artikel_id`, `created_at`, `updated_at`) VALUES
(1, 7, 2, '2026-07-09 06:58:06', '2026-07-09 06:58:06'),
(2, 7, 6, '2026-07-09 06:59:05', '2026-07-09 06:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `bukus`
--

CREATE TABLE `bukus` (
  `id` bigint UNSIGNED NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_halaman` int NOT NULL,
  `sinopsis` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bahasa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentang_penulis` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ready',
  `status_publish` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `buku_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '0001_01_01_000000_create_users_table', 1),
(8, '0001_01_01_000001_create_cache_table', 1),
(9, '0001_01_01_000002_create_jobs_table', 1),
(10, '2026_06_17_071702_create_bukus_table', 1),
(11, '2026_06_24_000000_create_artikels_table', 1),
(12, '2026_06_25_085839_create_reviews_table', 1),
(13, '2026_06_26_075323_create_peminjamans_table', 1),
(14, '2026_06_26_083917_create_admin_logs_table', 2),
(15, '2026_06_27_000000_create_settings_table', 3),
(16, '2026_06_29_191835_add_status_publish_to_bukus_table', 4),
(17, '2026_07_08_082229_add_resensi_to_peminjamans_table', 5),
(18, '2026_07_08_085146_create_favorites_table', 6),
(19, '2026_07_08_180624_add_denda_to_peminjamans_table', 7),
(20, '2026_07_09_133145_add_views_to_artikels_table', 8),
(21, '2026_07_09_135434_add_artikel_id_to_favorites_table', 9),
(22, '2026_07_09_135442_add_keywords_to_artikels_table', 9),
(23, '2026_07_09_135510_create_artikel_favorites_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjamans`
--

CREATE TABLE `peminjamans` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `buku_id` bigint UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resensi_rating` int DEFAULT NULL,
  `resensi_isi` text COLLATE utf8mb4_unicode_ci,
  `denda_dibayar` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `peran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `nama`, `avatar`, `peran`, `rating`, `isi`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Silvia Fahmi', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=300', 'Active Member', 5, 'Kanca Tegal has completely transformed my reading habits. The collection of local archives is outstanding, and the weekly book discussions are always inspiring.', '2026-06-26 00:53:53', '2026-06-26 00:53:53'),
(2, NULL, 'Bintang Wijaya', 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&q=80&w=300', 'Local Youth Advocate', 5, 'A wonderful space where traditional wisdom meets modern ideas! A place where community meets knowledge.', '2026-06-26 00:53:53', '2026-06-26 00:53:53'),
(3, 2, NULL, NULL, NULL, 5, 'kereen', '2026-06-26 02:04:32', '2026-06-26 02:04:32'),
(4, 7, NULL, NULL, NULL, 5, 'kereen coyy', '2026-07-09 06:19:40', '2026-07-09 06:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('GmluHs2LaLQnHPszpF1cKRmQJeqSh2Hk9SQyrtBZ', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'eyJfdG9rZW4iOiJ5TFZzaFpvRm9UYXBDWWJKRVVoNGx4NXdPZk56NVNFODlhU3RuOFphIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9hZG1pblwvc2V0dGluZ1wvYmFja3VwIiwicm91dGUiOm51bGx9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImFkbWluX2xvZ2dlZF9pbiI6dHJ1ZSwiYWRtaW5fdXNlcm5hbWUiOiJhZG1pbjEiLCJhZG1pbl9mdWxsbmFtZSI6IlppZG55IElsbWFuIiwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjd9', 1783580817);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hero_title', 'NYILIH | KANCA TEGAL', '2026-06-26 10:11:56', '2026-06-26 10:28:43'),
(2, 'hero_subtitle', 'NETWORKED YIELDING INFORMATION FOR LITERACY HUB -  Menghubungkan manusia, buku, dan gagasan dalam satu ekosistem literasi tempat pengetahuan dipinjamkan, dibagikan, diperdebatkan, dan diubah menjadi gerakan bersama.', '2026-06-26 10:11:56', '2026-06-26 10:28:43'),
(3, 'schedule_info', 'Kanca Tegal open 20.00 - Ngantuk!!', '2026-06-26 10:11:56', '2026-06-26 10:28:43'),
(4, 'map_label', 'LAPAK KAMI: Alun-alun Kota Tegal Sebelah Utara', '2026-06-26 10:11:56', '2026-06-26 10:28:43'),
(5, 'map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7922.386473390957!2d109.13534337403283!3d-6.867433293131199!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb77fd6964c41%3A0xde71bfa145f23be!2sAlun-Alun%20Tegal%2C%20Mangkukusuman%2C%20Kec.%20Tegal%20Tim.%2C%20Kota%20Tegal%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1782495189661!5m2!1sid!2sid', '2026-06-26 10:11:56', '2026-06-26 10:33:36'),
(6, 'site_title', 'Nyilih | Kanca Tegal', '2026-06-26 11:34:56', '2026-06-26 11:38:38'),
(7, 'default_language', 'id', '2026-06-26 11:34:56', '2026-07-08 00:36:34'),
(8, 'maintenance_mode', '0', '2026-06-26 11:34:56', '2026-07-09 06:08:31'),
(9, 'admin_fullname', 'Zidny Ilman', '2026-06-26 11:34:56', '2026-06-29 12:09:02'),
(10, 'admin_username', 'admin1', '2026-06-26 11:34:56', '2026-06-29 12:09:02'),
(11, 'loan_limit', '2', '2026-06-26 11:34:56', '2026-06-30 10:49:01'),
(12, 'loan_duration', '1', '2026-06-26 11:34:56', '2026-07-08 11:09:21'),
(13, 'late_fine_rate', '1000', '2026-06-26 11:34:56', '2026-06-26 11:34:56'),
(14, 'grace_period', '1', '2026-06-26 11:34:56', '2026-07-08 11:09:21'),
(15, 'wa_template_register', 'Halo {name}, pendaftaran Anda di Kanca Tegal berhasil!', '2026-06-26 11:34:56', '2026-06-26 11:34:56'),
(16, 'wa_template_borrow', 'Halo {name}, peminjaman buku {title} berhasil. Harap kembalikan sebelum {due_date}.', '2026-06-26 11:34:57', '2026-06-26 11:34:57'),
(17, 'wa_template_overdue', 'Halo {name}, peminjaman buku {title} telah terlambat. Denda saat ini adalah {fine}. Harap segera kembalikan.', '2026-06-26 11:34:57', '2026-06-26 11:34:57'),
(18, 'admin_password', '$2y$12$vXbXcufmZR1jAOKdZ8DHJe5d0MZg//K6kHCQKZkr15AQj5wdxZgz2', '2026-06-26 11:48:25', '2026-06-26 11:48:25'),
(19, 'wa_template_otp', 'Halo {name}, berikut adalah kode OTP untuk merubah kata sandi Anda: {otp}. Jangan sebarkan kode ini kepada siapapun!', '2026-06-26 12:18:44', '2026-06-26 12:18:44'),
(20, 'admin2_fullname', 'Irfan Maulana', '2026-06-29 12:09:02', '2026-06-29 12:09:02'),
(21, 'admin2_username', 'admin2', '2026-06-29 12:09:02', '2026-06-29 12:09:02'),
(22, 'hero_image', 'uploads/landing/1782812149_6a438df5b3d6d.jpg', '2026-06-30 02:35:49', '2026-06-30 02:35:49'),
(23, 'popup_status', '0', '2026-07-08 03:03:50', '2026-07-08 03:05:20'),
(24, 'popup_buka_image', 'uploads/landing/popup_buka_1783505030_6a4e20864923f.jpg', '2026-07-08 03:03:50', '2026-07-08 03:03:50'),
(25, 'popup_tutup_image', 'uploads/landing/popup_tutup_1783505030_6a4e20864e3ed.jpg', '2026-07-08 03:03:50', '2026-07-08 03:03:50'),
(26, 'popup_active_type', 'tutup', '2026-07-08 03:04:31', '2026-07-08 03:04:31'),
(27, 'wa_api_token', 'VuYtSiZ1GNDuXdGAMHy9', '2026-07-08 03:18:44', '2026-07-08 03:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `can_borrow` tinyint(1) NOT NULL DEFAULT '1',
  `can_upload_artikel` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `whatsapp`, `email`, `alamat`, `email_verified_at`, `password`, `can_borrow`, `can_upload_artikel`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Riana Kusuma', '0898765456780', 'riana@example.com', 'Jl. Pancasila No. 12, Tegal', NULL, '$2y$12$4jEv/hb2YmBQFZ4IHdacb.bQ2.Z6AhMtfr7V7rQ1gJ8UKUWYjp/e.', 1, 0, 'active', NULL, '2026-06-26 00:53:55', '2026-06-29 09:35:14'),
(2, 'Ahmad Fauzi', '0878675456790', 'ahmad@example.com', 'Jl. Ahmad Yani No. 45, Tegal', NULL, '$2y$12$ifbU6DzCuCTZ1j6eN698gOTVDHGjlg0MfJyUSzWVLV3X3aKN5mFJe', 1, 1, 'active', NULL, '2026-06-26 00:53:55', '2026-06-26 00:53:55'),
(3, 'Siti Aminah', '0898765432123', 'siti@example.com', 'Jl. Diponegoro No. 8, Tegal', NULL, '$2y$12$M6b6bSyNp1OQqe8V2titEOd4IRIS984i3pTnWYcCmHKdaDLAIqCKe', 0, 0, 'suspended', NULL, '2026-06-26 00:53:55', '2026-06-26 00:53:55'),
(5, 'Test User', '081234567890', 'test@example.com', 'Jl. Martoloyo No. 3, Tegal', NULL, '$2y$12$88LMs1jvAMVZb.jDx2tgkOBzduVKj12FCjrb92glXow6GOfG3rEAi', 1, 1, 'active', NULL, '2026-06-26 00:53:55', '2026-06-26 00:53:55'),
(7, 'zidny', '0895324606014', NULL, 'jl raya karanganyar', NULL, '$2y$12$JIKeB19tbtiH/OeHCJ0rM.C6u4YD0B9u2LBbhdmjiL/lZ7a5Q5Klm', 1, 1, 'active', NULL, '2026-06-26 13:12:18', '2026-07-09 06:12:03'),
(8, 'Annisa', '+6281325344193', NULL, 'Jl. Halmahera 2 rt 11 rw 11', NULL, '$2y$12$uWAsAzRPM89IbyoDO5fnOONfDO.b.wdQw0efCXkFT/nCiR9Ktoiki', 1, 0, 'active', NULL, '2026-07-08 03:56:15', '2026-07-08 03:56:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artikels`
--
ALTER TABLE `artikels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artikels_user_id_foreign` (`user_id`);

--
-- Indexes for table `artikel_favorites`
--
ALTER TABLE `artikel_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artikel_favorites_user_id_artikel_id_unique` (`user_id`,`artikel_id`),
  ADD KEY `artikel_favorites_artikel_id_foreign` (`artikel_id`);

--
-- Indexes for table `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_buku_id_unique` (`user_id`,`buku_id`),
  ADD KEY `favorites_buku_id_foreign` (`buku_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjamans_user_id_foreign` (`user_id`),
  ADD KEY `peminjamans_buku_id_foreign` (`buku_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_whatsapp_unique` (`whatsapp`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `artikels`
--
ALTER TABLE `artikels`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artikel_favorites`
--
ALTER TABLE `artikel_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `peminjamans`
--
ALTER TABLE `peminjamans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikels`
--
ALTER TABLE `artikels`
  ADD CONSTRAINT `artikels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artikel_favorites`
--
ALTER TABLE `artikel_favorites`
  ADD CONSTRAINT `artikel_favorites_artikel_id_foreign` FOREIGN KEY (`artikel_id`) REFERENCES `artikels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artikel_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjamans`
--
ALTER TABLE `peminjamans`
  ADD CONSTRAINT `peminjamans_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjamans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
