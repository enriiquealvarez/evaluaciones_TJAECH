<?php
header('Content-Type: text/html; charset=utf-8');

// Diagnóstico completo del estado del sistema

echo "<h2>🔍 Diagnóstico de Corrección de Adjuntos</h2>";
echo "<hr>";

// 1. Verificar versión del código
echo "<h3>1️⃣ Versión del Código (CursoArchivo.php)</h3>";
$cursoArchivoPath = __DIR__ . '/../app/Models/CursoArchivo.php';
if (file_exists($cursoArchivoPath)) {
    $content = file_get_contents($cursoArchivoPath);
    if (strpos($content, 'ORDER BY created_at DESC') !== false) {
        echo "<p style='color: green;'>✅ <strong>CORRECTO:</strong> El código tiene ORDER BY DESC (versión actualizada)</p>";
    } else if (strpos($content, 'ORDER BY created_at ASC') !== false) {
        echo "<p style='color: red;'>❌ <strong>PROBLEMA:</strong> El código aún tiene ORDER BY ASC (versión vieja)</p>";
        echo "<p><strong>Solución:</strong> Ejecuta <code>git pull origin main</code> en el hosting</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Archivo no encontrado</p>";
}

echo "<hr>";

// 2. Verificar ParticipantController
echo "<h3>2️⃣ Filtrado de Archivos Duplicados</h3>";
$participantPath = __DIR__ . '/../app/Controllers/ParticipantController.php';
if (file_exists($participantPath)) {
    $content = file_get_contents($participantPath);
    if (strpos($content, '$addedFiles = []') !== false) {
        echo "<p style='color: green;'>✅ <strong>CORRECTO:</strong> El filtro de duplicados está presente</p>";
    } else {
        echo "<p style='color: red;'>❌ <strong>PROBLEMA:</strong> Falta el código de filtrado</p>";
        echo "<p><strong>Solución:</strong> Ejecuta <code>git pull origin main</code> en el hosting</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Archivo no encontrado</p>";
}

echo "<hr>";

// 3. Conectar a BD y ver archivos duplicados
echo "<h3>3️⃣ Estado de la Base de Datos</h3>";

$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    echo "<p style='color: red;'>❌ .env no encontrado</p>";
    die;
}

$env = [];
foreach (file($envFile) as $line) {
    $line = trim($line);
    if (!$line || strpos($line, '#') === 0) continue;
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value, '"');
    }
}

try {
    $dsn = "mysql:host=" . ($env['DB_HOST'] ?? '127.0.0.1') . ";dbname=" . ($env['DB_NAME'] ?? 'tjaech_eval') . ";charset=utf8mb4";
    $pdo = new PDO($dsn, $env['DB_USER'] ?? 'root', $env['DB_PASS'] ?? '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Contar archivos duplicados
    $query = "
        SELECT COUNT(*) as total
        FROM (
            SELECT nombre_original, COUNT(*) as cnt
            FROM curso_archivos
            GROUP BY nombre_original
            HAVING cnt > 1
        ) duplicados
    ";
    $stmt = $pdo->query($query);
    $result = $stmt->fetch();
    $totalDuplicados = (int)($result['total'] ?? 0);
    
    if ($totalDuplicados === 0) {
        echo "<p style='color: green;'>✅ <strong>BIEN:</strong> No hay archivos duplicados en BD</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ <strong>DUPLICADOS ENCONTRADOS:</strong> {$totalDuplicados} archivo(s) con versiones múltiples</p>";
        echo "<p><strong>Solución:</strong> Haz clic en el botón <strong>🧹 Limpiar adjuntos</strong> desde el Dashboard de Admin</p>";
        
        // Mostrar detalle
        $detailQuery = "
            SELECT 
                nombre_original,
                COUNT(*) as total
            FROM curso_archivos
            GROUP BY nombre_original
            HAVING total > 1
            ORDER BY total DESC
        ";
        $detailStmt = $pdo->query($detailQuery);
        $duplicates = $detailStmt->fetchAll();
        
        echo "<table border='1' cellpadding='8' style='margin-top: 10px;'>";
        echo "<tr><th>Nombre del Archivo</th><th>Versiones</th></tr>";
        foreach ($duplicates as $dup) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($dup['nombre_original']) . "</td>";
            echo "<td>" . htmlspecialchars($dup['total']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Contar inscripciones recientes
    echo "<br><h4>Estadísticas Recientes</h4>";
    $inscQuery = "SELECT COUNT(*) as total FROM inscripcion_curso WHERE created_at > DATE_SUB(NOW(), INTERVAL 7 DAY)";
    $inscStmt = $pdo->query($inscQuery);
    $inscResult = $inscStmt->fetch();
    echo "<p>Inscripciones últimos 7 días: <strong>" . (int)($inscResult['total'] ?? 0) . "</strong></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error de BD: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h3>📋 Resumen de Pasos</h3>";
echo "<ol>";
echo "<li><strong>En el hosting (vía SSH):</strong> Ejecuta <code>git pull origin main</code></li>";
echo "<li><strong>En Admin Panel:</strong> Haz clic en <strong>🧹 Limpiar adjuntos</strong></li>";
echo "<li><strong>Prueba:</strong> Registra un nuevo participante y verifica el correo</li>";
echo "<li><strong>Si aún falla:</strong> Verifica esta página nuevamente</li>";
echo "</ol>";
?>
<hr>
<p><a href="/">Volver a inicio</a></p>
