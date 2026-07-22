<?php
require_once __DIR__ . '/bootstrap.php';
$pageTitle = isset($pageTitle) ? (string) $pageTitle : APP_NAME;
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Quellengebundene Lernwebsite für Kommunikationssysteme">
    <title><?= e($pageTitle) ?> · <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/app.js" defer></script>
</head>
<body>
<a class="skip-link" href="#main-content">Zum Inhalt springen</a>
<header class="site-header">
    <div class="header-inner">
        <a class="brand" href="index.php" aria-label="Zur Startseite">
            <span class="brand-mark" aria-hidden="true">KS</span>
            <span><strong>Kommunikationssysteme</strong><small>Quellenbasiert lernen</small></span>
        </a>
        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
            <span aria-hidden="true">☰</span><span class="sr-only">Navigation öffnen</span>
        </button>
        <?php require __DIR__ . '/navigation.php'; ?>
    </div>
</header>