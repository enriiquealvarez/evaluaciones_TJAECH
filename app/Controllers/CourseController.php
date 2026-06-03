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

        $documentoBases = null;
        if (isset($_FILES['documento_bases']) && $_FILES['documento_bases']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['documento_bases']['tmp_name'];
            $fileName = $_FILES['documento_bases']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/bases/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $newFileName = uniqid('bases_') . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $documentoBases = $newFileName;
                }
            }
        }

        Curso::create([
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
            'fecha_fin' => $_POST['fecha_fin'] ?: null,
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'tiene_cupo' => isset($_POST['tiene_cupo']) ? 1 : 0,
            'cupo_maximo' => (int)($_POST['cupo_maximo'] ?? 0),
            'documento_bases' => $documentoBases
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

        $curso = Curso::find($id);
        $documentoBases = $curso['documento_bases'] ?? null;
        
        if (isset($_FILES['documento_bases']) && $_FILES['documento_bases']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['documento_bases']['tmp_name'];
            $fileName = $_FILES['documento_bases']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($fileExtension, ['pdf', 'jpg', 'jpeg'])) {
                $uploadDir = __DIR__ . '/../../public/uploads/bases/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $newFileName = uniqid('bases_') . '.' . $fileExtension;
                $destPath = $uploadDir . $newFileName;
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    if ($documentoBases && is_file($uploadDir . $documentoBases)) {
                        @unlink($uploadDir . $documentoBases);
                    }
                    $documentoBases = $newFileName;
                }
            }
        }

        Curso::update($id, [
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'fecha_inicio' => $_POST['fecha_inicio'] ?: null,
            'fecha_fin' => $_POST['fecha_fin'] ?: null,
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'tiene_cupo' => isset($_POST['tiene_cupo']) ? 1 : 0,
            'cupo_maximo' => (int)($_POST['cupo_maximo'] ?? 0),
            'documento_bases' => $documentoBases
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


