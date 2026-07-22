<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/content-renderer.php';
$areas = load_data('learning-areas');
$slug = filter_input(INPUT_GET, 'area', FILTER_UNSAFE_RAW);
$area = is_string($slug) ? find_by($areas, 'slug', $slug) : null;
if ($area === null) {
    abort_not_found('Dieser Lernbereich ist nicht vorhanden.');
}
$topics = array_values(array_filter(load_data('topics'), static fn (array $topic): bool => $topic['areaId'] === $area['id']));
$pageTitle = (string) $area['title'];
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell">
    <header class="page-header"><p class="eyebrow">Lernbereich</p><h1><?= e((string) $area['title']) ?></h1><p><?= e((string) ($area['summary'] ?? '')) ?></p></header>
    <section class="objectives"><h2>Lernziele</h2><ul><?php foreach ($area['learningObjectives'] as $objective): ?><li><?= e((string) $objective) ?></li><?php endforeach; ?></ul></section>
    <?php foreach ($topics as $topic): ?>
        <p class="topic-intro"><?= e((string) $topic['intro']) ?></p>
        <aside class="exam-note"><strong>Prüfungsbezug</strong><p><?= e((string) $topic['examNotes']) ?></p></aside>
        <section class="learning-content" aria-label="Unterthemen">
            <?php foreach ($topic['blocks'] as $block) { render_content_block($block); } ?>
        </section>
    <?php endforeach; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>