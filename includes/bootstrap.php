<?php
declare(strict_types=1);

const APP_NAME = 'Kommunikationssysteme lernen';
const APP_ROOT = __DIR__ . '/..';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function current_page(): string
{
    return basename((string) ($_SERVER['SCRIPT_NAME'] ?? 'index.php'));
}

function page_url(string $page, array $query = []): string
{
    return $page . ($query === [] ? '' : '?' . http_build_query($query));
}

function load_data(string $name): array
{
    $path = APP_ROOT . '/data/' . $name . '.php';
    if (!is_file($path)) {
        return [];
    }

    $data = require $path;
    return is_array($data) ? $data : [];
}

function find_by(array $items, string $field, string $value): ?array
{
    foreach ($items as $item) {
        if (is_array($item) && ($item[$field] ?? null) === $value) {
            return $item;
        }
    }

    return null;
}

function abort_not_found(string $message = 'Der angeforderte Inhalt wurde nicht gefunden.'): never
{
    http_response_code(404);
    $pageTitle = 'Nicht gefunden';
    require APP_ROOT . '/includes/header.php';
    echo '<main id="main-content" class="page-shell"><div class="notice notice-warning"><h1>Nicht gefunden</h1><p>' . e($message) . '</p></div></main>';
    require APP_ROOT . '/includes/footer.php';
    exit;
}