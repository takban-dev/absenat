-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 23, 2017 at 06:38 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absenat`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_bounds`
--

CREATE TABLE `age_bounds` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `age_bounds`
--

INSERT INTO `age_bounds` (`id`, `title`) VALUES
(1, '۱۶ - ۱۸'),
(2, '۱۹ - ۲۵'),
(3, '۲۶ - ۳۵'),
(4, '۳۶ - ۵۰'),
(5, '۵۱ - ۷۵'),
(6, 'بالاتر از ۷۵');

-- --------------------------------------------------------

--
-- Table structure for table `business_license_sources`
--

CREATE TABLE `business_license_sources` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `business_license_sources`
--

INSERT INTO `business_license_sources` (`id`, `title`) VALUES
(1, 'اصناف'),
(2, 'غیره');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_types`
--

CREATE TABLE `certificate_types` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `certificate_types`
--

INSERT INTO `certificate_types` (`id`, `title`) VALUES
(1, 'اداری'),
(2, 'صنعتی'),
(3, 'تجاری'),
(4, 'خدماتی'),
(5, 'خرده فروشی');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `title`) VALUES
(1, 'رشت'),
(2, 'انزلی'),
(3, 'آستانه'),
(4, 'لاهیجان'),
(5, 'غیره');

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

CREATE TABLE `degrees` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `title`) VALUES
(1, 'زیر دیپلم'),
(2, 'دیپلم'),
(3, 'کاردانی'),
(4, 'کارشناسی'),
(5, 'کارشناسی ارشد'),
(6, 'دکتری');

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `title`) VALUES
(1, 'مرد'),
(2, 'زن'),
(3, 'نامشخص');

-- --------------------------------------------------------

--
-- Table structure for table `job_fields`
--

CREATE TABLE `job_fields` (
  `id` int(11) NOT NULL,
  `title` varchar(120) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `job_fields`
--

INSERT INTO `job_fields` (`id`, `title`) VALUES
(1, 'کشاورزي، جنگلداري و ماهیگیري'),
(2, 'استخراج معدن'),
(3, 'تولید صنعتی (ساخت)'),
(4, 'تأمین برق، گاز، بخار و تهویه هوا'),
(5, 'آب رسانی؛ مدیریت پسماند، فاضلاب و فعالیتهاي تصفیه'),
(6, 'ساختمان'),
(7, 'عمده فروشی و خرده فروشی؛ تعمیر وسایل نقلیه موتوري و موتور سیکلت'),
(8, 'حمل و نقل و انبارداري'),
(9, 'فعالیت هاي خدماتی مربوط به تامین جا و غذا'),
(10, 'اطلاعات و ارتباطات'),
(11, 'فعالیتهاي مالی و بیمه'),
(12, 'فعالیتهاي املاك و مستغلات'),
(13, 'فعالیتهاي حرفهاي، علمی و فنی'),
(14, 'فعالیتهاي اداري و خدمات پشتیبانی'),
(15, 'اداره امور عمومی و دفاع؛ تامین اجتماعی اجباري'),
(16, 'آموزش'),
(17, 'فعالیتهاي مربوط به سلامت انسان و مددکاري اجتماعی'),
(18, 'هنر، سرگرمی و تفریح'),
(19, 'سایر فعالیتهاي خدماتی'),
(20, 'فعالیتهاي خانوارها به عنوان کارفرما، فعالیتهاي تفکیک ناپذیر تولید کالاها و خدمات\r\nتوسط خانوارهاي معمولی براي خود مصرفی'),
(21, 'فعالیتهاي سازمانها و هیئتهاي برونمرزي');

-- --------------------------------------------------------

--
-- Table structure for table `merrige_types`
--

CREATE TABLE `merrige_types` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `merrige_types`
--

INSERT INTO `merrige_types` (`id`, `title`) VALUES
(1, 'مجرد'),
(2, 'متاهل'),
(3, 'مطلقه');

-- --------------------------------------------------------

--
-- Table structure for table `study_fields`
--

CREATE TABLE `study_fields` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `study_fields`
--

INSERT INTO `study_fields` (`id`, `title`) VALUES
(1, 'کامپیوتر'),
(2, 'حسابداری'),
(3, 'مدیریت'),
(4, 'ریاضی'),
(5, 'مهندسی شیمی'),
(6, 'حقوق'),
(7, 'فناوری اطلاعات و IT'),
(8, 'مکانیک'),
(9, 'عمران'),
(10, 'معارف'),
(11, 'موسیقی'),
(12, 'گرافیک'),
(13, 'هنر‌های تجسمی'),
(14, 'عکاسی'),
(15, 'سینما');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_bounds`
--
ALTER TABLE `age_bounds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_license_sources`
--
ALTER TABLE `business_license_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate_types`
--
ALTER TABLE `certificate_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_fields`
--
ALTER TABLE `job_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merrige_types`
--
ALTER TABLE `merrige_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `study_fields`
--
ALTER TABLE `study_fields`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_bounds`
--
ALTER TABLE `age_bounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `business_license_sources`
--
ALTER TABLE `business_license_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `certificate_types`
--
ALTER TABLE `certificate_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `job_fields`
--
ALTER TABLE `job_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `merrige_types`
--
ALTER TABLE `merrige_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `study_fields`
--
ALTER TABLE `study_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
