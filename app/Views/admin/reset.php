<section class="container auth auth-split">
    <div class="auth-hero">
        <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" class="auth-logo" width="48" height="48" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
        <p class="auth-eyebrow">Recuperación</p>
        <h2>Verificar código</h2>
        <p class="auth-lead">Ingresa el código que recibiste y define tu nueva contraseña.</p>
        <ul class="auth-points">
            <li>Código válido por 15 minutos</li>
            <li>El código es de 6 dígitos</li>
            <li>Protección ante intentos</li>
        </ul>
    </div>
    <div class="card auth-card">
        <div class="auth-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="12" cy="8" r="4"></circle>
                <path d="M4 20c1.6-3.5 5-6 8-6s6.4 2.5 8 6"></path>
            </svg>
        </div>
        <h3>Restablecer acceso</h3>
        <?php if (!empty($flash)): ?>
            <div class="alert alert-magenta"><?= e($flash) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= e(url('/admin/reset')) ?>" class="form">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <label>Correo
                <input type="email" name="email" required>
            </label>
            <label>Código
                <input type="text" name="code" inputmode="numeric" maxlength="6" required>
            </label>
            <label>Nueva contraseña
                <input type="password" name="password" required>
            </label>
            <label>Confirmar contraseña
                <input type="password" name="password_confirm" required>
            </label>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M5 12h12"></path>
                    <path d="M13 7l5 5-5 5"></path>
                </svg>
                Confirmar
            </button>
        </form>
        <a class="auth-link" href="<?= e(url('/admin/login')) ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M10 17l5-5-5-5"></path>
                <path d="M15 12H3"></path>
                <path d="M21 4v16"></path>
            </svg>
            Volver a iniciar sesión
        </a>
    </div>
</section>
