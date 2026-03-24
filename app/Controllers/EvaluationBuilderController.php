<?php
// app/Controllers/EvaluationBuilderController.php
class EvaluationBuilderController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('evaluations');
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso) {
            redirect('/admin/cursos');
        }
        $evaluaciones = Evaluacion::byCurso($cursoId);
        $this->render('admin/evaluaciones/index', [
            'curso' => $curso,
            'evaluaciones' => $evaluaciones
        ], 'admin');
    }

    public function create(): void {
        AuthMiddleware::requireRole('evaluations');
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso) {
            redirect('/admin/cursos');
        }
        $this->render('admin/evaluaciones/form', [
            'curso' => $curso,
            'evaluacion' => null,
            'preguntas' => [],
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? []
        ], 'admin');
    }

    public function edit(): void {
        AuthMiddleware::requireRole('evaluations');
        $id = (int)($_GET['id'] ?? 0);
        $evaluacion = $id ? Evaluacion::find($id) : null;
        if (!$evaluacion) {
            redirect('/admin/cursos');
        }
        $curso = Curso::find((int)$evaluacion['curso_id']);
        $preguntas = Pregunta::byEvaluacion($id);
        $this->render('admin/evaluaciones/form', [
            'curso' => $curso,
            'evaluacion' => $evaluacion,
            'preguntas' => $preguntas,
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? []
        ], 'admin');
    }

    public function store(): void {
        AuthMiddleware::requireRole('evaluations');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $cursoId = (int)($_POST['curso_id'] ?? 0);
        $curso = $cursoId ? Curso::find($cursoId) : null;
        if (!$curso) {
            redirect('/admin/cursos');
        }
        $validator = new Validator();
        $validator->required('titulo', $_POST['titulo'] ?? '', 'Título obligatorio.');
        $questions = $_POST['questions'] ?? [];
        $questionErrors = $this->validateQuestions($questions);
        if ($validator->hasErrors() || !empty($questionErrors)) {
            $errors = array_merge($validator->errors(), $questionErrors);
            Session::flash('errors', $errors);
            Session::flash('old', $_POST);
            redirect('/admin/evaluaciones/crear?curso_id=' . $cursoId);
        }
        $evalId = Evaluacion::create([
            'curso_id' => $cursoId,
            'titulo' => trim($_POST['titulo']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);
        $this->saveQuestions($evalId, $questions);
        redirect('/admin/evaluaciones/editar?id=' . $evalId);
    }

    public function update(): void {
        AuthMiddleware::requireRole('evaluations');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $id = (int)($_POST['id'] ?? 0);
        $evaluacion = $id ? Evaluacion::find($id) : null;
        if (!$evaluacion) {
            redirect('/admin/cursos');
        }
        $validator = new Validator();
        $validator->required('titulo', $_POST['titulo'] ?? '', 'Título obligatorio.');
        $questions = $_POST['questions'] ?? [];
        $questionErrors = $this->validateQuestions($questions);
        if ($validator->hasErrors() || !empty($questionErrors)) {
            $errors = array_merge($validator->errors(), $questionErrors);
            Session::flash('errors', $errors);
            Session::flash('old', $_POST);
            redirect('/admin/evaluaciones/editar?id=' . $id);
        }
        Evaluacion::update($id, [
            'titulo' => trim($_POST['titulo']),
            'descripcion' => trim($_POST['descripcion'] ?? ''),
            'activo' => isset($_POST['activo']) ? 1 : 0
        ]);

        Pregunta::deleteByEvaluacion($id);
        $this->saveQuestions($id, $questions);
        redirect('/admin/evaluaciones/editar?id=' . $id);
    }

    public function delete(): void {
        AuthMiddleware::requireRole('evaluations');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/cursos');
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            Evaluacion::delete($id);
        }
        redirect('/admin/cursos');
    }

    private function saveQuestions(int $evalId, array $questions): void {
        $order = 1;
        foreach ($questions as $question) {
            $texto = trim($question['texto'] ?? '');
            $tipo = $question['tipo'] ?? 'abierta';
            if ($texto === '') {
                continue;
            }
            $preguntaId = Pregunta::create($evalId, [
                'texto' => $texto,
                'tipo' => $tipo,
                'requerido' => isset($question['requerido']) ? 1 : 0,
                'orden' => $order
            ]);
            $order++;
            if (in_array($tipo, ['opcion', 'si_no', 'likert'], true)) {
                $opts = $question['opciones'] ?? [];
                $optOrder = 1;
                foreach ($opts as $opt) {
                    $optText = trim($opt['texto'] ?? '');
                    if ($optText === '') {
                        continue;
                    }
                    $optValue = trim($opt['valor'] ?? '');
                    if ($optValue === '') {
                        $optValue = $optText;
                    }
                    OpcionPregunta::create($preguntaId, [
                        'texto' => $optText,
                        'valor' => $optValue,
                        'es_correcta' => isset($opt['es_correcta']) ? 1 : 0,
                        'orden' => $optOrder
                    ]);
                    $optOrder++;
                }
            }
        }
    }

    private function validateQuestions(array $questions): array {
        $errors = [];
        $qIndex = 0;
        foreach ($questions as $question) {
            $texto = trim($question['texto'] ?? '');
            if ($texto === '') {
                $qIndex++;
                continue;
            }
            $tipo = $question['tipo'] ?? 'abierta';
            if (in_array($tipo, ['opcion', 'si_no', 'likert'], true)) {
                $seen = [];
                $opts = $question['opciones'] ?? [];
                foreach ($opts as $opt) {
                    $optText = trim($opt['texto'] ?? '');
                    if ($optText === '') {
                        continue;
                    }
                    $optValue = trim($opt['valor'] ?? '');
                    if ($optValue === '') {
                        $optValue = $optText;
                    }
                    $key = $this->normalizeOptionValue($optValue);
                    if (isset($seen[$key])) {
                        $errors['question_' . $qIndex] = "La pregunta " . ($qIndex + 1) . " tiene opciones duplicadas (valor: {$optValue}).";
                        break;
                    }
                    $seen[$key] = true;
                }
            }
            $qIndex++;
        }
        return $errors;
    }

    private function normalizeOptionValue(string $value): string {
        $value = mb_strtolower(trim($value));
        if ($value === '') {
            return '';
        }
        if (class_exists('Normalizer')) {
            $value = Normalizer::normalize($value, Normalizer::FORM_D);
        }
        $value = preg_replace('/\p{Mn}+/u', '', $value);
        $value = preg_replace('/[^a-z0-9]+/i', '', $value ?? '');
        if ($value !== '') {
            $value = preg_replace_callback('/\d+/', function ($m) {
                return (string)(int)$m[0];
            }, $value);
        }
        return $value ?? '';
    }
}
