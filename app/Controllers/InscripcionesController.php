<?php
// app/Controllers/InscripcionesController.php
class InscripcionesController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('results');

        $perPage = $this->normalizePerPage((int)($_GET['per_page'] ?? 20));
        $page = max(1, (int)($_GET['page'] ?? 1));
        $filters = [
            'curso_id' => $_GET['curso_id'] ?? '',
            'q' => trim((string)($_GET['q'] ?? '')),
            'search_in' => $this->normalizeSearchField((string)($_GET['search_in'] ?? 'all')),
            'per_page' => $perPage,
        ];

        $total = InscripcionCurso::countWithFilters($filters);
        $totalPages = max(1, (int)ceil($total / $perPage));
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $inscripciones = InscripcionCurso::allWithFilters($filters, [
            'page' => $page,
            'per_page' => $perPage,
        ]);
        $dashboardRows = InscripcionCurso::allWithFilters($filters);
        $dashboard = InscripcionCurso::dashboardStats($dashboardRows);
        $cursos = Curso::all();

        $this->render('admin/inscripciones/index', [
            'inscripciones' => $inscripciones,
            'exportRows' => $dashboardRows,
            'dashboard' => $dashboard,
            'cursos' => $cursos,
            'filters' => $filters,
            'pagination' => [
                'page' => $page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages,
            ],
            'flash' => Session::flash('success'),
            'error' => Session::flash('error'),
        ], 'admin');
    }

    public function delete(): void {
        AuthMiddleware::requireRole('results');

        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            $this->redirectToIndex();
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0 && InscripcionCurso::delete($id)) {
            Session::flash('success', 'Participante eliminado de inscripciones.');
        } else {
            Session::flash('error', 'No se pudo eliminar el participante.');
        }

        $this->redirectToIndex();
    }

    private function redirectToIndex(): void {
        $params = [];

        $cursoId = trim((string)($_POST['curso_id'] ?? ''));
        if ($cursoId !== '') {
            $params['curso_id'] = $cursoId;
        }

        $query = trim((string)($_POST['q'] ?? ''));
        if ($query !== '') {
            $params['q'] = $query;
        }

        $searchIn = $this->normalizeSearchField((string)($_POST['search_in'] ?? 'all'));
        if ($searchIn !== 'all') {
            $params['search_in'] = $searchIn;
        }

        $perPage = $this->normalizePerPage((int)($_POST['per_page'] ?? 20));
        $params['per_page'] = $perPage;

        $page = max(1, (int)($_POST['page'] ?? 1));
        if ($page > 1) {
            $params['page'] = $page;
        }

        $path = '/admin/inscripciones';
        if (!empty($params)) {
            $path .= '?' . http_build_query($params);
        }

        redirect($path);
    }

    private function normalizePerPage(int $perPage): int {
        $allowed = [10, 20, 50, 100];
        return in_array($perPage, $allowed, true) ? $perPage : 20;
    }

    private function normalizeSearchField(string $searchIn): string {
        $allowed = ['all', 'nombre', 'correo', 'telefono', 'institucion', 'cargo'];
        return in_array($searchIn, $allowed, true) ? $searchIn : 'all';
    }
}
