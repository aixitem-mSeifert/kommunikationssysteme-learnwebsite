<?php
declare(strict_types=1);

$root = dirname(__DIR__);
$load = static fn (string $name): array => require $root . '/data/' . $name . '.php';
$errors = [];
$allowedStatuses = ['belegt', 'mehrdeutig', 'rekonstruiert', 'historisch/vereinfacht', 'unklar', 'Gedächtnisprotokoll'];
$sources = $load('sources');
$areas = $load('learning-areas');
$topics = $load('topics');
$questions = $load('questions');
$glossary = $load('glossary');
$flashcards = $load('flashcards');
$exams = $load('exams');
$exercises = $load('exercises');

$ids = static function (array $items, string $name) use (&$errors): array {
    $values = array_column($items, 'id');
    if (count($values) !== count(array_unique($values))) {
        $errors[] = $name . ': doppelte IDs';
    }
    return array_fill_keys($values, true);
};

$sourceIds = $ids($sources, 'Quellen');
$areaIds = $ids($areas, 'Lernbereiche');
$topicIds = $ids($topics, 'Themen');
$ids($questions, 'Fragen');
$ids($glossary, 'Glossar');
$ids($flashcards, 'Lernkarten');
$ids($exams, 'Klausuren');
$ids($exercises, 'Übungen');

$validateRefs = static function (array $refs, string $context) use (&$errors, $sourceIds, $allowedStatuses): void {
    if ($refs === []) {
        $errors[] = $context . ': keine Quellenreferenz';
        return;
    }
    foreach ($refs as $ref) {
        if (!isset($sourceIds[$ref['sourceId'] ?? ''])) {
            $errors[] = $context . ': unbekannte Quelle ' . ($ref['sourceId'] ?? '(leer)');
        }
        if (!in_array($ref['sourceStatus'] ?? '', $allowedStatuses, true)) {
            $errors[] = $context . ': ungültiger Quellenstatus';
        }
        if (($ref['locator'] ?? '') === '') {
            $errors[] = $context . ': leere Fundstelle';
        }
    }
};

foreach ($areas as $area) {
    foreach ($area['topicIds'] as $topicId) {
        if (!isset($topicIds[$topicId])) {
            $errors[] = $area['id'] . ': unbekanntes Thema ' . $topicId;
        }
    }
    $validateRefs($area['sourceRefs'], $area['id']);
    $questionCount = count(array_filter($questions, static fn (array $question): bool => $question['areaId'] === $area['id']));
    if ($questionCount < 5) {
        $errors[] = $area['id'] . ': nur ' . $questionCount . ' Quizfragen';
    }
    $applicationCount = count(array_filter($questions, static fn (array $question): bool => $question['areaId'] === $area['id'] && ($question['competency'] ?? '') === 'application'));
    if ($applicationCount < 2) {
        $errors[] = $area['id'] . ': weniger als zwei Anwendungsfragen';
    }
    $methodCardCount = count(array_filter($flashcards, static fn (array $card): bool => $card['areaId'] === $area['id'] && !in_array($card['category'], ['definition', 'exam-trap'], true)));
    if ($methodCardCount < 1) {
        $errors[] = $area['id'] . ': keine Methodenlernkarte';
    }
}

$topicSourceIds = [];
foreach ($topics as $topic) {
    if (!isset($areaIds[$topic['areaId']])) {
        $errors[] = $topic['id'] . ': unbekannter Lernbereich';
    }
    foreach ($topic['blocks'] as $index => $block) {
        $context = $topic['id'] . '/Block ' . ($index + 1);
        $status = $block['sourceStatus'] ?? '';
        if (!in_array($status, $allowedStatuses, true)) {
            $errors[] = $context . ': ungültiger Quellenstatus';
        }
        if ($status !== 'belegt' && ($block['sourceNote'] ?? '') === '') {
            $errors[] = $context . ': unsicherer Inhalt ohne Hinweis';
        }
        if ($status === 'rekonstruiert' && count($block['sourceRefs'] ?? []) < 2) {
            $errors[] = $context . ': Rekonstruktion mit weniger als zwei Quellen';
        }
        $validateRefs($block['sourceRefs'] ?? [], $context);
        foreach ($block['sourceRefs'] ?? [] as $ref) {
            $topicSourceIds[$ref['sourceId']] = true;
        }
    }
}

foreach ($questions as $question) {
    if (!isset($areaIds[$question['areaId']]) || !isset($topicIds[$question['topicId']])) {
        $errors[] = $question['id'] . ': ungültige Bereichs-/Themenbeziehung';
    }
    if (!array_key_exists($question['correctAnswer'], $question['options'])) {
        $errors[] = $question['id'] . ': Antwortindex ungültig';
    }
    if (($question['sourceStatus'] ?? 'belegt') !== 'belegt' && ($question['sourceNote'] ?? '') === '') {
        $errors[] = $question['id'] . ': unsichere Frage ohne Hinweis';
    }
    $validateRefs($question['sourceRefs'], $question['id']);
}

foreach ($glossary as $item) {
    $validateRefs($item['sourceRefs'], $item['id']);
}
foreach ($flashcards as $card) {
    if (($card['front'] ?? '') === '' || ($card['back'] ?? '') === '') {
        $errors[] = $card['id'] . ': leere Kartenseite';
    }
    $validateRefs($card['sourceRefs'], $card['id']);
}
foreach ($exams as $exam) {
    $sum = array_sum(array_column($exam['tasks'], 'points'));
    if ($sum !== $exam['totalPoints']) {
        $errors[] = $exam['id'] . ': Punktesumme ' . $sum . ' statt ' . $exam['totalPoints'];
    }
    if ($exam['sourceStatus'] === 'Gedächtnisprotokoll' && ($exam['durationMinutes'] !== 0 || $exam['totalPoints'] !== 0)) {
        $errors[] = $exam['id'] . ': erfundene Zeit- oder Punktvorgabe';
    }
    foreach ($exam['tasks'] as $task) {
        if ($exam['sourceStatus'] === 'Gedächtnisprotokoll' && $task['authoritativeSolution']) {
            $errors[] = $task['id'] . ': Gedächtnisprotokoll mit autoritativer Lösung';
        }
        $validateRefs($task['sourceRefs'], $task['id']);
    }
}
foreach ($exercises as $exercise) {
    $validateRefs($exercise['sourceRefs'], $exercise['id']);
    if (($exercise['tasks'] ?? []) === []) {
        $errors[] = $exercise['id'] . ': keine Aufgabenfolge';
    }
    foreach ($exercise['tasks'] as $taskIndex => $task) {
        $context = $exercise['id'] . '/Aufgabe ' . ($taskIndex + 1);
        if (($task['title'] ?? '') === '' || ($task['prompt'] ?? '') === '') {
            $errors[] = $context . ': Titel oder Aufgabenstellung fehlt';
        }
        if (($task['solution'] ?? []) === []) {
            $errors[] = $context . ': keine Musterlösung';
        }
        if (($task['table'] ?? null) !== null && count($task['table']['headers'] ?? []) === 0) {
            $errors[] = $context . ': Tabelle ohne Spalten';
        }
    }
}

$officialExam = current(array_filter($exams, static fn (array $exam): bool => $exam['id'] === 'exam-2016'));
if ($officialExam === false || array_column($officialExam['tasks'], 'points') !== [20, 20, 15, 18, 12]) {
    $errors[] = 'Probeklausur 2016: Aufgabenpunkte weichen von 20/20/15/18/12 ab';
}
foreach (array_map(static fn (int $number): string => 's' . str_pad((string) $number, 2, '0', STR_PAD_LEFT), range(1, 19)) as $lectureId) {
    if (!isset($topicSourceIds[$lectureId])) {
        $errors[] = 'Folienquelle ohne Lerninhalt: ' . $lectureId;
    }
}

$lectureAndExamSources = array_filter($sources, static fn (array $source): bool => in_array($source['type'], ['lecture', 'mock-exam', 'memory-exam'], true));
if (count($lectureAndExamSources) !== 22) {
    $errors[] = 'Quellenabdeckung: ' . count($lectureAndExamSources) . ' statt 22 Fachquellen';
}
if (count($questions) < 30) {
    $errors[] = 'Nur ' . count($questions) . ' Quizfragen insgesamt';
}

if ($errors !== []) {
    fwrite(STDERR, implode(PHP_EOL, $errors) . PHP_EOL);
    exit(1);
}

echo 'Datenprüfung erfolgreich' . PHP_EOL;
echo count($areas) . ' Lernbereiche, ' . count($topics) . ' Themen, ' . count($questions) . ' Quizfragen, ' . count($glossary) . ' Glossareinträge, ' . count($flashcards) . ' Lernkarten, ' . count($lectureAndExamSources) . ' Fachquellen.' . PHP_EOL;