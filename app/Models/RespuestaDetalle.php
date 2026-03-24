<?php
// app/Models/RespuestaDetalle.php
class RespuestaDetalle {
    public static function create(int $respuestaId, int $preguntaId, array $data): void {
        // Prevent duplicate details for the same question in a single response.
        $cleanup = DB::conn()->prepare(
            'DELETE FROM respuestas_detalle WHERE respuesta_id = ? AND pregunta_id = ?'
        );
        $cleanup->execute([$respuestaId, $preguntaId]);

        $stmt = DB::conn()->prepare(
            'INSERT INTO respuestas_detalle (respuesta_id, pregunta_id, valor_texto, valor_opcion, valor_num, created_at)
             VALUES (?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $respuestaId,
            $preguntaId,
            $data['valor_texto'],
            $data['valor_opcion'],
            $data['valor_num']
        ]);
    }
}
