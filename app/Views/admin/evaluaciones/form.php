<section class="container">
    <div class="page-header">
        <h2><?= $evaluacion ? 'Editar evaluación' : 'Nueva evaluación' ?></h2>
        <p><?= e($curso['nombre']) ?></p>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-magenta">
            <?php foreach ($errors as $err): ?>
            <div><?= e($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $evaluacion ? e(url('/admin/evaluaciones/actualizar')) : e(url('/admin/evaluaciones/guardar')) ?>" class="form" id="builderForm">
        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
        <input type="hidden" name="curso_id" value="<?= (int)$curso['id'] ?>">
        <?php if ($evaluacion): ?>
            <input type="hidden" name="id" value="<?= (int)$evaluacion['id'] ?>">
        <?php endif; ?>

        <label>Título*
            <input type="text" name="titulo" required value="<?= e($old['titulo'] ?? ($evaluacion['titulo'] ?? '')) ?>">
        </label>
        <label>Descripción
            <textarea name="descripcion" rows="3"><?= e($old['descripcion'] ?? ($evaluacion['descripcion'] ?? '')) ?></textarea>
        </label>
        <label class="checkbox">
            <input type="checkbox" name="activo" <?= (int)($old['activo'] ?? ($evaluacion['activo'] ?? 1)) === 1 ? 'checked' : '' ?>>
            Evaluación activa
        </label>

        <div class="builder">
            <div class="builder-header">
                <h3>Preguntas</h3>
                <button type="button" class="btn btn-secondary" id="addQuestion">Agregar pregunta</button>
            </div>
            <div id="questionsContainer">
                <?php $qIndex = 0; foreach ($preguntas as $p): ?>
                <div class="question-block" data-index="<?= $qIndex ?>">
                    <div class="question-block-header">
                        <strong>Pregunta <?= $qIndex + 1 ?></strong>
                        <div class="question-actions">
                            <button type="button" class="btn btn-secondary btn-sm move-up">Subir</button>
                            <button type="button" class="btn btn-secondary btn-sm move-down">Bajar</button>
                            <button type="button" class="btn btn-danger btn-sm remove-question">Quitar</button>
                        </div>
                    </div>
                    <label>Texto
                        <input type="text" name="questions[<?= $qIndex ?>][texto]" value="<?= e($p['texto']) ?>" required>
                    </label>
                    <label>Tipo
                        <select name="questions[<?= $qIndex ?>][tipo]" class="question-type">
                            <option value="opcion" <?= $p['tipo'] === 'opcion' ? 'selected' : '' ?>>Opción múltiple</option>
                            <option value="likert" <?= $p['tipo'] === 'likert' ? 'selected' : '' ?>>Escala Likert</option>
                            <option value="si_no" <?= $p['tipo'] === 'si_no' ? 'selected' : '' ?>>Sí/No</option>
                            <option value="abierta" <?= $p['tipo'] === 'abierta' ? 'selected' : '' ?>>Abierta</option>
                        </select>
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" name="questions[<?= $qIndex ?>][requerido]" <?= (int)$p['requerido'] === 1 ? 'checked' : '' ?>>
                        Respuesta obligatoria
                    </label>
                    <div class="options-container">
                        <div class="options-header">
                            <strong>Opciones</strong>
                            <button type="button" class="btn btn-secondary btn-sm add-option">Agregar opción</button>
                            <button type="button" class="btn btn-secondary btn-sm dedupe-options">Limpiar duplicadas</button>
                        </div>
                        <div class="options-list">
                            <?php $oIndex = 0; foreach ($p['opciones'] as $opt): ?>
                                <div class="option-row">
                                    <input type="text" name="questions[<?= $qIndex ?>][opciones][<?= $oIndex ?>][texto]" value="<?= e($opt['texto']) ?>">
                                    <input type="hidden" name="questions[<?= $qIndex ?>][opciones][<?= $oIndex ?>][valor]" value="<?= e($opt['valor']) ?>">
                                    <label class="option-correct">
                                        <input type="checkbox" name="questions[<?= $qIndex ?>][opciones][<?= $oIndex ?>][es_correcta]" <?= (int)($opt['es_correcta'] ?? 0) === 1 ? 'checked' : '' ?>>
                                        Correcta
                                    </label>
                                    <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                                </div>
                            <?php $oIndex++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php $qIndex++; endforeach; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar evaluación</button>
            <a class="btn btn-secondary" href="<?= e(url('/admin/evaluaciones?curso_id=' . (int)$curso['id'])) ?>">Volver</a>
        </div>
    </form>
</section>

<?php
    $builderJsPath = __DIR__ . '/../../../../public/assets/js/builder.js';
    $builderJsVersion = @filemtime($builderJsPath) ?: time();
?>
<script src="<?= e(asset('/assets/js/builder.js?v=' . $builderJsVersion)) ?>"></script>
