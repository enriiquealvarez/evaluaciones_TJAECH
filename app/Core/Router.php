<?php
// app/Core/Router.php
class Router {
    private array $routes = [];
    private string $basePath;

    public function __construct(string $basePath = '') {
        $this->basePath = rtrim($basePath, '/');
    }

    public function get(string $path, callable $handler): void {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void {
        $this->map('POST', $path, $handler);
    }

    private function map(string $method, string $path, callable $handler): void {
        $this->routes[$method][$this->basePath . $path] = $handler;
    }

    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH);
        
        // Normalize trailing slash (e.g. /admin/ -> /admin, but keep basePath/)
        $normalizedPath = $path;
        $baseWithSlash = $this->basePath . '/';
        if ($path !== '/' && $path !== $baseWithSlash && str_ends_with($path, '/')) {
            $normalizedPath = rtrim($path, '/');
        }

        $routes = $this->routes[$method] ?? [];
        if (isset($routes[$normalizedPath])) {
            $routes[$normalizedPath]();
            return;
        }
        http_response_code(404);
        echo '404 - Página no encontrada';
    }
}


