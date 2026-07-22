<?php
require_once __DIR__ . '/source-citations.php';

function render_content_block(array $block): void
{
    $type = (string) ($block['type'] ?? 'definition');
    ?>
    <article class="content-block block-<?= e($type) ?>">
        <div class="block-heading"><span aria-hidden="true"><?= e(match ($type) { 'method' => '1→2', 'formula' => 'ƒ', 'warning' => '!', 'comparison' => '↔', 'rule' => '§', default => 'i' }) ?></span><h2><?= e((string) ($block['title'] ?? 'Inhalt')) ?></h2></div>
        <p><?= e((string) ($block['content'] ?? '')) ?></p>
        <?php if (isset($block['formula'])): ?><div class="formula" aria-label="Formel"><?= e((string) $block['formula']) ?></div><?php endif; ?>
        <?php if (isset($block['items']) && is_array($block['items'])): ?><ul><?php foreach ($block['items'] as $item): ?><li><?= e((string) $item) ?></li><?php endforeach; ?></ul><?php endif; ?>
        <?php render_source_refs((array) ($block['sourceRefs'] ?? []), isset($block['sourceNote']) ? (string) $block['sourceNote'] : null, (string) ($block['sourceStatus'] ?? 'unklar')); ?>
    </article>
    <?php
}