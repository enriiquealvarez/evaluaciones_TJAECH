<?php
// app/Models/Evaluacion.php
class Evaluacion {
    public static function byCurso(int $cursoId): array {
        $stmt = DB::conn()->prepare('SELECT * FROM evaluaciones WHERE curso_id = ? ORDER BY created_at DESC');
        $stmt->execute([$cursoId]);
        return $stmt->fetchAll();
    }

    public static function activeByCurso(int $cursoId): ?array {
        $stmt = DB::conn()->prepare('SELECT * FROM evaluaciones WHERE curso_id = ? AND activo = 1 ORDER BY created_at DESC LIMIT 1');
        $stmt->execute([$cursoId]);
        $eval = $stmt->fetch();
        return $eval ?: null;
    }

    public static function find(int $id): ?array {
        $stmt = DB::conn()->prepare('SELECT * FROM evaluaciones WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $eval = $stmt->fetch();
        return $eval ?: null;
    }

    public static function create(array $data): int {
        $stmt = DB::conn()->prepare(
            'INSERT INTO evaluaciones (curso_id, titulo, descripcion, activo, created_at) VALUES (?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['curso_id'],
            $data['titulo'],
            $data['descripcion'],
            $data['activo']
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function update(int $id, array $data): void {
        $stmt = DB::conn()->prepare(
            'UPDATE evaluaciones SET titulo=?, descripcion=?, activo=? WHERE id=?'
        );
        $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['activo'],
            $id
        ]);
    }

    public static function delete(int $id): void {
        $stmt = DB::conn()->prepare('DELETE FROM evaluaciones WHERE id = ?');
        $stmt->execute([$id]);
    }
}


