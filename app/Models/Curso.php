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

        $colCupo = DB::conn()->query("SHOW COLUMNS FROM cursos LIKE 'tiene_cupo'")->fetch();
        if (!$colCupo) {
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN tiene_cupo TINYINT(1) NOT NULL DEFAULT 0 AFTER terminado");
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN cupo_maximo INT NOT NULL DEFAULT 0 AFTER tiene_cupo");
        }

        $colBases = DB::conn()->query("SHOW COLUMNS FROM cursos LIKE 'documento_bases'")->fetch();
        if (!$colBases) {
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN documento_bases VARCHAR(255) NULL AFTER cupo_maximo");
        }

        $colEnviarBases = DB::conn()->query("SHOW COLUMNS FROM cursos LIKE 'enviar_documento_bases'")->fetch();
        if (!$colEnviarBases) {
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN enviar_documento_bases TINYINT(1) NOT NULL DEFAULT 1 AFTER documento_bases");
        }

        $colTipo = DB::conn()->query("SHOW COLUMNS FROM cursos LIKE 'tipo'")->fetch();
        if (!$colTipo) {
            DB::conn()->exec("ALTER TABLE cursos ADD COLUMN tipo VARCHAR(30) NOT NULL DEFAULT 'curso' AFTER nombre");
        }

        $ready = true;
    }

    public const TIPOS = ['curso' => 'Curso', 'taller' => 'Taller', 'curso-taller' => 'Curso-taller', 'diplomado' => 'Diplomado', 'seminario' => 'Seminario'];

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
            'INSERT INTO cursos (nombre, tipo, descripcion, fecha_inicio, fecha_fin, activo, terminado, tiene_cupo, cupo_maximo, documento_bases, enviar_documento_bases, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['nombre'],
            $data['tipo'] ?? 'curso',
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['activo'],
            0,
            $data['tiene_cupo'] ?? 0,
            $data['cupo_maximo'] ?? 0,
            $data['documento_bases'] ?? null,
            $data['enviar_documento_bases'] ?? 1
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        self::ensureSchema();
        $stmt = DB::conn()->prepare(
            'UPDATE cursos SET nombre=?, tipo=?, descripcion=?, fecha_inicio=?, fecha_fin=?, activo=?, tiene_cupo=?, cupo_maximo=?, documento_bases=?, enviar_documento_bases=? WHERE id=?'
        );
        $stmt->execute([
            $data['nombre'],
            $data['tipo'] ?? 'curso',
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['activo'],
            $data['tiene_cupo'] ?? 0,
            $data['cupo_maximo'] ?? 0,
            $data['documento_bases'] ?? null,
            $data['enviar_documento_bases'] ?? 1,
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


