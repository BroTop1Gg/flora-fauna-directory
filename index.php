<?php

declare(strict_types=1);

/**
 * Home page controller.
 * Fetches initial entries and renders the directory catalog.
 */

// Initialize application
require_once __DIR__ . '/core/init.php';

// Model: Fetch all entries (currently limited to 12 for the home page)
$entries = get_all_entries($db_connection, 12);

// Page metadata
$page_title = "Головна - Довідник флори та фауни";

// View: Include template parts
require_once __DIR__ . '/views/header.view.php';
require_once __DIR__ . '/views/index.view.php';
require_once __DIR__ . '/views/footer.view.php';
