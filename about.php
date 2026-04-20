<?php
/**
 * About page.
 */
declare(strict_types=1);
require_once __DIR__ . '/core/init.php';
$page_title = "Про проєкт - Довідник флори та фауни";
require_once __DIR__ . '/views/header.view.php';
?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="display-5 fw-bold mb-4">Про проєкт</h1>
        <p>Цей веб-довідник створений як індивідуальне завдання з дисципліни "Веб-технології".</p>
        <p>Мета проєкту — надати зручний інтерфейс для ознайомлення з різноманіттям флори та фауни, а також продемонструвати навички розробки на PHP з використанням архітектури Micro-MVC.</p>
    </div>
</div>
<?php
require_once __DIR__ . '/views/footer.view.php';
