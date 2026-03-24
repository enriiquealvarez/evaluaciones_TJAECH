<section class="container results-modern">
    <?php
        $dashboardJson = json_encode($dashboard ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $dashJsPath = __DIR__ . '/../../../../public/assets/js/resultados_dashboard.js';
        $dashJsVersion = is_file($dashJsPath) ? (string)filemtime($dashJsPath) : (string)time();
    ?>

    <?php if (!empty($flash)): ?>
        <div class="alert alert-green" data-swal="success" data-swal-title="Acción completada"><?= e($flash) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-magenta" data-swal="error" data-swal-title="Atención"><?= e($error) ?></div>
    <?php endif; ?>

    <div class="results-kpi-strip">
        <article class="results-kpi-card">
            <div class="results-kpi-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <path d="M4 6h16v12H4z"></path>
                    <path d="M4 10h16"></path>
                    <path d="M9 14h6"></path>
                </svg>
            </div>
            <div>
                <span>Total de respuestas</span>
                <strong><?= (int)($dashboard['total_respuestas'] ?? 0) ?></strong>
            </div>
        </article>
        <article class="results-kpi-card">
            <div class="results-kpi-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.2"></circle>
                    <path d="M5 20c.8-3.7 3.5-5.8 7-5.8s6.2 2.1 7 5.8"></path>
                </svg>
            </div>
            <div>
                <span>Participantes únicos</span>
                <strong><?= (int)($dashboard['total_participantes'] ?? 0) ?></strong>
            </div>
        </article>
        <article class="results-kpi-card">
            <div class="results-kpi-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <path d="M6 18V10"></path>
                    <path d="M12 18V6"></path>
                    <path d="M18 18V13"></path>
                </svg>
            </div>
            <div>
                <span>Promedio por curso</span>
                <strong><?= e((string)($dashboard['promedio_por_curso'] ?? 0)) ?></strong>
            </div>
        </article>
    </div>

    <form method="get" action="<?= e(url('/admin/resultados')) ?>" class="results-modern-filters">
        <input type="text" name="nombre" placeholder="Nombre participante" value="<?= e($filters['nombre']) ?>">
        <input type="email" name="correo" placeholder="Correo" value="<?= e($filters['correo']) ?>">
        <input type="tel" name="telefono" placeholder="Teléfono" value="<?= e($filters['telefono']) ?>">
        <select name="curso_id">
            <option value="">Todos los cursos</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= (int)$curso['id'] ?>" <?= (string)$filters['curso_id'] === (string)$curso['id'] ? 'selected' : '' ?>>
                    <?= e($curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="status">
            <option value="">Todos los estados</option>
            <option value="aprobado" <?= $filters['status'] === 'aprobado' ? 'selected' : '' ?>>Aprobado</option>
            <option value="reprobado" <?= $filters['status'] === 'reprobado' ? 'selected' : '' ?>>No aprobado</option>
            <option value="pendiente" <?= $filters['status'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
        </select>
        <input type="date" name="desde" value="<?= e($filters['desde']) ?>">
        <input type="date" name="hasta" value="<?= e($filters['hasta']) ?>">
        <button class="btn btn-info btn-no-icon" type="submit">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M3 5h18"></path>
                <path d="M6 12h12"></path>
                <path d="M10 19h4"></path>
            </svg>
            Filtrar
        </button>
        <?php $exportQuery = http_build_query($filters); ?>
        <a class="btn btn-success btn-no-icon" href="<?= e(url('/admin/resultados/exportar?' . $exportQuery)) ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <path d="M12 3v12"></path>
                <path d="M7 10l5 5 5-5"></path>
                <path d="M4 20h16"></path>
            </svg>
            Exportar CSV
        </a>
        <a class="btn btn-info btn-no-icon" href="<?= e(url('/admin/resultados/calificaciones')) ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            Consulta por Resultados
        </a>
    </form>

    <div class="results-charts-grid">
        <section class="card results-panel">
            <h3>Respuestas por curso</h3>
            <div class="results-chart-wrap">
                <canvas id="resultsByCourseChart"></canvas>
            </div>
        </section>
        <section class="card results-panel">
            <h3>Respuestas por día</h3>
            <div class="results-chart-wrap">
                <canvas id="resultsByDayChart"></canvas>
            </div>
        </section>
    </div>

    <div class="results-breakdown-grid">
        <section class="card results-panel">
            <h3>Top instituciones</h3>
            <?php
                $topInstituciones = $dashboard['top_instituciones'] ?? [];
                $maxTop = 0;
                foreach ($topInstituciones as $value) {
                    $maxTop = max($maxTop, (int)$value);
                }
                $maxTop = max(1, $maxTop);
            ?>
            <ul class="results-top-list">
                <?php foreach ($topInstituciones as $label => $total): ?>
                <li>
                    <div class="results-top-meta">
                        <span><?= e((string)$label) ?></span>
                        <strong><?= (int)$total ?></strong>
                    </div>
                    <div class="results-top-bar">
                        <span style="width: <?= (int)round((((int)$total) / $maxTop) * 100) ?>%"></span>
                    </div>
                </li>
                <?php endforeach; ?>
                <?php if (empty($dashboard['top_instituciones'])): ?>
                <li>
                    <div class="results-top-meta">
                        <span>Sin datos</span>
                        <strong>0</strong>
                    </div>
                    <div class="results-top-bar">
                        <span style="width: 0%"></span>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </section>

        <section class="card results-panel">
            <div class="results-activity-head">
                <h3>Actividad del periodo</h3>
                <div class="results-activity-legend">
                    <span><i class="dot teal"></i>Estado</span>
                    <span><i class="dot gold"></i>Estado</span>
                </div>
            </div>
            <form method="get" action="<?= e(url('/admin/resultados')) ?>" class="results-activity-grid results-activity-form" id="resultsActivityForm">
                <div>
                    <label>Desde</label>
                    <input type="date" name="desde" value="<?= e($filters['desde']) ?>">
                </div>
                <div>
                    <label>Hasta</label>
                    <input type="date" name="hasta" value="<?= e($filters['hasta']) ?>">
                </div>
                <div>
                    <label>Curso</label>
                    <select name="curso_id">
                        <option value="">Todos</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?= (int)$curso['id'] ?>" <?= (string)$filters['curso_id'] === (string)$curso['id'] ? 'selected' : '' ?>>
                                <?= e($curso['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </section>
    </div>

    <section class="card results-table-panel">
        <table class="table results-table-modern">
            <thead>
                <tr>
                            <th>Folio</th>
                    <th>Curso</th>
                    <th>Participante</th>
                    <th>Institución</th>
                    <th>Puntuación</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($respuestas as $r): ?>
                <tr>
                    <td><?= e($r['folio']) ?></td>
                    <td><?= e($r['curso_nombre']) ?></td>
                    <td><?= e($r['nombre_completo']) ?></td>
                    <td><?= e($r['municipio']) ?></td>
                        <td>
                        <?php if (isset($r['puntuacion'])): ?>
                            <?= (int)$r['puntuacion'] ?>%
                        <?php else: ?>
                            &ndash;
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($r['estatus'])): ?>
                            <span class="badge <?= $r['estatus'] === 'aprobado' ? 'bg-success' : ($r['estatus'] === 'reprobado' ? 'bg-danger' : 'bg-secondary') ?>">
                                <?= ucfirst(str_replace('_',' ',$r['estatus'])) ?>
                            </span>
                        <?php else: ?>
                            &ndash;
                        <?php endif; ?>
                    </td>
                    <td><?= e($r['created_at']) ?></td>
                    <td>
                        <div class="action-row results-actions">
                            <a class="btn btn-info btn-sm btn-no-icon results-action-btn" href="<?= e(url('/admin/resultados/ver?id=' . (int)$r['id'])) ?>">
                                <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path>
                                </svg>
                                Ver
                            </a>
                            <form method="post" action="<?= e(url('/admin/resultados/eliminar')) ?>" class="inline-form"
                                  data-confirm-title="Eliminar respuesta"
                                  data-confirm="Se eliminarán todas las respuestas del participante. ¿Continuar?"
                                  data-confirm-ok="Sí, eliminar"
                                  data-confirm-cancel="Cancelar"
                                  data-confirm-icon="warning"
                                  data-confirm-color="#D8065B"
                                  data-confirm-cancel-color="#111426">
                                <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm btn-no-icon results-action-btn">
                                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
                                        <path d="M4 7h16"></path>
                                        <path d="M9 7V4h6v3"></path>
                                        <path d="M7 7l1 13h8l1-13"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($respuestas)): ?>
                <tr><td colspan="6">No hay resultados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</section>

<script id="resultsDashboardData" type="application/json"><?= $dashboardJson ?: '{}' ?></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= e(asset('/assets/js/resultados_dashboard.js?v=' . $dashJsVersion)) ?>"></script>
<script>
(() => {
  const form = document.getElementById('resultsActivityForm');
  if (!form) return;
  form.querySelectorAll('input, select').forEach((field) => {
    field.addEventListener('change', () => form.submit());
  });
})();
</script>
