<?php
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Diagnóstico de Archivos por Curso</h2>";

// Cargar configuración
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die('<p style="color: red;">❌ .env no encontrado</p>');
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
    
    // Obtener todos los cursos
    $stmt = $pdo->query("SELECT id, nombre FROM cursos ORDER BY nombre");
    $cursos = $stmt->fetchAll();
    
    if (empty($cursos)) {
        echo "<p>No hay cursos.</p>";
        die;
    }
    
    echo "<p><strong>Selecciona un curso:</strong></p>";
    echo "<form method='GET'>";
    echo "<select name='curso_id' onchange='this.form.submit()'>";
    echo "<option value=''>-- Seleccionar --</option>";
    foreach ($cursos as $curso) {
        $selected = ($_GET['curso_id'] ?? '') == $curso['id'] ? 'selected' : '';
        echo "<option value='" . htmlspecialchars($curso['id']) . "' $selected>" . htmlspecialchars($curso['nombre']) . "</option>";
    }
    echo "</select>";
    echo "</form>";
    
    $cursoId = (int)($_GET['curso_id'] ?? 0);
    
    if ($cursoId > 0) {
        echo "<hr>";
        echo "<h3>Archivos del Curso ID: $cursoId</h3>";
        
        // Ver todos los archivos
        $stmt = $pdo->prepare("
            SELECT id, nombre_original, nombre_servidor, created_at
            FROM curso_archivos
            WHERE curso_id = ?
            ORDER BY nombre_original, created_at DESC
        ");
        $stmt->execute([$cursoId]);
        $archivos = $stmt->fetchAll();
        
        if (empty($archivos)) {
            echo "<p>No hay archivos.</p>";
        } else {
            echo "<table border='1' cellpadding='10' style='width: 100%;'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nombre Original</th>";
            echo "<th>Nombre Servidor</th>";
            echo "<th>Fecha</th>";
            echo "<th>¿Es el más reciente?</th>";
            echo "</tr>";
            
            // Agrupar por nombre_original
            $grouped = [];
            foreach ($archivos as $archivo) {
                $name = $archivo['nombre_original'];
                if (!isset($grouped[$name])) {
                    $grouped[$name] = [];
                }
                $grouped[$name][] = $archivo;
            }
            
            foreach ($grouped as $name => $versions) {
                echo "<tr style='background: #f0f0f0;'>";
                echo "<td colspan='5'><strong>" . htmlspecialchars($name) . "</strong> (" . count($versions) . " versión/versiones)</td>";
                echo "</tr>";
                
                foreach ($versions as $i => $archivo) {
                    $isLatest = $i === 0 ? '✅ SÍ' : '❌ NO (ANTIGUO)';
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($archivo['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($archivo['nombre_original']) . "</td>";
                    echo "<td>" . htmlspecialchars($archivo['nombre_servidor']) . "</td>";
                    echo "<td>" . htmlspecialchars($archivo['created_at']) . "</td>";
                    echo "<td>" . $isLatest . "</td>";
                    echo "</tr>";
                }
            }
            
            echo "</table>";
            
            echo "<hr>";
            echo "<h4>Consulta SQL que debería ejecutarse:</h4>";
            echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 5px;'>";
            echo "SELECT ca.* FROM curso_archivos ca\n";
            echo "INNER JOIN (\n";
            echo "    SELECT nombre_original, MAX(created_at) as latest_date\n";
            echo "    FROM curso_archivos\n";
            echo "    WHERE curso_id = $cursoId\n";
            echo "    GROUP BY nombre_original\n";
            echo ") latest ON ca.nombre_original = latest.nombre_original\n";
            echo "AND ca.created_at = latest.latest_date\n";
            echo "AND ca.curso_id = $cursoId\n";
            echo "ORDER BY ca.created_at DESC";
            echo "</pre>";
            
            // Ejecutar la consulta para ver qué devuelve
            echo "<h4>Resultado de la consulta:</h4>";
            $query = "
                SELECT ca.* FROM curso_archivos ca
                INNER JOIN (
                    SELECT nombre_original, MAX(created_at) as latest_date
                    FROM curso_archivos
                    WHERE curso_id = ?
                    GROUP BY nombre_original
                ) latest ON ca.nombre_original = latest.nombre_original
                AND ca.created_at = latest.latest_date
                AND ca.curso_id = ?
                ORDER BY ca.created_at DESC
            ";
            $queryStmt = $pdo->prepare($query);
            $queryStmt->execute([$cursoId, $cursoId]);
            $results = $queryStmt->fetchAll();
            
            if (empty($results)) {
                echo "<p style='color: red;'>❌ La consulta devolvió 0 archivos</p>";
            } else {
                echo "<table border='1' cellpadding='10' style='width: 100%;'>";
                echo "<tr><th>ID</th><th>Nombre Original</th><th>Fecha</th></tr>";
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nombre_original']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<hr>
<p><a href="/">Volver a inicio</a></p>
