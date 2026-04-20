<?php
/**
 * Category view template.
 * Renders entries filtered by a specific category.
 */
?>

<div class="row align-items-center mb-5">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Головна</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($category['name']) ?></li>
            </ol>
        </nav>
        <h1 class="display-4 fw-bold"><?= htmlspecialchars($category['name']) ?></h1>
        <p class="lead text-muted">Перегляд усіх записів у категорії "<?= htmlspecialchars($category['name']) ?>".</p>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <?php if (empty($entries)): ?>
        <div class="col-12 text-center py-5">
            <div class="alert alert-info">
                У цій категорії поки що немає записів.
            </div>
            <a href="/" class="btn btn-primary">Повернутися на головну</a>
        </div>
    <?php else: ?>
        <?php foreach ($entries as $entry): ?>
            <div class="col">
                <div class="card h-100 border">
                    <?php if (!empty($entry['image_path'])): ?>
                        <img src="/img/<?= htmlspecialchars($entry['image_path']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($entry['title']) ?>"
                             style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <span class="small">Фото відсутнє</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <?= htmlspecialchars($entry['title']) ?>
                        </h5>
                        <p class="card-text text-muted small">
                            <?= htmlspecialchars(mb_strimwidth(strip_tags($entry['content']), 0, 100, "...")) ?>
                        </p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="/item.php?id=<?= (int)$entry['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                            Читати далі
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
