<?php
$navigation = [
    'index.php' => 'Start',
    'glossary.php' => 'Glossar',
    'quiz.php' => 'Quiz',
    'flashcards.php' => 'Lernkarten',
    'exam-training.php' => 'Klausurtraining',
    'exercises.php' => 'Übungen',
    'sources.php' => 'Quellen',
];
$learningAreas = load_data('learning-areas');
$learningAreaPages = ['learning-areas.php', 'learning-area.php', 'topic.php'];
$isLearningAreaPage = in_array(current_page(), $learningAreaPages, true);
?>
<nav class="site-nav" id="site-navigation" aria-label="Hauptnavigation">
    <ul>
        <li><a href="index.php"<?= current_page() === 'index.php' ? ' aria-current="page"' : '' ?>>Start</a></li>
        <li class="nav-section">
            <details>
                <summary<?= $isLearningAreaPage ? ' class="is-current"' : '' ?>>Lernbereiche</summary>
                <ul class="nav-dropdown">
                    <li><a href="learning-areas.php"<?= current_page() === 'learning-areas.php' ? ' aria-current="page"' : '' ?>>Alle Lernbereiche</a></li>
                    <?php foreach ($learningAreas as $navigationArea): ?>
                        <?php $isCurrentArea = current_page() === 'learning-area.php' && ($_GET['area'] ?? null) === $navigationArea['slug']; ?>
                        <li><a href="<?= e(page_url('learning-area.php', ['area' => $navigationArea['slug']])) ?>"<?= $isCurrentArea ? ' aria-current="page"' : '' ?>><?= e((string) $navigationArea['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </details>
        </li>
        <?php foreach (array_slice($navigation, 1, null, true) as $file => $label): ?>
            <li><a href="<?= e($file) ?>"<?= current_page() === $file ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
    </ul>
</nav>