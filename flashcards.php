<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Lernkarten';
$areas = load_data('learning-areas');
$cards = load_data('flashcards');
require __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="page-shell"><header class="page-header"><p class="eyebrow">Wiederholen</p><h1>Lernkarten</h1><p>Antworten werden erst nach dem Aufdecken sichtbar. Die Selbsteinschätzung bleibt lokal in diesem Browser.</p></header>
<section class="card-controls"><label for="card-area">Lernbereich</label><select id="card-area"><option value="all">Alle Bereiche</option><?php foreach ($areas as $area): ?><option value="<?= e((string) $area['id']) ?>"><?= e((string) $area['title']) ?></option><?php endforeach; ?></select><span id="card-position"></span></section>
<section class="flashcard-stage" aria-live="polite"><article class="flashcard" id="flashcard"><p class="eyebrow" id="card-category"></p><h2 id="card-front"></h2><div id="card-back" hidden><div class="card-divider"></div><p></p><small id="card-source-status"></small></div></article><div class="card-actions"><button class="button button-dark" type="button" id="card-reveal">Antwort aufdecken</button><div id="card-rating" hidden><button type="button" data-rating="again">Noch einmal</button><button type="button" data-rating="known">Gewusst</button></div></div></section>
<script>window.KS_CARDS = <?= json_encode($cards, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script><script src="assets/js/flashcards.js" defer></script></main>
<?php require __DIR__ . '/includes/footer.php'; ?>