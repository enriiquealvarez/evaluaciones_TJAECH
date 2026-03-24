<section class="container">
    <div class="card acuse">
        <h2>Acuse de recepción</h2>
        <p>Su evaluación ha sido registrada correctamente.</p>
        <div class="acuse-grid">
            <div><strong>Folio:</strong> <?= e($respuesta['folio']) ?></div>
            <div><strong>Fecha:</strong> <?= e($respuesta['created_at']) ?></div>
            <div><strong>Curso:</strong> <?= e($respuesta['curso_nombre']) ?></div>
            <div><strong>Participante:</strong> <?= e($respuesta['nombre_completo']) ?></div>
            <div><strong>Municipio:</strong> <?= e($respuesta['municipio']) ?></div>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
            <a class="btn btn-secondary" href="<?= e(url('/')) ?>">Volver</a>
        </div>
    </div>
</section>
