<?php
// app/Controllers/HomeController.php
class HomeController extends BaseController {
    public function index(): void {
        $cursos = Curso::allActive();
        $cursoId = (int)($_GET['curso_id'] ?? 0);
        $singleCourseMode = false;
        if ($cursoId > 0) {
            $singleCourseMode = true;
            $cursos = array_values(array_filter($cursos, static fn(array $c): bool => (int)$c['id'] === $cursoId));
            if (empty($cursos)) {
                Session::flash('error', 'El curso solicitado no está disponible.');
            }
        }

        $this->render('public/home', [
            'cursos' => $cursos,
            'singleCourseMode' => $singleCourseMode,
            'flash' => Session::flash('error')
        ], 'public');
    }
}