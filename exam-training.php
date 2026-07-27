<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';
$pageTitle = 'Klausurtraining';
$exams = load_data('exams');
$renderTable = static function (array $table): void {
	?>
	<div class="exercise-table-wrap exam-solution-table-wrap">
		<table>
			<caption><?= e((string) ($table['title'] ?? 'Tabelle')) ?></caption>
			<thead><tr><?php foreach (($table['headers'] ?? []) as $header): ?><th scope="col"><?= e((string) $header) ?></th><?php endforeach; ?></tr></thead>
			<tbody><?php foreach (($table['rows'] ?? []) as $row): ?><tr><?php foreach ($row as $cell): ?><td><?= e((string) $cell) ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody>
		</table>
	</div>
	<?php
};
$selectedId = filter_input(INPUT_GET, 'exam', FILTER_UNSAFE_RAW) ?: $exams[0]['id'];
$exam = find_by($exams, 'id', (string) $selectedId) ?? $exams[0];
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Prüfungsvorbereitung</p><h1>Klausurtraining</h1><p>Offene Aufgaben werden anhand transparenter Erwartungshorizonte selbst bewertet. Lösungen erscheinen erst nach der Abgabe.</p></header>
<nav class="exam-picker" aria-label="Klausursets"><?php foreach ($exams as $item): ?><a href="<?= e(page_url('exam-training.php', ['exam' => $item['id']])) ?>"<?= $item['id'] === $exam['id'] ? ' aria-current="page"' : '' ?>><?= e((string) $item['title']) ?></a><?php endforeach; ?></nav>
<section class="exam-paper" data-duration="<?= e((string) $exam['durationMinutes']) ?>"><header class="exam-header"><div><p class="eyebrow"><?= e((string) $exam['sourceBasis']) ?></p><h2><?= e((string) $exam['title']) ?></h2><p><?= $exam['sourceStatus'] === 'Gedächtnisprotokoll' ? 'Keine autorisierte Punkte- oder Zeitvorgabe' : e((string) $exam['totalPoints']) . ' Punkte · ' . e((string) $exam['durationMinutes']) . ' Minuten' ?></p></div><?php if ($exam['durationMinutes'] > 0): ?><output id="exam-timer" aria-label="Verbleibende Zeit"></output><?php endif; ?></header>
<?php if (isset($exam['notice'])): ?><div class="notice notice-warning"><strong><?= e((string) $exam['notice']) ?></strong></div><?php endif; ?>
<form id="exam-form">
<?php foreach ($exam['tasks'] as $index => $task): ?>
	<?php $structuredSolution = is_array($task['solution'] ?? null); ?>
	<article class="exam-task">
		<header><span><?= $index + 1 ?></span><div><h3><?= e((string) $task['title']) ?></h3><small><?= $exam['sourceStatus'] === 'Gedächtnisprotokoll' ? 'ohne autorisierte Punktvorgabe' : e((string) $task['points']) . ' Punkte' ?></small></div></header>
		<p><?= e((string) $task['prompt']) ?></p>
		<?php if (($task['table'] ?? null) !== null): ?><?php $renderTable($task['table']); ?><?php endif; ?>
		<label for="answer-<?= e((string) $task['id']) ?>">Ihre Antwort</label>
		<textarea id="answer-<?= e((string) $task['id']) ?>" rows="7"></textarea>
		<section class="exam-solution" hidden>
			<h4>Vollständige Musterlösung</h4>
			<?php if ($structuredSolution): ?>
				<?php if (($task['solution']['steps'] ?? []) !== []): ?><ol><?php foreach ($task['solution']['steps'] as $step): ?><li><?= e((string) $step) ?></li><?php endforeach; ?></ol><?php endif; ?>
				<?php if (($task['solution']['table'] ?? null) !== null): ?><?php $renderTable($task['solution']['table']); ?><?php endif; ?>
				<?php if (isset($task['solution']['result'])): ?><p><strong>Ergebnis und Begründung:</strong> <?= e((string) $task['solution']['result']) ?></p><?php endif; ?>
			<?php else: ?>
				<p><strong>Lösungshinweis:</strong> <?= e((string) $task['solution']) ?></p>
			<?php endif; ?>
			<h4>Erwartungshorizont</h4><ul><?php foreach ($task['rubric'] as $criterion): ?><li><label><input type="checkbox" data-rubric> <?= e((string) $criterion) ?></label></li><?php endforeach; ?></ul>
			<?php render_source_refs($task['sourceRefs'], $task['authoritativeSolution'] ? null : (string) $task['derivation']); ?>
		</section>
	</article>
<?php endforeach; ?>
<div class="exam-submit"><button class="button button-dark" type="submit">Klausur abgeben</button><p id="exam-result" aria-live="polite"></p></div>
</form>
<?php if (($exam['qualityChecks'] ?? []) !== []): ?><aside class="notice notice-success exam-quality"><h3>Qualitätskontrolle</h3><ul><?php foreach ($exam['qualityChecks'] as $check): ?><li><?= e((string) $check) ?></li><?php endforeach; ?></ul></aside><?php endif; ?>
</section><script src="assets/js/exam-training.js" defer></script></main>
<?php require __DIR__ . '/includes/footer.php'; ?>