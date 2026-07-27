<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/source-citations.php';

$pageTitle = 'Glossar';
$items = load_data('glossary');
$formulas = load_data('formulas');
$areas = load_data('learning-areas');
$termItems = array_values(array_filter(
    $items,
    static fn (array $item): bool => ($item['entryType'] ?? 'term') !== 'command'
));
$commandItems = array_values(array_filter(
    $items,
    static fn (array $item): bool => ($item['entryType'] ?? 'term') === 'command'
));

$areaById = [];
foreach ($areas as $area) {
    $areaById[(string) $area['id']] = $area;
}

$itemById = [];
foreach ($items as $item) {
    $itemById[(string) $item['id']] = $item;
}

$lettersFor = static function (array $entries): array {
    $letters = [];

    foreach ($entries as $item) {
        $letter = mb_strtoupper(mb_substr((string) ($item['term'] ?? ''), 0, 1));

        if ($letter !== '') {
            $letters[$letter] = true;
        }
    }

    $letters = array_keys($letters);
    sort($letters, SORT_NATURAL | SORT_FLAG_CASE);

    return $letters;
};

$termLetters = $lettersFor($termItems);
$commandLetters = $lettersFor($commandItems);

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

function render_glossary_entries(array $entries, array $areaById, array $itemById, string $letterPrefix): void
{
    $letter = '';

    foreach ($entries as $item):
        $term = (string) ($item['term'] ?? '');
        $firstLetter = mb_strtoupper(mb_substr($term, 0, 1));

        $areaId = (string) (($item['areaIds'][0] ?? ''));
        $area = $areaById[$areaId] ?? null;

        $status = (string) ($item['sourceStatus'] ?? 'belegt');
        $aliases = $item['aliases'] ?? [];
        $relatedTermIds = $item['relatedTermIds'] ?? [];
        $isCommand = ($item['entryType'] ?? 'term') === 'command';

        if ($firstLetter !== $letter):
            $letter = $firstLetter;
            ?>
            <h3
                class="glossary-letter"
                id="<?= e($letterPrefix . $letter) ?>"
                data-filter-always
            >
                <?= e($letter) ?>
            </h3>
            <?php
        endif;
        ?>
        <article
            class="glossary-entry source-<?= e(str_replace('/', '-', $status)) ?><?= $isCommand ? ' glossary-command-entry' : '' ?>"
            data-filter-text="<?= e($term . ' ' . implode(' ', $aliases) . ' ' . ($item['shortDefinition'] ?? '') . ' ' . ($item['details'] ?? '')) ?>"
            data-area-id="<?= e($areaId) ?>"
        >
            <div class="glossary-entry-header">
                <div>
                    <h4 id="glossary-<?= e((string) $item['id']) ?>">
                        <?php if ($isCommand): ?>
                            <code class="glossary-command-term"><?= e($term) ?></code>
                        <?php else: ?>
                            <?= e($term) ?>
                        <?php endif; ?>
                    </h4>

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
    <?php endforeach;
}

function render_formula_entries(array $formulas, array $areaById): void
{
    foreach ($formulas as $formula):
        $areaId = (string) ($formula['areaId'] ?? '');
        $area = $areaById[$areaId] ?? null;
        $searchText = implode(' ', [
            (string) ($formula['title'] ?? ''),
            (string) ($formula['formula'] ?? ''),
            (string) ($formula['description'] ?? ''),
            implode(' ', array_keys($formula['variables'] ?? [])),
            implode(' ', array_values($formula['variables'] ?? [])),
        ]);
        ?>
        <article
            class="glossary-entry glossary-formula-entry"
            data-filter-text="<?= e($searchText) ?>"
            data-area-id="<?= e($areaId) ?>"
        >
            <div class="glossary-entry-header">
                <h3 id="glossary-<?= e((string) ($formula['id'] ?? '')) ?>">
                    <?= e((string) ($formula['title'] ?? 'Formel')) ?>
                </h3>

                <span class="status-badge">
                    <?= e(glossary_status_label((string) ($formula['sourceStatus'] ?? 'belegt'))) ?>
                </span>
            </div>

            <div class="formula glossary-formula-display" aria-label="Formel">
                <?= e((string) ($formula['formula'] ?? '')) ?>
            </div>

            <p class="glossary-definition">
                <?= e((string) ($formula['description'] ?? '')) ?>
            </p>

            <?php if (!empty($formula['variables'])): ?>
                <dl class="formula-variables">
                    <?php foreach ($formula['variables'] as $symbol => $meaning): ?>
                        <div>
                            <dt><?= e((string) $symbol) ?></dt>
                            <dd><?= e((string) $meaning) ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            <?php endif; ?>

            <?php if ($area !== null): ?>
                <p class="glossary-area">
                    Lernbereich:
                    <a href="<?= e(page_url('learning-area.php', ['area' => $area['slug']])) ?>">
                        <?= e((string) $area['title']) ?>
                    </a>
                </p>
            <?php endif; ?>

            <?php
            render_source_refs(
                $formula['sourceRefs'] ?? [],
                $formula['sourceNote'] ?? null,
                $formula['sourceStatus'] ?? 'unklar'
            );
            ?>
        </article>
    <?php endforeach;
}

require __DIR__ . '/includes/header.php';
?>

<main id="main-content" class="page-shell">
    <header class="page-header">
        <p class="eyebrow">Nachschlagen</p>

        <h1>Glossar</h1>

        <p>
            <?= e((string) count($termItems)) ?> Fachbegriffe und
            <?= e((string) count($commandItems)) ?> Befehle sowie
            <?= e((string) count($formulas)) ?> Formeln mit Erklärungen,
            Lernbereichen und Quellenhinweisen.
        </p>
    </header>

    <div class="filter-bar filter-bar-wide">
        <label for="glossary-search">Begriff, Befehl oder Formel suchen</label>

        <input
            id="glossary-search"
            type="search"
            data-filter-input="glossary-list"
            placeholder="Zum Beispiel: Routing, TCP, CRC oder RTT"
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

    <?php if ($termLetters !== [] || $commandLetters !== [] || $formulas !== []): ?>
        <nav class="glossary-jump-nav" aria-label="Alphabetische Glossarnavigation">
            <span>Springe zu:</span>

            <a href="#glossary-terms">Fachbegriffe</a>
            <a href="#glossary-commands">Befehle</a>
            <?php if ($formulas !== []): ?>
                <a href="#glossary-formulas">Formelsammlung</a>
            <?php endif; ?>

            <?php foreach ($termLetters as $letter): ?>
                <a href="#glossary-term-letter-<?= e($letter) ?>">
                    <?= e($letter) ?>
                </a>
            <?php endforeach; ?>

            <?php if ($commandLetters !== []): ?>
                <span>Befehle:</span>

                <?php foreach ($commandLetters as $letter): ?>
                    <a href="#glossary-command-letter-<?= e($letter) ?>">
                        <?= e($letter) ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>
    <?php endif; ?>

    <div class="glossary-sections" id="glossary-list">
        <section class="glossary-section" id="glossary-terms">
            <header class="glossary-section-header">
                <p class="eyebrow">Begriffe</p>
                <h2>Fachbegriffe</h2>
                <p>Grundlagen, Protokolle, Verfahren und Praktikumsbausteine.</p>
            </header>

            <div class="glossary-list">
                <?php render_glossary_entries($termItems, $areaById, $itemById, 'glossary-term-letter-'); ?>
            </div>
        </section>

        <section class="glossary-section" id="glossary-commands">
            <header class="glossary-section-header">
                <p class="eyebrow">Praxisreferenz</p>
                <h2>Befehle-Glossar</h2>
                <p>Kommandozeilenbefehle und wichtige API-Aufrufe aus den Praktikumsunterlagen.</p>
            </header>

            <div class="glossary-list glossary-command-list">
                <?php render_glossary_entries($commandItems, $areaById, $itemById, 'glossary-command-letter-'); ?>
            </div>
        </section>

        <section class="glossary-section" id="glossary-formulas">
            <header class="glossary-section-header">
                <p class="eyebrow">Rechenhilfe</p>
                <h2>Formelsammlung</h2>
                <p>Wichtige Formeln aus Netzwerktechnik, Transport, Fehlerkontrolle und Digitalisierung.</p>
            </header>

            <div class="glossary-list glossary-formula-list">
                <?php render_formula_entries($formulas, $areaById); ?>
            </div>
        </section>
    </div>

    <?php if ($items === [] && $formulas === []): ?>
        <p class="empty-state">
            Noch keine Glossarbegriffe vorhanden.
        </p>
    <?php endif; ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
