<?php
// app/Controllers/SatisfaccionController.php
class SatisfaccionController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('results');

        $filters = [
            'curso_id' => $_GET['curso_id'] ?? '',
            'desde' => $_GET['desde'] ?? '',
            'hasta' => $_GET['hasta'] ?? ''
        ];

        $rows = EncuestaSatisfaccion::filter($filters);
        $dashboard = EncuestaSatisfaccion::dashboard($rows);
        $cursos = Curso::all();

        $this->render('admin/satisfaccion/index', [
            'rows' => $rows,
            'dashboard' => $dashboard,
            'filters' => $filters,
            'cursos' => $cursos
        ], 'admin');
    }

    public function export(): void {
        AuthMiddleware::requireRole('results');

        $filters = [
            'curso_id' => $_GET['curso_id'] ?? '',
            'desde' => $_GET['desde'] ?? '',
            'hasta' => $_GET['hasta'] ?? ''
        ];
        $rows = EncuestaSatisfaccion::filter($filters);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="encuestas_satisfaccion.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, [
            'Folio', 'Curso', 'Participante',
            'P1 Satisfaccion general', 'P2 Calidad contenidos', 'P3 Organizacion actividades',
            'P4 Utilidad funciones', 'P5 Recomendacion', 'Comentarios', 'Fecha'
        ]);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['folio'],
                $r['curso_nombre'],
                $r['nombre_completo'],
                $r['q1_satisfaccion_general'],
                $r['q2_calidad_contenidos'],
                $r['q3_organizacion_actividades'],
                $r['q4_utilidad_funciones'],
                $r['q5_recomendacion'],
                $r['comentarios'],
                $r['created_at']
            ]);
        }

        fclose($out);
        exit;
    }
}
