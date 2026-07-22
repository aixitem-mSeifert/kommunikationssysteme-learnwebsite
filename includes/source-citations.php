<?php

function source_status_label(string $status): string
{
    return match ($status) {
        'belegt' => 'Belegt',
        'mehrdeutig' => 'Mehrdeutig',
        'rekonstruiert' => 'Rekonstruiert',
        'historisch/vereinfacht' => 'Historisch / vereinfacht',
        'unklar' => 'Unklar',
        'Gedächtnisprotokoll' => 'Gedächtnisprotokoll',
        default => 'Nicht klassifiziert',
    };
}

function render_source_refs(array $refs, ?string $note = null, ?string $aggregateStatus = null): void
{
    $sources = load_data('sources');
    $status = $aggregateStatus ?? (string) ($refs[0]['sourceStatus'] ?? 'unklar');
    ?>
    <footer class="source-box source-<?= e(preg_replace('/[^a-z]+/i', '-', $status) ?? 'unklar') ?>">
        <span class="status-badge"><?= e(source_status_label($status)) ?></span>
        <?php if ($note !== null && $note !== ''): ?><p class="source-note"><?= e($note) ?></p><?php endif; ?>
        <ul class="source-list">
            <?php foreach ($refs as $ref): $source = find_by($sources, 'id', (string) ($ref['sourceId'] ?? '')); ?>
                <li><a href="sources.php#source-<?= e((string) ($ref['sourceId'] ?? '')) ?>"><?= e((string) ($source['title'] ?? $ref['sourceId'] ?? 'Unbekannte Quelle')) ?></a>: <?= e((string) ($ref['locator'] ?? 'ohne Fundstelle')) ?></li>
            <?php endforeach; ?>
        </ul>
    </footer>
    <?php
}