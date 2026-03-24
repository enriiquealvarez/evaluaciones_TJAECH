<section class="container">
    <div class="page-header between users-header-modern">
        <h2>Usuarios</h2>
        <a class="btn btn-primary" href="<?= e(url('/admin/usuarios/crear')) ?>">Nuevo Usuario</a>
    </div>

    <?php if (!empty($flash)): ?>
        <div class="alert alert-green" data-swal="success" data-swal-title="Usuario actualizado"><?= e($flash) ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-magenta" data-swal="error" data-swal-title="Atención"><?= e($error) ?></div>
    <?php endif; ?>

    <?php
        $allRoleLabels = [];
        foreach ($admins as $admin) {
            foreach (($admin['roles'] ?? []) as $roleKey) {
                $allRoleLabels[$roleKey] = $roles[$roleKey] ?? $roleKey;
            }
        }
        asort($allRoleLabels);
    ?>

    <div class="card users-card-modern">
        <div class="users-toolbar">
            <div class="users-search-wrap">
                <input type="text" id="userSearch" class="users-search" placeholder="Buscar usuario o correo">
            </div>
            <div class="users-filters">
                <select id="roleFilter" aria-label="Filtrar por rol">
                    <option value="all">Filtrar por Rol</option>
                    <?php foreach ($allRoleLabels as $roleKey => $roleLabel): ?>
                        <option value="<?= e(mb_strtolower((string)$roleKey)) ?>"><?= e($roleLabel) ?></option>
                    <?php endforeach; ?>
                </select>
                <select id="statusFilter" aria-label="Filtrar por estado">
                    <option value="all">Filtrar por Estado</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>

        <div class="table-responsive users-table-wrap">
            <table class="table users-modern-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Roles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admins)): ?>
                        <tr>
                            <td colspan="5">No hay usuarios registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($admins as $admin): ?>
                            <?php
                                $roleLabels = [];
                                $roleKeys = [];
                                foreach (($admin['roles'] ?? []) as $role) {
                                    $roleLabels[] = $roles[$role] ?? $role;
                                    $roleKeys[] = mb_strtolower((string)$role);
                                }
                                $statusKey = (int)$admin['activo'] === 1 ? 'activo' : 'inactivo';
                            ?>
                            <tr
                                data-user-row
                                data-name="<?= e(mb_strtolower((string)$admin['nombre'])) ?>"
                                data-email="<?= e(mb_strtolower((string)$admin['email'])) ?>"
                                data-roles="<?= e(implode(',', $roleKeys)) ?>"
                                data-status="<?= e($statusKey) ?>"
                                data-user-id="<?= (int)$admin['id'] ?>">
                                <td><?= e($admin['nombre']) ?></td>
                                <td><?= e($admin['email']) ?></td>
                                <td>
                                    <div class="role-chips">
                                        <?php foreach ($roleLabels as $label): ?>
                                            <span class="role-chip"><?= e($label) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ((int)$admin['activo'] === 1): ?>
                                        <span class="badge success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="users-actions">
                                        <a class="btn btn-info btn-sm" href="<?= e(url('/admin/usuarios/editar?id=' . (int)$admin['id'])) ?>">Editar</a>
                                        <button type="button" class="btn btn-no-icon users-menu-trigger" data-user-expand-trigger data-user-id="<?= (int)$admin['id'] ?>" aria-expanded="false" title="Más acciones">•••</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="users-expand-row" data-user-expand-row data-user-id="<?= (int)$admin['id'] ?>" hidden>
                                <td colspan="5">
                                    <div class="users-expand-panel">
                                        <div class="users-expand-menu">
                                            <form method="post" action="<?= e(url('/admin/usuarios/estado')) ?>" class="course-menu-form"
                                                  data-confirm-title="<?= (int)$admin['activo'] === 1 ? 'Desactivar usuario' : 'Activar usuario' ?>"
                                                  data-confirm="<?= (int)$admin['activo'] === 1 ? 'El usuario ya no podrá ingresar al sistema.' : 'El usuario podrá ingresar al sistema.' ?>"
                                                  data-confirm-ok="<?= (int)$admin['activo'] === 1 ? 'Sí, desactivar' : 'Sí, activar' ?>"
                                                  data-confirm-cancel="Cancelar"
                                                  data-confirm-icon="<?= (int)$admin['activo'] === 1 ? 'warning' : 'info' ?>"
                                                  data-confirm-color="<?= (int)$admin['activo'] === 1 ? '#D8065B' : '#009482' ?>"
                                                  data-confirm-cancel-color="#111426">
                                                <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                                                <input type="hidden" name="id" value="<?= (int)$admin['id'] ?>">
                                                <input type="hidden" name="activo" value="<?= (int)$admin['activo'] === 1 ? 0 : 1 ?>">
                                                <button type="submit" class="course-menu-item with-icon <?= (int)$admin['activo'] === 1 ? 'icon-flag danger' : 'icon-flag' ?>"><?= (int)$admin['activo'] === 1 ? 'Desactivar usuario' : 'Activar usuario' ?></button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
(() => {
  const rows = Array.from(document.querySelectorAll('[data-user-row]'));
  const searchInput = document.getElementById('userSearch');
  const roleFilter = document.getElementById('roleFilter');
  const statusFilter = document.getElementById('statusFilter');

  const closeExpandedRows = () => {
    document.querySelectorAll('[data-user-expand-row]').forEach(expandRow => {
      expandRow.hidden = true;
    });
    document.querySelectorAll('[data-user-expand-trigger]').forEach(btn => {
      btn.setAttribute('aria-expanded', 'false');
    });
  };

  const applyFilters = () => {
    const query = (searchInput?.value || '').toLowerCase().trim();
    const role = roleFilter?.value || 'all';
    const status = statusFilter?.value || 'all';

    rows.forEach(row => {
      const name = row.dataset.name || '';
      const email = row.dataset.email || '';
      const roles = (row.dataset.roles || '').split(',').filter(Boolean);
      const rowStatus = row.dataset.status || '';

      const matchQuery = !query || name.includes(query) || email.includes(query);
      const matchRole = role === 'all' || roles.includes(role);
      const matchStatus = status === 'all' || status === rowStatus;
      const visible = matchQuery && matchRole && matchStatus;

      row.style.display = visible ? '' : 'none';

      const userId = row.dataset.userId || '';
      const expandRow = document.querySelector('[data-user-expand-row][data-user-id="' + userId + '"]');
      const trigger = document.querySelector('[data-user-expand-trigger][data-user-id="' + userId + '"]');

      if (expandRow) {
        expandRow.style.display = visible ? '' : 'none';
        if (!visible) expandRow.hidden = true;
      }
      if (trigger && !visible) trigger.setAttribute('aria-expanded', 'false');
    });
  };

  [searchInput, roleFilter, statusFilter].forEach(el => {
    if (!el) return;
    el.addEventListener('input', applyFilters);
    el.addEventListener('change', applyFilters);
  });

  document.querySelectorAll('[data-user-expand-trigger]').forEach(trigger => {
    trigger.addEventListener('click', (event) => {
      event.stopPropagation();
      const userId = trigger.dataset.userId || '';
      const row = document.querySelector('[data-user-expand-row][data-user-id="' + userId + '"]');
      const isOpen = row && !row.hidden;
      closeExpandedRows();
      if (row && !isOpen) {
        row.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');
      }
    });
  });

  document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-user-expand-trigger]') && !event.target.closest('[data-user-expand-row]')) {
      closeExpandedRows();
    }
  });
})();
</script>
