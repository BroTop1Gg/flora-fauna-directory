<?php
/**
 * Login page view template.
 * Simple, secure form for administrator authentication.
 */
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow border-0 mt-5">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Вхід в адмін-панель</h2>
                    <p class="text-muted">Тільки для авторизованих користувачів</p>
                </div>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="/login.php" method="POST">
                    <!-- CSRF Protection -->
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label">Ім'я користувача</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Введіть логін" required autofocus>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Введіть пароль" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">Увійти</button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <a href="/" class="text-decoration-none small text-muted">&larr; На головну сторінку</a>
                </div>
            </div>
        </div>
    </div>
</div>
