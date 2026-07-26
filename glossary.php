<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';

$pageTitle = 'Glossar';
$items = load_data('glossary');
$areas = load_data('learning-areas');

$areaById = [];
foreach ($areas as $area) {
    $areaById[(string) $area['id']] = $area;
}

$itemById = [];
foreach ($items as $item) {
    $itemById[(string) $item['id']] = $item;
}

$letters = [];
foreach ($items as $item) {
    $letter = mb_strtoupper(
        mb_substr((string) ($item['term'] ?? ''), 0, 1)
    );

    if ($letter !== '') {
        $letters[$letter] = true;
    }
}

$letters = array_keys($letters);
sort($letters, SORT_NATURAL | SORT_FLAG_CASE);

function glossary_status_label(string $status): string
{
    return match ($status) {
        'belegt' => 'Quelle belegt',
        'unklar' => 'Quellenlage unklar',
        'mehrdeutig' => 'Mehrdeutige Quelle',
        'historisch/vereinfacht' => 'Historisch oder vereinfacht',
        default => $status,
    };
}

require __DIR__ . '/includes/header.php';
?>

<main id="main-content" class="page-shell">
    <header class="page-header">
        <p class="eyebrow">Nachschlagen</p>

        <h1>Glossar</h1>

        <p>
            <?= e((string) count($items)) ?>
            Fachbegriffe mit Definitionen, Lernbereichen und Quellenhinweisen.
        </p>
    </header>

    <div class="filter-bar filter-bar-wide">
        <label for="glossary-search">Begriff suchen</label>

        <input
            id="glossary-search"
            type="search"
            data-filter-input="glossary-list"
            placeholder="Zum Beispiel: Routing, TCP oder XML"
        >

        <label for="glossary-area">Lernbereich</label>

        <select id="glossary-area" data-area-filter="glossary-list">
            <option value="">Alle Bereiche</option>

            <?php foreach ($areas as $area): ?>
                <option value="<?= e((string) $area['id']) ?>">
                    <?= e((string) $area['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php if ($letters !== []): ?>
        <nav class="glossary-jump-nav" aria-label="Alphabetische Glossarnavigation">
            <span>Springe zu:</span>

            <a href="#glossary-top">Alle</a>

            <?php foreach ($letters as $letter): ?>
                <a href="#glossary-letter-<?= e($letter) ?>">
                    <?= e($letter) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>

    <div class="glossary-list" id="glossary-list">
        <?php
        $letter = '';
        ?>

        <?php foreach ($items as $item): ?>
            <?php
            $term = (string) ($item['term'] ?? '');
            $firstLetter = mb_strtoupper(mb_substr($term, 0, 1));

            $areaId = (string) (($item['areaIds'][0] ?? ''));
            $area = $areaById[$areaId] ?? null;

            $status = (string) ($item['sourceStatus'] ?? 'belegt');
            $aliases = $item['aliases'] ?? [];
            $relatedTermIds = $item['relatedTermIds'] ?? [];

            if ($firstLetter !== $letter):
                $letter = $firstLetter;
            ?>
                <h2
                    class="glossary-letter"
                    id="glossary-letter-<?= e($letter) ?>"
                    data-filter-always
                >
                    <?= e($letter) ?>
                </h2>
            <?php endif; ?>

            <article
                class="glossary-entry source-<?= e(str_replace('/', '-', $status)) ?>"
                data-filter-text="<?= e($term . ' ' . implode(' ', $aliases)) ?>"
                data-area-id="<?= e($areaId) ?>"
            >
                <div class="glossary-entry-header">
                    <div>
                        <h3 id="glossary-<?= e((string) $item['id']) ?>">
                            <?= e($term) ?>
                        </h3>

                        <?php if ($aliases !== []): ?>
                            <p class="glossary-aliases">
                                Auch bekannt als:
                                <?= e(implode(', ', $aliases)) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <span class="status-badge">
                        <?= e(glossary_status_label($status)) ?>
                    </span>
                </div>

                <p class="glossary-definition">
                    <?= e((string) ($item['shortDefinition'] ?? '')) ?>
                </p>

                <?php if (!empty($item['details']) && $item['details'] !== $item['shortDefinition']): ?>
                    <details class="glossary-details">
                        <summary>Ausführliche Erklärung anzeigen</summary>

                        <p>
                            <?= e((string) $item['details']) ?>
                        </p>
                    </details>
                <?php endif; ?>

                <?php if ($area !== null): ?>
                    <p class="glossary-area">
                        Lernbereich:
                        <a href="<?= e(page_url('learning-area.php', ['area' => $area['slug']])) ?>">
                            <?= e((string) $area['title']) ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if ($relatedTermIds !== []): ?>
                    <?php
                    $relatedItems = [];

                    foreach ($relatedTermIds as $relatedTermId) {
                        if (isset($itemById[(string) $relatedTermId])) {
                            $relatedItems[] = $itemById[(string) $relatedTermId];
                        }
                    }
                    ?>

                    <?php if ($relatedItems !== []): ?>
                        <div class="glossary-related">
                            <strong>Verwandte Begriffe:</strong>

                            <?php foreach ($relatedItems as $relatedItem): ?>
                                <a href="#glossary-<?= e((string) $relatedItem['id']) ?>">
                                    <?= e((string) $relatedItem['term']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!empty($item['sourceNote'])): ?>
                    <p class="source-note">
                        <?= e((string) $item['sourceNote']) ?>
                    </p>
                <?php endif; ?>

                <?php
                render_source_refs(
                    $item['sourceRefs'] ?? [],
                    $item['sourceNote'] ?? null
                );
                ?>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($items === []): ?>
        <p class="empty-state">
            Noch keine Glossarbegriffe vorhanden.
        </p>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
