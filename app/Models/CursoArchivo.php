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
