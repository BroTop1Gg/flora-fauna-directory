<?php
/**
 * Single entry view.
 * Displays details of a specific flora/fauna entry.
 */
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Головна</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($entry['title']) ?></li>
            </ol>
        </nav>

        <article class="card border overflow-hidden">
            <?php if (!empty($entry['image_path'])): ?>
                <img src="/img/<?= htmlspecialchars($entry['image_path']) ?>" class="card-img-top main-entry-image" alt="<?= htmlspecialchars($entry['title']) ?>" style="max-height: 500px; object-fit: cover;">
            <?php endif; ?>
            
            <div class="card-body p-4 p-md-5">
                <div class="d-flex align-items-center mb-3">
                    <span class="badge bg-success me-2"><?= htmlspecialchars($entry['category_name']) ?></span>
                    <small class="text-muted"><?= date('d.m.Y', strtotime($entry['created_at'])) ?></small>
                </div>
                
                <h1 class="display-5 fw-bold mb-4"><?= htmlspecialchars($entry['title']) ?></h1>
                
                <div class="entry-content fs-5 leading-relaxed">
                    <?= nl2br(htmlspecialchars($entry['content'])) ?>
                </div>
                
                <hr class="my-5">
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="/" class="btn btn-outline-secondary">
                        &larr; Повернутися до списку
                    </a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/admin/edit.php?id=<?= $entry['id'] ?>" class="btn btn-warning">
                            Редагувати
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    </div>
</div>
