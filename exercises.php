<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';
$pageTitle = 'Übungen';
$exercises = load_data('exercises');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Klausurvorbereitung</p><h1>Übungen</h1><p>Die bereitgestellten Übungsblätter sind nach Thema geordnet. Aufgaben, Lösungshinweise, Tabellen und Codebeispiele werden aus den Originaldateien vollständig angezeigt.</p></header>
<nav class="exam-picker exercise-index" aria-label="Übungsblätter"><strong>Direkt zu:</strong><?php foreach ($exercises as $exercise): ?><a href="#<?= e((string) $exercise['id']) ?>"><?= e((string) $exercise['title']) ?></a><?php endforeach; ?></nav>
<div class="exercise-list">
<?php foreach ($exercises as $exercise): ?>
    <?php $sourcePath = APP_ROOT . '/' . ltrim((string) $exercise['filename'], '/\\'); $content = is_file($sourcePath) ? file_get_contents($sourcePath) : false; ?>
    <article id="<?= e((string) $exercise['id']) ?>" class="exam-paper exercise-paper">
        <header class="exam-header"><div><p class="eyebrow">Übungsblatt</p><h2><?= e((string) $exercise['title']) ?></h2><p><?= e((string) $exercise['description']) ?></p></div><a class="exercise-file-link" href="<?= e((string) $exercise['filename']) ?>">Originaldatei öffnen</a></header>
        <div class="exercise-summary"><section><h3>Aufgabenfolge</h3><ol><?php foreach ($exercise['tasks'] as $task): ?><li><?= e((string) $task) ?></li><?php endforeach; ?></ol></section><section><h3>Themen</h3><ul><?php foreach ($exercise['topics'] as $topic): ?><li><?= e((string) $topic) ?></li><?php endforeach; ?></ul><p><strong>Lösungsstatus:</strong> <?= e((string) $exercise['solutionStatus']) ?></p></section></div>
        <?php if (($exercise['tables'] ?? []) !== []): ?><section class="exercise-tables" aria-label="Formatierte Tabellen"><h3>Formatierte Tabellen</h3><?php foreach ($exercise['tables'] as $table): ?><div class="exercise-table-wrap"><table><caption><?= e((string) $table['title']) ?></caption><thead><tr><?php foreach ($table['headers'] as $header): ?><th scope="col"><?= e((string) $header) ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ($table['rows'] as $row): ?><tr><?php foreach ($row as $cell): ?><td><?= e((string) $cell) ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table><?php if (($table['note'] ?? null) !== null): ?><p class="exercise-table-note"><?= e((string) $table['note']) ?></p><?php endif; ?></div><?php endforeach; ?></section><?php endif; ?>
        <details class="exercise-original" open><summary>Aufgaben und Lösungen aus der Originaldatei</summary><?php if ($content === false): ?><div class="notice notice-warning"><strong>Originaldatei nicht gefunden</strong><p><?= e((string) $exercise['filename']) ?></p></div><?php else: ?><pre class="exercise-text"><?= e((string) $content) ?></pre><?php endif; ?></details>
        <?php render_source_refs((array) $exercise['sourceRefs']); ?>
    </article>
<?php endforeach; ?>
</div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>