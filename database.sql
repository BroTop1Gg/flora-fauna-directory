-- Database schema for Flora and Fauna Directory

CREATE DATABASE IF NOT EXISTS `flora_fauna` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `flora_fauna`;

-- Stores credentials for administrative panel access.
CREATE TABLE IF NOT EXISTS `administrators` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Stores biological or environmental groupings (e.g., Mammals, Birds, etc.).
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- Stores public navigation menu items.
CREATE TABLE IF NOT EXISTS `menu` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(50) NOT NULL,
    `url` VARCHAR(100) NOT NULL DEFAULT '/'
) ENGINE=InnoDB;

-- Stores the primary records for flora and fauna items.
CREATE TABLE IF NOT EXISTS `entries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `content` TEXT NOT NULL,
    `image_path` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_entries_category` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seed Data

-- Admin account
INSERT IGNORE INTO `administrators` (`username`, `password_hash`) VALUES 
('admin', '$2y$10$8/LDJoOijFttQQKrMufknOxvZwJ5JQVnFqKk3Qi2CXu9xa/eVwjr.');

-- Initial categories
INSERT IGNORE INTO `categories` (`id`, `name`) VALUES 
(1, 'Flora (Рослини)'),
(2, 'Fauna (Тварини)');

-- Initial menu items
INSERT IGNORE INTO `menu` (`title`, `url`) VALUES 
('Головна', '/'),
('Про проєкт', '/about.php'),
('Контакти', '/contact.php');
