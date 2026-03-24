<?php
// app/Controllers/CourseController.php
class CourseController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('courses');
        $this->render('admin/cursos/index', [
            'cursos' => Curso::all(),
            'flash' => Session::flash('success')
        ], 'admin');
    }

    public function create(): void {
        AuthMiddleware::requireRole('courses');
        $this->render('admin/cursos/form', [
            'curso' => null,
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? []
        ], 'admin');
    }

    public function store(): void {
        AuthMiddleware::requireRole('courses');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $validator = new Validator();
        $validator->required('nombre', $_POST['nombre'] ?? '', 'Nombre obligatorio.');
        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/admin/cursos/crear');
        }
        Curso::create([
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
            'fecha_fin' => $_POST['fecha_fin'] ?: null,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);
        Session::flash('success', 'Curso creado.');
        redirect('/admin/cursos');
    }

    public function edit(): void {
        AuthMiddleware::requireRole('courses');
        $id = (int)($_GET['id'] ?? 0);
        $curso = $id ? Curso::find($id) : null;
        if (!$curso) {
            redirect('/admin/cursos');
        }
        $this->render('admin/cursos/form', [
            'curso' => $curso,
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? []
        ], 'admin');
    }

    public function update(): void {
        AuthMiddleware::requireRole('courses');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $id = (int)($_POST['id'] ?? 0);
        $validator = new Validator();
        $validator->required('nombre', $_POST['nombre'] ?? '', 'Nombre obligatorio.');
        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/admin/cursos/editar?id=' . $id);
        }
        Curso::update($id, [
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
            'fecha_fin' => $_POST['fecha_fin'] ?: null,
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);
        Session::flash('success', 'Curso actualizado.');
        redirect('/admin/cursos');
    }

    public function delete(): void {
        AuthMiddleware::requireRole('courses');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            Curso::delete($id);
        }
        Session::flash('success', 'Curso eliminado.');
        redirect('/admin/cursos');
    }

    public function finish(): void {
        AuthMiddleware::requireRole('courses');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $id = (int)($_POST['id'] ?? 0);
        $terminado = (int)($_POST['terminado'] ?? 0) === 1 ? 1 : 0;
        if ($id > 0) {
            Curso::setFinished($id, $terminado);
            Session::flash('success', $terminado === 1 ? 'Curso marcado como terminado.' : 'Curso reabierto.');
        }
        redirect('/admin/cursos');
    }
}


