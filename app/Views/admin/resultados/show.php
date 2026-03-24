<?php $autoPrint = isset($_GET['print']) && $_GET['print'] === '1'; ?>
<section class="container">
    <div class="page-header">
        <h2>Detalle de respuesta</h2>
        <p><?= e($respuesta['curso_nombre']) ?> · <?= e($respuesta['evaluacion_titulo']) ?></p>
    </div>

    <?php
    $aciertos = 0;
    $evaluables = 0;
    foreach ($respuesta['detalles'] as $det) {
        if (in_array($det['pregunta_tipo'], ['opcion', 'si_no'], true)) {
            $evaluables++;
            if ((int)$det['opcion_correcta'] === 1) {
                $aciertos++;
            }
        }
    }
    $porcentaje = $evaluables > 0 ? round(($aciertos / $evaluables) * 100) : 0;
    ?>

    <div class="card">
        <div class="detail-grid">
            <div><strong>Folio:</strong> <?= e($respuesta['folio']) ?></div>
            <div><strong>Participante:</strong> <?= e($respuesta['nombre_completo']) ?></div>
            <div><strong>Correo:</strong> <?= e($respuesta['correo']) ?></div>
            <div><strong>Teléfono:</strong> <?= e($respuesta['telefono']) ?></div>
            <div><strong>Municipio:</strong> <?= e($respuesta['municipio']) ?></div>
            <div><strong>Cargo:</strong> <?= e($respuesta['cargo_puesto']) ?></div>
            <div><strong>Fecha:</strong> <?= e($respuesta['created_at']) ?></div>
            <div><strong>Aciertos:</strong> <?= $aciertos ?> / <?= $evaluables ?> (<?= $porcentaje ?>%)</div>
        </div>
    </div>

    <div class="card">
        <h3>Respuestas</h3>
        <ol class="answer-list">
            <?php foreach ($respuesta['detalles'] as $det): ?>
            <li>
                <div class="answer-question"><?= e($det['pregunta_texto']) ?></div>
                <div class="answer-value">
                    <?php if ($det['pregunta_tipo'] === 'likert'): ?>
                        <?= e($det['opcion_texto'] ?? (string)$det['valor_num']) ?>
                    <?php elseif (in_array($det['pregunta_tipo'], ['opcion', 'si_no'], true)): ?>
                        <?= e($det['opcion_texto'] ?? ($det['valor_opcion'] ?? '')) ?>
                        <?php if ((int)$det['opcion_correcta'] === 1): ?>
                            <span class="badge success">Correcta</span>
                        <?php else: ?>
                            <span class="badge danger">Incorrecta</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?= e($det['valor_texto'] ?? '') ?>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <div class="card">
        <h3>Comentarios finales</h3>
        <p><?= e($respuesta['comentarios'] ?? '') ?></p>
    </div>

    <a class="btn btn-secondary" href="<?= e(url('/admin/resultados')) ?>">Volver</a>
</section>

<?php if ($autoPrint): ?>
<script>
window.addEventListener('load', function () {
  setTimeout(function () {
    window.print();
  }, 250);
  window.addEventListener('afterprint', function () {
    try {
      window.close();
    } catch (e) {}
  });
});
</script>
<?php endif; ?>
