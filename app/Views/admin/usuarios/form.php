<section class="container">
    <div class="page-header">
        <h2><?= $admin ? 'Editar usuario' : 'Nuevo usuario' ?></h2>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-magenta">
            <?php foreach ($errors as $err): ?>
            <div><?= e($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $admin ? e(url('/admin/usuarios/actualizar')) : e(url('/admin/usuarios/guardar')) ?>" class="form">
        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
        <?php if ($admin): ?>
            <input type="hidden" name="id" value="<?= (int)$admin['id'] ?>">
        <?php endif; ?>

        <label>Nombre*
            <input type="text" name="nombre" required value="<?= e($old['nombre'] ?? ($admin['nombre'] ?? '')) ?>">
        </label>
        <label>Correo*
            <input type="email" name="email" required value="<?= e($old['email'] ?? ($admin['email'] ?? '')) ?>">
        </label>
        <label><?= $admin ? 'Contraseña (dejar en blanco para mantener)' : 'Contraseña*' ?>
            <input type="password" name="password" <?= $admin ? '' : 'required' ?>>
        </label>

        <div class="form-section">
            <strong>Roles*</strong>
            <div class="form-grid">
                <?php
                    $selected = $old['roles'] ?? ($admin['roles'] ?? []);
                    if (!is_array($selected)) {
                        $selected = [];
                    }
                ?>
                <?php foreach ($roles as $key => $label): ?>
                <label class="option">
                    <input type="checkbox" name="roles[]" value="<?= e($key) ?>" <?= in_array($key, $selected, true) ? 'checked' : '' ?>>
                    <?= e($label) ?>
                </label>
                <?php endforeach; ?>
            </div>
        </div>

        <label class="checkbox">
            <input type="checkbox" name="activo" <?= (int)($old['activo'] ?? ($admin['activo'] ?? 1)) === 1 ? 'checked' : '' ?>>
            Usuario activo
        </label>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-secondary" href="<?= e(url('/admin/usuarios')) ?>">Cancelar</a>
        </div>
    </form>
</section>
