<?php
// public/index.php
ob_start();

require __DIR__ . '/../app/Core/Env.php';
Env::load(__DIR__ . '/../.env');

// Log PHP errors to a file (hosting-safe)
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0775, true);
}
ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/php_errors.log');

require __DIR__ . '/../app/Core/Session.php';
Session::start();

require __DIR__ . '/../app/Core/helpers.php';
require __DIR__ . '/../app/Core/DB.php';
require __DIR__ . '/../app/Core/CSRF.php';
require __DIR__ . '/../app/Core/Validator.php';
require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/MunicipiosChiapas.php';
require __DIR__ . '/../app/Core/Mailer.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/Controllers/' . $class . '.php',
        __DIR__ . '/../app/Models/' . $class . '.php',
        __DIR__ . '/../app/Middlewares/' . $class . '.php'
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

set_exception_handler(function ($e) {
    $message = sprintf(
        "[%s] %s in %s:%d\n%s",
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );
    error_log($message);

    if (!headers_sent()) {
        http_response_code(500);
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        echo 'Error interno.';
    }
});

$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$basePath = rtrim(str_replace('/index.php', '', $scriptName), '/');
$router = new Router($basePath);

$home = new HomeController();
$participant = new ParticipantController();
$auth = new AdminAuthController();
$dashboard = new AdminDashboardController();
$course = new CourseController();
$evals = new EvaluationBuilderController();
$results = new ResultsController();
$inscripciones = new InscripcionesController();
$satisfaccion = new SatisfaccionController();
$users = new AdminUsersController();

$router->get('/', fn() => $home->index());
$router->get('/curso/registro', fn() => $participant->showCourseRegistration());
$router->post('/curso/registrar', fn() => $participant->submitCourseRegistration());
$router->get('/participante/registro', fn() => $participant->show());
$router->post('/participante/registrar', fn() => $participant->submit());
$router->get('/participante/satisfaccion', fn() => $participant->showSatisfaction());
$router->post('/participante/satisfaccion', fn() => $participant->submitSatisfaction());
$router->get('/participante/acuse', fn() => $participant->receipt());
$router->get('/participante/verificar', fn() => $participant->checkContact());
$router->get('/participante/buscar-calificaciones', fn() => $participant->searchScores());
$router->post('/participante/obtener-calificaciones', fn() => $participant->getScores());
$router->get('/participante/ver-calificacion', fn() => $participant->showScore());

$router->get('/admin/login', fn() => $auth->showLogin());
$router->post('/admin/login', fn() => $auth->login());
$router->get('/admin/forgot', fn() => $auth->showForgot());
$router->post('/admin/forgot', fn() => $auth->requestCode());
$router->get('/admin/reset', fn() => $auth->showReset());
$router->post('/admin/reset', fn() => $auth->resetPassword());
$router->post('/admin/logout', fn() => $auth->logout());

$router->get('/admin', fn() => $dashboard->index());
$router->get('/admin/limpiar-adjuntos', fn() => $dashboard->cleanupAttachments());
$router->get('/admin/cursos', fn() => $course->index());
$router->get('/admin/cursos/crear', fn() => $course->create());
$router->post('/admin/cursos/guardar', fn() => $course->store());
$router->get('/admin/cursos/editar', fn() => $course->edit());
$router->post('/admin/cursos/actualizar', fn() => $course->update());
$router->post('/admin/cursos/eliminar', fn() => $course->delete());
$router->post('/admin/cursos/terminado', fn() => $course->finish());

$router->get('/admin/evaluaciones', fn() => $evals->index());
$router->get('/admin/evaluaciones/crear', fn() => $evals->create());
$router->post('/admin/evaluaciones/guardar', fn() => $evals->store());
$router->get('/admin/evaluaciones/editar', fn() => $evals->edit());
$router->post('/admin/evaluaciones/actualizar', fn() => $evals->update());
$router->post('/admin/evaluaciones/eliminar', fn() => $evals->delete());

$router->get('/admin/resultados', fn() => $results->index());
$router->get('/admin/resultados/ver', fn() => $results->show());
$router->get('/admin/resultados/detalle-calificacion', fn() => $results->showScoreDetail());
$router->get('/admin/resultados/exportar', fn() => $results->export());
$router->post('/admin/resultados/eliminar', fn() => $results->delete());
$router->get('/admin/resultados/calificaciones', fn() => $results->scoreLookup());
$router->post('/admin/resultados/calificaciones', fn() => $results->runScoreLookup());
$router->get('/admin/inscripciones', fn() => $inscripciones->index());
$router->post('/admin/inscripciones/enviar-correo', fn() => $inscripciones->sendEmails());
$router->post('/admin/inscripciones/eliminar', fn() => $inscripciones->delete());
$router->post('/admin/inscripciones/validar', fn() => $inscripciones->toggleValidation());
$router->post('/admin/inscripciones/validar-masivo', fn() => $inscripciones->bulkValidation());
$router->get('/admin/satisfaccion', fn() => $satisfaccion->index());
$router->get('/admin/satisfaccion/exportar', fn() => $satisfaccion->export());

$router->get('/admin/usuarios', fn() => $users->index());
$router->get('/admin/usuarios/crear', fn() => $users->create());
$router->post('/admin/usuarios/guardar', fn() => $users->store());
$router->get('/admin/usuarios/editar', fn() => $users->edit());
$router->post('/admin/usuarios/actualizar', fn() => $users->update());
$router->post('/admin/usuarios/estado', fn() => $users->toggleStatus());

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
