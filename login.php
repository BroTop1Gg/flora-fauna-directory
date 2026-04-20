<?php

declare(strict_types=1);

/**
 * Login controller.
 * Handles administrator authentication and session management.
 */

// Initialize application
require_once __DIR__ . '/core/init.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /admin/index.php');
    exit;
}

$error = null;

// Handle authentication request (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. CSRF Verification
    $token = $_POST['csrf_token'] ?? '';
    if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die('Помилка безпеки: CSRF токен невалідний.');
    }

    // 2. Extract and sanitize input
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Будь ласка, заповніть усі поля.";
    } else {
        // 3. Model: Fetch user
        $user = get_admin_by_username($db_connection, $username);

        // 4. Verification logic
        if ($user && password_verify($password, $user['password_hash'])) {
            // Success: Regenerate session ID to prevent Session Fixation
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: /admin/index.php');
            exit;
        } else {
            $error = "Неправильне ім'я користувача або пароль.";
            // Security Best Practice: Use a generic error message
        }
    }
}

// Page metadata
$page_title = "Авторизація - Довідник флори та фауни";

// View: Include template parts
require_once __DIR__ . '/views/header.view.php';
require_once __DIR__ . '/views/login.view.php';
require_once __DIR__ . '/views/footer.view.php';
