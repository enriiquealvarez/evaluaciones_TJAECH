<section class="container satisfaction-wrap">
    <style>
    .custom-radio-scale input:checked + .radio-dot {
        background-color: #134063 !important;
        border-color: #134063 !important;
    }
    .custom-radio-scale:hover .radio-dot {
        box-shadow: 0 0 0 3px rgba(19, 64, 99, 0.15);
    }
    </style>

    <div class="satisfaction-head">
        <h1>Encuesta de Satisfacci&oacute;n</h1>
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

    <form method="post" action="<?= e(url('/participante/satisfaccion')) ?>" class="satisfaction-card form">
        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
        <input type="hidden" name="folio" value="<?= e($respuesta['folio']) ?>">

        <!-- Instrucciones -->
        <div style="margin-bottom: 2rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0; line-height: 1.6;">
                Instrucciones: En una escala del 1 al 5, siendo 1 el m&iacute;nimo y 5 el m&aacute;ximo, indica tu valoraci&oacute;n del curso o capacitaci&oacute;n.
            </h3>
            <p style="color: #ef4444; font-weight: 700; font-size: 1rem; margin: 0;">*Campos obligatorios.</p>
        </div>

        <!-- Pregunta 1 -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                1. La relevancia y utilidad de los temas abordados. <span style="color: #ef4444;">*</span>
            </h3>
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-left: 1.5rem; flex-wrap: wrap;">
                <?php foreach (['5', '4', '3', '2', '1'] as $val): ?>
                    <label class="custom-radio-scale" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="radio" name="q1" value="<?= $val ?>" <?= ($old['q1'] ?? '') === $val ? 'checked' : '' ?> required style="position: absolute; opacity: 0; pointer-events: none;">
                        <span class="radio-dot" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #134063; background: #fff; display: inline-block; position: relative; transition: all 0.2s;"></span>
                        <span style="font-size: 1.1rem; font-weight: 600; color: #1f2937; line-height: 1;"><?= $val ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 2 -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                2. &iquest;C&oacute;mo eval&uacute;a la calidad y claridad de los contenidos impartidos durante el curso? <span style="color: #ef4444;">*</span>
            </h3>
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-left: 1.5rem; flex-wrap: wrap;">
                <?php foreach (['5', '4', '3', '2', '1'] as $val): ?>
                    <label class="custom-radio-scale" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="radio" name="q2" value="<?= $val ?>" <?= ($old['q2'] ?? '') === $val ? 'checked' : '' ?> required style="position: absolute; opacity: 0; pointer-events: none;">
                        <span class="radio-dot" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #134063; background: #fff; display: inline-block; position: relative; transition: all 0.2s;"></span>
                        <span style="font-size: 1.1rem; font-weight: 600; color: #1f2937; line-height: 1;"><?= $val ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 3 -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                3. El desarrollo en general del curso. <span style="color: #ef4444;">*</span>
            </h3>
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-left: 1.5rem; flex-wrap: wrap;">
                <?php foreach (['5', '4', '3', '2', '1'] as $val): ?>
                    <label class="custom-radio-scale" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="radio" name="q3" value="<?= $val ?>" <?= ($old['q3'] ?? '') === $val ? 'checked' : '' ?> required style="position: absolute; opacity: 0; pointer-events: none;">
                        <span class="radio-dot" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #134063; background: #fff; display: inline-block; position: relative; transition: all 0.2s;"></span>
                        <span style="font-size: 1.1rem; font-weight: 600; color: #1f2937; line-height: 1;"><?= $val ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 4 -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                4. La aplicaci&oacute;n de lo aprendido en tu vida profesional o cotidiana. <span style="color: #ef4444;">*</span>
            </h3>
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-left: 1.5rem; flex-wrap: wrap;">
                <?php foreach (['5', '4', '3', '2', '1'] as $val): ?>
                    <label class="custom-radio-scale" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="radio" name="q4" value="<?= $val ?>" <?= ($old['q4'] ?? '') === $val ? 'checked' : '' ?> required style="position: absolute; opacity: 0; pointer-events: none;">
                        <span class="radio-dot" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #134063; background: #fff; display: inline-block; position: relative; transition: all 0.2s;"></span>
                        <span style="font-size: 1.1rem; font-weight: 600; color: #1f2937; line-height: 1;"><?= $val ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Pregunta 5 -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                5. La organizaci&oacute;n del curso. <span style="color: #ef4444;">*</span>
            </h3>
            <div style="display: flex; gap: 1.5rem; align-items: center; margin-left: 1.5rem; flex-wrap: wrap;">
                <?php foreach (['5', '4', '3', '2', '1'] as $val): ?>
                    <label class="custom-radio-scale" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; user-select: none;">
                        <input type="radio" name="q5" value="<?= $val ?>" <?= ($old['q5'] ?? '') === $val ? 'checked' : '' ?> required style="position: absolute; opacity: 0; pointer-events: none;">
                        <span class="radio-dot" style="width: 1.25rem; height: 1.25rem; border-radius: 50%; border: 2px solid #134063; background: #fff; display: inline-block; position: relative; transition: all 0.2s;"></span>
                        <span style="font-size: 1.1rem; font-weight: 600; color: #1f2937; line-height: 1;"><?= $val ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Comentario -->
        <div class="s-q-block" style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #111827; margin: 0 0 1rem 0; line-height: 1.5;">
                Comentario (Opcional)
            </h3>
            <textarea name="comentarios" rows="5" placeholder="Comparta cualquier observaci&oacute;n que nos ayude a mejorar..."><?= e($old['comentarios'] ?? '') ?></textarea>
            <p class="muted">La informaci&oacute;n recabada ser&aacute; utilizada exclusivamente para fines estad&iacute;sticos, de evaluaci&oacute;n y mejora continua.</p>
        </div>

        <div class="form-actions s-actions">
            <button type="submit" class="btn btn-primary">Enviar encuesta</button>
        </div>
    </form>
</section>