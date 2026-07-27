<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';
$pageTitle = 'Übungen';
$exercises = load_data('exercises');
$renderTable = static function (array $table, string $class = '', bool $fillable = false, string $inputPrefix = 'exercise'): void {
    ?>
    <div class="exercise-table-wrap <?= e($class) ?>">
        <table>
            <caption><?= e((string) ($table['title'] ?? 'Tabelle')) ?></caption>
            <thead><tr><?php foreach (($table['headers'] ?? []) as $header): ?><th scope="col"><?= e((string) $header) ?></th><?php endforeach; ?></tr></thead>
            <tbody><?php foreach (($table['rows'] ?? []) as $rowIndex => $row): ?><tr><?php foreach ($row as $cellIndex => $cell): ?><?php $editable = $fillable && ($cell === '' || $cell === null); ?><td<?= $editable ? ' class="exercise-blank-cell"' : '' ?>><?php if ($editable): ?><input class="exercise-table-input" type="text" name="<?= e($inputPrefix . '-' . $rowIndex . '-' . $cellIndex) ?>" aria-label="Tabelle, Zeile <?= e((string) ($rowIndex + 1)) ?>, Spalte <?= e((string) ($cellIndex + 1)) ?>"><?php else: ?><?= e((string) $cell) ?><?php endif; ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody>
        </table>
    </div>
    <?php
};
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Klausurvorbereitung</p><h1>Übungen</h1><p>Bearbeite die Aufgaben zunächst selbst. Vorgegebene Tabellen kannst du direkt ausfüllen; die Musterlösung lässt sich anschließend pro Aufgabe aufdecken.</p></header>
<nav class="exam-picker exercise-index" aria-label="Übungsblätter"><strong>Direkt zu:</strong><?php foreach ($exercises as $exercise): ?><a href="#<?= e((string) $exercise['id']) ?>"><?= e((string) $exercise['title']) ?></a><?php endforeach; ?></nav>
<div class="exercise-list">
<?php foreach ($exercises as $exercise): ?>
    <article id="<?= e((string) $exercise['id']) ?>" class="exam-paper exercise-paper">
        <header class="exam-header"><div><p class="eyebrow">Übungsblatt</p><h2><?= e((string) $exercise['title']) ?></h2><p><?= e((string) $exercise['description']) ?></p></div></header>
        <div class="exercise-summary"><section><h3>Aufgabenfolge</h3><ol><?php foreach ($exercise['tasks'] as $task): ?><li><?= e((string) $task['title']) ?></li><?php endforeach; ?></ol></section><section><h3>Themen</h3><ul><?php foreach ($exercise['topics'] as $topic): ?><li><?= e((string) $topic) ?></li><?php endforeach; ?></ul><p><strong>Lösungsstatus:</strong> <?= e((string) $exercise['solutionStatus']) ?></p></section></div>
        <section class="exercise-tasks" aria-label="Aufgaben">
            <?php foreach ($exercise['tasks'] as $taskIndex => $task): ?>
                <article class="exercise-task"><header><span><?= e((string) ($taskIndex + 1)) ?></span><h3><?= e((string) $task['title']) ?></h3></header><p><?= e((string) $task['prompt']) ?></p>
                    <?php if (($task['table'] ?? null) !== null): ?><section class="exercise-table-section" aria-label="Tabelle zum Ausfüllen"><h4>Zum Ausfüllen</h4><?php $renderTable($task['table'], 'exercise-fill-table', true, (string) $exercise['id'] . '-' . (string) ($taskIndex + 1)); ?></section><?php endif; ?>
                    <details class="exercise-solution"><summary>Musterlösung aufdecken</summary><div class="exercise-solution-content">
                        <?php if (($task['solution']['steps'] ?? []) !== []): ?><ol><?php foreach ($task['solution']['steps'] as $step): ?><li><?= e((string) $step) ?></li><?php endforeach; ?></ol><?php endif; ?>
                        <?php if (isset($task['solution']['code'])): ?><pre class="exercise-code"><?= e((string) $task['solution']['code']) ?></pre><?php endif; ?>
                        <?php if (($task['solution']['table'] ?? null) !== null): ?><?php $renderTable($task['solution']['table'], 'exercise-solution-table'); ?><?php endif; ?>
                        <?php if (isset($task['solution']['result'])): ?><p><strong>Ergebnis:</strong> <?= e((string) $task['solution']['result']) ?></p><?php endif; ?>
                    </div></details>
                </article>
            <?php endforeach; ?>
        </section>
        <?php render_source_refs((array) $exercise['sourceRefs']); ?>
    </article>
<?php endforeach; ?>
</div></main>
<?php require __DIR__ . '/includes/footer.php'; ?>