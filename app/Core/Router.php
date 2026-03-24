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
        $routes = $this->routes[$method] ?? [];
        if (isset($routes[$path])) {
            $routes[$path]();
            return;
        }
        http_response_code(404);
        echo '404 - Página no encontrada';
    }
}


