-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 Ağu 2026, 12:05:41
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cv_portal`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_post_id` bigint(20) UNSIGNED NOT NULL,
  `cv_id` bigint(20) UNSIGNED NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'received',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `job_post_id`, `cv_id`, `cover_letter`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, 'aaa', 'reviewing', '2026-08-24 08:50:49', '2026-08-24 14:04:35'),
(2, 1, 3, 1, 'ssssssss', 'received', '2026-08-24 14:06:28', '2026-08-24 14:06:28');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `candidate_profiles`
--

CREATE TABLE `candidate_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `github` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `portfolio` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `candidate_profiles`
--

INSERT INTO `candidate_profiles` (`id`, `user_id`, `phone`, `city`, `about`, `profile_photo`, `github`, `linkedin`, `portfolio`, `created_at`, `updated_at`) VALUES
(1, 2, '05300790575', 'elazig', 'yazilim öğrenci', 'profile-photos/St0Tfl2jbJijNizezYNUoqDQbJT5O34uOew4ewy6.jpg', 'https://github.com/nisa75', 'https://github.com/nisa75', 'https://github.com/nisa75', '2026-08-17 08:37:21', '2026-08-17 09:12:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `companies`
--

INSERT INTO `companies` (`id`, `user_id`, `name`, `logo`, `description`, `industry`, `location`, `website`, `linkedin`, `instagram`, `created_at`, `updated_at`) VALUES
(1, 3, 'aa', 'company-logos/qE7rp3eSwmQvfmbl4S8THkTfN7lgFdcCutESiAXt.jpg', 'zzzzzzzzd', 'yaz', 'ist', 'https://example.com', 'https://github.com/nisa75', 'https://instagram.com/example', '2026-08-24 05:46:12', '2026-08-24 06:03:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cvs`
--

CREATE TABLE `cvs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `template` varchar(255) NOT NULL DEFAULT 'modern',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `public_token` varchar(64) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `cvs`
--

INSERT INTO `cvs` (`id`, `user_id`, `title`, `template`, `created_at`, `updated_at`, `public_token`, `is_public`) VALUES
(1, 1, 'frontend dev', 'classic', '2026-08-24 08:10:33', '2026-08-24 17:02:10', 'MWiYLd5t2cTutYYbBY8G4YrcG1nsNbtyIfMM6HHq', 1),
(2, 1, 'kkkk', 'minimal', '2026-08-25 05:33:23', '2026-08-25 05:35:58', 'ql7sjoh9lfnrTaQc6sqxHcousZzo25nHcya8MOSi', 0),
(3, 2, 'nnn', 'modern', '2026-08-25 06:04:29', '2026-08-25 06:04:29', 'HQWUwWsLemoyydRPtYTIbqCdKd2Rkr6txXkVZtkR', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `educations`
--

CREATE TABLE `educations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `school` varchar(255) NOT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `currently_studying` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `educations`
--

INSERT INTO `educations` (`id`, `user_id`, `school`, `degree`, `field`, `start_date`, `end_date`, `currently_studying`, `description`, `created_at`, `updated_at`) VALUES
(2, 1, 'fü', 'lisans', 'yaz müh', '2022-02-28', '2026-07-09', 0, 'ffffffffffffffffffffffffffffffaaaaaaaaaa', '2026-08-25 05:50:27', '2026-08-25 05:50:38'),
(3, 2, 'h', 'h', 'h', '2022-03-25', '2026-08-09', 0, 'hhhhhhh', '2026-08-25 06:05:15', '2026-08-25 06:05:15');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `currently_working` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `experiences`
--

INSERT INTO `experiences` (`id`, `user_id`, `company`, `position`, `start_date`, `end_date`, `currently_working`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'a', 'ab', '2026-08-21', '2026-08-29', 0, 'a', '2026-08-21 07:57:32', '2026-08-25 05:52:53');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_post_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `job_post_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-08-24 13:22:25', '2026-08-24 13:22:25');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `job_posts`
--

CREATE TABLE `job_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `employment_type` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `salary_min` decimal(10,2) DEFAULT NULL,
  `salary_max` decimal(10,2) DEFAULT NULL,
  `experience_level` varchar(255) DEFAULT NULL,
  `education_level` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `skills` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `job_posts`
--

INSERT INTO `job_posts` (`id`, `company_id`, `title`, `department`, `employment_type`, `location`, `salary_min`, `salary_max`, `experience_level`, `education_level`, `description`, `skills`, `benefits`, `deadline`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'aa', 'aa', 'Tam Zamanlı', 'aa', 1000.00, 10000.00, 'Stajyer', 'Ön Lisans', 'dwdwd', 'swdw', 'dwdwdwd', '2026-08-24', 'published', '2026-08-24 08:44:46', '2026-08-24 08:44:46'),
(3, 1, 'bb', 'bbb', 'Tam Zamanlı', 'bbb', 222.00, 233.00, 'Stajyer', 'Ön Lisans', 'eqeqeqeqeqe', 'eee', 'eeeee', '2026-09-03', 'published', '2026-08-24 14:05:18', '2026-08-24 18:05:32');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_13_113533_add_role_to_users_table', 2),
(5, '2026_08_17_105926_create_candidate_profiles_table', 3),
(6, '2026_08_21_094942_create_education_table', 4),
(7, '2026_08_21_101608_create_experiences_table', 5),
(9, '2026_08_21_105757_create_skills_table', 6),
(10, '2026_08_24_082802_create_companies_table', 7),
(11, '2026_08_24_090654_create_jobs_table', 8),
(12, '2026_08_24_103106_create_cvs_table', 9),
(13, '2026_08_24_113234_create_applications_table', 10),
(14, '2026_08_24_160847_create_favorites_table', 11),
(15, '2026_08_24_162841_create_notifications_table', 12),
(16, '2026_08_24_193403_add_visibility_and_public_token_to_cvs_table', 13);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('73887dc0-fa9e-4d73-a764-90f8ff821d20', 'App\\Notifications\\ApplicationReceived', 'App\\Models\\User', 1, '{\"type\":\"application_received\",\"message\":\"Ba\\u015fvurunuz ba\\u015far\\u0131yla g\\u00f6nderildi.\",\"job_title\":\"bb\",\"company_name\":\"aa\"}', '2026-08-25 05:44:59', '2026-08-24 14:06:37', '2026-08-25 05:44:59'),
('ce86f0ef-e154-4006-bea1-c369aac3029f', 'App\\Notifications\\NewApplicationReceived', 'App\\Models\\User', 3, '{\"type\":\"new_application\",\"message\":\"Yeni bir i\\u015f ba\\u015fvurusu ald\\u0131n\\u0131z.\",\"candidate_name\":\"Nisa Ko\\u00e7\",\"job_title\":\"bb\"}', '2026-08-24 14:07:27', '2026-08-24 14:06:37', '2026-08-24 14:07:27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Y7ll3mMDqDXu9CNq1QlUTT3V64mmEBJjjPb5T3Q7', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTkFmSDU1THd5dG11WlF4NUc0RjJJVzlmeFcyTEQ5Ym95ZXE5MzVQUCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1787648992);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `skills`
--

INSERT INTO `skills` (`id`, `user_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'aaaaaa', '2026-08-25 05:53:47', '2026-08-25 05:53:47'),
(2, 2, 'llgllg', '2026-08-25 06:05:30', '2026-08-25 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'candidate',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nisa Koç', 'nisabyz75@gmail.com', NULL, '$2y$12$Ciy14YuFHhJoeGyFjWv1nexmwuq0ikuHDAtAoI1utPCk4yyF.KW4G', 'candidate', NULL, '2026-08-13 07:49:09', '2026-08-13 07:49:09'),
(2, 'emre', 'emre@gmail.com', NULL, '$2y$12$VEKj9V7HinEmIjhhdsjS0OVcTI1Jz6KdHBvo3nKvI47uZ3VKuEZiS', 'candidate', NULL, '2026-08-13 08:50:17', '2026-08-13 08:50:17'),
(3, 'ahmet', 'ahmet@gmail.com', NULL, '$2y$12$5ZfAtyljcvqCVWa5XZwKFuFeLvUaGhmSZ9aGlWKKbyBk0Wrwv3Gcm', 'employer', NULL, '2026-08-13 08:52:37', '2026-08-13 08:52:37'),
(4, 'Admin', 'admin@cvportal.com', NULL, '$2y$12$Pv2zhqab2QvmUjXI0nqpZeQVUUg/YW64ia35JCsvSkr7skgzxa4Na', 'admin', NULL, '2026-08-17 07:56:13', '2026-08-17 07:56:13');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `applications_user_id_job_post_id_unique` (`user_id`,`job_post_id`),
  ADD KEY `applications_job_post_id_foreign` (`job_post_id`),
  ADD KEY `applications_cv_id_foreign` (`cv_id`);

--
-- Tablo için indeksler `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Tablo için indeksler `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Tablo için indeksler `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_profiles_user_id_foreign` (`user_id`);

--
-- Tablo için indeksler `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_user_id_foreign` (`user_id`);

--
-- Tablo için indeksler `cvs`
--
ALTER TABLE `cvs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cvs_public_token_unique` (`public_token`),
  ADD KEY `cvs_user_id_foreign` (`user_id`);

--
-- Tablo için indeksler `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `educations_user_id_foreign` (`user_id`);

--
-- Tablo için indeksler `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `experiences_user_id_foreign` (`user_id`);

--
-- Tablo için indeksler `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Tablo için indeksler `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_job_post_id_unique` (`user_id`,`job_post_id`),
  ADD KEY `favorites_job_post_id_foreign` (`job_post_id`);

--
-- Tablo için indeksler `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Tablo için indeksler `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `job_posts`
--
ALTER TABLE `job_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_posts_company_id_foreign` (`company_id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Tablo için indeksler `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Tablo için indeksler `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Tablo için indeksler `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skills_user_id_name_unique` (`user_id`,`name`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `cvs`
--
ALTER TABLE `cvs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `educations`
--
ALTER TABLE `educations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `job_posts`
--
ALTER TABLE `job_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_cv_id_foreign` FOREIGN KEY (`cv_id`) REFERENCES `cvs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD CONSTRAINT `candidate_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `cvs`
--
ALTER TABLE `cvs`
  ADD CONSTRAINT `cvs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `educations`
--
ALTER TABLE `educations`
  ADD CONSTRAINT `educations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `experiences`
--
ALTER TABLE `experiences`
  ADD CONSTRAINT `experiences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_job_post_id_foreign` FOREIGN KEY (`job_post_id`) REFERENCES `job_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `job_posts`
--
ALTER TABLE `job_posts`
  ADD CONSTRAINT `job_posts_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
