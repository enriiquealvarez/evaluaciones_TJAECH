<section class="container results-modern sat-modern">
    <?php
        $dashboardJson = json_encode($dashboard ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $dashJsPath = __DIR__ . '/../../../../public/assets/js/satisfaccion_dashboard.js';
        $dashJsVersion = is_file($dashJsPath) ? (string)filemtime($dashJsPath) : (string)time();
    ?>

    <div class="page-header between">
        <div>
            <h2>Satisfacci&oacute;n de capacitaciones</h2>
            <p>Estad&iacute;sticas y respuestas de la encuesta posterior a evaluaci&oacute;n.</p>
        </div>
    </div>

    <div class="results-kpi-strip">
        <article class="results-kpi-card">
            <div>
                <span>Total de encuestas</span>
                <strong><?= (int)($dashboard['total'] ?? 0) ?></strong>
            </div>
        </article>
        <article class="results-kpi-card">
            <div>
                <span>Promedio de satisfacci&oacute;n (1-4)</span>
                <strong><?= e((string)($dashboard['promedio_satisfaccion'] ?? 0)) ?></strong>
            </div>
        </article>
        <article class="results-kpi-card">
            <div>
                <span>Recomendar&iacute;an el curso</span>
                <strong><?= e((string)($dashboard['porcentaje_recomendacion'] ?? 0)) ?>%</strong>
            </div>
        </article>
        <article class="results-kpi-card">
            <div>
                <span>Con comentarios</span>
                <strong><?= (int)($dashboard['con_comentarios'] ?? 0) ?></strong>
            </div>
        </article>
    </div>

    <form method="get" action="<?= e(url('/admin/satisfaccion')) ?>" class="results-modern-filters">
        <select name="curso_id">
            <option value="">Todos los cursos</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= (int)$curso['id'] ?>" <?= (string)$filters['curso_id'] === (string)$curso['id'] ? 'selected' : '' ?>>
                    <?= e($curso['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="date" name="desde" value="<?= e($filters['desde']) ?>">
        <input type="date" name="hasta" value="<?= e($filters['hasta']) ?>">
        <button class="btn btn-info btn-no-icon" type="submit">Filtrar</button>
        <?php $exportQuery = http_build_query($filters); ?>
        <a class="btn btn-success btn-no-icon" href="<?= e(url('/admin/satisfaccion/exportar?' . $exportQuery)) ?>">Exportar CSV</a>
    </form>

    <div class="results-charts-grid sat-grid-questions">
        <section class="card results-panel">
            <h3>P1. Satisfacci&oacute;n general</h3>
            <div class="results-chart-wrap"><canvas id="satQ1Chart"></canvas></div>
        </section>
        <section class="card results-panel">
            <h3>P5. Recomendaci&oacute;n del curso</h3>
            <div class="results-chart-wrap"><canvas id="satQ5Chart"></canvas></div>
        </section>
    </div>

    <div class="results-charts-grid sat-grid-questions">
        <section class="card results-panel">
            <h3>P2. Calidad y claridad de contenidos</h3>
            <div class="results-chart-wrap"><canvas id="satQ2Chart"></canvas></div>
        </section>
        <section class="card results-panel">
            <h3>P3. Organizaci&oacute;n y desarrollo</h3>
            <div class="results-chart-wrap"><canvas id="satQ3Chart"></canvas></div>
        </section>
        <section class="card results-panel">
            <h3>P4. Utilidad en funciones</h3>
            <div class="results-chart-wrap"><canvas id="satQ4Chart"></canvas></div>
        </section>
    </div>

    <section class="card results-table-panel">
        <table class="table results-table-modern">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Curso</th>
                    <th>Participante</th>
                    <th>P1</th>
                    <th>P5</th>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e((string)$row['created_at']) ?></td>
                    <td><?= e((string)$row['curso_nombre']) ?></td>
                    <td><?= e((string)$row['nombre_completo']) ?></td>
                    <td><?= e((string)$row['q1_satisfaccion_general']) ?></td>
                    <td><?= e((string)$row['q5_recomendacion']) ?></td>
                    <td><?= e(trim((string)$row['comentarios']) !== '' ? (string)$row['comentarios'] : '-') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($rows)): ?>
                <tr><td colspan="6">No hay encuestas de satisfacci&oacute;n.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</section>

<script id="satisfaccionDashboardData" type="application/json"><?= $dashboardJson ?: '{}' ?></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= e(asset('/assets/js/satisfaccion_dashboard.js?v=' . $dashJsVersion)) ?>"></script>
