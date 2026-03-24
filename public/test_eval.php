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
    echo "❌ Error de BD: " . $e->getMessage() . "<br>";
}

echo "<h4>Diagnóstico de Webhook (Hacia Constancias):</h4>";
$webhookUrl = getenv('CONSTANCIAS_WEBHOOK_URL');
$webhookSecret = getenv('CONSTANCIAS_WEBHOOK_SECRET');

echo "Webhook URL: " . ($webhookUrl ?: 'NO DEFINIDO ❌') . "<br>";
echo "Webhook Secret: " . ($webhookSecret ? 'Configurado ✅' : 'NO DEFINIDO ❌') . "<br>";

if ($webhookUrl && isset($_GET['trigger_test'])) {
    echo "<h4>Probando Trigger Manual:</h4>";
    $ch = curl_init($webhookUrl);
    $payload = json_encode([
        'participant_name' => 'Prueba Produccion',
        'participant_email' => $_GET['trigger_test'],
        'course_name' => 'Curso de Prueba Webhook',
        'doc_type' => 'Constancia'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $webhookSecret
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "❌ Error de Red/CURL: $error <br>";
    } else {
        echo "Código HTTP: $httpCode <br>";
        echo "Respuesta: <pre>$response</pre><br>";
        if ($httpCode === 200) {
            echo "✅ El webhook respondió correctamente. Revisa el correo de prueba.";
        } else {
            echo "❌ El webhook falló (Posible secreto incorrecto o URL mal configurada).";
        }
    }
} else if ($webhookUrl) {
    echo "<a href='?trigger_test=tu_correo@ejemplo.com' style='padding: 10px; background: #c2410c; color: white; text-decoration: none; border-radius: 5px;'>Probar Trigger de Webhook</a> (Cambia el correo en la URL)<br>";
}
