<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Quiz';
$areas = load_data('learning-areas');
$questions = load_data('questions');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Selbsttest</p><h1>Quiz</h1><p>Sieben quellengebundene Fragen je Lernbereich, darunter zwei Anwendungsfragen. Unsichere Quellenlagen werden als solche geprüft.</p></header>
<section class="quiz-setup" id="quiz-setup"><label for="quiz-area">Lernbereich</label><select id="quiz-area"><option value="all">Alle Bereiche</option><?php foreach ($areas as $area): ?><option value="<?= e((string) $area['id']) ?>"><?= e((string) $area['title']) ?></option><?php endforeach; ?></select><label for="quiz-difficulty">Schwierigkeit</label><select id="quiz-difficulty"><option value="all">Alle Stufen</option><option value="leicht">Leicht</option><option value="mittel">Mittel</option><option value="schwer">Schwer</option></select><button class="button button-dark" id="quiz-start" type="button">Quiz starten</button></section>
<section class="quiz-stage" id="quiz-stage" hidden aria-live="polite"><div class="quiz-meta"><span id="quiz-position"></span><div class="progress-track"><span id="quiz-progress"></span></div></div><form id="quiz-form"><fieldset><legend id="quiz-prompt"></legend><div id="quiz-options" class="answer-options"></div></fieldset><div id="quiz-feedback" class="quiz-feedback" hidden></div><div class="quiz-actions"><button class="button button-dark" id="quiz-submit" type="submit">Antwort prüfen</button><button class="button button-dark" id="quiz-next" type="button" hidden>Nächste Frage</button></div></form></section>
<section class="quiz-result" id="quiz-result" hidden aria-live="polite"><p class="eyebrow">Ergebnis</p><h2 id="quiz-score"></h2><p id="quiz-summary"></p><button class="button button-dark" id="quiz-restart" type="button">Neues Quiz</button></section>
<script>window.KS_QUIZ = <?= json_encode($questions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script><script src="assets/js/quiz.js" defer></script></main>
<?php require __DIR__ . '/includes/footer.php'; ?>