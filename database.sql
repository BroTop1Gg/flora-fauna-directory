-- Database schema for Flora and Fauna Directory
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- Stores credentials for administrative panel access.
CREATE TABLE IF NOT EXISTS `administrators` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores biological or environmental groupings (e.g., Mammals, Birds, etc.).
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Stores public navigation menu items.
CREATE TABLE IF NOT EXISTS `menu` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(50) NOT NULL,
    `url` VARCHAR(100) NOT NULL DEFAULT '/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- Seed Data

-- Admin account
INSERT IGNORE INTO `administrators` (`username`, `password_hash`) VALUES 
('admin', '$2y$10$8/LDJoOijFttQQKrMufknOxvZwJ5JQVnFqKk3Qi2CXu9xa/eVwjr.');

-- Initial categories
INSERT IGNORE INTO `categories` (`id`, `name`) VALUES 
(1, 'Flora (Рослини)'),
(2, 'Fauna (Тварини)');

-- Initial menu items
INSERT IGNORE INTO `menu` (`id`, `title`, `url`) VALUES 
(1, 'Головна', '/'),
(2, 'Про проєкт', '/about.php'),
(3, 'Контакти', '/contact.php');

-- Initial entries
INSERT IGNORE INTO `entries` (`id`, `category_id`, `title`, `content`, `image_path`) VALUES 
(1, 1, 'Біле латаття (Nymphaea alba)', 'Багаторічна водяна рослина з плаваючим листям і великими білими квітками. Росте в стоячих і повільно текучих водах.', '7154eb892f61ee9d_1776714159.jpeg'),
(2, 1, 'Дуб звичайний (Quercus robur)', 'Довговічне дерево родини букових. Одна з найпоширеніших деревних порід у помірній смузі Європи.', 'fdfdbd8dc6a9d33c_1776712744.jpeg'),
(3, 1, 'Сосна звичайна (Pinus sylvestris)', 'Хвойне дерево, що широко розповсюджене в Євразії. Має високу стійкість до несприятливих умов.', '2486baecfa9d12c9_1776712786.jpeg'),
(4, 1, 'Проліска дволиста (Scilla bifolia)', 'Ранньовесняна багаторічна трав''яниста рослина. Цвіте у березні-квітні дрібними блакитними квітками.', '9d409be57647bffd_1776712827.jpg'),
(5, 1, 'Ковила дніпровська (Stipa borysthenica)', 'Багаторічна злакова рослина, занесена до Червоної книги України. Характерна для піщаних степів.', 'caa66623a294c2bd_1776714209.jpeg'),
(6, 1, 'Шафран Гейфеля (Crocus heuffelianus)', 'Рідкісна весняна квітка карпатських високогір''їв. Має насичений фіолетовий колір пелюсток.', 'e4549b37c282f9e0_1776714393.jpeg'),
(7, 1, 'Лаванда вузьколиста (Lavandula angustifolia)', 'Вічнозелений напівчагарник з ароматними синьо-фіолетовими квітками. Використовується в медицині та парфумерії.', '244762149804c367_1776714434.jpeg'),
(8, 1, 'Барвінок малий (Vinca minor)', 'Вічнозелена напівкущова рослина з повзучими пагонами та блакитними квітками. Символ життя в українській культурі.', '177661b0cf1f9be7_1776713210.jpeg'),
(9, 1, 'Конвалія травнева (Convallaria majalis)', 'Багаторічна трав''яниста рослина з дзвоникоподібними запашними квітами. Росте в тінистих лісах.', 'f3946d4532d68a24_1776713246.webp'),
(10, 1, 'Мати-й-мачуха (Tussilago farfara)', 'Багаторічна трав''яниста рослина, що цвіте ранньою весною до появи листя. Використовується як лікарська сировина.', 'b854570dc954ca2f_1776713313.jpeg'),
(11, 2, 'Бурий ведмідь (Ursus arctos)', 'Хижий ссавець родини ведмежих. Один з найбільших наземних хижаків, що мешкають в лісах Євразії.', '5250ac487020d3d1_1776713354.jpeg'),
(12, 2, 'Орел-беркут (Aquila chrysaetos)', 'Один з найбільших хижих птахів родини яструбових. В Україні рідкісний гніздовий птах Карпат.', '1b1c9cf1d5911e1b_1776713409.jpeg'),
(13, 2, 'Козуля європейська (Capreolus capreolus)', 'Ссавець родини оленевих. Граційна тварина, поширена в лісових та лісостепових зонах.', '11a2d1a8df47e7cd_1776713464.jpeg'),
(14, 2, 'Лисиця звичайна (Vulpes vulpes)', 'Найпоширеніший вид роду лисиць. Відома своєю адаптивністю до різних середовищ існування.', 'a73e93e2742f7c89_1776713499.jpg'),
(15, 2, 'Борсук європейський (Meles meles)', 'Великий хижий ссавець родини куницевих. Веде переважно нічний спосіб життя в складних норах.', 'b96168c2753c7e01_1776713539.jpeg'),
(16, 2, 'Рись євразійська (Lynx lynx)', 'Великий котячий хижак з характерними китицями на вухах. Мешкає переважно в глухих лісах.', '5edc5686433cd0fb_1776713574.jpg'),
(17, 2, 'Чорний лелека (Ciconia nigra)', 'Рідкісний птах, що веде прихований спосіб життя. Гніздиться в старих лісах поблизу боліт.', '9154e8f275060261_1776713612.jpg'),
(18, 2, 'Зубр (Bison bonasus)', 'Найбільший наземний ссавець Європи. Вид, що був врятований від повного вимирання.', '761653493c7e445e_1776713646.jpeg'),
(19, 2, 'Горностай (Mustela erminea)', 'Малий спритний хижак, відомий зміною забарвлення хутра на біле в зимовий період.', '2111442ffcc28c58_1776713681.jpeg'),
(20, 2, 'Пугач (Bubo bubo)', 'Один з найбільших представників ряду совоподібних. Має характерні вушні пучки пір''я.', '4c82819f6e3874a6_1776713732.jpg');
