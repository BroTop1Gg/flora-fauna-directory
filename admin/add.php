<?php

declare(strict_types=1);

/**
 * Add entry controller.
 * Handles the creation of new flora/fauna records.
 */

require_once __DIR__ . '/../core/init.php';

// Access Control
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$error = null;
$success = null;

// Handle form submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF Verification
    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die('Помилка безпеки: CSRF токен невалідний.');
    }

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $image_path = null;

    if (empty($title) || empty($content) || $category_id <= 0) {
        $error = "Будь ласка, заповніть усі обов'язкові поля.";
    } else {
        // Handle image upload if provided
        if (!empty($_FILES['image']['name'])) {
            $image_path = handle_image_upload($_FILES['image']);
            if (!$image_path) {
                $error = "Помилка при завантаженні зображення. Перевірте формат файлу.";
            }
        }

        if (!$error) {
            $data = [
                'title' => $title,
                'content' => $content,
                'category_id' => $category_id,
                'image_path' => $image_path
            ];

            if (create_entry($db_connection, $data)) {
                $success = "Запис успішно створено!";
                header('Refresh: 2; url=/admin/index.php');
            } else {
                $error = "Помилка при збереженні запису в базі даних.";
            }
        }
    }
}

$categories = get_active_categories($db_connection);
$page_title = "Додати новий запис - Адмін-панель";

require_once __DIR__ . '/../views/header.view.php';
require_once __DIR__ . '/../views/admin/add.view.php';
require_once __DIR__ . '/../views/footer.view.php';
