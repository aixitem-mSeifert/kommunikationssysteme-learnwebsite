<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Lernbereiche';
$areas = load_data('learning-areas');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell">
    <header class="page-header"><p class="eyebrow">Themenübersicht</p><h1>Lernbereiche</h1><p>Die Gliederung wird aus den bereitgestellten Quellen abgeleitet.</p></header>
    <div class="filter-bar"><label for="area-search">Lernbereich suchen</label><input id="area-search" type="search" data-filter-input="area-list" placeholder="Suchbegriff"></div>
    <div class="content-grid" id="area-list">
        <?php foreach ($areas as $area): ?>
            <article class="area-card" data-filter-text="<?= e((string) $area['title'] . ' ' . (string) $area['summary']) ?>">
                <p class="priority priority-<?= e(str_replace(' ', '-', (string) $area['examPriority'])) ?>">Prüfungspriorität: <?= e((string) $area['examPriority']) ?></p>
                <h2><a href="<?= e(page_url('learning-area.php', ['area' => $area['slug']])) ?>"><?= e((string) $area['title']) ?></a></h2>
                <p><?= e((string) $area['summary']) ?></p>
                <ul><?php foreach ($area['learningObjectives'] as $objective): ?><li><?= e((string) $objective) ?></li><?php endforeach; ?></ul>
            </article>
        <?php endforeach; ?>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>