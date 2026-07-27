<?php
require_once __DIR__ . '/source-citations.php';

function render_content_text(string $content): string
{
    $content = preg_replace('/(?<!\d) (?=\d+\.\s)/', "\n", $content) ?? $content;
    return nl2br(e($content), false);
}

function content_table_cells(string $line): array
{
    $line = trim($line);
    $line = trim($line, '|');
    return array_map(static fn (string $cell): string => trim($cell), explode('|', $line));
}

function is_content_table_row(string $line): bool
{
    $line = trim($line);
    return strlen($line) >= 2 && str_starts_with($line, '|') && str_ends_with($line, '|');
}

function is_content_table_separator(string $line): bool
{
    if (!is_content_table_row($line)) {
        return false;
    }

    foreach (content_table_cells($line) as $cell) {
        if (preg_match('/^:?-{3,}:?$/', $cell) !== 1) {
            return false;
        }
    }

    return true;
}

function render_content_table_cell(string $cell): string
{
    $cell = e($cell);
    return preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $cell) ?? $cell;
}

function render_content_table(array $headers, array $rows): string
{
    $html = '<div class="content-table-wrap"><table class="content-table"><thead><tr>';
    foreach ($headers as $header) {
        $html .= '<th scope="col">' . render_content_table_cell($header) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>';
        foreach ($headers as $index => $header) {
            $html .= '<td>' . render_content_table_cell((string) ($row[$index] ?? '')) . '</td>';
        }
        $html .= '</tr>';
    }

    return $html . '</tbody></table></div>';
}

function render_content_code(string $code): string
{
    $lines = preg_split('/\R/', $code) ?: [];
    $html = '';
    $textLines = [];
    $flushText = static function () use (&$html, &$textLines): void {
        if ($textLines === []) {
            return;
        }

        $html .= '<pre class="content-code"><code>' . e(implode("\n", $textLines)) . '</code></pre>';
        $textLines = [];
    };

    for ($index = 0, $lineCount = count($lines); $index < $lineCount; $index++) {
        if ($index + 1 < $lineCount && is_content_table_row($lines[$index]) && is_content_table_separator($lines[$index + 1])) {
            $flushText();
            $headers = content_table_cells($lines[$index]);
            $index++;
            $rows = [];
            while ($index + 1 < $lineCount && is_content_table_row($lines[$index + 1])) {
                $rows[] = content_table_cells($lines[++$index]);
            }
            $html .= render_content_table($headers, $rows);
            continue;
        }

        $textLines[] = $lines[$index];
    }

    $flushText();
    return $html;
}

function render_content_section(array $section): void
{
    $type = (string) ($section['type'] ?? 'definition');
    ?>
    <section class="content-subsection block-<?= e($type) ?>">
        <h3><?= e((string) ($section['title'] ?? 'Abschnitt')) ?></h3>
        <?php if (isset($section['content'])): ?><p><?= render_content_text((string) $section['content']) ?></p><?php endif; ?>
        <?php if (isset($section['example'])): ?><div class="content-example"><strong>Beispiel:</strong> <?= render_content_text((string) $section['example']) ?></div><?php endif; ?>
        <?php if (isset($section['formula'])): ?><div class="formula" aria-label="Formel"><?= e((string) $section['formula']) ?></div><?php endif; ?>
        <?php if (isset($section['code'])): ?><?= render_content_code((string) $section['code']) ?><?php endif; ?>
    </section>
    <?php
}

function render_content_block(array $block): void
{
    $type = (string) ($block['type'] ?? 'definition');
    ?>
    <article class="content-block block-<?= e($type) ?>">
        <div class="block-heading"><span aria-hidden="true"><?= e(match ($type) { 'method' => '1→2', 'formula' => 'ƒ', 'warning' => '!', 'comparison' => '↔', 'rule' => '§', default => 'i' }) ?></span><h2><?= e((string) ($block['title'] ?? 'Inhalt')) ?></h2></div>
        <p><?= render_content_text((string) ($block['content'] ?? '')) ?></p>
        <?php if (isset($block['example'])): ?><div class="content-example"><strong>Beispiel:</strong> <?= render_content_text((string) $block['example']) ?></div><?php endif; ?>
        <?php if (isset($block['formula'])): ?><div class="formula" aria-label="Formel"><?= e((string) $block['formula']) ?></div><?php endif; ?>
        <?php if (isset($block['code'])): ?><?= render_content_code((string) $block['code']) ?><?php endif; ?>
        <?php if (isset($block['items']) && is_array($block['items'])): ?><ul><?php foreach ($block['items'] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul><?php endif; ?>
        <?php if (isset($block['sections']) && is_array($block['sections'])): ?><div class="content-subsections"><?php foreach ($block['sections'] as $section) { render_content_section((array) $section); } ?></div><?php endif; ?>
        <?php render_source_refs((array) ($block['sourceRefs'] ?? []), isset($block['sourceNote']) ? (string) $block['sourceNote'] : null, (string) ($block['sourceStatus'] ?? 'unklar')); ?>
    </article>
    <?php
}