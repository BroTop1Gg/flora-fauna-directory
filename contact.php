<?php
/**
 * Contact page.
 */
declare(strict_types=1);
require_once __DIR__ . '/core/init.php';
$page_title = "Контакти - Довідник флори та фауни";
require_once __DIR__ . '/views/header.view.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="display-5 fw-bold mb-4">Зворотний зв'язок</h1>
        <p>Якщо у вас виникли запитання щодо роботи сервісу, будь ласка, звертайтеся за наступними контактами:</p>
        <ul class="list-unstyled mt-4">
            <li class="mb-2">📧 GitHub: <a href="https://github.com/BroTop1Gg" target="_blank">BroTop1Gg</a></li>
            <li class="mb-2">✉️ Email: <a href="mailto:135653314+BroTop1Gg@users.noreply.github.com">135653314+BroTop1Gg@users.noreply.github.com</a></li>
        </ul>
    </div>
</div>
<?php
require_once __DIR__ . '/views/footer.view.php';
