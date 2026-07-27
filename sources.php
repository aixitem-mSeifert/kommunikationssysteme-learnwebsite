<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Quellen';
$sources = load_data('sources');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Nachvollziehbarkeit</p><h1>Quellen</h1><p>Alle bereitgestellten Fach-, Übungs- und Anforderungsquellen mit Verlässlichkeit, Abdeckungsstatus und bekannten Extraktionsproblemen.</p></header>
<div class="source-register"><?php foreach ($sources as $source): ?><article id="source-<?= e((string) $source['id']) ?>" class="source-entry"><div><span class="source-type"><?= e((string) $source['type']) ?></span><h2><?= e((string) $source['title']) ?></h2><p><?= e((string) $source['filename']) ?></p></div><dl><dt>Verlässlichkeit</dt><dd><?= e((string) $source['reliability']) ?></dd><dt>Abdeckung</dt><dd><?= e((string) $source['coverageStatus']) ?></dd></dl><?php if ($source['knownIssues'] !== []): ?><div class="source-issues"><strong>Bekannte Hinweise</strong><ul><?php foreach ($source['knownIssues'] as $issue): ?><li><?= e((string) $issue) ?></li><?php endforeach; ?></ul></div><?php endif; ?></article><?php endforeach; ?></div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>