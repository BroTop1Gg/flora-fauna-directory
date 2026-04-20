<?php
/**
 * Admin Dashboard view.
 * Table of all entries with CRUD actions.
 */
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h2 fw-bold">Керування довідником</h1>
    <div class="btn-group">
        <a href="/admin/add.php" class="btn btn-success">Додати новий запис</a>
        <a href="/admin/logout.php" class="btn btn-outline-danger">Вийти</a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Зображення</th>
                        <th>Назва</th>
                        <th>Категорія</th>
                        <th>Дата створення</th>
                        <th class="text-end pe-4">Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($entries)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Записів поки немає. Створіть свій перший запис!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($entries as $entry): ?>
                            <tr>
                                <td class="ps-4 text-muted">#<?= $entry['id'] ?></td>
                                <td>
                                    <?php if (!empty($entry['image_path'])): ?>
                                        <img src="/img/<?= htmlspecialchars($entry['image_path']) ?>" alt="" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <small class="text-muted">N/A</small>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-semibold"><?= htmlspecialchars($entry['title']) ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($entry['category_name']) ?></span>
                                </td>
                                <td class="text-muted small"><?= date('d.m.Y H:i', strtotime($entry['created_at'])) ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="/item.php?id=<?= $entry['id'] ?>" class="btn btn-outline-secondary" title="Переглянути" target="_blank">
                                            Перегляд
                                        </a>
                                        <a href="/admin/edit.php?id=<?= $entry['id'] ?>" class="btn btn-outline-primary" title="Редагувати">
                                            Редагувати
                                        </a>
                                        <a href="/admin/delete.php?id=<?= $entry['id'] ?>" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirm('Ви впевнені, що хочете видалити цей запис?')"
                                           title="Видалити">
                                            Видалити
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
