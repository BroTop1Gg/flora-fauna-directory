<?php

declare(strict_types=1);

/**
 * Admin Dashboard controller.
 * Displays management interface for all entries.
 */

// Initialize application
require_once __DIR__ . '/../core/init.php';

// Access Control: Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Model: Fetch all entries for the management table
$entries = get_all_entries($db_connection);

// Page metadata
$page_title = "Адмін-панель - Керування записниками";

// View: Include template parts
require_once __DIR__ . '/../views/header.view.php';
require_once __DIR__ . '/../views/admin/index.view.php';
require_once __DIR__ . '/../views/footer.view.php';
