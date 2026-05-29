<?php
// app/Views/public/buscar_calificaciones.php
?>
<div style="background: linear-gradient(135deg, #f8fafc 0%, #f0f4f8 100%); padding: 4rem 1.5rem; min-height: 100vh;">
    <div style="max-width: 800px; margin: 0 auto;">
        <!-- Tarjeta principal -->
        <div style="background: white; border-radius: 0.75rem; padding: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.08); border: 1px solid #e2e8f0;">
            
            <!-- Header -->
            <div style="margin-bottom: 2rem; text-align: center;">
                <h1 style="font-size: 2rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                    <span style="font-size: 2.5rem;">📋</span>
                    Consultar calificaciones por participante
                </h1>
                <p style="color: #6b7280; font-size: 0.95rem; margin: 0; font-weight: 500;">
                    Para realizar la consulta de sus resultados deberá ingresar los mismos datos que proporcionó en su registro.
                </p>
            </div>

            <!-- Errores -->
            <?php if (!empty($error)): ?>
                <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.4rem;">
                    <p style="color: #7f1d1d; margin: 0; font-weight: 500;">
                        <span style="font-weight: 700;">❌ Error:</span> <?= e($error) ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.4rem;">
                    <p style="color: #92400e; margin: 0 0 0.5rem 0; font-weight: 600;">Por favor corrija los siguientes errores:</p>
                    <ul style="margin: 0; padding-left: 1.5rem; color: #92400e;">
                        <?php foreach ($errors as $field => $message): ?>
                            <li style="margin-bottom: 0.25rem;"><?= e($message) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form method="POST" action="/participante/obtener-calificaciones" style="margin-bottom: 1.5rem;">
                <input type="hidden" name="_csrf" value="<?= CSRF::token() ?>">

                <!-- Fila 1: Correo y Teléfono -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; align-items: flex-start;">
                    <div>
                        <label for="correo" style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 0.95rem;">Correo electrónico</label>
                        <input 
                            type="email" 
                            id="correo" 
                            name="correo" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.4rem; font-size: 0.95rem; box-sizing: border-box; background: #f9fafb; transition: all 0.2s;"
                            placeholder="ejemplo@correo.com"
                            value="<?= e($old['correo'] ?? '') ?>"
                            onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'; this.style.boxShadow='none';"
                        >
                    </div>

                    <div>
                        <label for="telefono" style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 0.95rem;">Teléfono</label>
                        <input 
                            type="tel" 
                            id="telefono" 
                            name="telefono" 
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.4rem; font-size: 0.95rem; box-sizing: border-box; background: #f9fafb; transition: all 0.2s;"
                            placeholder="Al menos 10 dígitos"
                            value="<?= e($old['telefono'] ?? '') ?>"
                            onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'; this.style.boxShadow='none';"
                        >
                    </div>
                </div>

                <!-- Fila 2: Curso y Estado -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <div>
                        <label for="curso_id" style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 0.95rem;">
                            <span style="margin-right: 0.35rem;">📚</span> Curso <span style="color: #9ca3af; font-weight: 400;">(Opcional)</span>
                        </label>
                        <select id="curso_id" name="curso_id" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.4rem; font-size: 0.95rem; background: #f9fafb; color: #1f2937; transition: all 0.2s; cursor: pointer;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                            <option value="">Todos los cursos</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option 
                                    value="<?= e($curso['id']) ?>"
                                    <?php if((string)($old['curso_id'] ?? '') === (string)$curso['id']) echo 'selected'; ?>
                                >
                                    <?= e($curso['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label for="status" style="display: block; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 0.95rem;">
                            <span style="margin-right: 0.35rem;">✓</span> Estado de evaluación <span style="color: #9ca3af; font-weight: 400;">(Opcional)</span>
                        </label>
                        <select id="status" name="status" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 0.4rem; font-size: 0.95rem; background: #f9fafb; color: #1f2937; transition: all 0.2s; cursor: pointer;"
                            onfocus="this.style.borderColor='#6366f1'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)';"
                            onblur="this.style.borderColor='#d1d5db'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                            <option value="">Todos los estados</option>
                            <option value="aprobado" <?php if(($old['status'] ?? '') === 'aprobado') echo 'selected'; ?>>
                                ✓ Aprobado
                            </option>
                            <option value="reprobado" <?php if(($old['status'] ?? '') === 'reprobado') echo 'selected'; ?>>
                                ✗ No aprobado
                            </option>
                            <option value="pendiente" <?php if(($old['status'] ?? '') === 'pendiente') echo 'selected'; ?>>
                                ⏱ Pendiente
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Información sincronización -->
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                        <span style="font-size: 1rem;">🔄</span>
                        <span>Resultados sincronizados en tiempo real</span>
                    </p>
                </div>

                <!-- Botón -->
                <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #b8a36e 0%, #a8925f 100%); color: white; border: none; border-radius: 0.4rem; font-weight: 600; font-size: 1rem; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 8px rgba(184, 163, 110, 0.3);"
                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(184, 163, 110, 0.4)';"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(184, 163, 110, 0.3)';">
                    🔍 Consultar calificaciones
                </button>
            </form>
        </div>
    </div>
</div>
