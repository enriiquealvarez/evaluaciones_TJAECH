<?php
$csrf = CSRF::token();
$adminId = Session::get('admin_id');
$canCourses = false;
$canEvaluations = false;
$canResults = false;
$canUsers = false;
if ($adminId) {
    try {
        $canCourses = AuthMiddleware::can('courses');
        $canEvaluations = AuthMiddleware::can('evaluations');
        $canResults = AuthMiddleware::can('results');
        $canUsers = AuthMiddleware::can('users');
    } catch (Throwable $e) {
        error_log($e->getMessage());
    }
}

$current = $currentView ?? '';
$isAuthPage = in_array($current, ['admin/login', 'admin/forgot', 'admin/reset'], true);
$isDashboardView = $current === 'admin/dashboard';
$isCursosView = strpos($current, 'admin/cursos') === 0;
$isEvaluacionesView = strpos($current, 'admin/evaluaciones') === 0;
$isResultadosView = strpos($current, 'admin/resultados') === 0;
$isInscripcionesView = strpos($current, 'admin/inscripciones') === 0;
$isSatisfaccionView = strpos($current, 'admin/satisfaccion') === 0;
$isUsuariosView = strpos($current, 'admin/usuarios') === 0;

$cssPath = __DIR__ . '/../../public/assets/css/styles.css';
$cssVersion = is_file($cssPath) ? (string)filemtime($cssPath) : (string)time();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administraci&oacute;n - TJAECH</title>
    <script>
        document.documentElement.classList.add('js');
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(asset('/assets/css/styles.css?v=' . $cssVersion)) ?>">
    <script>
        window.addEventListener('load', () => {
            document.body.classList.add('is-ready');
        });
        window.addEventListener('pageshow', () => {
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.classList.remove('show');
            }
        });
        document.addEventListener('click', (event) => {
            const link = event.target.closest('a');
            if (!link) return;
            if (link.target === '_blank' || link.hasAttribute('download') || link.getAttribute('href')?.startsWith('#')) {
                return;
            }
            const loader = document.getElementById('page-loader');
            if (loader) {
                const textEl = document.getElementById('page-loader-text');
                if (textEl) {
                    textEl.textContent = 'Cargando, por favor espere...';
                }
                loader.classList.add('show');
            }
        });
        document.addEventListener('submit', (event) => {
            if (event.defaultPrevented) return;
            const form = event.target;
            const loader = document.getElementById('page-loader');
            if (loader) {
                const textEl = document.getElementById('page-loader-text');
                if (textEl) {
                    const customText = form.getAttribute('data-loader-text');
                    textEl.textContent = customText || 'Procesando, por favor espere...';
                }
                loader.classList.add('show');
            }
        });
    </script>
</head>
<?php
$authViews = ['admin/login', 'admin/forgot', 'admin/reset'];
$isAuth = in_array($current, $authViews, true);
?>
<body class="admin-body<?= $isAuth ? ' admin-auth' : '' ?><?= $current === 'admin/login' ? ' admin-login' : '' ?><?= $current === 'admin/forgot' ? ' admin-forgot' : '' ?>">
<div class="page-loader" id="page-loader" aria-hidden="true" style="z-index: 999999;">
    <div style="display: flex; flex-direction: column; align-items: center; background: #ffffff; padding: 28px 40px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); border: 1px solid #e2e8f0;">
        <div class="spinner"></div>
        <div class="loader-text" id="page-loader-text" style="margin-top: 16px; font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 600; color: #1b3f66; text-align: center; white-space: nowrap;">Procesando, por favor espere...</div>
    </div>
</div>
<header class="site-header">
    <div class="container header-inner">
        <div class="brand">
            <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" class="logo" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
            <div>
                <span class="brand-title">Panel Administrativo</span>
                <span class="brand-sub">Sistema de Evaluaci&oacute;n TJAECH</span>
            </div>
        </div>
        <nav class="nav">
            <a class="nav-admin-link<?= $isDashboardView ? ' active' : '' ?>" href="<?= e(url('/admin')) ?>">Tablero</a>
            <?php if ($canCourses): ?>
            <a class="nav-admin-link<?= $isCursosView ? ' active' : '' ?>" href="<?= e(url('/admin/cursos')) ?>">Cursos</a>
            <?php endif; ?>
            <?php if ($canEvaluations): ?>
            <a class="nav-admin-link<?= $isEvaluacionesView ? ' active' : '' ?>" href="<?= e(url('/admin/evaluaciones')) ?>">Evaluaciones</a>
            <?php endif; ?>
            <?php if ($canResults): ?>
            <a class="nav-admin-link<?= $isResultadosView ? ' active' : '' ?>" href="<?= e(url('/admin/resultados')) ?>">Resultados</a>
            <a class="nav-admin-link<?= $isInscripcionesView ? ' active' : '' ?>" href="<?= e(url('/admin/inscripciones')) ?>">Inscripciones</a>
            <a class="nav-admin-link<?= $isSatisfaccionView ? ' active' : '' ?>" href="<?= e(url('/admin/satisfaccion')) ?>">Satisfacci&oacute;n</a>
            <?php endif; ?>
            <?php if ($canUsers): ?>
            <a class="nav-admin-link<?= $isUsuariosView ? ' active' : '' ?>" href="<?= e(url('/admin/usuarios')) ?>">Usuarios</a>
            <?php endif; ?>
            <?php if ($adminId): ?>
            <form method="post" action="<?= e(url('/admin/logout')) ?>" class="inline-form">
                <input type="hidden" name="_csrf" value="<?= e($csrf) ?>">
                <button type="submit" class="btn btn-secondary btn-no-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                        <path d="M15 17l5-5-5-5"></path>
                        <path d="M20 12H8"></path>
                        <path d="M4 4v16"></path>
                    </svg>
                    Salir
                </button>
            </form>
            <?php elseif ($isAuthPage): ?>
            <?php if ($current === 'admin/forgot' || $current === 'admin/reset'): ?>
            <a class="btn btn-outline-light btn-no-icon" href="<?= e(url('/admin/login')) ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M10 17l5-5-5-5"></path>
                    <path d="M15 12H3"></path>
                    <path d="M21 4v16"></path>
                </svg>
                Iniciar sesi&oacute;n
            </a>
            <?php else: ?>
            <a class="btn btn-outline-light btn-no-icon" href="<?= e(url('/admin/forgot')) ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M12 6a4 4 0 0 1 4 4v3"></path>
                    <rect x="7" y="9" width="10" height="11" rx="2"></rect>
                </svg>
                Recuperar
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="main-content">
