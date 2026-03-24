<?php
// app/Models/Curso.php
class Curso {
    private static function ensureSchema(): void {
        static $ready = false;
        if ($ready) {
            return;
        }

        $col = DB::conn()->query("SHOW COLUMNS FROM cursos LIKE 'terminado'")->fetch();
        if (!$col) {
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN terminado TINYINT(1) NOT NULL DEFAULT 0 AFTER activo");
        }

        $ready = true;
    }

    public static function allActive(): array {
        self::ensureSchema();
        $stmt = DB::conn()->query('SELECT * FROM cursos WHERE activo = 1 AND terminado = 0 ORDER BY fecha_inicio DESC');
        return $stmt->fetchAll();
    }

    public static function all(): array {
        self::ensureSchema();
        $stmt = DB::conn()->query('SELECT * FROM cursos ORDER BY fecha_inicio DESC');
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('SELECT * FROM cursos WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $curso = $stmt->fetch();
        return $curso ?: null;
    }

    public static function create(array $data): int {
        self::ensureSchema();
        $stmt = DB::conn()->prepare(
            'INSERT INTO cursos (nombre, descripcion, fecha_inicio, fecha_fin, activo, terminado, created_at) VALUES (?,?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['activo'],
            0
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        self::ensureSchema();
        $stmt = DB::conn()->prepare(
            'UPDATE cursos SET nombre=?, descripcion=?, fecha_inicio=?, fecha_fin=?, activo=? WHERE id=?'
        );
        $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['activo'],
            $id
        ]);
    }

    public static function delete(int $id): void {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('DELETE FROM cursos WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function setFinished(int $id, int $terminado): void {
        self::ensureSchema();
        $stmt = DB::conn()->prepare('UPDATE cursos SET terminado = ? WHERE id = ?');
        $stmt->execute([$terminado, $id]);
    }
}


