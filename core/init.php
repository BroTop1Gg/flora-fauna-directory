<?php

declare(strict_types=1);

/**
 * Bootstrapper for the Flora and Fauna Directory application.
 * Initializes environment, sessions, and security tokens.
 */

// NOTE: We assume 'vendor/autoload.php' exists after running composer.
$autoloader_path = __DIR__ . '/../vendor/autoload.php';

if (file_exists($autoloader_path)) {
    require_once $autoloader_path;
}

// Start secure session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure'   => isset($_SERVER['HTTPS']),
        'cookie_samesite' => 'Lax',
    ]);
}

// Load Environment Variables
if (class_exists('Dotenv\Dotenv')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();
}

// Generate CSRF token if it doesn't exist to prevent Race Conditions
if (empty($_SESSION['csrf_token'])) {
    try {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
        // NOTE: fallback if random_bytes fails, though extremely unlikely on modern PHP
        $_SESSION['csrf_token'] = md5(uniqid((string)mt_rand(), true));
    }
}

// Basic error reporting for development
if (($_ENV['APP_ENV'] ?? 'development') === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}

// Include models/functions
require_once __DIR__ . '/functions.php';

// Initialize Database connection
try {
    $db_connection = get_db_connection();
    
    // Global data available to all views
    $header_menu = get_navigation_menu($db_connection);
    $header_categories = get_active_categories($db_connection);
} catch (PDOException $e) {
    if (($_ENV['APP_ENV'] ?? 'development') === 'development') {
        die("Помилка підключення до бази даних: " . $e->getMessage());
    }
    error_log("DB Connection Error: " . $e->getMessage());
    // In production, we might show a cleaner error page
}
