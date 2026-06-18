<?php
// Script de limpieza de archivos duplicados
// Ejecutar solo una vez para limpiar duplicados existentes
require_once __DIR__ . '/../app/Core/Env.php';
require_once __DIR__ . '/../app/Core/DB.php';
require_once __DIR__ . '/../app/Models/CursoArchivo.php';

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

try {
    $stmt = DB::conn()->prepare($query);
    $stmt->execute();
    $cursosConDuplicados = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($cursosConDuplicados)) {
        echo "<h2 style='color: green;'>✅ No hay duplicados para limpiar</h2>";
        echo "<p>Todos los archivos adjuntos están en buen estado.</p>";
    } else {
        echo "<h2 style='color: orange;'>🧹 Limpiando archivos duplicados...</h2>";
        echo "<ul>";
        
        $totalLimpiados = 0;
        foreach ($cursosConDuplicados as $cursoId) {
            $limpiados = CursoArchivo::cleanupDuplicates((int)$cursoId);
            $totalLimpiados += $limpiados;
            echo "<li>Curso ID {$cursoId}: Se eliminaron <strong>{$limpiados}</strong> archivo(s) antiguo(s)</li>";
        }
        
        echo "</ul>";
        echo "<h3 style='color: green;'>✅ Proceso completado</h3>";
        echo "<p>Total de archivos eliminados: <strong>{$totalLimpiados}</strong></p>";
        echo "<p style='color: #666; font-size: 12px;'>Se mantuvieron las versiones más recientes de cada archivo.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error:</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
<hr>
<p><a href="/">Volver a inicio</a></p>
