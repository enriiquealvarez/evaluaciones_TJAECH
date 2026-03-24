<section class="container public-immersive public-pro">
    <div class="public-shell public-shell-pro">
        <div class="public-visual public-visual-pro">
            <div class="public-badge">
                <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" width="52" height="52" style="width:52px;height:52px;object-fit:contain" onerror="this.style.display='none'">
            </div>
            <p class="public-overline">Evaluación del curso</p>
            <h2><?= e($curso['nombre']) ?></h2>
            <p class="public-copy"><?= e($evaluacion['titulo']) ?></p>
            <div class="public-meta">
                <div>
                    <span class="meta-label">Modalidad</span>
                    <strong>Evaluaci&oacute;n en l&iacute;nea</strong>
                </div>
                <div>
                    <span class="meta-label">Soporte</span>
                    <strong>informatica@tjaech.gob.mx</strong>
                </div>
            </div>
            <ul class="public-features">
                <li>Acceso con datos de registro previo</li>
                <li>Tiempo estimado corto</li>
                <li>Resultados institucionales</li>
            </ul>
        </div>
        <div class="public-card public-card-pro">
            <div class="page-header">
                <h3>Iniciar evaluaci&oacute;n</h3>
                <p><?= e($evaluacion['titulo']) ?></p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-magenta">
                    <strong>Revise la informaci&oacute;n:</strong>
                    <ul>
                        <?php foreach ($errors as $err): ?>
                        <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-magenta"><?= e($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= e(url('/participante/registrar')) ?>" class="form" id="evaluacionForm" data-verify-url="<?= e(url('/participante/verificar')) ?>" data-evaluacion-id="<?= (int)$evaluacion['id'] ?>" data-curso-id="<?= (int)$curso['id'] ?>">
                <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                <input type="hidden" name="curso_id" value="<?= (int)$curso['id'] ?>">
                <input type="hidden" name="evaluacion_id" value="<?= (int)$evaluacion['id'] ?>">

                <div class="form-section" id="registroSection">
                    <h3>Paso 1: Validación de acceso</h3>
                    <div class="alert alert-magenta" id="contactWarning" hidden></div>
                    <div class="form-grid">
                        <label>Correo registrado*
                            <input type="email" name="correo" required value="<?= e($old['correo'] ?? '') ?>">
                        </label>
                        <label>Tel&eacute;fono registrado*
                            <input type="text" name="telefono" required value="<?= e($old['telefono'] ?? '') ?>">
                        </label>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="goQuestions">Continuar a preguntas</button>
                        <a href="<?= e(url('/curso/registro?curso_id=' . (int)$curso['id'])) ?>" class="btn btn-secondary">Registrarme al curso</a>
                    </div>
                </div>

                <div class="form-section" id="preguntasSection" hidden>
                    <h3>Paso 2: Evaluaci&oacute;n</h3>
                    <div class="progress" id="progressBar"><span></span></div>
                    <?php foreach ($preguntas as $index => $pregunta): ?>
                        <div class="question">
                            <label class="question-title">
                                <?= ($index + 1) . '. ' . e($pregunta['texto']) ?>
                                <?php if ((int)$pregunta['requerido'] === 1): ?>
                                    <span class="req">*</span>
                                <?php endif; ?>
                            </label>

                            <?php if ($pregunta['tipo'] === 'abierta'): ?>
                                <textarea name="answers[<?= (int)$pregunta['id'] ?>]" rows="4" <?= (int)$pregunta['requerido'] === 1 ? 'required' : '' ?>><?= e($old['answers'][$pregunta['id']] ?? '') ?></textarea>
                            <?php elseif ($pregunta['tipo'] === 'opcion'): ?>
                                <?php foreach ($pregunta['opciones'] as $opt): ?>
                                    <label class="option">
                                        <input type="radio" name="answers[<?= (int)$pregunta['id'] ?>]" value="<?= e($opt['valor']) ?>" <?= (int)$pregunta['requerido'] === 1 ? 'required' : '' ?>>
                                        <?= e($opt['texto']) ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php elseif ($pregunta['tipo'] === 'si_no'): ?>
                                <?php foreach ($pregunta['opciones'] as $opt): ?>
                                    <label class="option">
                                        <input type="radio" name="answers[<?= (int)$pregunta['id'] ?>]" value="<?= e($opt['valor']) ?>" <?= (int)$pregunta['requerido'] === 1 ? 'required' : '' ?>>
                                        <?= e($opt['texto']) ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php elseif ($pregunta['tipo'] === 'likert'): ?>
                                <div class="likert">
                                    <?php foreach ($pregunta['opciones'] as $opt): ?>
                                        <label>
                                            <input type="radio" name="answers[<?= (int)$pregunta['id'] ?>]" value="<?= e($opt['valor']) ?>" <?= (int)$pregunta['requerido'] === 1 ? 'required' : '' ?>>
                                            <span><?= e($opt['texto']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="form-section">
                        <h3>Comentarios finales</h3>
                        <textarea name="comentarios" rows="5" placeholder="Sus comentarios son importantes."><?= e($old['comentarios'] ?? '') ?></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Enviar evaluaci&oacute;n</button>
                        <a href="<?= e(url('/')) ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script src="<?= e(asset('/assets/js/app.js')) ?>"></script>