<?php
// Script de limpieza de archivos duplicados
// Ejecutar solo una vez para limpiar duplicados existentes

// Inicializar como HTML
header('Content-Type: text/html; charset=utf-8');

// Cargar configuración
$envFile = __DIR__ . '/../.env';
if (!file_exists($envFile)) {
    die('<h2 style="color: red;">❌ Error:</h2><p>Archivo .env no encontrado</p>');
}

$env = [];
$lines = file($envFile);
foreach ($lines as $line) {
    $line = trim($line);
    if (!$line || strpos($line, '#') === 0) continue;
    if (strpos($line, '=') !== false) {
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}

$dbHost = $env['DB_HOST'] ?? '127.0.0.1';
$dbName = $env['DB_NAME'] ?? 'tjaech_eval';
$dbUser = $env['DB_USER'] ?? 'root';
$dbPass = $env['DB_PASS'] ?? '';

try {
    // Conectar a la BD
    $dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Obtener todos los cursos que tienen archivos duplicados
    $query = "
        SELECT DISTINCT curso_id
        FROM curso_archivos ca
        WHERE (
            SELECT COUNT(*)
            FROM curso_archivos ca2
            WHERE ca2.curso_id = ca.curso_id
            AND ca2.nombre_original = ca.nombre_original
        ) > 1
        GROUP BY curso_id
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $cursosConDuplicados = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($cursosConDuplicados)) {
        echo "<h2 style='color: green;'>✅ No hay duplicados para limpiar</h2>";
        echo "<p>Todos los archivos adjuntos están en buen estado.</p>";
    } else {
        echo "<h2 style='color: orange;'>🧹 Limpiando archivos duplicados...</h2>";
        echo "<ul>";
        
        $uploadDir = __DIR__ . '/uploads/adjuntos/';
        $totalLimpiados = 0;
        
        foreach ($cursosConDuplicados as $cursoId) {
            // Encontrar duplicados
            $dupQuery = "
                SELECT nombre_original, COUNT(*) as total
                FROM curso_archivos
                WHERE curso_id = ?
                GROUP BY nombre_original
                HAVING total > 1
            ";
            $dupStmt = $pdo->prepare($dupQuery);
            $dupStmt->execute([$cursoId]);
            $duplicates = $dupStmt->fetchAll();
            
            $cursoLimpiados = 0;
            foreach ($duplicates as $dup) {
                // Obtener todas las versiones de este archivo
                $fileQuery = "
                    SELECT id, nombre_servidor
                    FROM curso_archivos
                    WHERE curso_id = ? AND nombre_original = ?
                    ORDER BY created_at DESC
                ";
                $fileStmt = $pdo->prepare($fileQuery);
                $fileStmt->execute([$cursoId, $dup['nombre_original']]);
                $files = $fileStmt->fetchAll();
                
                // Eliminar todos excepto el primero (más reciente)
                for ($i = 1; $i < count($files); $i++) {
                    $fileId = (int)$files[$i]['id'];
                    $filename = $files[$i]['nombre_servidor'];
                    
                    // Eliminar archivo físico
                    $filePath = $uploadDir . $filename;
                    if (is_file($filePath)) {
                        @unlink($filePath);
                    }
                    
                    // Eliminar registro de BD
                    $deleteStmt = $pdo->prepare('DELETE FROM curso_archivos WHERE id = ?');
                    $deleteStmt->execute([$fileId]);
                    $cursoLimpiados++;
                }
            }
            
            if ($cursoLimpiados > 0) {
                echo "<li>Curso ID {$cursoId}: Se eliminaron <strong>{$cursoLimpiados}</strong> archivo(s) antiguo(s)</li>";
                $totalLimpiados += $cursoLimpiados;
            }
        }
        
        echo "</ul>";
        echo "<h3 style='color: green;'>✅ Proceso completado</h3>";
        echo "<p>Total de archivos eliminados: <strong>{$totalLimpiados}</strong></p>";
        echo "<p style='color: #666; font-size: 12px;'>Se mantuvieron las versiones más recientes de cada archivo.</p>";
    }
    
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Error de conexión a la base de datos:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p style='font-size: 12px;'><strong>Datos de conexión:</strong><br>";
    echo "Host: " . htmlspecialchars($dbHost) . "<br>";
    echo "Base de datos: " . htmlspecialchars($dbName) . "<br>";
    echo "Usuario: " . htmlspecialchars($dbUser) . "<br>";
    echo "</p>";
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<hr>
<p><a href="/">Volver a inicio</a></p>
