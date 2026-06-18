<?php
// app/Models/CursoArchivo.php
class CursoArchivo {
    private static function ensureSchema(): void {
        static $ready = false;
        if ($ready) {
            return;
        }

        // Create table if it doesn't exist
        DB::conn()->exec("
            CREATE TABLE IF NOT EXISTS curso_archivos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                curso_id INT NOT NULL,
                nombre_original VARCHAR(255) NOT NULL,
                nombre_servidor VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        $ready = true;
    }

    public static function getByCurso(int $cursoId): array {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('SELECT * FROM curso_archivos WHERE curso_id = ? ORDER BY created_at DESC');
        $stmt->execute([$cursoId]);
        return $stmt->fetchAll();
    }

    public static function getLatestByName(int $cursoId, string $nombreOriginal): ?array {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('
            SELECT * FROM curso_archivos 
            WHERE curso_id = ? AND nombre_original = ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ');
        $stmt->execute([$cursoId, $nombreOriginal]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function getLatestUniqueByNombre(int $cursoId): array {
        self::ensureSchema();
        // Get only the most recent version of each unique nombre_original
        $stmt = DB::conn()->prepare('
            SELECT DISTINCT ON (nombre_original) *
            FROM curso_archivos
            WHERE curso_id = ?
            ORDER BY nombre_original, created_at DESC
        ');
        
        try {
            $stmt->execute([$cursoId]);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            // DISTINCT ON is not supported in MySQL, use subquery instead
            $stmt = DB::conn()->prepare('
                SELECT * FROM curso_archivos ca1
                WHERE curso_id = ? AND id = (
                    SELECT id FROM curso_archivos ca2
                    WHERE ca2.curso_id = ca1.curso_id
                    AND ca2.nombre_original = ca1.nombre_original
                    ORDER BY ca2.created_at DESC
                    LIMIT 1
                )
                ORDER BY created_at DESC
            ');
            $stmt->execute([$cursoId]);
            return $stmt->fetchAll();
        }
    }
    public static function cleanupDuplicates(int $cursoId): int {
        self::ensureSchema();
        // Find all duplicates by nombre_original
        $stmt = DB::conn()->prepare('
            SELECT nombre_original, COUNT(*) as total
            FROM curso_archivos
            WHERE curso_id = ?
            GROUP BY nombre_original
            HAVING total > 1
        ');
        $stmt->execute([$cursoId]);
        $duplicates = $stmt->fetchAll();
        
        $deletedCount = 0;
        $uploadDir = __DIR__ . '/../../public/uploads/adjuntos/';
        
        foreach ($duplicates as $dup) {
            // Get all versions of this file, ordered by date (newest first)
            $stmt = DB::conn()->prepare('
                SELECT id, nombre_servidor
                FROM curso_archivos
                WHERE curso_id = ? AND nombre_original = ?
                ORDER BY created_at DESC
            ');
            $stmt->execute([$cursoId, $dup['nombre_original']]);
            $files = $stmt->fetchAll();
            
            // Delete all but the first (latest) one
            for ($i = 1; $i < count($files); $i++) {
                $fileId = (int)$files[$i]['id'];
                $filename = $files[$i]['nombre_servidor'];
                
                // Delete physical file
                $filePath = $uploadDir . $filename;
                if (is_file($filePath)) {
                    @unlink($filePath);
                }
                
                // Delete record
                $deleteStmt = DB::conn()->prepare('DELETE FROM curso_archivos WHERE id = ?');
                $deleteStmt->execute([$fileId]);
                $deletedCount++;
            }
        }
        
        return $deletedCount;
    }
    public static function create(int $cursoId, string $nombreOriginal, string $nombreServidor): int {
        self::ensureSchema();
        $stmt = DB::conn()->prepare(
            'INSERT INTO curso_archivos (curso_id, nombre_original, nombre_servidor, created_at) VALUES (?, ?, ?, NOW())'
        );
        $stmt->execute([$cursoId, $nombreOriginal, $nombreServidor]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function find(int $id): ?array {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('SELECT * FROM curso_archivos WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function delete(int $id): void {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('DELETE FROM curso_archivos WHERE id = ?');
        $stmt->execute([$id]);
    }
}
