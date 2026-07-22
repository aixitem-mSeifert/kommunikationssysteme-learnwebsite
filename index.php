<?php
require_once __DIR__ . '/includes/bootstrap.php';
$pageTitle = 'Start';
$areas = load_data('learning-areas');
$questionCount = count(load_data('questions'));
require __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="intro-band">
        <div class="page-shell intro-layout">
            <div>
                <p class="eyebrow">Lernübersicht</p>
                <h1>Kommunikationssysteme verstehen und prüfungsnah trainieren</h1>
                <p class="lead">Lernbereiche, Fachbegriffe und Trainingsformen werden nachvollziehbar mit den bereitgestellten Vorlesungs- und Klausurquellen verknüpft.</p>
                <a class="button" href="learning-areas.php">Lernbereiche öffnen</a>
            </div>
            <div class="progress-panel" aria-label="Lernfortschritt">
                <span class="progress-label">Lokaler Fortschritt</span>
                <strong id="overall-progress" data-question-count="<?= e((string) $questionCount) ?>">0 %</strong>
                <div class="progress-track" aria-hidden="true"><span style="width:0%"></span></div>
                <small>Wird nur in diesem Browser gespeichert.</small>
            </div>
        </div>
    </section>
    <section class="page-shell section-block" aria-labelledby="areas-heading">
        <div class="section-heading"><div><p class="eyebrow">Struktur</p><h2 id="areas-heading">Lernbereiche</h2></div><a href="learning-areas.php">Alle anzeigen</a></div>
        <div class="home-area-grid"><?php foreach ($areas as $area): ?><a href="<?= e(page_url('learning-area.php', ['area' => $area['slug']])) ?>"><span><?= e((string) $area['examPriority']) ?>e Priorität</span><strong><?= e((string) $area['title']) ?></strong><small><?= count($area['learningObjectives']) ?> Lernziele</small></a><?php endforeach; ?></div>
    </section>
    <section class="tool-band">
        <div class="page-shell tool-grid">
            <a href="glossary.php"><strong>Glossar</strong><span>Begriffe nachschlagen</span></a>
            <a href="quiz.php"><strong>Quiz</strong><span>Verständnis prüfen</span></a>
            <a href="flashcards.php"><strong>Lernkarten</strong><span>Wissen wiederholen</span></a>
            <a href="exam-training.php"><strong>Klausurtraining</strong><span>Aufgaben bearbeiten</span></a>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>