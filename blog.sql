-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 04:11 PM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_list_items`
--

CREATE TABLE `about_list_items` (
  `id` int(11) NOT NULL,
  `about_section_id` int(11) DEFAULT NULL,
  `list_item` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `about_list_items`
--

INSERT INTO `about_list_items` (`id`, `about_section_id`, `list_item`) VALUES
(7, 1, 'Platus paslaugų spektras pagal individualius poreikius'),
(8, 1, 'Patikimi ir profesionalūs specialistai'),
(9, 1, 'Aukščiausios kokybės grožio produktai');

-- --------------------------------------------------------

--
-- Table structure for table `about_section`
--

CREATE TABLE `about_section` (
  `id` int(11) NOT NULL,
  `background_image` varchar(255) DEFAULT NULL,
  `main_title` varchar(255) DEFAULT NULL,
  `story_heading` varchar(255) DEFAULT NULL,
  `story_subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `additional_paragraph` text DEFAULT NULL,
  `video_link` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `about_section`
--

INSERT INTO `about_section` (`id`, `background_image`, `main_title`, `story_heading`, `story_subtitle`, `description`, `additional_paragraph`, `video_link`, `updated_at`) VALUES
(1, '1740404868_hero-carousel-2.jpg', 'Profesionalios grožio paslaugos VIP Grožio Studijoje', 'Patirtis ir profesionalumas', 'Mūsų istorija', 'VIP Grožio Studija – tai komanda, kuri siekia sukurti unikalų grožio patyrimą kiekvienam klientui', 'Kiekvienas mūsų klientas yra svarbus, todėl mes pasirūpinsime, kad kiekviena paslauga būtų suteikta su didžiausiu dėmesiu ir profesionalumu. Mes vertiname aukštą kokybę ir kruopštumą visuose mūsų darbuose.', 'https://www.youtube.com/watch?v=Mj7KARIRji4', '2025-02-24 13:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$vU6V2drdRTGNcCQjkIe42OGacyx..897hVjAGxFwviM6pYxqA29T2', '2025-02-23 05:25:46');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `google_map_embed` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`id`, `address`, `email`, `phone`, `google_map_embed`) VALUES
(1, 'VIP Grožio Studija, Vingininkų g. 2, Šilalė', 'info@vipgroziostudija.lt', '+370 657 43 558', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2260.5710583290083!2d22.190692677087753!3d55.48757361238846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e44ed18097f225%3A0xe799da1416e6304c!2zVmluZ2luaW5rxbMgZy4gMiwgxaBpbGFsxJcsIDc1MTI0IMWgaWxhbMSXcyByLiBzYXYu!5e0!3m2!1sen!2slt!4v1740400354891!5m2!1sen!2slt\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `hero_carousel`
--

CREATE TABLE `hero_carousel` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `span_text` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `hero_carousel`
--

INSERT INTO `hero_carousel` (`id`, `title`, `span_text`, `description`, `button_text`, `button_link`, `image`, `created_at`) VALUES
(6, 'Kirpykla VIP Grožio Studija', '', 'Madingos šukuosenos ir kruopštus plaukų priežiūros paslaugos.', 'Rezervuoti', 'https://app.simplymeet.me/vipstudija?is_widget=1&view=compact', '1740405432_hero-carousel-2.jpg', '2025-02-23 18:46:33'),
(7, 'Kirpykla VIP Grožio Studija', '', 'Visapusiška priežiūra vyrams ir moterims.', 'Rezervuoti', 'https://app.simplymeet.me/vipstudija?is_widget=1&view=compact', '1740405345_hero-carousel-1.jpg', '2025-02-23 18:52:52');

-- --------------------------------------------------------

--
-- Table structure for table `navigation_links`
--

CREATE TABLE `navigation_links` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `dropdown_icon` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `navigation_links`
--

INSERT INTO `navigation_links` (`id`, `name`, `url`, `parent_id`, `dropdown_icon`, `status`, `created_at`) VALUES
(1, 'Pagrindinis.', 'index.php', NULL, 0, 'active', '2025-02-24 12:37:38'),
(2, 'Apie mus.', 'apie.php', NULL, 0, 'active', '2025-02-24 12:37:38'),
(3, 'Paslaugos.', 'index.php#services', NULL, 0, 'active', '2025-02-24 12:37:38'),
(4, 'Darbai.', 'index.php#projects', NULL, 0, 'active', '2025-02-24 12:37:38'),
(5, 'Atsiliepimai.', 'index.php#testimonials', NULL, 0, 'active', '2025-02-24 12:37:38'),
(6, 'Blogas.', '#', NULL, 1, 'active', '2025-02-24 12:37:38'),
(7, 'Visi.', 'blog.php', 6, 0, 'inactive', '2025-02-24 12:37:38'),
(8, 'Kontaktai.', 'kontaktai.php', NULL, 0, 'active', '2025-02-24 12:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `details` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_links`
--

CREATE TABLE `post_links` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `link` varchar(500) NOT NULL,
  `link_type` enum('youtube','google_drive') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_media`
--

CREATE TABLE `post_media` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('image','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `full_image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `description`, `thumbnail`, `full_image`, `created_at`, `category_id`) VALUES
(4, 'Modernus moterų kirpimas', 'Stilingas ir energingas kirpimas, atitinkantis šiuolaikines madas.', '1740407952_latest-1.jpg', '1740407952_latest-1.jpg', '2025-02-24 14:39:12', 8),
(5, 'Barzdos formavimas ir kirpimas', 'Profesionalus barzdos kirpimas ir formavimas pagal individualų stilių.\r\n', '1740408150_latest-2.jpg', '1740408151_latest-2.jpg', '2025-02-24 14:42:31', 10),
(6, 'Barzdos priežiūra ir stilizavimas', 'Barzdos priežiūra ir stilizavimas naudojant natūralius produktus, užtikrinant aukščiausią kokybę.\r\n', '', '', '2025-02-24 14:43:50', 10),
(8, 'Šiuolaikinis plaukų kirpimas', 'Plaukų kirpimas, atitinkantis modernią stilistiką ir klientų poreikius.\r\n', '1740408351_haircut-1.jpg', '1740408352_haircut-1.jpg', '2025-02-24 14:45:52', 8),
(9, 'Moterų kirpimas su stilizavimu', 'Kirpimas ir stiliaus formavimas, siekiant išryškinti asmeninį įvaizdį.\r\n', '1740408501_latest-3.jpg', '1740408502_latest-3.jpg', '2025-02-24 14:48:22', 7),
(10, 'Švelnus skutimas su aliejumi', 'Patogus ir švelnus skutimas naudojant natūralius aliejus ir produktus, užtikrinant geriausią odos priežiūrą.\r\n', '1740408638_shaving-2.jpg', '1740408639_shaving-2.jpg', '2025-02-24 14:50:39', 9);

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_categories`
--

INSERT INTO `project_categories` (`id`, `name`, `description`, `created_at`) VALUES
(7, 'Naujausi', '', '2025-02-24 09:41:19'),
(8, 'Kirpimai', '', '2025-02-24 09:41:34'),
(9, 'Skutimas', '', '2025-02-24 09:41:41'),
(10, 'Barzdos priežiūra', '', '2025-02-24 09:42:02');

-- --------------------------------------------------------

--
-- Table structure for table `project_links`
--

CREATE TABLE `project_links` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `link_type` enum('youtube','google_drive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_links`
--

INSERT INTO `project_links` (`id`, `project_id`, `link`, `link_type`) VALUES
(3, 6, 'https://www.youtube.com/watch?v=Mj7KARIRji4', 'youtube');

-- --------------------------------------------------------

--
-- Table structure for table `project_media`
--

CREATE TABLE `project_media` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` enum('video') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_section`
--

CREATE TABLE `project_section` (
  `id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_description` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `project_section`
--

INSERT INTO `project_section` (`id`, `section_title`, `section_description`, `updated_at`) VALUES
(1, 'Darbai', 'Atlikti darbai, kuriuos įgyvendinome su aukščiausios kokybės paslaugomis ir profesionalia komanda.', '2025-02-24 14:36:48');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `section_description` text DEFAULT NULL,
  `section_title` varchar(255) NOT NULL DEFAULT 'Our Services'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `icon`, `section_description`, `section_title`) VALUES
(1, 'Kirpimai vyrams ir moterims', 'Kirpimai pagal individualius poreikius.\r\nStilingi plaukų kirpimai.\r\nPlaukų kirpimas su mašinėle', 'fa-solid fa-cut', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų.', 'Paslaugos'),
(2, 'Skutimas', 'Tradicinis skutimas.\r\nSkutimas karštuoju rankšluosčiu.\r\nVyrų skutimas su peiliu', 'bi-scissors', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų', 'Our Services'),
(3, 'Plaukų priežiūra', 'Plaukų drėkinimas ir maitinančios procedūros.\r\nPlaukų stiprinimo ir regeneracijos paslaugos.\r\nPlaukų atstatymo procedūros', 'fa-solid fa-spa', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų', 'Our Services'),
(4, 'Barzdos priežiūra', 'Barzdos kirpimas ir formavimas.\r\nBarzdos valymas ir modeliavimas.\r\nBarzdos stiprinimo ir maitinimo procedūros', 'bi-scissors', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų', 'Our Services'),
(5, 'Rankų ir nagų priežiūra', 'Manikiūras ir pedikiūras.\r\nRankų ir nagų priežiūros procedūros.\r\nNagų lakavimas', 'fa-solid fa-hand-sparkles', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų', 'Our Services'),
(6, 'Plaukų dažymas', 'Plaukų dažymas pagal individualius poreikius.\r\nDažymas natūraliais dažais.\r\nPlaukų šviesinimas ir tonavimas', 'fa-solid fa-tint', 'Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų', 'Our Services');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_text` varchar(255) DEFAULT NULL,
  `span_text` varchar(50) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_title`, `logo`, `logo_text`, `span_text`, `footer_text`, `updated_at`) VALUES
(1, 'VIP', NULL, 'VIP', 'studija', '© 2024 VIP. All rights reserved.', '2025-02-24 13:44:32');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `role`, `description`, `image`, `facebook`, `instagram`, `created_at`) VALUES
(3, 'Jūratė Morkūnaitė', 'Kirpėja', 'Specializuojasi įvairiuose kirpimuose, šukuosenų kūrime ir stilingose plaukų procedūrose. Užtikrina, kad kiekvienas klientas išsiskirtų unikaliu stiliumi.', '1740404956_team-4.jpg', '', '', '2025-02-24 12:12:44');

-- --------------------------------------------------------

--
-- Table structure for table `team_section`
--

CREATE TABLE `team_section` (
  `id` int(11) NOT NULL,
  `section_title` varchar(255) DEFAULT NULL,
  `section_description` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `team_section`
--

INSERT INTO `team_section` (`id`, `section_title`, `section_description`, `updated_at`) VALUES
(1, 'Mūsų Komanda', 'VIP Grožio Studijoje dirba profesionalių grožio specialistų komanda, kuri užtikrina, kad kiekvienas klientas gautų geriausią paslaugą.', '2025-02-24 12:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `designation`, `image`, `rating`, `content`, `created_at`) VALUES
(3, 'Saulius', 'Klientas', '1740408785_testimonials-1.jpg', 5, 'Puikus kirpimas ir barzdos formavimas! Ačiū, kad išpildėte mano norus ir suteikėte šviežias idėjas', '2025-02-24 14:53:05'),
(4, 'Jūratė', 'Klientė', '1740408833_testimonials-3.jpg', 5, 'Labai patiko plaukų kirpimas! Profesionalus požiūris ir malonus aptarnavimas. Tikrai sugrįšiu', '2025-02-24 14:53:53'),
(5, 'Jonas', 'Klientas', '1740408897_testimonials-4.jpg', 5, 'Nuostabi kirpykla, profesionalus požiūris ir aukščiausios kokybės paslaugos! Ačiū už puikų kirpimą', '2025-02-24 14:54:57');

-- --------------------------------------------------------

--
-- Table structure for table `testimonial_section`
--

CREATE TABLE `testimonial_section` (
  `id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_description` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `testimonial_section`
--

INSERT INTO `testimonial_section` (`id`, `section_title`, `section_description`, `updated_at`) VALUES
(1, 'Atsiliepimai', 'Mūsų klientai vertina aukštą paslaugų kokybę, profesionalumą ir dėmesį detalėms. Štai keletas jų atsiliepimų', '2025-02-24 14:55:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_list_items`
--
ALTER TABLE `about_list_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `about_section_id` (`about_section_id`);

--
-- Indexes for table `about_section`
--
ALTER TABLE `about_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hero_carousel`
--
ALTER TABLE `hero_carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation_links`
--
ALTER TABLE `navigation_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `subcategory_id` (`subcategory_id`);

--
-- Indexes for table `post_links`
--
ALTER TABLE `post_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_links`
--
ALTER TABLE `project_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_media`
--
ALTER TABLE `project_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_section`
--
ALTER TABLE `project_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_section`
--
ALTER TABLE `team_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonial_section`
--
ALTER TABLE `testimonial_section`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_list_items`
--
ALTER TABLE `about_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `about_section`
--
ALTER TABLE `about_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hero_carousel`
--
ALTER TABLE `hero_carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `navigation_links`
--
ALTER TABLE `navigation_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `post_links`
--
ALTER TABLE `post_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `project_links`
--
ALTER TABLE `project_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `project_media`
--
ALTER TABLE `project_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_section`
--
ALTER TABLE `project_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_section`
--
ALTER TABLE `team_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testimonial_section`
--
ALTER TABLE `testimonial_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_list_items`
--
ALTER TABLE `about_list_items`
  ADD CONSTRAINT `about_list_items_ibfk_1` FOREIGN KEY (`about_section_id`) REFERENCES `about_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_links`
--
ALTER TABLE `post_links`
  ADD CONSTRAINT `post_links_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_media`
--
ALTER TABLE `post_media`
  ADD CONSTRAINT `post_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `project_categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `project_links`
--
ALTER TABLE `project_links`
  ADD CONSTRAINT `project_links_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `project_media`
--
ALTER TABLE `project_media`
  ADD CONSTRAINT `project_media_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
