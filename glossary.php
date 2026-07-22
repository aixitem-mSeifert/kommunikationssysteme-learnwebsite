<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';
$pageTitle = 'Glossar';
$items = load_data('glossary');
$areas = load_data('learning-areas');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Nachschlagen</p><h1>Glossar</h1><p><?= count($items) ?> Begriffe mit Lernbereich, Quellenstatus und konkreter Fundstelle.</p></header>
<div class="filter-bar filter-bar-wide"><label for="glossary-search">Begriff suchen</label><input id="glossary-search" type="search" data-filter-input="glossary-list" placeholder="Fachbegriff"><label for="glossary-area">Lernbereich</label><select id="glossary-area" data-area-filter="glossary-list"><option value="">Alle Bereiche</option><?php foreach ($areas as $area): ?><option value="<?= e((string) $area['id']) ?>"><?= e((string) $area['title']) ?></option><?php endforeach; ?></select></div>
<div class="glossary-list" id="glossary-list"><?php $letter = ''; foreach ($items as $item): $first = mb_strtoupper(mb_substr((string) $item['term'], 0, 1)); if ($first !== $letter): $letter = $first; ?><h2 class="glossary-letter" data-filter-always><?= e($letter) ?></h2><?php endif; ?><article class="glossary-entry" data-filter-text="<?= e((string) $item['term'] . ' ' . implode(' ', $item['aliases'])) ?>" data-area-id="<?= e((string) $item['areaIds'][0]) ?>"><h3><?= e((string) $item['term']) ?></h3><p><?= e((string) $item['shortDefinition']) ?></p><?php render_source_refs($item['sourceRefs'], $item['sourceNote']); ?></article><?php endforeach; ?></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>