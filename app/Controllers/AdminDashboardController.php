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
}
