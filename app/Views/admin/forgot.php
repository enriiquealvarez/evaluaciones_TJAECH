<section class="container auth auth-split">
    <div class="auth-hero">
        <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" class="auth-logo" width="48" height="48" onerror="this.onerror=null;this.src='<?= e(asset('/assets/img/logo_placeholder.svg')) ?>'">
        <p class="auth-eyebrow">Recuperación</p>
        <h2>Recuperar acceso</h2>
        <p class="auth-lead">Te enviaremos un código de 6 dígitos para restablecer tu acceso.</p>
        <ul class="auth-points">
            <li>Código válido por 15 minutos</li>
            <li>Confirmación en 2 pasos</li>
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
        <h3>Solicitar código</h3>
        <?php if (!empty($flash)): ?>
            <div class="alert alert-green"><?= e($flash) ?></div>
        <?php endif; ?>
        <form method="post" action="<?= e(url('/admin/forgot')) ?>" class="form">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <label>Correo
                <input type="email" name="email" required>
            </label>
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M22 6l-10 7L2 6"></path>
                    <path d="M2 6h20v12H2z"></path>
                </svg>
                Enviar código
            </button>
        </form>
        <a class="auth-link" href="<?= e(url('/admin/reset')) ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M8 7h8"></path>
                <path d="M8 12h8"></path>
                <path d="M8 17h8"></path>
            </svg>
            Ya tengo un código
        </a>
    </div>
</section>