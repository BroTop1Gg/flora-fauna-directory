<?php

declare(strict_types=1);

/**
 * Delete entry controller.
 */

require_once __DIR__ . '/../core/init.php';

// Access Control
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    delete_entry($db_connection, $id);
}

header('Location: /admin/index.php');
exit;
