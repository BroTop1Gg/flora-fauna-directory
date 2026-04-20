<?php

declare(strict_types=1);

/**
 * Category controller.
 * Filters entries by category and renders the view.
 */

// Initialize application
require_once __DIR__ . '/core/init.php';

// Get and validate category ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: /');
    exit;
}

// Model: Fetch category details
$category = get_category_by_id($db_connection, $id);

if (!$category) {
    header('Location: /');
    exit;
}

// Model: Fetch entries for this category
$entries = get_entries_by_category($db_connection, $id);

// Page metadata
$page_title = $category['name'] . " - Довідник флори та фауни";

// View: Include template parts
require_once __DIR__ . '/views/header.view.php';
require_once __DIR__ . '/views/category.view.php';
require_once __DIR__ . '/views/footer.view.php';
