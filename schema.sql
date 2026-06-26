-- SQL Database Schema for CleVista Group Limited
-- Designed for MySQL/MariaDB on traditional cPanel web hosts

SET FOREIGN_KEY_CHECKS=0;

-- 1. Admin Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Properties (Estates Division) Table
CREATE TABLE IF NOT EXISTS `properties` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `type` ENUM('Land', 'Property', 'Development') NOT NULL,
  `status` ENUM('For Sale', 'For Rent', 'Invested') NOT NULL,
  `price` VARCHAR(100) NOT NULL,
  `location` VARCHAR(255) NOT NULL DEFAULT 'Diani',
  `description_en` TEXT NOT NULL,
  `description_sw` TEXT NOT NULL,
  `description_de` TEXT NOT NULL,
  `description_it` TEXT NOT NULL,
  `description_fr` TEXT NOT NULL,
  `description_pl` TEXT NOT NULL,
  `features` TEXT NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Villas (Hospitality Division) Table
CREATE TABLE IF NOT EXISTS `villas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `price_per_night` VARCHAR(100) NOT NULL,
  `capacity` VARCHAR(100) NOT NULL,
  `location` VARCHAR(255) NOT NULL DEFAULT 'Diani',
  `description_en` TEXT NOT NULL,
  `description_sw` TEXT NOT NULL,
  `description_de` TEXT NOT NULL,
  `description_it` TEXT NOT NULL,
  `description_fr` TEXT NOT NULL,
  `description_pl` TEXT NOT NULL,
  `features` TEXT NOT NULL,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. General Inquiries Table
CREATE TABLE IF NOT EXISTS `inquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `subject` VARCHAR(255) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `division` ENUM('General', 'Estates', 'Care', 'Hospitality') NOT NULL DEFAULT 'General',
  `reference_id` INT DEFAULT NULL,
  `status` ENUM('New', 'Read', 'Replied') NOT NULL DEFAULT 'New',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Bookings (Care & Hospitality Bookings) Table
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `service_type` ENUM('Care', 'Hospitality') NOT NULL,
  `service_name` VARCHAR(100) NOT NULL,
  `preferred_date` DATE NOT NULL,
  `details` TEXT DEFAULT NULL,
  `status` ENUM('Pending', 'Confirmed', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS=1;
