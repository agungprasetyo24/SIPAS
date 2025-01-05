-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2025 at 11:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas-st-bayes`
--

-- --------------------------------------------------------

--
-- Table structure for table `dataset`
--

CREATE TABLE `dataset` (
  `id` int NOT NULL,
  `bidang_minat` varchar(50) DEFAULT NULL,
  `spesialisasi` varchar(50) DEFAULT NULL,
  `tingkat_keahlian` varchar(20) DEFAULT NULL,
  `metode_pembelajaran` varchar(50) DEFAULT NULL,
  `rekomendasi` varchar(200) DEFAULT NULL,
  `rujukan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dataset`
--

INSERT INTO `dataset` (`id`, `bidang_minat`, `spesialisasi`, `tingkat_keahlian`, `metode_pembelajaran`, `rekomendasi`, `rujukan`) VALUES
(1, 'Pemrograman', 'Web Developer', 'Pemula', 'Video', 'HTML CSS Fundamental Course', 'FreeCodeCamp, Traversy Media'),
(2, 'Pemrograman', 'Web Developer', 'Menengah', 'Artikel', 'React.js Development', 'React Documentation, Medium'),
(3, 'Pemrograman', 'Mobile Developer', 'Pemula', 'Video', 'Flutter Basic Course', 'Flutter Dev Channel, Net Ninja'),
(4, 'Pemrograman', 'Mobile Developer', 'Menengah', 'Artikel', 'Advanced Android Development', 'Android Developers Blog'),
(5, 'Pemrograman', 'Data Science', 'Pemula', 'Video', 'Python for Data Science', 'DataCamp, Kaggle'),
(6, 'Pemrograman', 'Game Developer', 'Pemula', 'Video', 'Unity Basics', 'Unity Learn, Brackeys'),
(7, 'Pemrograman', 'Backend Developer', 'Pemula', 'Artikel', 'Node.js Fundamentals', 'Node.js Docs, Dev.to'),
(8, 'Jaringan', 'Network Administration', 'Pemula', 'Video', 'CCNA Basics', 'CBT Nuggets, NetworkChuck'),
(9, 'Jaringan', 'Cloud Computing', 'Pemula', 'Artikel', 'AWS Fundamentals', 'AWS Documentation, A Cloud Guru'),
(10, 'Jaringan', 'Cybersecurity', 'Menengah', 'Video', 'Security+ Certification', 'Professor Messer, ITProTV'),
(11, 'Jaringan', 'System Administration', 'Pemula', 'Video', 'Linux Administration', 'Linux Academy, TechWorld'),
(12, 'Jaringan', 'DevOps', 'Menengah', 'Artikel', 'Docker and Kubernetes', 'Docker Docs, Kubernetes.io'),
(13, 'Desain', 'UI/UX Design', 'Pemula', 'Video', 'UI Design Fundamentals', 'DesignCourse, Flux Academy'),
(14, 'Desain', 'Graphic Design', 'Pemula', 'Video', 'Adobe Photoshop Basics', 'Envato Tuts+, PHLEARN'),
(15, 'Desain', 'Motion Graphics', 'Menengah', 'Video', 'After Effects Essential', 'School of Motion, VideoHive'),
(16, 'Desain', '3D Modeling', 'Pemula', 'Video', 'Blender Basics', 'Blender Guru, CG Cookie'),
(17, 'Desain', 'Web Design', 'Pemula', 'Artikel', 'Responsive Web Design', 'Smashing Magazine, Web Design Weekly');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_konsultasi`
--

CREATE TABLE `hasil_konsultasi` (
  `id` int NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `umur` int DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `bidang_minat` varchar(50) DEFAULT NULL,
  `spesialisasi` varchar(50) DEFAULT NULL,
  `tingkat_keahlian` varchar(20) DEFAULT NULL,
  `metode_pembelajaran` varchar(50) DEFAULT NULL,
  `rekomendasi` varchar(200) DEFAULT NULL,
  `rujukan` varchar(200) DEFAULT NULL,
  `probabilitas` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hasil_konsultasi`
--

INSERT INTO `hasil_konsultasi` (`id`, `tanggal`, `nama`, `umur`, `jenis_kelamin`, `bidang_minat`, `spesialisasi`, `tingkat_keahlian`, `metode_pembelajaran`, `rekomendasi`, `rujukan`, `probabilitas`) VALUES
(13, '2025-01-05 11:16:53', 'Gasali', 17, 'Laki-laki', 'Pemrograman', 'Data Science', 'Pemula', 'Buku', 'Python for Data Science', 'DataCamp, Kaggle', 33.3333);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(7, 'agung24', '$2y$10$yRFCC3lcmTR9GgAybeOO9uKfqqzieuqAhbPg1hxB92XMTe8kDCk32', 'shirome910@gmail.com', '2025-01-05 10:06:23'),
(8, 'user', '$2y$10$T3YbzF/WFNnCpkngDvR26uudEYt/4EHX/Anzpm05f7M7p/4x4XY46', 'user@mail.com', '2025-01-05 11:06:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dataset`
--
ALTER TABLE `dataset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hasil_konsultasi`
--
ALTER TABLE `hasil_konsultasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dataset`
--
ALTER TABLE `dataset`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `hasil_konsultasi`
--
ALTER TABLE `hasil_konsultasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
