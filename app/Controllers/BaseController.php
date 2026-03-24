<?php
// app/Controllers/BaseController.php
class BaseController {
    protected function render(string $view, array $data = [], string $layout = 'public'): void {
        extract($data);
        $currentView = $view;
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/layouts/' . $layout . '.php';
        if (!file_exists($viewPath)) {
            throw new RuntimeException('Vista no encontrada.');
        }
        include $layoutPath;
    }
}


