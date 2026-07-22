<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/content-renderer.php';
$slug = filter_input(INPUT_GET, 'topic', FILTER_UNSAFE_RAW);
$topic = is_string($slug) ? find_by(load_data('topics'), 'slug', $slug) : null;
if ($topic === null) {
    abort_not_found('Dieses Unterthema ist nicht vorhanden.');
}
$area = find_by(load_data('learning-areas'), 'id', (string) $topic['areaId']);
$pageTitle = (string) $topic['title'];
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell topic-layout">
    <nav class="breadcrumbs" aria-label="Brotkrümelnavigation"><a href="learning-areas.php">Lernbereiche</a><span aria-hidden="true">/</span><a href="<?= e(page_url('learning-area.php', ['area' => $area['slug'] ?? ''])) ?>"><?= e((string) ($area['title'] ?? 'Lernbereich')) ?></a></nav>
    <header class="page-header"><p class="eyebrow">Unterthema</p><h1><?= e((string) $topic['title']) ?></h1><p><?= e((string) $topic['intro']) ?></p></header>
    <aside class="exam-note"><strong>Prüfungsbezug</strong><p><?= e((string) $topic['examNotes']) ?></p></aside>
    <div class="learning-content"><?php foreach ($topic['blocks'] as $block) { render_content_block($block); } ?></div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>