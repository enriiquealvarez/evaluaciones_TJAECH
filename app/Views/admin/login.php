<section class="container auth auth-split">
    <div class="auth-hero">
        <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" class="auth-logo" width="48" height="48" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
        <p class="auth-eyebrow">Panel Administrativo</p>
        <h2>Acceso Administrativo</h2>
        <p class="auth-lead">Gestiona cursos, evaluaciones y resultados desde un espacio seguro.</p>
        <ul class="auth-points">
            <li>Verificación por correo</li>
            <li>Roles y permisos por área</li>
            <li>Acceso seguro por código</li>
        </ul>
    </div>
    <div class="card auth-card">
        <div class="auth-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="12" cy="8" r="4"></circle>
                <path d="M4 20c1.6-3.5 5-6 8-6s6.4 2.5 8 6"></path>
            </svg>
        </div>
        <h3>Inicia sesión</h3>
        <?php if (!empty($flash)): ?>
            <div class="alert alert-green"><?= e($flash) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-magenta"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= e(url('/admin/login')) ?>" class="form">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <label>Correo
                <input type="email" name="email" required>
            </label>
            <label>Contraseña
                <input type="password" name="password" required>
            </label>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M5 12h12"></path>
                    <path d="M13 7l5 5-5 5"></path>
                </svg>
                Ingresar
            </button>
        </form>
        <a class="auth-link" href="<?= e(url('/admin/forgot')) ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M12 7a4 4 0 0 1 4 4v2"></path>
                <rect x="7" y="11" width="10" height="9" rx="2"></rect>
            </svg>
            ¿Olvidaste tu contraseña?
        </a>
        <p class="muted">Si es la primera vez, se creará un usuario administrador por defecto.</p>
    </div>
</section>
