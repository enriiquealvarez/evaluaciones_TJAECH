<?php
// app/Views/public/resultados_calificaciones.php
$isAdminView = !empty($isAdminView);
$searchUrl = (string)($searchUrl ?? '/participante/buscar-calificaciones');
$detailRoute = (string)($detailRoute ?? '/participante/ver-calificacion');
$printRoute = (string)($printRoute ?? $detailRoute);
$pageTitle = (string)($pageTitle ?? 'Resultados de busqueda');
$searchLabel = (string)($searchLabel ?? 'Nueva busqueda');
$emptyReturnLabel = (string)($emptyReturnLabel ?? 'Volver a buscar');
$totalEval = count($resultados);
$aprobadas = count(array_filter($resultados, fn($r) => $r['estatus'] === 'aprobado'));
$reprobadas = count(array_filter($resultados, fn($r) => $r['estatus'] === 'reprobado'));
?>

<section class="container results-modern" style="padding: 2rem 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; margin: 0 0 0.5rem 0; color: #0f172a;">
                <?= e($pageTitle) ?>
            </h1>
            <div style="display: flex; align-items: center; gap: 0.8rem; color: #64748b; font-size: 0.9rem; flex-wrap: wrap;">
                <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 5h18"></path>
                    <path d="M6 12h12"></path>
                    <path d="M10 19h4"></path>
                </svg>
                <span style="font-weight: 500;">Filtros aplicados:</span>
                <?php
                $filtrosAplicados = [];
                if (!empty($filtros['correo'])) {
                    $filtrosAplicados[] = "Correo: " . e($filtros['correo']);
                }
                if (!empty($filtros['telefono'])) {
                    $filtrosAplicados[] = "Telefono: " . e($filtros['telefono']);
                }
                if (!empty($filtros['curso_id'])) {
                    foreach ($cursos as $c) {
                        if ((string)$c['id'] === (string)$filtros['curso_id']) {
                            $filtrosAplicados[] = "Curso: " . e($c['nombre']);
                            break;
                        }
                    }
                }
                if (!empty($filtros['status'])) {
                    $statusLabels = ['aprobado' => 'Aprobado', 'reprobado' => 'No aprobado', 'pendiente' => 'Pendiente'];
                    $filtrosAplicados[] = "Estado: " . ($statusLabels[$filtros['status']] ?? $filtros['status']);
                }
                echo !empty($filtrosAplicados) ? implode(', ', $filtrosAplicados) : 'Ninguno';
                ?>
            </div>
        </div>
        <a href="<?= e(url($searchUrl)) ?>" class="btn btn-primary" style="padding: 0.6rem 1.2rem; font-size: 0.9rem;">
            <svg style="width: 16px; height: 16px; margin-right: 0.5rem; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <?= e($searchLabel) ?>
        </a>
    </div>

    <?php if (empty($resultados)): ?>
        <div style="text-align: center; padding: 3rem 1rem; background: #f8fafc; border-radius: 12px; margin-top: 2rem;">
            <svg style="width: 64px; height: 64px; margin: 0 auto 1rem; color: #cbd5e1;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <h3 style="font-size: 1.5rem; margin: 0 0 0.5rem 0; color: #0f172a;">No se encontraron resultados</h3>
            <p style="color: #64748b; margin: 0 0 1.5rem 0;">No hay calificaciones que coincidan con su busqueda. Intente con diferentes datos de contacto.</p>
            <a href="<?= e(url($searchUrl)) ?>" class="btn btn-primary">
                <svg style="width: 16px; height: 16px; margin-right: 0.5rem; vertical-align: middle;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5"></path>
                    <path d="M12 19l-7-7 7-7"></path>
                </svg>
                <?= e($emptyReturnLabel) ?>
            </a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.2rem; margin-bottom: 2rem;">
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; background: #ede9fe; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #7c3aed; font-size: 1.4rem;">
                    #
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">
                        Total de evaluaciones
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #0f172a; line-height: 1;">
                        <?= $totalEval ?>
                    </div>
                </div>
            </div>

            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #15803d; font-size: 1.4rem;">
                    +
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">
                        Aprobadas
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #15803d; line-height: 1;">
                        <?= $aprobadas ?>
                    </div>
                </div>
            </div>

            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
                <div style="width: 48px; height: 48px; background: #fee2e2; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #dc2626; font-size: 1.4rem;">
                    -
                </div>
                <div>
                    <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;">
                        No aprobadas
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #dc2626; line-height: 1;">
                        <?= $reprobadas ?>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Folio</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Curso</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Nombre</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Puntuacion</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Estado</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Fecha</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: #475569; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $resultado): ?>
                            <tr style="border-bottom: 1px solid #e2e8f0; transition: background 0.2s;">
                                <td style="padding: 1rem; font-weight: 500; color: #5b6adb; font-family: monospace;"><?= e($resultado['folio'] ?? 'N/A') ?></td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.85rem;"><?= e($resultado['curso_nombre'] ?? 'N/A') ?></td>
                                <td style="padding: 1rem; color: #0f172a; font-weight: 500;"><?= e($resultado['nombre_completo'] ?? 'N/A') ?></td>
                                <td style="padding: 1rem; font-weight: 600; color: #0f172a;"><?= (int)($resultado['puntuacion'] ?? 0) ?>%</td>
                                <td style="padding: 1rem;">
                                    <span style="display: inline-block; padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;
                                        <?php if (($resultado['estatus'] ?? '') === 'aprobado'): ?>
                                            background: #dcfce7; color: #15803d;
                                        <?php elseif (($resultado['estatus'] ?? '') === 'reprobado'): ?>
                                            background: #fee2e2; color: #dc2626;
                                        <?php else: ?>
                                            background: #f1f5f9; color: #64748b;
                                        <?php endif; ?>
                                    ">
                                        <?= e($resultado['etiqueta_estatus'] ?? 'Pendiente') ?>
                                    </span>
                                </td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.85rem;">
                                    <?= date('d/m/Y H:i', strtotime((string)$resultado['created_at'])) ?>
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a href="<?= e(url($detailRoute . '?id=' . (int)$resultado['id'])) ?>"
                                           style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; background: #f1f5f9; color: #3b82f6; text-decoration: none; transition: all 0.2s;"
                                           title="Ver detalle">
                                            <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="3"></circle>
                                                <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path>
                                            </svg>
                                        </a>
                                        <?php if ($isAdminView): ?>
                                            <?php $adminPrintUrl = url($printRoute . '?id=' . (int)$resultado['id']); ?>
                                            <a href="#"
                                               onclick="return triggerInlinePrint('<?= e($adminPrintUrl) ?>');"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 6px; background: #f1f5f9; color: #8b5cf6; text-decoration: none; transition: all 0.2s;"
                                               title="Imprimir">
                                                <svg style="width: 16px; height: 16px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                                    <rect x="6" y="14" width="12" height="8"></rect>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="padding: 1rem; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 0.85rem; text-align: center;">
                Mostrando <?= count($resultados) ?> de <?= count($resultados) ?> registros
            </div>
        </div>
    <?php endif; ?>
</section>

<?php if ($isAdminView): ?>
<script>
function triggerInlinePrint(url) {
  var frame = document.getElementById('admin-print-frame');
  if (!frame) {
    frame = document.createElement('iframe');
    frame.id = 'admin-print-frame';
    frame.style.position = 'fixed';
    frame.style.right = '0';
    frame.style.bottom = '0';
    frame.style.width = '0';
    frame.style.height = '0';
    frame.style.border = '0';
    frame.style.opacity = '0';
    frame.setAttribute('aria-hidden', 'true');
    document.body.appendChild(frame);
  }

  var printUrl = url + (url.indexOf('?') === -1 ? '?' : '&') + '_print_ts=' + Date.now();
  frame.onload = function () {
    setTimeout(function () {
      try {
        frame.contentWindow.focus();
        frame.contentWindow.print();
      } catch (e) {}
    }, 450);
  };
  frame.src = printUrl;
  return false;
}
</script>
<?php endif; ?>
