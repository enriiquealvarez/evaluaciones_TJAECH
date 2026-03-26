<section class="container insc-modern">
    <?php
        $selectedCourseName = 'Todos los cursos';
        foreach ($cursos as $cursoItem) {
            if ((string)$filters['curso_id'] === (string)$cursoItem['id']) {
                $selectedCourseName = (string)$cursoItem['nombre'];
                break;
            }
        }
        $dashboardJson = json_encode($dashboard ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $exportRowsJson = json_encode($exportRows ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $dashJsPath = __DIR__ . '/../../../../public/assets/js/inscripciones_dashboard.js';
        $dashJsVersion = is_file($dashJsPath) ? (string)filemtime($dashJsPath) : (string)time();
        $page = max(1, (int)($pagination['page'] ?? 1));
        $perPage = (int)($pagination['per_page'] ?? 20);
        $total = (int)($pagination['total'] ?? count($inscripciones));
        $totalPages = max(1, (int)($pagination['total_pages'] ?? 1));
        $rangeStart = $total > 0 ? (($page - 1) * $perPage) + 1 : 0;
        $rangeEnd = $total > 0 ? min($total, $rangeStart + count($inscripciones) - 1) : 0;

        $baseQuery = [
            'curso_id' => (string)$filters['curso_id'],
            'q' => (string)$filters['q'],
            'search_in' => (string)($filters['search_in'] ?? 'all'),
            'per_page' => $perPage,
        ];

        $buildPageUrl = static function (int $targetPage) use ($baseQuery): string {
            $query = $baseQuery;
            if ($targetPage > 1) {
                $query['page'] = $targetPage;
            }
            return url('/admin/inscripciones?' . http_build_query(array_filter(
                $query,
                static fn($value): bool => $value !== ''
            )));
        };
    ?>

    <?php if (!empty($flash)): ?>
        <div class="alert alert-green" data-swal="success" data-swal-title="Acción completada"><?= e($flash) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-magenta" data-swal="error" data-swal-title="Atención"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="page-header between insc-modern-header">
        <div>
            <h2>Inscripciones al curso</h2>
            <p>Listado de participantes registrados y datos de acceso.</p>
        </div>
        <div class="action-row">
            <button type="button" class="btn btn-info btn-no-icon" id="exportInscripcionesExcel">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M12 3v12"></path>
                    <path d="M7 10l5 5 5-5"></path>
                    <path d="M4 20h16"></path>
                </svg>
                Exportar Excel inscritos
            </button>
            <button type="button" class="btn btn-secondary btn-no-icon" id="exportInscripcionesPdf">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M12 3v12"></path>
                    <path d="M7 10l5 5 5-5"></path>
                    <path d="M4 20h16"></path>
                </svg>
                Exportar PDF inscritos
            </button>
            <button type="button" class="btn btn-success btn-no-icon" id="exportDashboardPdf">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                    <path d="M12 3v12"></path>
                    <path d="M7 10l5 5 5-5"></path>
                    <path d="M4 20h16"></path>
                </svg>
                Exportar PDF demogr&aacute;fico
            </button>
            <?php if ((int)$filters['curso_id'] > 0): ?>
            <form method="post" action="<?= e(url('/admin/inscripciones/validar-masivo')) ?>" class="inline-form"
                  data-confirm-title="Validación masiva"
                  data-confirm="¿Deseas validar a TODOS los participantes registrados en este curso para que puedan realizar la evaluación?"
                  data-confirm-ok="Sí, validar todos"
                  data-confirm-color="#1b3f66">
                <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                <input type="hidden" name="curso_id" value="<?= (int)$filters['curso_id'] ?>">
                <input type="hidden" name="validado" value="1">
                <button type="submit" class="btn btn-primary btn-no-icon">Validar todos (Curso)</button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <form method="get" action="<?= e(url('/admin/inscripciones')) ?>" class="insc-modern-filters" id="inscripcionesFiltersForm">
        <select name="curso_id">
            <option value="">Todos los cursos</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= (int)$curso['id'] ?>" <?= (string)$filters['curso_id'] === (string)$curso['id'] ? 'selected' : '' ?>>
                    <?= e($curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="search_in">
            <option value="all" <?= (($filters['search_in'] ?? 'all') === 'all') ? 'selected' : '' ?>>Buscar en todo</option>
            <option value="nombre" <?= (($filters['search_in'] ?? 'all') === 'nombre') ? 'selected' : '' ?>>Nombre</option>
            <option value="correo" <?= (($filters['search_in'] ?? 'all') === 'correo') ? 'selected' : '' ?>>Correo</option>
            <option value="telefono" <?= (($filters['search_in'] ?? 'all') === 'telefono') ? 'selected' : '' ?>>Teléfono</option>
            <option value="institucion" <?= (($filters['search_in'] ?? 'all') === 'institucion') ? 'selected' : '' ?>>Institución</option>
            <option value="cargo" <?= (($filters['search_in'] ?? 'all') === 'cargo') ? 'selected' : '' ?>>Cargo/Puesto</option>
        </select>
        <input type="text" name="q" value="<?= e($filters['q']) ?>" placeholder="Escribe un valor real: ej. gmail, Tribunal, Alejandro">
        <select name="per_page">
            <?php foreach ([10, 20, 50, 100] as $size): ?>
                <option value="<?= $size ?>" <?= $perPage === $size ? 'selected' : '' ?>>
                    Mostrar <?= $size ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-info btn-no-icon" type="submit">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="M20 20l-3.5-3.5"></path>
            </svg>
            Filtrar
        </button>
    </form>

    <div class="insc-kpi-grid">
        <article class="insc-kpi-card accent-gold">
            <span>Total inscritos</span>
            <strong><?= (int)($dashboard['total'] ?? 0) ?></strong>
        </article>
        <article class="insc-kpi-card accent-teal">
            <span>Edad promedio</span>
            <strong><?= e((string)($dashboard['age_avg'] ?? 0)) ?></strong>
        </article>
        <article class="insc-kpi-card accent-teal">
            <span>Edad m&iacute;nima</span>
            <strong><?= (int)($dashboard['age_min'] ?? 0) ?></strong>
        </article>
        <article class="insc-kpi-card accent-gold">
            <span>Edad m&aacute;xima</span>
            <strong><?= (int)($dashboard['age_max'] ?? 0) ?></strong>
        </article>
    </div>

    <div class="insc-modern-dash-head">
        <h3>Resumen demogr&aacute;fico</h3>
        <p>Curso: <?= e($selectedCourseName) ?></p>
    </div>

    <div class="insc-analytics-grid">
        <section class="card insc-analytics-card">
            <h4>Distribuci&oacute;n por g&eacute;nero</h4>
            <div class="insc-analytics-body">
                <div class="insc-chart-wrap">
                    <canvas id="genderPieChart"></canvas>
                </div>
                <ul class="insc-mini-list">
                    <?php foreach (($dashboard['gender'] ?? []) as $label => $count): ?>
                        <li><span><?= e((string)$label) ?></span><strong><?= (int)$count ?></strong></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <section class="card insc-analytics-card">
            <h4>Rangos de edad</h4>
            <div class="insc-analytics-body">
                <div class="insc-chart-wrap">
                    <canvas id="agePieChart"></canvas>
                </div>
                <ul class="insc-mini-list">
                    <?php foreach (($dashboard['age_ranges'] ?? []) as $label => $count): ?>
                        <li><span><?= e((string)$label) ?></span><strong><?= (int)$count ?></strong></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <section class="card insc-analytics-card">
            <h4>Colectivos registrados</h4>
            <div class="insc-analytics-body">
                <div class="insc-chart-wrap">
                    <canvas id="colectivosBarChart"></canvas>
                </div>
                <ul class="insc-mini-list">
                    <?php foreach (($dashboard['colectivos'] ?? []) as $label => $count): ?>
                        <li><span><?= e((string)$label) ?></span><strong><?= (int)$count ?></strong></li>
                    <?php endforeach; ?>
                    <?php if (empty($dashboard['colectivos'])): ?>
                        <li><span>Sin datos</span><strong>0</strong></li>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </div>

    <section class="card insc-table-shell">
        <div class="page-header between">
            <div>
                <h3>Listado de participantes registrados y datos de acceso.</h3>
                <p>
                    <?php if ($total > 0): ?>
                        Mostrando <?= (int)$rangeStart ?> a <?= (int)$rangeEnd ?> de <?= (int)$total ?> registros.
                    <?php else: ?>
                        No hay registros para mostrar.
                    <?php endif; ?>
                </p>
            </div>
            <?php if ($totalPages > 1): ?>
                <div class="action-row">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl($page - 1)) ?>">Anterior</a>
                    <?php endif; ?>
                    <span class="badge info">Página <?= (int)$page ?> de <?= (int)$totalPages ?></span>
                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl($page + 1)) ?>">Siguiente</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <table class="table insc-table-modern">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Curso</th>
                    <th>Nombre</th>
                    <th>Instituci&oacute;n</th>
                    <th>Asistencia</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody>
                <?php foreach ($inscripciones as $row): ?>
                    <?php
                        $colectivos = json_decode((string)($row['colectivos_json'] ?? ''), true);
                        $colectivosTxt = (is_array($colectivos) && !empty($colectivos)) ? implode(', ', $colectivos) : 'Ninguno';
                    ?>
                    <tr data-insc-row data-insc-id="<?= (int)$row['id'] ?>">
                        <td><?= e((string)$row['created_at']) ?></td>
                        <td><?= e((string)$row['curso_nombre']) ?></td>
                        <td><?= e((string)$row['nombre_completo']) ?></td>
                        <td><?= e((string)$row['institucion']) ?></td>
                        <td>
                            <form method="post" action="<?= e(url('/admin/inscripciones/validar')) ?>" class="inline-form">
                                <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                <input type="hidden" name="validado" value="<?= (int)$row['validado_evaluacion'] ? '0' : '1' ?>">
                                <input type="hidden" name="curso_id" value="<?= e((string)$filters['curso_id']) ?>">
                                <input type="hidden" name="q" value="<?= e((string)$filters['q']) ?>">
                                <input type="hidden" name="search_in" value="<?= e((string)($filters['search_in'] ?? 'all')) ?>">
                                <input type="hidden" name="per_page" value="<?= (int)$perPage ?>">
                                <input type="hidden" name="page" value="<?= (int)$page ?>">
                                
                                <button type="submit" class="btn <?= (int)$row['validado_evaluacion'] ? 'btn-success' : 'btn-danger' ?> btn-xs btn-no-icon" 
                                        style="padding: 2px 8px; font-size: 11px; min-width: 80px;">
                                    <?= (int)$row['validado_evaluacion'] ? 'VALIDADO' : 'PENDIENTE' ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <button type="button" class="btn btn-no-icon insc-expand-trigger" data-insc-expand-trigger data-insc-id="<?= (int)$row['id'] ?>" aria-expanded="false">
                                Ver m&aacute;s
                            </button>
                        </td>

                    </tr>
                    <tr class="insc-expand-row" data-insc-expand-row data-insc-id="<?= (int)$row['id'] ?>" hidden>
                        <td colspan="6">
                            <div class="insc-expand-panel">
                                <p><strong>Edad:</strong> <?= (int)$row['edad'] ?> | <strong>G&eacute;nero:</strong> <?= e((string)$row['genero']) ?> | <strong>Correo:</strong> <?= e((string)$row['correo']) ?> | <strong>Tel&eacute;fono:</strong> <?= e((string)$row['telefono']) ?></p>
                                <p><strong>Cargo/Puesto:</strong> <?= e((string)$row['cargo_puesto']) ?> | <strong>Grado:</strong> <?= e((string)$row['grado_estudios']) ?> | <strong>Otro grado:</strong> <?= e((string)$row['grado_otro'] ?: 'Ninguno') ?></p>
                                <p><strong>Colectivos:</strong> <?= e($colectivosTxt) ?></p>
                                <form method="post" action="<?= e(url('/admin/inscripciones/eliminar')) ?>" class="inline-form"
                                      data-confirm-title="Eliminar inscripción"
                                      data-confirm="Se eliminará este participante registrado. ¿Deseas continuar?"
                                      data-confirm-ok="Sí, eliminar"
                                      data-confirm-cancel="Cancelar"
                                      data-confirm-icon="warning"
                                      data-confirm-color="#D8065B"
                                      data-confirm-cancel-color="#111426">
                                    <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <input type="hidden" name="curso_id" value="<?= e((string)$filters['curso_id']) ?>">
                                    <input type="hidden" name="q" value="<?= e((string)$filters['q']) ?>">
                                    <input type="hidden" name="search_in" value="<?= e((string)($filters['search_in'] ?? 'all')) ?>">
                                    <input type="hidden" name="per_page" value="<?= (int)$perPage ?>">
                                    <input type="hidden" name="page" value="<?= (int)$page ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-no-icon">Eliminar participante</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($inscripciones)): ?>
                    <tr><td colspan="5">No hay inscripciones.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($totalPages > 1): ?>
            <div class="page-header between" style="margin-top:16px;">
                <span class="badge info">Página <?= (int)$page ?> de <?= (int)$totalPages ?></span>
                <div class="action-row">
                    <?php if ($page > 1): ?>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl(1)) ?>">Primera</a>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl($page - 1)) ?>">Anterior</a>
                    <?php endif; ?>
                    <?php if ($page < $totalPages): ?>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl($page + 1)) ?>">Siguiente</a>
                        <a class="btn btn-secondary btn-sm btn-no-icon" href="<?= e($buildPageUrl($totalPages)) ?>">Última</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</section>

<script id="inscripcionesDashboardData" type="application/json"><?= $dashboardJson ?: '{}' ?></script>
<script id="inscripcionesExportRows" type="application/json"><?= $exportRowsJson ?: '[]' ?></script>
<script>
    window.inscripcionesDashboardMeta = <?= json_encode([
        'cursoNombre' => $selectedCourseName,
        'filtroBusqueda' => (string)$filters['q'],
        'logoUrl' => asset('/assets/img/logo_tjaech.png'),
        'reportScope' => (string)$filters['curso_id'] !== '' ? 'Curso seleccionado' : 'Todos los cursos',
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;

    (() => {
      const filtersForm = document.getElementById('inscripcionesFiltersForm');
      if (filtersForm) {
        const textInput = filtersForm.querySelector('input[name="q"]');

        filtersForm.querySelectorAll('select').forEach((field) => {
          field.addEventListener('change', () => filtersForm.submit());
        });

        if (textInput) {
          textInput.addEventListener('keydown', (event) => {
            if (event.key !== 'Enter') {
              return;
            }
            event.preventDefault();
            filtersForm.submit();
          });
          textInput.addEventListener('change', () => filtersForm.submit());
        }
      }

      const closeRows = () => {
        document.querySelectorAll('[data-insc-expand-row]').forEach((row) => {
          row.hidden = true;
        });
        document.querySelectorAll('[data-insc-expand-trigger]').forEach((btn) => {
          btn.setAttribute('aria-expanded', 'false');
          btn.textContent = 'Ver más';
        });
      };

      document.querySelectorAll('[data-insc-expand-trigger]').forEach((btn) => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.inscId || '';
          const detailRow = document.querySelector('[data-insc-expand-row][data-insc-id="' + id + '"]');
          const isOpen = detailRow && !detailRow.hidden;
          closeRows();
          if (detailRow && !isOpen) {
            detailRow.hidden = false;
            btn.setAttribute('aria-expanded', 'true');
            btn.textContent = 'Ocultar';
          }
        });
      });
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="<?= e(asset('/assets/js/inscripciones_dashboard.js?v=' . $dashJsVersion)) ?>"></script>
