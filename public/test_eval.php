<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "<h3>Diagnóstico Evaluaciones</h3>";

$dotEnvPath = __DIR__ . '/../.env';
if (!file_exists($dotEnvPath)) {
    echo "❌ Archivo .env NO encontrado en: $dotEnvPath<br>";
    exit;
} else {
    echo "✅ Archivo .env encontrado.<br>";
}

require_once __DIR__ . '/../app/Core/Env.php';
\Env::load($dotEnvPath);

echo "DB_USER: " . (getenv('DB_USER') ?: 'NO DEFINIDO') . "<br>";
echo "DB_NAME: " . (getenv('DB_NAME') ?: 'NO DEFINIDO') . "<br>";

try {
    $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', getenv('DB_HOST'), getenv('DB_NAME'));
    $pdo = new \PDO($dsn, getenv('DB_USER'), getenv('DB_PASS'), [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    echo "✅ Conexión EXITOSA.<br>";
} catch (\Throwable $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}
