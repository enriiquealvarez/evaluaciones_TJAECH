<?php
// app/Controllers/AdminDashboardController.php
class AdminDashboardController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireAdmin();
        $cursos = Curso::all();
        $totalRespuestas = Respuesta::countAll();
        $ultimos = Respuesta::latestWithStatus(5);
        $summary = Respuesta::dashboardSummary(6);
        $courseStatus = Respuesta::statusByCurso();
        $satRows = EncuestaSatisfaccion::filter([]);
        $sat = EncuestaSatisfaccion::dashboard($satRows);
        $this->render('admin/dashboard', [
            'cursos' => $cursos,
            'totalRespuestas' => $totalRespuestas,
            'ultimos' => $ultimos,
            'promedioPuntuacion' => (int)($summary['promedio_puntuacion'] ?? 0),
            'tasaFinalizacion' => (int)($summary['tasa_finalizacion'] ?? 0),
            'actividadMensual' => $summary['actividad_mensual'] ?? [],
            'courseStatus' => $courseStatus,
            'satTotal' => (int)($sat['total'] ?? 0),
            'satPromedio' => (float)($sat['promedio_satisfaccion'] ?? 0),
            'satRecomendacion' => (float)($sat['porcentaje_recomendacion'] ?? 0),
            'satComentarios' => (int)($sat['con_comentarios'] ?? 0),
            'satQ1' => $sat['q1'] ?? []
        ], 'admin');
    }

    public function cleanupAttachments(): void {
        AuthMiddleware::requireAdmin();
        
        // Obtener todos los cursos que tienen archivos duplicados
        $query = "
            SELECT DISTINCT curso_id
            FROM curso_archivos ca
            WHERE (
                SELECT COUNT(*)
                FROM curso_archivos ca2
                WHERE ca2.curso_id = ca.curso_id
                AND ca2.nombre_original = ca.nombre_original
            ) > 1
            GROUP BY curso_id
        ";
        
        $stmt = DB::conn()->prepare($query);
        $stmt->execute();
        $cursosConDuplicados = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $totalLimpiados = 0;
        $uploadDir = __DIR__ . '/../../public/uploads/adjuntos/';
        
        foreach ($cursosConDuplicados as $cursoId) {
            // Encontrar duplicados
            $dupQuery = "
                SELECT nombre_original, COUNT(*) as total
                FROM curso_archivos
                WHERE curso_id = ?
                GROUP BY nombre_original
                HAVING total > 1
            ";
            $dupStmt = DB::conn()->prepare($dupQuery);
            $dupStmt->execute([$cursoId]);
            $duplicates = $dupStmt->fetchAll();
            
            foreach ($duplicates as $dup) {
                // Obtener todas las versiones de este archivo
                $fileQuery = "
                    SELECT id, nombre_servidor
                    FROM curso_archivos
                    WHERE curso_id = ? AND nombre_original = ?
                    ORDER BY created_at DESC
                ";
                $fileStmt = DB::conn()->prepare($fileQuery);
                $fileStmt->execute([$cursoId, $dup['nombre_original']]);
                $files = $fileStmt->fetchAll();
                
                // Eliminar todos excepto el primero (más reciente)
                for ($i = 1; $i < count($files); $i++) {
                    $fileId = (int)$files[$i]['id'];
                    $filename = $files[$i]['nombre_servidor'];
                    
                    // Eliminar archivo físico
                    $filePath = $uploadDir . $filename;
                    if (is_file($filePath)) {
                        @unlink($filePath);
                    }
                    
                    // Eliminar registro de BD
                    $deleteStmt = DB::conn()->prepare('DELETE FROM curso_archivos WHERE id = ?');
                    $deleteStmt->execute([$fileId]);
                    $totalLimpiados++;
                }
            }
        }
        
        Session::flash('success', 'Limpieza completada. Se eliminaron ' . $totalLimpiados . ' archivo(s) duplicado(s).');
        redirect('/admin');
    }
}
