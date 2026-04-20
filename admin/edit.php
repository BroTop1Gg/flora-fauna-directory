<?php

declare(strict_types=1);

/**
 * Edit entry controller.
 * Handles the modification of existing flora/fauna records.
 */

require_once __DIR__ . '/../core/init.php';

// Access Control
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: /admin/index.php');
    exit;
}

// Fetch current entry data
$entry = get_entry_by_id($db_connection, $id);

if (!$entry) {
    header('Location: /admin/index.php');
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
    $image_path = $entry['image_path']; // Keep existing image by default

    if (empty($title) || empty($content) || $category_id <= 0) {
        $error = "Будь ласка, заповніть усі обов'язкові поля.";
    } else {
        // Handle new image upload if provided
        if (!empty($_FILES['image']['name'])) {
            $new_image = handle_image_upload($_FILES['image']);
            if ($new_image) {
                // Delete old image if it exists
                if (!empty($entry['image_path'])) {
                    $old_path = __DIR__ . '/../img/' . $entry['image_path'];
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                $image_path = $new_image;
            } else {
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

            if (update_entry($db_connection, $id, $data)) {
                $success = "Запис успішно оновлено!";
                header('Refresh: 2; url=/admin/index.php');
            } else {
                $error = "Помилка при оновленні запису в базі даних.";
            }
        }
    }
}

$categories = get_active_categories($db_connection);
$page_title = "Редагувати запис - Адмін-панель";

require_once __DIR__ . '/../views/header.view.php';
require_once __DIR__ . '/../views/admin/edit.view.php';
require_once __DIR__ . '/../views/footer.view.php';
