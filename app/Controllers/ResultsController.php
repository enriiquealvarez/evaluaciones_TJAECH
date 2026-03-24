<?php
// app/Controllers/ResultsController.php
class ResultsController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('results');
        $filters = [
            'curso_id' => $_GET['curso_id'] ?? '',
            'desde' => $_GET['desde'] ?? '',
            'hasta' => $_GET['hasta'] ?? '',
            'correo' => mb_strtolower(trim($_GET['correo'] ?? '')),
            'telefono' => preg_replace('/\D+/', '', (string)($_GET['telefono'] ?? '')),
            'nombre' => trim($_GET['nombre'] ?? ''),
            'status' => trim($_GET['status'] ?? '')
        ];
        $respuestas = Respuesta::filterAdmin($filters);
        $cursos = Curso::all();
        $stats = Respuesta::statsByCurso();
        $dashboard = $this->buildDashboard($respuestas, $filters);
        $this->render('admin/resultados/index', [
            'respuestas' => $respuestas,
            'cursos' => $cursos,
            'filters' => $filters,
            'stats' => $stats,
            'dashboard' => $dashboard,
            'flash' => Session::flash('success'),
            'error' => Session::flash('error')
        ], 'admin');
    }

    public function show(): void {
        AuthMiddleware::requireRole('results');
        $id = (int)($_GET['id'] ?? 0);
        $respuesta = $id ? Respuesta::findWithDetails($id) : null;
        if (!$respuesta) {
            redirect('/admin/resultados');
        }
        $this->render('admin/resultados/show', [
            'respuesta' => $respuesta
        ], 'admin');
    }

    public function scoreLookup(): void {
        AuthMiddleware::requireRole('results');
        $this->render('admin/resultados/calificaciones_busqueda', [
            'cursos' => Curso::all(),
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
            'error' => Session::flash('error')
        ], 'admin');
    }

    public function runScoreLookup(): void {
        AuthMiddleware::requireRole('results');

        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token invalido.');
            redirect('/admin/resultados/calificaciones');
        }

        $correo = mb_strtolower(trim($_POST['correo'] ?? ''));
        $telefono = preg_replace('/\D+/', '', (string)($_POST['telefono'] ?? ''));
        $status = trim($_POST['status'] ?? '');
        $cursoId = (int)($_POST['curso_id'] ?? 0);

        $validator = new Validator();

        if ($correo === '' && $telefono === '') {
            $validator->required('contacto', '', 'Ingrese al menos un correo o telefono para buscar.');
        }

        if ($correo !== '') {
            $validator->email('correo', $correo, 'Correo invalido.');
        }

        if ($telefono !== '' && mb_strlen($telefono) < 10) {
            $validator->required('telefono', '', 'El telefono debe contener al menos 10 digitos.');
        }

        if ($status !== '' && !in_array($status, ['aprobado', 'reprobado', 'pendiente'], true)) {
            $validator->required('status', '', 'Seleccione un status valido.');
        }

        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/admin/resultados/calificaciones');
        }

        $resultados = Respuesta::searchByContact($correo, $telefono, $status, $cursoId);

        $this->render('public/resultados_calificaciones', [
            'resultados' => $resultados,
            'cursos' => Curso::all(),
            'filtros' => [
                'correo' => $correo,
                'telefono' => $telefono,
                'status' => $status,
                'curso_id' => $cursoId
            ],
            'isAdminView' => true,
            'searchUrl' => '/admin/resultados/calificaciones',
            'detailRoute' => '/admin/resultados/detalle-calificacion',
            'pageTitle' => 'Calificaciones por contacto',
            'searchLabel' => 'Nueva consulta',
            'emptyReturnLabel' => 'Volver a consultar'
        ], 'admin');
    }

    public function showScoreDetail(): void {
        AuthMiddleware::requireRole('results');
        $id = (int)($_GET['id'] ?? 0);
        $respuesta = $id ? Respuesta::getDetailedScore($id) : null;
        if (!$respuesta) {
            redirect('/admin/resultados/calificaciones');
        }
        $this->render('public/detalle_calificacion', [
            'respuesta' => $respuesta,
            'isAdminView' => true
        ]);
    }

    public function export(): void {
        AuthMiddleware::requireRole('results');
        $filters = [
            'curso_id' => $_GET['curso_id'] ?? '',
            'desde' => $_GET['desde'] ?? '',
            'hasta' => $_GET['hasta'] ?? '',
            'correo' => mb_strtolower(trim($_GET['correo'] ?? '')),
            'telefono' => preg_replace('/\D+/', '', (string)($_GET['telefono'] ?? '')),
            'nombre' => trim($_GET['nombre'] ?? ''),
            'status' => trim($_GET['status'] ?? '')
        ];
        $respuestas = Respuesta::filterAdmin($filters);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="respuestas.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['Folio', 'Curso', 'Nombre', 'Correo', 'Teléfono', 'Institución', 'Cargo', 'Fecha', 'Puntuación', 'Estado']);
        foreach ($respuestas as $r) {
            fputcsv($out, [
                $r['folio'],
                $r['curso_nombre'],
                $r['nombre_completo'],
                $r['correo'],
                $r['telefono'],
                $r['municipio'],
                $r['cargo_puesto'],
                $r['created_at'],
                $r['puntuacion'] ?? '',
                $r['estatus'] ?? ''
            ]);
        }
        fclose($out);
        exit;
    }

    public function delete(): void {
        AuthMiddleware::requireRole('results');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/resultados');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            Respuesta::delete($id);
            Session::flash('success', 'Respuesta eliminada.');
        }
        redirect('/admin/resultados');
    }

    private function buildDashboard(array $respuestas, array $filters): array {
        $porCurso = [];
        $porDia = [];
        $porInstitucion = [];
        $participantes = [];

        foreach ($respuestas as $r) {
            $curso = (string)($r['curso_nombre'] ?? 'Sin curso');
            $porCurso[$curso] = ($porCurso[$curso] ?? 0) + 1;

            $fecha = substr((string)($r['created_at'] ?? ''), 0, 10);
            if ($fecha !== '') {
                $porDia[$fecha] = ($porDia[$fecha] ?? 0) + 1;
            }

            $inst = trim((string)($r['municipio'] ?? ''));
            if ($inst === '') {
                $inst = 'Sin institución';
            }
            $porInstitucion[$inst] = ($porInstitucion[$inst] ?? 0) + 1;

            $correo = mb_strtolower(trim((string)($r['correo'] ?? '')));
            $telefono = preg_replace('/\D+/', '', (string)($r['telefono'] ?? ''));
            $key = $correo . '|' . $telefono;
            if ($key === '|') {
                $key = 'folio:' . (string)($r['folio'] ?? '');
            }
            $participantes[$key] = true;
        }

        ksort($porDia);
        arsort($porInstitucion);
        $topInstituciones = array_slice($porInstitucion, 0, 8, true);

        $selectedCourseName = 'Todos los cursos';
        if (!empty($filters['curso_id'])) {
            foreach (Curso::all() as $c) {
                if ((string)$c['id'] === (string)$filters['curso_id']) {
                    $selectedCourseName = (string)$c['nombre'];
                    break;
                }
            }
        }

        return [
            'total_respuestas' => count($respuestas),
            'total_participantes' => count($participantes),
            'total_cursos_con_respuestas' => count($porCurso),
            'promedio_por_curso' => count($porCurso) > 0 ? round(count($respuestas) / count($porCurso), 1) : 0,
            'curso_seleccionado' => $selectedCourseName,
            'por_curso' => $porCurso,
            'por_dia' => $porDia,
            'top_instituciones' => $topInstituciones,
        ];
    }
}
