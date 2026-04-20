<?php
/**
 * Add entry view template.
 */
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold">Додати новий запис</h1>
            <a href="/admin/index.php" class="btn btn-outline-secondary">Скасувати</a>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success mb-4" role="alert">
                <?= htmlspecialchars($success) ?> Вас буде перенаправлено на дашборд через 2 секунди...
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <form action="/admin/add.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Назва <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Введіть назву рослини або тварини" required>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold">Категорія <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">Оберіть категорію...</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label fw-semibold">Зображення</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="form-text">Підтримуються формати JPEG, PNG, WEBP.</div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-semibold">Опис <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="form-control" rows="10" placeholder="Детальний опис..." required></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Зберегти запис</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
