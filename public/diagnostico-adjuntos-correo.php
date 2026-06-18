<?php
header('Content-Type: text/html; charset=utf-8');

echo "<h2>🔍 Diagnóstico Completo de Adjuntos a Enviar</h2>";
echo "<p>Este script simula exactamente qué archivos se enviarían en el correo de registro</p>";
echo "<hr>";

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
        echo "<h3>Archivos que se ENVIARÍAN en el correo para este curso:</h3>";
        
        $attachments = [];
        
        // 1. Archivo de indicaciones para participantes (siempre se envía)
        echo "<h4>1️⃣ Indicaciones para Participantes (fijo)</h4>";
        $guidePath = __DIR__ . '/assets/docs/indicaciones-participantes-capacitaciones.pdf';
        if (is_file($guidePath)) {
            echo "<p style='color: green;'>✅ <strong>SE ENVIARÁ:</strong></p>";
            echo "<ul>";
            echo "<li><strong>Nombre en correo:</strong> indicaciones-participantes-capacitaciones.pdf</li>";
            echo "<li><strong>Ruta del servidor:</strong> " . htmlspecialchars($guidePath) . "</li>";
            echo "</ul>";
            $attachments[] = [
                'nombre' => 'indicaciones-participantes-capacitaciones.pdf',
                'ruta' => $guidePath
            ];
        } else {
            echo "<p style='color: orange;'>⚠️ <strong>NO SE ENVIARÁ:</strong> Archivo no encontrado en " . htmlspecialchars($guidePath) . "</p>";
        }
        
        echo "<hr>";
        
        // 2. Documento de bases del curso
        echo "<h4>2️⃣ Documento de Bases del Curso</h4>";
        $stmt = $pdo->prepare("SELECT documento_bases FROM cursos WHERE id = ?");
        $stmt->execute([$cursoId]);
        $curso = $stmt->fetch();
        $documentoBases = $curso['documento_bases'] ?? null;
        
        if ($documentoBases) {
            $basesPath = __DIR__ . '/uploads/bases/' . $documentoBases;
            if (is_file($basesPath)) {
                echo "<p style='color: green;'>✅ <strong>SE ENVIARÁ:</strong></p>";
                echo "<ul>";
                echo "<li><strong>Nombre:</strong> " . htmlspecialchars($documentoBases) . "</li>";
                echo "<li><strong>Ruta:</strong> " . htmlspecialchars($basesPath) . "</li>";
                echo "</ul>";
                $attachments[] = [
                    'nombre' => $documentoBases,
                    'ruta' => $basesPath
                ];
            } else {
                echo "<p style='color: red;'>❌ Documento de bases NO EXISTE: " . htmlspecialchars($basesPath) . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠️ No hay documento de bases asignado</p>";
        }
        
        echo "<hr>";
        
        // 3. Archivos adjuntos del curso
        echo "<h4>3️⃣ Archivos Adjuntos del Curso</h4>";
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
        $stmt = $pdo->prepare($query);
        $stmt->execute([$cursoId, $cursoId]);
        $cursoArchivos = $stmt->fetchAll();
        
        if (empty($cursoArchivos)) {
            echo "<p style='color: orange;'>⚠️ No hay archivos adjuntos</p>";
        } else {
            $uploadDir = __DIR__ . '/uploads/adjuntos/';
            foreach ($cursoArchivos as $archivo) {
                $filePath = $uploadDir . $archivo['nombre_servidor'];
                if (is_file($filePath)) {
                    echo "<p style='color: green;'>✅ <strong>SE ENVIARÁ:</strong></p>";
                    echo "<ul>";
                    echo "<li><strong>Nombre en correo:</strong> " . htmlspecialchars($archivo['nombre_original']) . "</li>";
                    echo "<li><strong>Nombre en servidor:</strong> " . htmlspecialchars($archivo['nombre_servidor']) . "</li>";
                    echo "<li><strong>Ruta:</strong> " . htmlspecialchars($filePath) . "</li>";
                    echo "<li><strong>Fecha carga:</strong> " . htmlspecialchars($archivo['created_at']) . "</li>";
                    echo "</ul>";
                    $attachments[] = [
                        'nombre' => $archivo['nombre_original'],
                        'ruta' => $filePath
                    ];
                } else {
                    echo "<p style='color: red;'>❌ ARCHIVO NO EXISTE: " . htmlspecialchars($filePath) . "</p>";
                }
            }
        }
        
        echo "<hr>";
        echo "<h3>📨 Resumen de Adjuntos en el Correo:</h3>";
        echo "<ol>";
        foreach ($attachments as $i => $att) {
            echo "<li>" . htmlspecialchars($att['nombre']) . "</li>";
        }
        echo "</ol>";
        echo "<p><strong>Total de archivos:</strong> " . count($attachments) . "</p>";
        
        if (count($attachments) > 1) {
            echo "<p style='color: #ff9800; background: #fff3cd; padding: 10px; border-radius: 5px;'>";
            echo "⚠️ <strong>NOTA:</strong> Se enviarán múltiples archivos. El usuario verá todos en el correo.";
            echo "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<hr>
<p><a href="/">Volver a inicio</a></p>
