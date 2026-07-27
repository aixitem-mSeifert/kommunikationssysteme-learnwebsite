<?php
require_once __DIR__ . '/source-citations.php';

function render_content_text(string $content): string
{
    $content = preg_replace('/(?<!\d) (?=\d+\.\s)/', "\n", $content) ?? $content;
    return nl2br(e($content), false);
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
        <?php if (isset($section['code'])): ?><pre class="content-code"><code><?= e((string) $section['code']) ?></code></pre><?php endif; ?>
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
        <?php if (isset($block['code'])): ?><pre class="content-code"><code><?= e((string) $block['code']) ?></code></pre><?php endif; ?>
        <?php if (isset($block['items']) && is_array($block['items'])): ?><ul><?php foreach ($block['items'] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul><?php endif; ?>
        <?php if (isset($block['sections']) && is_array($block['sections'])): ?><div class="content-subsections"><?php foreach ($block['sections'] as $section) { render_content_section((array) $section); } ?></div><?php endif; ?>
        <?php render_source_refs((array) ($block['sourceRefs'] ?? []), isset($block['sourceNote']) ? (string) $block['sourceNote'] : null, (string) ($block['sourceStatus'] ?? 'unklar')); ?>
    </article>
    <?php
}