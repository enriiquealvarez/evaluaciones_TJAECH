<section class="container">
    <div class="page-header between">
        <div>
            <h2>Evaluaciones - <?= e($curso['nombre']) ?></h2>
            <p>Administre instrumentos de evaluación por curso.</p>
        </div>
        <a class="btn btn-primary" href="<?= e(url('/admin/evaluaciones/crear?curso_id=' . (int)$curso['id'])) ?>">Nueva evaluación</a>
    </div>

    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($evaluaciones as $eval): ?>
                <tr>
                    <td><?= e($eval['titulo']) ?></td>
                    <td><?= (int)$eval['activo'] === 1 ? 'Sí' : 'No' ?></td>
                    <td>
                        <a class="btn btn-secondary" href="<?= e(url('/admin/evaluaciones/editar?id=' . (int)$eval['id'])) ?>">Editar</a>
                        <form method="post" action="<?= e(url('/admin/evaluaciones/eliminar')) ?>" class="inline-form"
                              data-confirm-title="Eliminar evaluación"
                              data-confirm="¿Deseas eliminar esta evaluación?"
                              data-confirm-ok="Sí, eliminar"
                              data-confirm-cancel="Cancelar"
                              data-confirm-icon="warning"
                              data-confirm-color="#D8065B"
                              data-confirm-cancel-color="#111426">
                            <input type="hidden" name="_csrf" value="<?= e(CSRF::token()) ?>">
                            <input type="hidden" name="id" value="<?= (int)$eval['id'] ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($evaluaciones)): ?>
                <tr><td colspan="3">No hay evaluaciones.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a class="btn btn-secondary" href="<?= e(url('/admin/cursos')) ?>">Volver</a>
</section>
