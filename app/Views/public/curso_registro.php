<?php
$generos = ['Mujer', 'Hombre', 'No binario/otro', 'Prefiero no responder'];
$generoOld = $old['genero'] ?? '';
$gradoOld = trim((string)($old['grado_estudios'] ?? ''));
$gradoOldKey = mb_strtolower($gradoOld);
$gradoOldKey = strtr($gradoOldKey, [
    'á' => 'a',
    'é' => 'e',
    'í' => 'i',
    'ó' => 'o',
    'ú' => 'u',
]);
$institucionOld = trim((string)($old['institucion'] ?? ''));
$courseTitle = trim((string)($curso['nombre'] ?? ''));
if (function_exists('iconv')) {
    $cleanCourseTitle = @iconv('UTF-8', 'UTF-8//IGNORE', $courseTitle);
    if ($cleanCourseTitle !== false) {
        $courseTitle = $cleanCourseTitle;
    }
}
$courseTitle = trim($courseTitle, " \t\n\r\0\x0B\"'");
$courseTitle = $courseTitle !== '' ? $courseTitle : 'Programa de capacitacion';
$institutionOptions = $institutionOptions ?? [];
$institutionLookup = array_values(array_filter(array_map(static function ($institution) {
    $institution = trim((string)$institution);
    return $institution !== '' ? $institution : null;
}, $institutionOptions)));
$colectivosOld = $old['colectivos'] ?? [];
if (!is_array($colectivosOld)) {
    $colectivosOld = [];
}
$gradoOptions = [
    ['value' => 'Educacion media superior', 'label' => 'Educaci&oacute;n media superior', 'key' => 'educacion media superior'],
    ['value' => 'Licenciatura', 'label' => 'Licenciatura', 'key' => 'licenciatura'],
    ['value' => 'Posgrado', 'label' => 'Posgrado', 'key' => 'posgrado'],
    ['value' => 'Otro', 'label' => 'Otro', 'key' => 'otro'],
];
$colectivos = [
    ['value' => 'Discapacidad fisica', 'label' => 'Discapacidad f&iacute;sica'],
    ['value' => 'Discapacidad sensorial', 'label' => 'Discapacidad sensorial'],
    ['value' => 'Discapacidad intelectual', 'label' => 'Discapacidad intelectual'],
    ['value' => 'Discapacidad psicosocial', 'label' => 'Discapacidad psicosocial'],
    ['value' => 'Personas adultas mayores', 'label' => 'Personas adultas mayores'],
    ['value' => 'Pueblos indigenas u originarios', 'label' => 'Pueblos ind&iacute;genas u originarios'],
    ['value' => 'Situacion de movilidad humana o migracion', 'label' => 'Situaci&oacute;n de movilidad humana o migraci&oacute;n'],
    ['value' => 'Diversidad sexual y de genero (LGBTIQ+)', 'label' => 'Diversidad sexual y de g&eacute;nero (LGBTIQ+)'],
    ['value' => 'Ninguno', 'label' => 'Ninguno'],
    ['value' => 'Prefiero no responder', 'label' => 'Prefiero no responder'],
];
?>

<style>
.course-registration-classic {
  background: #f3f6fb;
  color: #0f172a;
  font-family: Inter, "Segoe UI", sans-serif;
  padding: 48px 0 56px;
}

.course-registration-classic .wrap {
  max-width: 1160px;
  margin: 0 auto;
  padding: 0 20px;
}

.course-registration-classic .kicker {
  margin: 0;
  color: #1e3a8a;
  font-size: 0.88rem;
  font-weight: 700;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.course-registration-classic .hero-title {
  margin: 8px 0 8px;
  color: #0f172a;
  font-size: clamp(1.8rem, 3.2vw, 2.6rem);
  line-height: 1.08;
  letter-spacing: -0.02em;
  max-width: 760px;
  font-weight: 800;
}

.course-registration-classic .hero-copy {
  max-width: 760px;
  margin: 10px 0 0;
  color: #475569;
  font-size: clamp(0.95rem, 1.1vw, 1.05rem);
  line-height: 1.5;
}

.course-registration-classic form {
  margin-top: 40px;
  padding: 32px 40px;
  border: 1px solid #dbe3ef;
  border-radius: 24px;
  background: #ffffff;
  box-shadow: 0 24px 48px rgba(148, 163, 184, 0.16);
}

.course-registration-classic .section-head {
  display: flex;
  align-items: center;
  gap: 14px;
  margin: 0;
  padding: 0 0 24px;
  border-bottom: 1px solid #e9eef5;
}

.course-registration-classic .section-head-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  border: 2px solid #1e40af;
  border-radius: 50%;
  color: #1e40af;
  font-size: 1.25rem;
  font-weight: 700;
  line-height: 1;
  flex: 0 0 auto;
}

.course-registration-classic .section-head h3 {
  margin: 0;
  color: #0f172a;
  font-size: clamp(1.55rem, 2vw, 2.15rem);
  line-height: 1.15;
}

.course-registration-classic .section-head p {
  margin: 4px 0 0;
  color: #64748b;
  font-size: 0.95rem;
  font-style: italic;
}

.course-registration-classic .alerts {
  display: grid;
  gap: 14px;
  margin: 24px 0 0;
}

.course-registration-classic .form-grid {
  display: grid;
  grid-template-columns: repeat(12, minmax(0, 1fr));
  gap: 20px;
  margin-top: 24px;
}

.course-registration-classic .field {
  display: flex;
  flex-direction: column;
  gap: 6px;
  min-width: 0;
}

.course-registration-classic .field-label {
  color: #1e293b;
  font-size: 0.9rem;
  font-weight: 600;
  line-height: 1.3;
  margin-bottom: 4px;
}

.course-registration-classic .span-4 {
  grid-column: span 5;
}

.course-registration-classic .span-3 {
  grid-column: span 3;
}

.course-registration-classic .span-2 {
  grid-column: span 2;
}

.course-registration-classic .span-5 {
  grid-column: span 6;
}

.course-registration-classic .span-6 {
  grid-column: span 6;
}

.course-registration-classic .span-12 {
  grid-column: span 12;
}

.course-registration-classic input[type="text"],
.course-registration-classic input[type="email"],
.course-registration-classic input[type="number"],
.course-registration-classic select {
  width: 100%;
  min-height: 48px;
  padding: 10px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  background: #ffffff;
  color: #1e293b;
  font: inherit;
  font-size: 0.95rem;
  transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
}

.course-registration-classic select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  padding-right: 44px;
}

.course-registration-classic .select-wrap {
  position: relative;
}

.course-registration-classic .select-wrap::after {
  content: "⌄";
  position: absolute;
  right: 16px;
  top: 50%;
  transform: translateY(-50%);
  color: #64748b;
  font-size: 1.15rem;
  pointer-events: none;
}

.course-registration-classic input::placeholder {
  color: #6b7280;
}

.course-registration-classic input:focus,
.course-registration-classic select:focus {
  outline: none;
  border-color: #1e3a8a;
  box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.12);
  background: #fff;
}

.course-registration-classic .hint {
  margin: 0;
  display: flex;
  align-items: flex-start;
  gap: 8px;
  color: #1d4ed8;
  font-size: 0.72rem;
  line-height: 1.45;
  padding: 10px 12px;
  border: 1px solid #dbeafe;
  border-radius: 10px;
  background: #eff6ff;
}

.course-registration-classic .hint::before {
  content: "i";
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  height: 16px;
  border: 1px solid currentColor;
  border-radius: 50%;
  font-size: 0.68rem;
  font-weight: 700;
  line-height: 1;
  vertical-align: 1px;
}

.course-registration-classic .institution-combobox {
  position: relative;
}

.course-registration-classic .institution-search {
  padding-left: 44px;
}

.course-registration-classic .institution-search-icon {
  position: absolute;
  left: 14px;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  width: 18px;
  height: 18px;
  pointer-events: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.course-registration-classic .institution-search-icon svg {
  width: 16px;
  height: 16px;
  display: block;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.course-registration-classic .institution-results {
  position: absolute;
  top: calc(100% + 8px);
  left: 0;
  right: 0;
  z-index: 20;
  display: grid;
  gap: 2px;
  max-height: 320px;
  padding: 8px;
  border: 1px solid #dbe3ef;
  border-radius: 12px;
  background: #ffffff;
  box-shadow: 0 18px 28px rgba(15, 23, 42, 0.12);
  overflow-y: auto;
  overscroll-behavior: contain;
}

.course-registration-classic .institution-results[hidden] {
  display: none;
}

.course-registration-classic .institution-option,
.course-registration-classic .institution-empty {
  width: 100%;
  padding: 11px 12px;
  border: 0;
  border-radius: 10px;
  background: transparent;
  color: #23314b;
  font: inherit;
  font-size: 0.92rem;
  line-height: 1.45;
  text-align: left;
}

.course-registration-classic .institution-option {
  cursor: pointer;
}

.course-registration-classic .institution-option:hover,
.course-registration-classic .institution-option.is-active {
  background: #eff6ff;
  color: #1d4ed8;
}

.course-registration-classic .institution-empty {
  color: #64748b;
}

.course-registration-classic .collective-card {
  margin-top: 28px;
  border: 1px solid #dbe3ef;
  border-radius: 16px;
  background: #f8fafc;
  overflow: hidden;
}

.course-registration-classic .collective-head {
  padding: 24px 32px 12px;
  border-bottom: 0;
}

.course-registration-classic .collective-head h3 {
  margin: 0;
  color: #0f172a;
  font-size: clamp(1.1rem, 1.5vw, 1.6rem);
}

.course-registration-classic .collective-head p {
  margin: 6px 0 0;
  color: #64748b;
  font-size: 0.95rem;
}

.course-registration-classic .collective-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 14px;
  padding: 0 32px 28px;
}

.course-registration-classic .collective-option {
  display: flex;
  align-items: center;
  gap: 10px;
  min-height: 48px;
  padding: 0 12px;
  border: 1px solid #d7e0ea;
  border-radius: 8px;
  background: #fff;
  color: #1b2942;
  font-size: 0.9rem;
  line-height: 1.4;
  cursor: pointer;
  transition: border-color 0.18s ease, box-shadow 0.18s ease;
}

.course-registration-classic .collective-option input {
  width: 20px;
  height: 20px;
  margin: 0;
  accent-color: #1e3a8a;
  flex: 0 0 auto;
}

.course-registration-classic .collective-option:hover {
  border-color: #c4d2e4;
}

.course-registration-classic .actions {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
  margin-top: 32px;
  padding-top: 24px;
  border-top: 1px solid #e9eef5;
}

.course-registration-classic .privacy-note {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #64748b;
  font-size: 0.78rem;
  line-height: 1.4;
}

.course-registration-classic .privacy-note-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  height: 16px;
  color: #64748b;
  flex: 0 0 auto;
}

.course-registration-classic .privacy-note-icon svg {
  width: 16px;
  height: 16px;
  display: block;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
  stroke-linecap: round;
  stroke-linejoin: round;
}

.course-registration-classic .action-buttons {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 16px;
  flex-wrap: wrap;
}

.course-registration-classic .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 180px;
  min-height: 52px;
  padding: 0 26px;
  border-radius: 10px;
  text-decoration: none;
  font: inherit;
  font-size: 1rem;
  font-weight: 700;
  border: 1px solid transparent;
  cursor: pointer;
  transition: transform 0.16s ease, box-shadow 0.16s ease, background-color 0.16s ease, color 0.16s ease;
}

.course-registration-classic .btn-primary {
  background: #1e3a8a;
  color: #fff;
  box-shadow: 0 12px 22px rgba(30, 58, 138, 0.22);
}

.course-registration-classic .btn-secondary {
  background: transparent;
  border-color: transparent;
  color: #334155;
  min-width: auto;
  padding: 0 10px;
}

.course-registration-classic .btn:hover {
  transform: translateY(-1px);
}

.course-registration-classic .btn-secondary[disabled] {
  cursor: not-allowed;
  opacity: 0.75;
  transform: none;
}

.course-registration-classic .btn-primary:hover {
  background: #1d3479;
}

.course-registration-classic .btn-secondary:hover:not([disabled]) {
  background: #f8fafc;
  color: #0f172a;
}

.course-registration-classic .notes {
  display: grid;
  gap: 12px;
  margin-top: 18px;
}

.course-registration-classic .note {
  margin: 0;
  color: #607089;
  font-size: 0.88rem;
  line-height: 1.5;
}

@media (max-width: 1100px) {
  .course-registration-classic .span-4,
  .course-registration-classic .span-3,
  .course-registration-classic .span-2,
  .course-registration-classic .span-5,
  .course-registration-classic .span-6 {
    grid-column: span 6;
  }

  .course-registration-classic .collective-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .course-registration-classic form {
    padding: 28px 24px;
  }
}

@media (max-width: 760px) {
  .course-registration-classic .wrap {
    padding: 0 16px;
  }

  .course-registration-classic .hero-title {
    font-size: 2.25rem;
  }

  .course-registration-classic .span-4,
  .course-registration-classic .span-3,
  .course-registration-classic .span-2,
  .course-registration-classic .span-5,
  .course-registration-classic .span-6,
  .course-registration-classic .span-12 {
    grid-column: span 12;
  }

  .course-registration-classic .collective-grid {
    grid-template-columns: 1fr;
    padding: 20px;
  }

  .course-registration-classic .btn {
    width: 100%;
    min-width: 0;
  }

  .course-registration-classic .actions {
    align-items: stretch;
  }

  .course-registration-classic .collective-head {
    padding: 24px 20px 18px;
  }

  .course-registration-classic form {
    padding: 22px 16px;
    border-radius: 18px;
  }

  .course-registration-classic .action-buttons {
    width: 100%;
  }

  .course-registration-classic .btn-secondary {
    padding: 0;
  }
}
</style>

<section class="course-registration-classic">
    <div class="wrap">
        <p class="kicker">REGISTRO AL CURSO</p>
        <h1 class="hero-title">&quot;<?= e($courseTitle) ?>&quot;</h1>

        <div class="alerts" style="margin-top: 32px; max-width: 760px;">
            <?php if (!empty($success)): ?>
                <div class="alert alert-green">
                    <div><?= e($success) ?></div>
                    <?php if (!empty($participantGuideUrl)): ?>
                        <div style="margin-top:12px;">
                            <a href="<?= e($participantGuideUrl) ?>" class="btn btn-secondary" target="_blank" rel="noopener">Descargar indicaciones y recomendaciones para participantes</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

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
        </div>

        <?php if (!empty($cupoLleno)): ?>
            <?php if (empty($success)): ?>
            <div style="margin-top: 40px; padding: 40px; border-radius: 24px; background: #fff; box-shadow: 0 24px 48px rgba(148, 163, 184, 0.16); text-align: center;">
                <h2 style="color: #1e3a8a; margin-top: 0;">Cupo Lleno</h2>
                <p style="color: #475569; font-size: 1.1rem; line-height: 1.5;">Lo sentimos, el l&iacute;mite de registros para este curso se ha alcanzado. Agradecemos su inter&eacute;s.</p>
                <div style="margin-top: 32px;">
                    <a href="<?= e(url('/')) ?>" class="btn btn-primary" style="text-decoration: none;">Volver al inicio</a>
                </div>
            </div>
            <?php else: ?>
            <div style="margin-top: 32px; text-align: center;">
                <a href="<?= e(url('/')) ?>" class="btn btn-primary" style="text-decoration: none;">Volver al inicio</a>
            </div>
            <?php endif; ?>
        <?php else: ?>
        <form method="post" action="<?= e(url('/curso/registrar')) ?>">
            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
            <input type="hidden" name="curso_id" value="<?= (int)$curso['id'] ?>">

            <div class="section-head">
                <span class="section-head-icon">+</span>
                <div>
                    <h3>Registro al curso</h3>
                    <p>Todos los campos marcados con (*) son obligatorios</p>
                </div>
            </div>

            <div class="form-grid">
                <label class="field span-6">
                    <span class="field-label">Nombre completo*</span>
                    <input type="text" name="nombre_completo" required value="<?= e($old['nombre_completo'] ?? '') ?>" placeholder="Ingrese su nombre completo">
                </label>

                <label class="field span-3">
                    <span class="field-label">Edad*</span>
                    <input type="number" min="10" max="99" name="edad" required value="<?= e($old['edad'] ?? '') ?>" placeholder="00">
                </label>

                <label class="field span-3">
                    <span class="field-label">G&eacute;nero*</span>
                    <div class="select-wrap">
                        <select name="genero" required>
                            <option value="">Seleccione</option>
                            <?php foreach ($generos as $genero): ?>
                                <option value="<?= e($genero) ?>" <?= $generoOld === $genero ? 'selected' : '' ?>><?= e($genero) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </label>

                <label class="field span-6">
                    <span class="field-label">Tel&eacute;fono*</span>
                    <input type="text" name="telefono" required value="<?= e($old['telefono'] ?? '') ?>" placeholder="10 d&iacute;gitos">
                </label>

                <label class="field span-6">
                    <span class="field-label">Correo electr&oacute;nico*</span>
                    <input type="email" name="correo" required value="<?= e($old['correo'] ?? '') ?>" placeholder="ejemplo@correo.com">
                </label>

                <label class="field span-6" id="institucion-container">
                    <span class="field-label">Institución a la que pertenece*</span>
                    <div class="institution-combobox" data-institution-combobox>
                        <input type="hidden" name="institucion" value="<?= e($institucionOld) ?>" data-institution-value>
                        <input
                            type="text"
                            data-institution-input
                            value="<?= e($institucionOld) ?>"
                            placeholder="Escriba para buscar una institución"
                            autocomplete="off"
                            spellcheck="false"
                            required
                        >
                        <div class="institution-results" data-institution-results hidden></div>
                    </div>
                    <p class="hint">Debe seleccionar una opción del listado autorizado que aparecerá al escribir.</p>
                </label>

                <label class="field span-6" id="institucion-otra-container" style="<?= $institucionOld === 'Otro' ? '' : 'display: none;' ?>">
                    <span class="field-label">Especifique*</span>
                    <input type="text" name="institucion_otra" id="institucion-otra-input" value="<?= e($old['institucion_otra'] ?? '') ?>" placeholder="Escriba su institución">
                </label>

                <label class="field span-12">
                    <span class="field-label">Cargo o puesto que desempeña</span>
                    <input type="text" name="cargo_puesto" value="<?= e($old['cargo_puesto'] ?? '') ?>" placeholder="Su cargo actual">
                </label>

                <label class="field span-6">
                    <span class="field-label">&Uacute;ltimo grado de estudios concluido*</span>
                    <div class="select-wrap">
                        <select name="grado_estudios" required>
                            <option value="">Seleccione una opci&oacute;n</option>
                            <?php foreach ($gradoOptions as $gradoOption): ?>
                                <option value="<?= e($gradoOption['value']) ?>" <?= $gradoOldKey === $gradoOption['key'] ? 'selected' : '' ?>><?= $gradoOption['label'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </label>

                <label class="field span-6">
                    <span class="field-label">Especifique otro grado (si aplica)</span>
                    <input type="text" name="grado_otro" value="<?= e($old['grado_otro'] ?? '') ?>" placeholder="Opcional">
                </label>
            </div>

            <div class="collective-card">
                <div class="collective-head">
                    <h3>&iquest;Se identifica con alguno de los siguientes grupos o colectivos?*</h3>
                    <p>Puede seleccionar m&aacute;s de una opci&oacute;n.</p>
                </div>

                <div class="collective-grid">
                    <?php foreach ($colectivos as $colectivo): ?>
                        <label class="collective-option">
                            <input type="checkbox" name="colectivos[]" value="<?= e($colectivo['value']) ?>" <?= in_array($colectivo['value'], $colectivosOld, true) ? 'checked' : '' ?>>
                            <span><?= $colectivo['label'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="actions">
                <div class="privacy-note" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" id="privacy-checkbox" name="aviso_privacidad" required style="margin: 0; cursor: not-allowed; width: 18px; height: 18px; flex-shrink: 0;" onclick="return false;" onkeydown="return false;">
                    <label for="privacy-checkbox" style="margin: 0; font-size: 14px; color: #111426; font-weight: normal; display: inline-block; cursor: default;">
                        He le&iacute;do y acepto el <a href="#" id="privacy-link" style="color: #2b5c8f !important; text-decoration: underline !important; font-weight: 600 !important; display: inline-block !important; border: none !important; padding: 0 !important; background: transparent !important; box-shadow: none !important; outline: none !important;">Aviso de Privacidad</a>*
                    </label>
                </div>
                <p class="hint" style="margin-top: 4px; font-size: 0.85em; margin-left: 26px;">(Debe abrir el aviso de privacidad para poder aceptar y enviar su registro).</p>

                <div class="action-buttons" style="margin-top: 16px;">
                    <button type="submit" id="submit-btn" class="btn btn-primary" disabled style="cursor: not-allowed; opacity: 0.6;">Enviar registro</button>
                </div>
            </div>

            <div class="notes">
                <?php if (!empty($participantGuideUrl)): ?>
                    <p class="note">Al completar el registro, recibir&aacute; por correo electr&oacute;nico las indicaciones y recomendaciones del curso.</p>
                <?php endif; ?>
            </div>
        </form>
        <?php endif; ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var normalizeText = function (value) {
    return (value || '')
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim();
  };

  var institutionOptions = <?= json_encode($institutionLookup, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  var comboboxes = document.querySelectorAll('[data-institution-combobox]');

  comboboxes.forEach(function (combobox) {
    var hiddenInput = combobox.querySelector('[data-institution-value]');
    var searchInput = combobox.querySelector('[data-institution-input]');
    var results = combobox.querySelector('[data-institution-results]');
    var activeIndex = -1;
    var visibleOptions = [];

    if (!hiddenInput || !searchInput || !results) {
      return;
    }

    var closeResults = function () {
      results.hidden = true;
      activeIndex = -1;
    };

    var setValue = function (value) {
      hiddenInput.value = value;
      searchInput.value = value;
      searchInput.setCustomValidity('');
      closeResults();
      
      var institucionOtraContainer = document.getElementById('institucion-otra-container');
      var institucionOtraInput = document.getElementById('institucion-otra-input');
      if (institucionOtraContainer && institucionOtraInput) {
        if (value === 'Otro') {
          institucionOtraContainer.style.display = '';
          institucionOtraInput.required = true;
        } else {
          institucionOtraContainer.style.display = 'none';
          institucionOtraInput.required = false;
          institucionOtraInput.value = '';
        }
      }
    };

    var buildOption = function (value, index) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'institution-option';
      button.textContent = value;
      button.setAttribute('data-option-index', String(index));
      button.addEventListener('mousedown', function (event) {
        event.preventDefault();
        setValue(value);
      });
      return button;
    };

    var renderResults = function () {
      var term = normalizeText(searchInput.value);
      visibleOptions = institutionOptions.filter(function (option) {
        return term === '' || normalizeText(option).indexOf(term) !== -1;
      });

      results.innerHTML = '';

      if (visibleOptions.length === 0) {
        var emptyState = document.createElement('div');
        emptyState.className = 'institution-empty';
        emptyState.textContent = 'No se encontraron coincidencias en el listado autorizado.';
        results.appendChild(emptyState);
        results.hidden = false;
        activeIndex = -1;
        return;
      }

      visibleOptions.forEach(function (option, index) {
        results.appendChild(buildOption(option, index));
      });

      results.hidden = false;
      activeIndex = -1;
    };

    var syncActiveOption = function () {
      var optionNodes = results.querySelectorAll('.institution-option');
      optionNodes.forEach(function (node, index) {
        node.classList.toggle('is-active', index === activeIndex);
      });
    };

    searchInput.addEventListener('focus', function () {
      renderResults();
    });

    searchInput.addEventListener('input', function () {
      hiddenInput.value = '';
      searchInput.setCustomValidity('');
      renderResults();
    });

    searchInput.addEventListener('keydown', function (event) {
      if (results.hidden || visibleOptions.length === 0) {
        return;
      }

      if (event.key === 'ArrowDown') {
        event.preventDefault();
        activeIndex = Math.min(activeIndex + 1, visibleOptions.length - 1);
        syncActiveOption();
      }

      if (event.key === 'ArrowUp') {
        event.preventDefault();
        activeIndex = Math.max(activeIndex - 1, 0);
        syncActiveOption();
      }

      if (event.key === 'Enter' && activeIndex >= 0) {
        event.preventDefault();
        setValue(visibleOptions[activeIndex]);
      }

      if (event.key === 'Escape') {
        closeResults();
      }
    });

    searchInput.addEventListener('blur', function () {
      window.setTimeout(function () {
        var typedValue = searchInput.value.trim();
        var exactMatch = institutionOptions.find(function (option) {
          return normalizeText(option) === normalizeText(typedValue);
        });

        if (exactMatch) {
          setValue(exactMatch);
        } else if (typedValue === '') {
          hiddenInput.value = '';
          searchInput.setCustomValidity('Seleccione una institucion del listado.');
          closeResults();
        } else if (hiddenInput.value !== typedValue) {
          hiddenInput.value = '';
          searchInput.setCustomValidity('Seleccione una institucion valida del listado.');
          closeResults();
        }
      }, 120);
    });

    var form = searchInput.form;
    if (form) {
      form.addEventListener('submit', function (event) {
        var exactMatch = institutionOptions.find(function (option) {
          return normalizeText(option) === normalizeText(searchInput.value);
        });

        if (!exactMatch) {
          hiddenInput.value = '';
          searchInput.setCustomValidity('Seleccione una institucion valida del listado.');
          searchInput.reportValidity();
          event.preventDefault();
          return;
        }

        hiddenInput.value = exactMatch;
        searchInput.value = exactMatch;
        searchInput.setCustomValidity('');
      });
    }
  });

  var privacyLink = document.getElementById('privacy-link');
  var privacyCheckbox = document.getElementById('privacy-checkbox');
  var submitBtn = document.getElementById('submit-btn');

  if (privacyLink && privacyCheckbox && submitBtn) {
    privacyLink.addEventListener('click', function(e) {
      e.preventDefault();
      if (typeof Swal !== 'undefined') {
        let timerInterval;
        let timeLeft = 5;

        Swal.fire({
          title: 'Aviso de Privacidad',
          html: '<iframe src="https://transparencia.tjaech.gob.mx/avisos_privacidad/APS-ACCIONES-CAPACITACION-IJA.pdf" style="width: 100%; height: 65vh; border: none; border-radius: 4px;"></iframe>',
          width: '800px',
          showCloseButton: true,
          confirmButtonText: 'He leído y acepto (' + timeLeft + 's)',
          confirmButtonColor: '#2b5c8f',
          cancelButtonText: 'Cerrar',
          showCancelButton: true,
          didOpen: () => {
            const confirmBtn = Swal.getConfirmButton();
            confirmBtn.disabled = true;
            confirmBtn.style.opacity = '0.5';
            confirmBtn.style.cursor = 'not-allowed';
            
            timerInterval = setInterval(() => {
              timeLeft -= 1;
              if (timeLeft <= 0) {
                clearInterval(timerInterval);
                confirmBtn.disabled = false;
                confirmBtn.style.opacity = '1';
                confirmBtn.style.cursor = 'pointer';
                confirmBtn.textContent = 'He leído y acepto';
              } else {
                confirmBtn.textContent = 'He leído y acepto (' + timeLeft + 's)';
              }
            }, 1000);
          },
          willClose: () => {
            clearInterval(timerInterval);
          }
        }).then((result) => {
          if (result.isConfirmed) {
            privacyCheckbox.checked = true;
            submitBtn.disabled = false;
            submitBtn.style.cursor = 'pointer';
            submitBtn.style.opacity = '1';
          }
        });
      } else {
        window.open('https://transparencia.tjaech.gob.mx/avisos_privacidad/APS-ACCIONES-CAPACITACION-IJA.pdf', '_blank');
        setTimeout(function() {
            privacyCheckbox.checked = true;
            submitBtn.disabled = false;
            submitBtn.style.cursor = 'pointer';
            submitBtn.style.opacity = '1';
        }, 5000);
      }
    });

    // Make sure manual clicks don't change state if somehow they bypass readonly
    privacyCheckbox.addEventListener('click', function(e) {
      e.preventDefault();
      return false;
    });
  }
});
</script>
