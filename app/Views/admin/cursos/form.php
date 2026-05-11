<section class="container">
    <div class="page-header">
        <h2><?= $curso ? 'Editar curso' : 'Nuevo curso' ?></h2>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-magenta">
            <?php foreach ($errors as $err): ?>
            <div><?= e($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $curso ? e(url('/admin/cursos/actualizar')) : e(url('/admin/cursos/guardar')) ?>" class="form">
        <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
        <?php if ($curso): ?>
            <input type="hidden" name="id" value="<?= (int)$curso['id'] ?>">
        <?php endif; ?>
        <label>Nombre*
            <input type="text" name="nombre" required value="<?= e($old['nombre'] ?? ($curso['nombre'] ?? '')) ?>">
        </label>
        <label>Descripción
            <textarea name="descripcion" rows="3"><?= e($old['descripcion'] ?? ($curso['descripcion'] ?? '')) ?></textarea>
        </label>
        <div class="form-grid">
            <label>Fecha inicio
                <input type="date" name="fecha_inicio" value="<?= e($old['fecha_inicio'] ?? ($curso['fecha_inicio'] ?? '')) ?>">
            </label>
            <label>Fecha fin
                <input type="date" name="fecha_fin" value="<?= e($old['fecha_fin'] ?? ($curso['fecha_fin'] ?? '')) ?>">
            </label>
        </div>
        <label class="checkbox">
            <input type="checkbox" name="activo" <?= (int)($old['activo'] ?? ($curso['activo'] ?? 1)) === 1 ? 'checked' : '' ?>>
            Curso activo
        </label>
        
        <label class="checkbox">
            <input type="checkbox" name="tiene_cupo" id="tiene_cupo" <?= (int)($old['tiene_cupo'] ?? ($curso['tiene_cupo'] ?? 0)) === 1 ? 'checked' : '' ?>>
            Limitar número de registros
        </label>
        <label id="cupo_maximo_container" style="<?= (int)($old['tiene_cupo'] ?? ($curso['tiene_cupo'] ?? 0)) === 1 ? '' : 'display: none;' ?>">
            Número máximo de registros
            <input type="number" name="cupo_maximo" min="1" value="<?= e($old['cupo_maximo'] ?? ($curso['cupo_maximo'] ?? '')) ?>">
        </label>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-secondary" href="<?= e(url('/admin/cursos')) ?>">Cancelar</a>
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('tiene_cupo');
    var container = document.getElementById('cupo_maximo_container');
    
    if (checkbox && container) {
        checkbox.addEventListener('change', function() {
            container.style.display = this.checked ? 'block' : 'none';
        });
    }
});
</script>
