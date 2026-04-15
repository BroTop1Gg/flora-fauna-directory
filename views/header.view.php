<?php

declare(strict_types=1);

/**
 * Main application header.
 * Provides the navigation and Bootstrap 5 boilerplate.
 */
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?? '' ?>">
    <title><?= $page_title ?? 'Довідник флори та фауни' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🌿 Flora & Fauna</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($header_menu as $menu_item): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= htmlspecialchars($menu_item['url']) ?>">
                                <?= htmlspecialchars($menu_item['title']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php if (isset($header_categories)): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Категорії
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="categoryDropdown">
                                <?php foreach ($header_categories as $category): ?>
                                    <li>
                                        <a class="dropdown-item" href="/category.php?id=<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex ms-lg-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/admin/index.php" class="btn btn-outline-light btn-sm">Адмін-панель</a>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-primary btn-sm">Вхід</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <main class="container py-5">
