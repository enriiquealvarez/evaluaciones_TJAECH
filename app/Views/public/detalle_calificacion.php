<?php
// app/Views/public/detalle_calificacion.php
$isAdminView = !empty($isAdminView);
$correctas = (int)($respuesta['aciertos'] ?? 0);
$totales = (int)($respuesta['evaluables'] ?? 0);
$incorrectas = $totales - $correctas;
$puntuacion = (int)($respuesta['puntuacion'] ?? 0);
$esAprobado = $puntuacion >= 70;
$success = trim((string)($success ?? ''));
?>

<section style="background: #f8fafc; min-height: 100vh; padding: 2rem 1rem;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <?php if ($success !== ''): ?>
            <div style="margin-bottom: 1rem; padding: 0.9rem 1rem; border-radius: 8px; border: 1px solid #86efac; background: #f0fdf4; color: #166534; font-weight: 600;">
                <?= e($success) ?>
            </div>
        <?php endif; ?>
        
        <!-- Encabezado -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; margin: 0; color: #0f172a;">
                    Detalle de Calificación
                </h1>
                <p style="margin: 0.5rem 0 0; color: #64748b; font-size: 0.9rem;">
                    <span style="color: #94a3b8;">Folio:</span> <strong style="color: #5b6adb; font-family: monospace;"><?= e($respuesta['folio']) ?></strong>
                </p>
            </div>
            <button onclick="window.print()" style="padding: 0.6rem 1rem; background: white; border: 1px solid #ef4444; border-radius: 6px; cursor: pointer; font-weight: 600; color: #b91c1c; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem;" title="Imprimir">
                <svg style="width: 16px; height: 16px; color: #dc2626;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                <span>Imprimir</span>
            </button>
        </div>

        <!-- Información del participante, evaluación y puntuación -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 280px; gap: 1.5rem; margin-bottom: 2rem;">
            
            <!-- Participante -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <svg style="width: 20px; height: 20px; color: #3b82f6;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="3.2"></circle>
                        <path d="M5 20c.8-3.7 3.5-5.8 7-5.8s6.2 2.1 7 5.8"></path>
                    </svg>
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: #0f172a;">Participante</h3>
                </div>
                <ul style="list-style: none; margin: 0; padding: 0; font-size: 0.9rem;">
                    <li style="margin-bottom: 0.75rem;">
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Nombre</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;"><?= e($respuesta['nombre_completo']) ?></div>
                    </li>
                    <li style="margin-bottom: 0.75rem;">
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Correo</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;"><?= e($respuesta['correo']) ?></div>
                    </li>
                    <li>
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Cargo</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;"><?= e($respuesta['cargo_puesto']) ?></div>
                    </li>
                </ul>
            </div>

            <!-- Evaluación -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                    <svg style="width: 20px; height: 20px; color: #f59e0b;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5h16m-16-1l1.5-6h13l1.5 6M8 4h8M6 4h12"></path>
                    </svg>
                    <h3 style="margin: 0; font-size: 1rem; font-weight: 600; color: #0f172a;">Evaluación</h3>
                </div>
                <ul style="list-style: none; margin: 0; padding: 0; font-size: 0.9rem;">
                    <li style="margin-bottom: 0.75rem;">
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Curso</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;"><?= e($respuesta['curso_nombre']) ?></div>
                    </li>
                    <li style="margin-bottom: 0.75rem;">
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Fecha de realización</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;">
                            <?php
                            $meses = ['January' => 'Enero', 'February' => 'Febrero', 'March' => 'Marzo', 'April' => 'Abril', 'May' => 'Mayo', 'June' => 'Junio', 'July' => 'Julio', 'August' => 'Agosto', 'September' => 'Septiembre', 'October' => 'Octubre', 'November' => 'Noviembre', 'December' => 'Diciembre'];
                            echo strtr(date('d \d\e F \d\e Y \a \l\a\s H:i', strtotime($respuesta['created_at'])), $meses);
                            ?>
                        </div>
                    </li>
                    <li>
                        <div style="color: #64748b; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Entidad</div>
                        <div style="color: #0f172a; margin-top: 0.25rem;"><?= e($respuesta['municipio']) ?></div>
                    </li>
                </ul>
            </div>

            <!-- Puntuación circular -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                <div style="position: relative; width: 120px; height: 120px; margin-bottom: 1rem;">
                    <svg style="width: 100%; height: 100%; transform: rotate(-90deg);" viewBox="0 0 100 100">
                        <!-- Círculo de fondo -->
                        <circle cx="50" cy="50" r="45" fill="none" stroke="#e2e8f0" stroke-width="8"></circle>
                        <!-- Círculo de progreso -->
                        <circle 
                            cx="50" cy="50" r="45" fill="none" 
                            stroke="<?= $esAprobado ? '#10b981' : '#ef4444' ?>" 
                            stroke-width="8"
                            stroke-dasharray="<?= ($puntuacion / 100) * 283 ?> 283"
                            stroke-linecap="round"
                        ></circle>
                    </svg>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700; color: #0f172a;">
                            <?= $puntuacion ?>%
                        </div>
                    </div>
                </div>
                <span style="display: inline-block; padding: 0.35rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem;
                    background: <?= $esAprobado ? '#dcfce7' : '#fee2e2' ?>; color: <?= $esAprobado ? '#15803d' : '#dc2626' ?>;">
                    <?= $esAprobado ? '✓ Aprobado' : '✕ No Aprobado' ?>
                </span>
                <p style="margin: 0.5rem 0 0; font-size: 0.75rem; color: #64748b;">
                    Se requiere 70% para aprobar
                </p>
            </div>
        </div>

        <!-- Estadísticas -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                    Total preguntas
                </div>
                <div style="font-size: 2rem; font-weight: 700; color: #0f172a;">
                    <?= $totales ?>
                </div>
            </div>
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: #15803d;">
                    Correctas
                </div>
                <div style="font-size: 2rem; font-weight: 700; color: #15803d;">
                    <?= $correctas ?>
                </div>
            </div>
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; text-align: center;">
                <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 0.5rem; color: #dc2626;">
                    Incorrectas
                </div>
                <div style="font-size: 2rem; font-weight: 700; color: #dc2626;">
                    <?= $incorrectas ?>
                </div>
            </div>
        </div>

        <!-- Respuestas Detalladas -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
            <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0;">
                <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700; color: #0f172a;">
                    Respuestas Detalladas
                </h2>
            </div>

            <div style="padding: 1.5rem;">
                <?php if (empty($respuesta['detalles'])): ?>
                    <div style="text-align: center; padding: 2rem; color: #64748b;">
                        No hay respuestas registradas para esta evaluación.
                    </div>
                <?php else: ?>
                    <div style="space-y: 1rem;">
                        <?php foreach ($respuesta['detalles'] as $idx => $detalle): ?>
                            <?php
                            $esEvaluable = in_array($detalle['pregunta_tipo'], ['opcion', 'si_no'], true);
                            $esCorrecto = (int)($detalle['es_correcta'] ?? 0) === 1;
                            $numeroPregunta = $idx + 1;
                            ?>
                            <div style="margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                                <div style="background: #f8fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                                    <strong style="color: #0f172a;">Pregunta <?= $numeroPregunta ?></strong>
                                    <?php if ($esEvaluable): ?>
                                        <span style="display: inline-block; padding: 0.25rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
                                            background: <?= $esCorrecto ? '#dcfce7' : '#fee2e2' ?>; color: <?= $esCorrecto ? '#15803d' : '#dc2626' ?>;">
                                            <?= $esCorrecto ? '✓ Correcto' : '✕ Incorrecto' ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div style="padding: 1rem;">
                                    <p style="margin: 0 0 1rem 0; font-weight: 500; color: #0f172a;">
                                        <?= e($detalle['pregunta_texto']) ?>
                                    </p>
                                    <div style="margin-bottom: 1rem;">
                                        <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                                            Tu respuesta:
                                        </div>
                                        <div style="padding: 1rem; border-radius: 8px; border-left: 4px solid <?= $esEvaluable && $esCorrecto ? '#10b981' : ($esEvaluable && !$esCorrecto ? '#ef4444' : '#3b82f6') ?>;
                                            background: <?= $esEvaluable && $esCorrecto ? '#ecfdf5' : ($esEvaluable && !$esCorrecto ? '#fef2f2' : '#eff6ff') ?>;">
                                            <?php if ($detalle['pregunta_tipo'] === 'abierta'): ?>
                                                <p style="margin: 0; color: #0f172a; white-space: pre-wrap;">
                                                    <?= nl2br(e($detalle['valor_texto'] ?? 'Sin respuesta')) ?>
                                                </p>
                                            <?php else: ?>
                                                <p style="margin: 0; color: #0f172a; font-weight: 500;">
                                                    <?= e($detalle['opcion_texto'] ?? $detalle['valor_opcion'] ?? 'Sin respuesta') ?>
                                                </p>
                                                <?php if ($esEvaluable && $esCorrecto): ?>
                                                    <p style="margin: 0.5rem 0 0; font-size: 0.85rem; color: #15803d;">
                                                        ✓ Respuesta correcta
                                                    </p>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Acciones finales -->
        <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; padding-bottom: 2rem; flex-wrap: wrap;">
            <a href="<?= $isAdminView ? '/admin/resultados/calificaciones' : '/' ?>" style="padding: 0.6rem 1.2rem; background: white; border: 1px solid #e2e8f0; border-radius: 6px; color: #475569; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                ← <?= $isAdminView ? 'Volver' : 'Volver al inicio' ?>
            </a>
            <?php if (!$isAdminView): ?>
            <a href="/participante/buscar-calificaciones" style="padding: 0.6rem 1.2rem; background: white; border: 1px solid #e2e8f0; border-radius: 6px; color: #475569; text-decoration: none; font-weight: 500; transition: all 0.2s;">
                ↩ Volver a resultados
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 1fr 280px"] {
            grid-template-columns: 1fr !important;
        }
    }
    
    @media print {
        button, a[href] {
            display: none !important;
        }
        section[style*="background: #f8fafc"] {
            background: white !important;
        }
    }
</style>
