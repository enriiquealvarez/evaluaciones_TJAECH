<section class="container">
    <div class="page-header between">
        <div>
            <h2>Gesti&oacute;n de cursos</h2>
            <p>Administre cursos activos e hist&oacute;ricos.</p>
        </div>
        <a class="btn btn-info" href="<?= e(url('/admin/cursos/crear')) ?>">Nuevo curso</a>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert alert-green" data-swal="success" data-swal-title="Curso actualizado"><?= e($flash) ?></div>
    <?php endif; ?>

    <div class="card courses-card-modern">
        <div class="courses-toolbar">
            <div class="courses-search-wrap">
                <input type="text" id="courseSearch" placeholder="Buscar curso" class="courses-search">
            </div>
            <div class="courses-filters">
                <label>Estatus:
                    <select id="statusFilter">
                        <option value="all">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                        <option value="terminado">Terminado</option>
                    </select>
                </label>
                <label>Filtro:
                    <select id="extraFilter">
                        <option value="all">Todos</option>
                        <option value="con_fechas">Con fechas</option>
                        <option value="sin_fechas">Sin fechas</option>
                    </select>
                </label>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table courses-modern-table" id="coursesTable">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fechas</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cursos as $curso): ?>
                    <?php
                        $isTerminado = (int)($curso['terminado'] ?? 0) === 1;
                        $isActivo = (int)$curso['activo'] === 1;
                        $statusKey = $isTerminado ? 'terminado' : ($isActivo ? 'activo' : 'inactivo');
                        $statusLabel = $isTerminado ? 'Terminado' : ($isActivo ? 'Activo' : 'Inactivo');
                        $hasDates = !empty($curso['fecha_inicio']) || !empty($curso['fecha_fin']);
                        $publicaUrl = url('/?curso_id=' . (int)$curso['id']);
                        $registroUrl = url('/curso/registro?curso_id=' . (int)$curso['id']);
                        $evaluacionUrl = url('/participante/registro?curso_id=' . (int)$curso['id']);
                    ?>
                    <tr data-course-row
                        data-course-id="<?= (int)$curso['id'] ?>"
                        data-name="<?= e(mb_strtolower((string)$curso['nombre'])) ?>"
                        data-status="<?= e($statusKey) ?>"
                        data-has-dates="<?= $hasDates ? '1' : '0' ?>">
                        <td><?= e($curso['nombre']) ?></td>
                        <td><?= e(Curso::TIPOS[$curso['tipo'] ?? 'curso'] ?? 'Curso') ?></td>
                        <td><?= e($curso['fecha_inicio'] ?? 'N/D') ?> - <?= e($curso['fecha_fin'] ?? 'N/D') ?></td>
                        <td>
                            <span class="badge <?= $statusKey === 'activo' ? 'success' : ($statusKey === 'terminado' ? 'warning' : 'danger') ?>"><?= e($statusLabel) ?></span>
                        </td>
                        <td>
                            <div class="courses-actions">
                                <a class="btn btn-info" href="<?= e(url('/admin/cursos/editar?id=' . (int)$curso['id'])) ?>">Gestionar</a>
                                <button type="button" class="btn btn-no-icon course-menu-trigger" data-expand-trigger data-course-id="<?= (int)$curso['id'] ?>" aria-expanded="false" title="Más acciones">•••</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="course-expand-row" data-expand-row data-course-id="<?= (int)$curso['id'] ?>" hidden>
                        <td colspan="4">
                            <div class="course-expand-panel">
                                <div class="course-expand-menu">
                                    <a class="course-menu-item with-icon icon-eval" href="<?= e(url('/admin/evaluaciones?curso_id=' . (int)$curso['id'])) ?>">Evaluaciones</a>
                                    <button type="button" class="course-menu-item copy-link with-icon icon-link" data-link="<?= e($publicaUrl) ?>">Copiar URL publica</button>
                                    <button type="button" class="course-menu-item copy-link with-icon icon-link" data-link="<?= e($registroUrl) ?>">Copiar URL de registro</button>
                                    <button type="button" class="course-menu-item copy-link with-icon icon-link" data-link="<?= e($evaluacionUrl) ?>">Copiar URL de evaluacion</button>
                                    <form method="post" action="<?= e(url('/admin/cursos/terminado')) ?>" class="course-menu-form"
                                          data-confirm-title="<?= $isTerminado ? 'Reabrir curso' : 'Marcar curso como terminado' ?>"
                                          data-confirm="<?= $isTerminado ? 'El curso volverá a estar disponible públicamente.' : 'El curso dejará de mostrarse y no aceptará nuevos registros/evaluaciones.' ?>"
                                          data-confirm-ok="<?= $isTerminado ? 'Sí, reabrir' : 'Sí, terminar' ?>"
                                          data-confirm-cancel="Cancelar"
                                          data-confirm-icon="warning"
                                          data-confirm-color="#AC986A"
                                          data-confirm-cancel-color="#111426">
                                        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                        <input type="hidden" name="id" value="<?= (int)$curso['id'] ?>">
                                        <input type="hidden" name="terminado" value="<?= $isTerminado ? 0 : 1 ?>">
                                        <button type="submit" class="course-menu-item with-icon icon-flag"><?= $isTerminado ? 'Reabrir curso' : 'Marcar terminado' ?></button>
                                    </form>
                                    <form method="post" action="<?= e(url('/admin/cursos/eliminar')) ?>" class="course-menu-form"
                                          data-confirm-title="Eliminar curso"
                                          data-confirm="¿Deseas eliminar este curso y sus evaluaciones?"
                                          data-confirm-ok="Sí, eliminar"
                                          data-confirm-cancel="Cancelar"
                                          data-confirm-icon="warning"
                                          data-confirm-color="#D8065B"
                                          data-confirm-cancel-color="#111426">
                                        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                        <input type="hidden" name="id" value="<?= (int)$curso['id'] ?>">
                                        <button type="submit" class="course-menu-item danger with-icon icon-trash">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($cursos)): ?>
                    <tr><td colspan="4">No hay cursos.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
(() => {
  const rows = Array.from(document.querySelectorAll('[data-course-row]'));
  const searchInput = document.getElementById('courseSearch');
  const statusFilter = document.getElementById('statusFilter');
  const extraFilter = document.getElementById('extraFilter');

  const applyFilters = () => {
    const query = (searchInput?.value || '').toLowerCase().trim();
    const status = statusFilter?.value || 'all';
    const extra = extraFilter?.value || 'all';

    rows.forEach(row => {
      const name = row.dataset.name || '';
      const rowStatus = row.dataset.status || '';
      const hasDates = row.dataset.hasDates === '1';

      const matchQuery = !query || name.includes(query);
      const matchStatus = status === 'all' || status === rowStatus;
      const matchExtra = extra === 'all' || (extra === 'con_fechas' ? hasDates : !hasDates);

      const visible = matchQuery && matchStatus && matchExtra;
      row.style.display = visible ? '' : 'none';

      const courseId = row.dataset.courseId || '';
      const expandRow = document.querySelector('[data-expand-row][data-course-id="' + courseId + '"]');
      const trigger = document.querySelector('[data-expand-trigger][data-course-id="' + courseId + '"]');
      if (!visible && expandRow) {
        expandRow.hidden = true;
        row.classList.remove('menu-open');
        if (trigger) trigger.setAttribute('aria-expanded', 'false');
      }
    });
  };

  [searchInput, statusFilter, extraFilter].forEach(el => {
    if (!el) return;
    el.addEventListener('input', applyFilters);
    el.addEventListener('change', applyFilters);
  });

  const closeExpandedRows = () => {
    document.querySelectorAll('[data-expand-row]').forEach(expandRow => {
      expandRow.hidden = true;
    });
    rows.forEach(row => row.classList.remove('menu-open'));
    document.querySelectorAll('[data-expand-trigger]').forEach(button => {
      button.setAttribute('aria-expanded', 'false');
    });
  };

  document.querySelectorAll('[data-expand-trigger]').forEach(trigger => {
    trigger.addEventListener('click', (event) => {
      event.stopPropagation();
      const courseId = trigger.dataset.courseId || '';
      const expandRow = document.querySelector('[data-expand-row][data-course-id="' + courseId + '"]');
      const isOpen = expandRow && !expandRow.hidden;
      closeExpandedRows();
      if (expandRow && !isOpen) {
        const row = trigger.closest('[data-course-row]');
        if (row) row.classList.add('menu-open');
        expandRow.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');
      }
    });
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-expand-trigger]') && !event.target.closest('[data-expand-row]')) {
      closeExpandedRows();
    }
  });

  const fallbackCopy = (text, btn, originalText) => {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    document.body.appendChild(textArea);
    textArea.select();
    try {
      if (document.execCommand('copy')) {
        btn.textContent = 'Copiado';
        setTimeout(() => (btn.textContent = originalText), 1100);
      } else {
        prompt("Copie la URL manualmente (Ctrl+C o Cmd+C):", text);
      }
    } catch (err) {
      prompt("Copie la URL manualmente (Ctrl+C o Cmd+C):", text);
    }
    document.body.removeChild(textArea);
  };

  document.querySelectorAll('.copy-link').forEach(btn => {
    btn.addEventListener('click', () => {
      const link = btn.dataset.link || '';
      if (!link) return;
      const originalText = btn.dataset.originalText || btn.textContent;
      btn.dataset.originalText = originalText;
      if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(link).then(() => {
          btn.textContent = 'Copiado';
          setTimeout(() => (btn.textContent = originalText), 1100);
        }).catch(() => fallbackCopy(link, btn, originalText));
      } else {
        fallbackCopy(link, btn, originalText);
      }
    });
  });
})();
</script>
