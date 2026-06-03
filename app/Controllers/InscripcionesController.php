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

    public function sendEmails(): void {
        AuthMiddleware::requireRole('results');

        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            $this->redirectToIndex();
        }

        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $asunto = trim((string)($_POST['asunto'] ?? ''));
        $mensaje = trim((string)($_POST['mensaje'] ?? ''));

        if ($cursoId <= 0) {
            Session::flash('error', 'Debe seleccionar un curso válido.');
            $this->redirectToIndex();
        }

        if ($asunto === '' || $mensaje === '') {
            Session::flash('error', 'El asunto y el mensaje son obligatorios.');
            $this->redirectToIndex();
        }

        $curso = Curso::find($cursoId);
        if (!$curso) {
            Session::flash('error', 'Curso no encontrado.');
            $this->redirectToIndex();
        }

        // Get participants
        $participants = InscripcionCurso::allWithFilters(['curso_id' => $cursoId]);
        if (empty($participants)) {
            Session::flash('error', 'No hay participantes inscritos en este curso.');
            $this->redirectToIndex();
        }

        $mailer = new Mailer();
        $successCount = 0;
        $failCount = 0;

        foreach ($participants as $p) {
            $toEmail = trim($p['correo'] ?? '');
            $toName = trim($p['nombre_completo'] ?? '');

            if ($toEmail !== '') {
                $htmlBody = nl2br(htmlspecialchars($mensaje));
                
                $html = "<div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                    <div style='background-color: #1b3f66; padding: 20px; color: #ffffff;'>
                        <h2 style='margin: 0; font-size: 18px;'>Aviso Importante: {$curso['nombre']}</h2>
                    </div>
                    <div style='padding: 25px;'>
                        <p style='margin-top: 0;'>Estimado(a) <strong>{$toName}</strong>,</p>
                        <p>{$htmlBody}</p>
                        <hr style='border: 0; border-top: 1px solid #e2e8f0; margin: 25px 0;'>
                        <p style='font-size: 12px; color: #64748b; margin-bottom: 0;'>
                            Este correo fue enviado de manera automática por el sistema de evaluaciones del Tribunal de Justicia Administrativa del Estado de Chiapas. Por favor no responda a esta dirección.
                        </p>
                    </div>
                </div>";
                
                $sent = $mailer->send($toEmail, $toName, $asunto, $html, $mensaje);
                if ($sent) {
                    $successCount++;
                } else {
                    $failCount++;
                }
            }
        }

        if ($failCount === 0) {
            Session::flash('success', "Se enviaron {$successCount} correos con éxito.");
        } else {
            Session::flash('success', "Se enviaron {$successCount} correos con éxito. Fallaron {$failCount} envíos.");
        }

        $this->redirectToIndex();
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

    public function toggleValidation(): void {
        AuthMiddleware::requireRole('results');

        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            $this->redirectToIndex();
        }

        $id = (int)($_POST['id'] ?? 0);
        $valid = (int)($_POST['validado'] ?? 0);

        if ($id > 0) {
            InscripcionCurso::setValidation($id, $valid);
            Session::flash('success', $valid ? 'Participante validado para evaluación.' : 'Validación revocada.');
        }

        $this->redirectToIndex();
    }

    public function bulkValidation(): void {
        AuthMiddleware::requireRole('results');

        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            $this->redirectToIndex();
        }

        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $valid = (int)($_POST['validado'] ?? 0);

        if ($cursoId > 0) {
            $count = InscripcionCurso::setBulkValidation($cursoId, $valid);
            Session::flash('success', "Se han actualizado {$count} participantes.");
        } else {
            Session::flash('error', 'Debe seleccionar un curso para la validación masiva.');
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
