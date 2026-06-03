<section class="container public-immersive public-pro">
    <div class="public-shell public-shell-pro">
        <div class="public-visual public-visual-pro">
            <div class="public-badge">
                <img src="<?= e(asset('/assets/img/logo_tjaech.png')) ?>" alt="Logo TJAECH" width="52" height="52" style="width:52px;height:52px;object-fit:contain" onerror="this.style.display='none'">
            </div>
        </div>
        <div class="public-card public-card-pro">
            <div class="page-header">
                <h3>Evaluación del Curso : <strong><?= e($curso['nombre']) ?></strong></h3>
                <p>Iniciar</p>
                <p style="margin-top: 6px; font-weight: bold; color: var(--magenta);">Tiempo estimado: 20 minutos.</p>
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
                        <button type="button" class="btn btn-primary" id="goQuestions" style="min-width: 220px;">Continuar a preguntas</button>
                    </div>
                </div>

                <div class="form-section" id="preguntasSection" hidden>
                    <style>
                        @keyframes pulse {
                            from { opacity: 1; }
                            to { opacity: 0.5; }
                        }
                    </style>
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; border-bottom: 1px solid var(--border); padding-bottom: 12px;">
                        <h3 style="margin: 0;">Paso 2: Evaluaci&oacute;n</h3>
                        <div id="timerContainer" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border: 1px solid #cbd5e1; border-radius: 20px; background: #f8fafc; color: #1b446e; font-weight: bold; font-size: 0.95rem; transition: all 0.3s ease;">
                            <span>⏱️ Tiempo restante: <span id="timerDisplay">20:00</span></span>
                        </div>
                    </div>
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