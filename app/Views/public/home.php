<section class="home-catalog-hero">
    <div class="container home-catalog-hero-inner">
        <article class="home-catalog-welcome">
            <p class="welcome-kicker">Sistema institucional</p>
            <h1>Evaluaci&oacute;n de Capacitaciones</h1>
            <p>Primero complete su registro al curso. Cuando la evaluaci&oacute;n est&eacute; activa, podr&aacute; ingresar con correo y tel&eacute;fono registrados.</p>
            <p class="home-catalog-guide">Si ya present&oacute; su evaluaci&oacute;n, puede consultar su resultado directamente desde la tarjeta de su curso.</p>
        </article>
        <?php if (!empty($flash)): ?>
            <div class="alert alert-magenta"><?= e($flash) ?></div>
        <?php endif; ?>
    </div>
</section>

<section class="container home-catalog-section" id="cursos">
    <div class="home-catalog-head">
        <h2><?= !empty($singleCourseMode) ? 'Curso seleccionado' : 'Listado de cursos' ?></h2>
        <p>
            <?= !empty($singleCourseMode)
                ? 'Este enlace corresponde a un curso espec&iacute;fico.'
                : 'Seleccione un curso para registrarse o para evaluar si ya cuenta con registro previo.' ?>
        </p>
    </div>

    <div class="home-catalog-grid">
        <?php foreach ($cursos as $curso): ?>
        <article class="home-catalog-card">
            <h3><?= e($curso['nombre']) ?></h3>
            <p><?= e($curso['descripcion']) ?></p>
            <div class="home-catalog-dates">
                <span><strong>Inicio:</strong> <?= e($curso['fecha_inicio'] ?? 'N/D') ?></span>
                <span><strong>Fin:</strong> <?= e($curso['fecha_fin'] ?? 'N/D') ?></span>
            </div>
            <div class="home-catalog-actions">
                <a class="btn btn-primary btn-no-decor" href="<?= e(url('/curso/registro?curso_id=' . (int)$curso['id'])) ?>">Registrarme</a>
                <a class="btn btn-secondary btn-no-decor" href="<?= e(url('/participante/registro?curso_id=' . (int)$curso['id'])) ?>">Realizar evaluaci&oacute;n</a>
            </div>
            <details class="home-score-lookup">
                <summary>Ya present&eacute; la evaluaci&oacute;n, quiero ver mi calificaci&oacute;n</summary>
                <form method="post" action="<?= e(url('/participante/obtener-calificaciones')) ?>" class="home-score-lookup-form">
                    <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                    <input type="hidden" name="curso_id" value="<?= (int)$curso['id'] ?>">
                    <input type="hidden" name="status" value="">

                    <p>Ingrese el mismo correo o tel&eacute;fono con el que se registr&oacute; para consultar el resultado de este curso.</p>

                    <div class="home-score-lookup-fields">
                        <label>
                            <span>Correo electr&oacute;nico</span>
                            <input type="email" name="correo" placeholder="ejemplo@correo.com">
                        </label>
                        <label>
                            <span>Tel&eacute;fono</span>
                            <input type="tel" name="telefono" placeholder="10 d&iacute;gitos">
                        </label>
                    </div>

                    <button type="submit" class="btn btn-info btn-no-decor">Consultar calificaci&oacute;n</button>
                </form>
            </details>
        </article>
        <?php endforeach; ?>

        <?php if (empty($cursos)): ?>
        <article class="home-catalog-card home-catalog-empty">
            <p>No hay cursos activos por el momento.</p>
        </article>
        <?php endif; ?>
    </div>
</section>

