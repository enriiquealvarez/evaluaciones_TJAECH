<section class="container satisfaction-wrap">
    <div class="satisfaction-head">
        <h1>Encuesta de Satisfacci&oacute;n</h1>
        <p>Su retroalimentaci&oacute;n es fundamental para mantener la excelencia acad&eacute;mica de nuestros programas. Tiempo estimado: 2 minutos.</p>
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

        <div class="s-q-block">
            <h3><span class="s-step">1</span>&iquest;Qu&eacute; tan satisfecho/a est&aacute; con el curso en general?</h3>
            <div class="s-options s-options-4">
                <?php
                $q1Opts = ['Muy satisfecho/a', 'Satisfecho/a', 'Ni satisfecho/a ni insatisfecho/a', 'Insatisfecho/a'];
                $q1Old = $old['q1'] ?? '';
                foreach ($q1Opts as $opt):
                ?>
                    <label class="s-pill">
                        <input type="radio" name="q1" value="<?= e($opt) ?>" <?= $q1Old === $opt ? 'checked' : '' ?> required>
                        <span><?= e($opt) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-q-block">
            <h3><span class="s-step">2</span>&iquest;C&oacute;mo eval&uacute;as la calidad y claridad de los contenidos impartidos durante el curso (virtual y/o presencial)?</h3>
            <div class="s-options s-options-4">
                <?php
                $q2Opts = ['Muy buena', 'Buena', 'Regular', 'Deficiente'];
                $q2Old = $old['q2'] ?? '';
                foreach ($q2Opts as $opt):
                ?>
                    <label class="s-pill">
                        <input type="radio" name="q2" value="<?= e($opt) ?>" <?= $q2Old === $opt ? 'checked' : '' ?> required>
                        <span><?= e($opt) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-q-block">
            <h3><span class="s-step">3</span>&iquest;C&oacute;mo califica la organizaci&oacute;n y desarrollo de las actividades del curso (virtuales y presenciales)?</h3>
            <div class="s-options s-options-4">
                <?php
                $q3Opts = ['Excelente', 'Buena', 'Regular', 'Deficiente'];
                $q3Old = $old['q3'] ?? '';
                foreach ($q3Opts as $opt):
                ?>
                    <label class="s-pill">
                        <input type="radio" name="q3" value="<?= e($opt) ?>" <?= $q3Old === $opt ? 'checked' : '' ?> required>
                        <span><?= e($opt) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-q-block">
            <h3><span class="s-step">4</span>&iquest;Considera que los conocimientos adquiridos ser&aacute;n &uacute;tiles para el desempe&ntilde;o de sus funciones?</h3>
            <div class="s-options s-options-4">
                <?php
                $q4Opts = [
                    'Muy utiles' => 'Muy &uacute;tiles',
                    'Utiles' => '&Uacute;tiles',
                    'Poco utiles' => 'Poco &uacute;tiles',
                    'Nada utiles' => 'Nada &uacute;tiles'
                ];
                $q4Old = $old['q4'] ?? '';
                foreach ($q4Opts as $value => $label):
                ?>
                    <label class="s-pill">
                        <input type="radio" name="q4" value="<?= e($value) ?>" <?= $q4Old === $value ? 'checked' : '' ?> required>
                        <span><?= $label ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-q-block">
            <h3><span class="s-step">5</span>&iquest;Recomendar&iacute;a este curso a otras personas?</h3>
            <div class="s-options s-options-4">
                <?php
                $q5Opts = [
                    'Si, definitivamente' => 'S&iacute;, definitivamente',
                    'Probablemente si' => 'Probablemente s&iacute;',
                    'Probablemente no' => 'Probablemente no',
                    'No' => 'No'
                ];
                $q5Old = $old['q5'] ?? '';
                foreach ($q5Opts as $value => $label):
                ?>
                    <label class="s-pill">
                        <input type="radio" name="q5" value="<?= e($value) ?>" <?= $q5Old === $value ? 'checked' : '' ?> required>
                        <span><?= $label ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="s-q-block">
            <h3><span class="s-step">6</span>Comentarios (opcional)</h3>
            <textarea name="comentarios" rows="5" placeholder="Comparta cualquier observaci&oacute;n que nos ayude a mejorar..."><?= e($old['comentarios'] ?? '') ?></textarea>
            <p class="muted">La informaci&oacute;n recabada ser&aacute; utilizada exclusivamente para fines estad&iacute;sticos, de evaluaci&oacute;n y mejora continua.</p>
        </div>

        <div class="form-actions s-actions">
            <button type="submit" class="btn btn-primary">Enviar encuesta</button>
        </div>
    </form>
</section>