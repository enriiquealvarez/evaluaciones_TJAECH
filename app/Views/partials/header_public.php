<?php
$csrf = CSRF::token();
$cssPath = __DIR__ . '/../../public/assets/css/styles.css';
$cssVersion = is_file($cssPath) ? (string)filemtime($cssPath) : (string)time();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Evaluaci&oacute;n de Capacitaciones - TJAECH</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('/assets/css/styles.css?v=' . $cssVersion)) ?>">
    <style>
        .header-nav {
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .header-nav .btn {
            font-size: .85rem;
            padding: .4rem .75rem;
        }
    </style>
</head>
<body>
<header class="site-header site-header-public">
    <div class="container header-inner">
        <div class="brand">
            <span class="brand-tag">Sistema institucional</span>
            <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" class="logo" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
            <div>
                <span class="brand-title">Tribunal de Justicia Administrativa</span>
                <span class="brand-sub">Sistema de Evaluaci&oacute;n de Capacitaciones</span>
            </div>
        </div>
        <div class="brand-mark">
            <img src="<?= e(asset('/assets/img/logo_justicia_humanismo.png')) ?>" alt="Justicia con Humanismo" class="logo-alt" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
            <span class="brand-mark-text">Justicia con Humanismo</span>
        </div>
        <nav class="header-nav">
            <a href="<?= e(url('/participante/buscar-calificaciones')) ?>" class="btn btn-sm btn-outline-light">
                <i class="bi bi-card-checklist"></i> Mis calificaciones
            </a>
        </nav>
    </div>
</header>
<main class="main-content">
