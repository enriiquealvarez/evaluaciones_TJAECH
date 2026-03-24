<?php
// app/Models/Pregunta.php
class Pregunta {
    public static function byEvaluacion(int $evaluacionId): array {
        $stmt = DB::conn()->prepare('SELECT * FROM preguntas WHERE evaluacion_id = ? ORDER BY orden ASC');
        $stmt->execute([$evaluacionId]);
        $preguntas = $stmt->fetchAll();
        foreach ($preguntas as &$p) {
            $p['opciones'] = OpcionPregunta::byPregunta((int)$p['id']);
        }
        return $preguntas;
    }

    public static function create(int $evaluacionId, array $data): int {
        $stmt = DB::conn()->prepare(
            'INSERT INTO preguntas (evaluacion_id, texto, tipo, requerido, orden) VALUES (?,?,?,?,?)'
        );
        $stmt->execute([
            $evaluacionId,
            $data['texto'],
            $data['tipo'],
            $data['requerido'],
            $data['orden']
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function deleteByEvaluacion(int $evaluacionId): void {
        $stmt = DB::conn()->prepare('DELETE FROM preguntas WHERE evaluacion_id = ?');
        $stmt->execute([$evaluacionId]);
    }
}


