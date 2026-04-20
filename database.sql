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
INSERT IGNORE INTO `menu` (`id`, `title`, `url`) VALUES 
(1, 'Головна', '/'),
(2, 'Про проєкт', '/about.php'),
(3, 'Контакти', '/contact.php');

-- Initial entries
INSERT IGNORE INTO `entries` (`category_id`, `title`, `content`, `image_path`) VALUES 
(1, 'Біле латаття (Nymphaea alba)', 'Багаторічна водяна рослина з плаваючим листям і великими білими квітками. Росте в стоячих і повільно текучих водах.', 'water_lily.jpg'),
(1, 'Дуб звичайний (Quercus robur)', 'Довговічне дерево родини букових. Одна з найпоширеніших деревних порід у помірній смузі Європи.', 'oak.jpg'),
(1, 'Сосна звичайна (Pinus sylvestris)', 'Хвойне дерево, що широко розповсюджене в Євразії. Має високу стійкість до несприятливих умов.', 'pine.jpg'),
(1, 'Проліска дволиста (Scilla bifolia)', 'Ранньовесняна багаторічна трав''яниста рослина. Цвіте у березні-квітні дрібними блакитними квітками.', 'scilla.jpg'),
(1, 'Ковила дніпровська (Stipa borysthenica)', 'Багаторічна злакова рослина, занесена до Червоної книги України. Характерна для піщаних степів.', 'stipa.jpg'),
(1, 'Шафран Гейфеля (Crocus heuffelianus)', 'Рідкісна весняна квітка карпатських високогір''їв. Має насичений фіолетовий колір пелюсток.', 'crocus.jpg'),
(1, 'Лаванда вузьколиста (Lavandula angustifolia)', 'Вічнозелений напівчагарник з ароматними синьо-фіолетовими квітками. Використовується в медицині та парфумерії.', 'lavender.jpg'),
(1, 'Барвінок малий (Vinca minor)', 'Вічнозелена напівкущова рослина з повзучими пагонами та блакитними квітками. Символ життя в українській культурі.', 'periwinkle.jpg'),
(1, 'Конвалія травнева (Convallaria majalis)', 'Багаторічна трав''яниста рослина з дзвоникоподібними запашними квітами. Росте в тінистих лісах.', 'lily_of_valley.jpg'),
(1, 'Мати-й-мачуха (Tussilago farfara)', 'Багаторічна трав''яниста рослина, що цвіте ранньою весною до появи листя. Використовується як лікарська сировина.', 'coltsfoot.jpg'),
(2, 'Бурий ведмідь (Ursus arctos)', 'Хижий ссавець родини ведмежих. Один з найбільших наземних хижаків, що мешкають в лісах Євразії.', 'brown_bear.jpg'),
(2, 'Орел-беркут (Aquila chrysaetos)', 'Один з найбільших хижих птахів родини яструбових. В Україні рідкісний гніздовий птах Карпат.', 'golden_eagle.jpg'),
(2, 'Козуля європейська (Capreolus capreolus)', 'Ссавець родини оленевих. Граційна тварина, поширена в лісових та лісостепових зонах.', 'roe_deer.jpg'),
(2, 'Лисиця звичайна (Vulpes vulpes)', 'Найпоширеніший вид роду лисиць. Відома своєю адаптивністю до різних середовищ існування.', 'fox.jpg'),
(2, 'Борсук європейський (Meles meles)', 'Великий хижий ссавець родини куницевих. Веде переважно нічний спосіб життя в складних норах.', 'badger.jpg'),
(2, 'Рись євразійська (Lynx lynx)', 'Великий котячий хижак з характерними китицями на вухах. Мешкає переважно в глухих лісах.', 'lynx.jpg'),
(2, 'Чорний лелека (Ciconia nigra)', 'Рідкісний птах, що веде прихований спосіб життя. Гніздиться в старих лісах поблизу боліт.', 'black_stork.jpg'),
(2, 'Зубр (Bison bonasus)', 'Найбільший наземний ссавець Європи. Вид, що був врятований від повного вимирання.', 'bison.jpg'),
(2, 'Горностай (Mustela erminea)', 'Малий спритний хижак, відомий зміною забарвлення хутра на біле в зимовий період.', 'ermine.jpg'),
(2, 'Пугач (Bubo bubo)', 'Один з найбільших представників ряду совоподібних. Має характерні вушні пучки пір''я.', 'eagle_owl.jpg');
