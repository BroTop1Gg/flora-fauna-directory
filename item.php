<?php

declare(strict_types=1);

/**
 * Single entry controller.
 * Fetches specific entry and renders its detail page.
 */

// Initialize application
require_once __DIR__ . '/core/init.php';

// Get and validate entry ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    // Redirect to home if no valid ID provided
    header('Location: /');
    exit;
}

// Model: Fetch specific entry
$entry = get_entry_by_id($db_connection, $id);

if (!$entry) {
    // Graceful error if entry not found
    $page_title = "Запис не знайдено - Довідник";
    require_once __DIR__ . '/views/header.view.php';
    echo '<div class="alert alert-danger">Вибачте, запис із таким ID не знайдено. <a href="/">Повернутися на головну</a></div>';
    require_once __DIR__ . '/views/footer.view.php';
    exit;
}

// Page metadata
$page_title = $entry['title'] . " - Довідник флори та фауни";

// View: Include template parts
require_once __DIR__ . '/views/header.view.php';
require_once __DIR__ . '/views/item.view.php';
require_once __DIR__ . '/views/footer.view.php';
