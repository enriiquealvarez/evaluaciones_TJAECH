<?php
// Diagnóstico para revisar archivos adjuntos duplicados
require_once __DIR__ . '/../app/Core/Env.php';
require_once __DIR__ . '/../app/Core/DB.php';

// Obtener todos los archivos agrupados por curso y nombre
$query = "
    SELECT 
        curso_id,
        nombre_original,
        COUNT(*) as total,
        GROUP_CONCAT(id ORDER BY created_at DESC) as ids,
        GROUP_CONCAT(nombre_servidor ORDER BY created_at DESC) as servidores,
        GROUP_CONCAT(created_at ORDER BY created_at DESC) as fechas
    FROM curso_archivos
    GROUP BY curso_id, nombre_original
    HAVING total > 1
    ORDER BY curso_id, nombre_original
";

try {
    $stmt = DB::conn()->prepare($query);
    $stmt->execute();
    $duplicados = $stmt->fetchAll();
    
    echo "<h2>Archivos Duplicados en la BD</h2>";
    if (empty($duplicados)) {
        echo "<p style='color: green;'>✅ No hay archivos duplicados en la base de datos.</p>";
    } else {
        echo "<p style='color: red;'>⚠️ Se encontraron archivos duplicados:</p>";
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>Curso ID</th><th>Nombre Original</th><th>Total</th><th>IDs</th><th>Servidores</th><th>Fechas</th></tr>";
        foreach ($duplicados as $dup) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($dup['curso_id']) . "</td>";
            echo "<td>" . htmlspecialchars($dup['nombre_original']) . "</td>";
            echo "<td>" . htmlspecialchars($dup['total']) . "</td>";
            echo "<td>" . htmlspecialchars($dup['ids']) . "</td>";
            echo "<td>" . htmlspecialchars($dup['servidores']) . "</td>";
            echo "<td><small>" . htmlspecialchars($dup['fechas']) . "</small></td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    echo "<hr>";
    echo "<h2>Últimos Cambios de Código</h2>";
    echo "<p>Verificar que ParticipantController.php tenga la lógica de filtrado.</p>";
    echo "<p><a href='https://github.com/enriiquealvarez/evaluaciones_TJAECH/commit/dc4a252'>Ver commit en GitHub</a></p>";
    
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>
