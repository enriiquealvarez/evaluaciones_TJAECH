<?php
require_once __DIR__ . '/../app/Core/Env.php';
require_once __DIR__ . '/../app/Core/DB.php';

try {
    $pdo = DB::conn();
    
    // Check if column exists
    $stmt = $pdo->query("SHOW COLUMNS FROM inscripciones_curso LIKE 'validado_evaluacion'");
    if (!$stmt->fetch()) {
        $pdo->exec("ALTER TABLE inscripciones_curso ADD COLUMN validado_evaluacion TINYINT(1) NOT NULL DEFAULT 0 AFTER colectivos_json");
        echo "Column 'validado_evaluacion' added successfully.\n";
    } else {
        echo "Column 'validado_evaluacion' already exists.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
