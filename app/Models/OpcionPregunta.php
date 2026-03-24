<?php
// app/Models/OpcionPregunta.php
class OpcionPregunta {
    public static function byPregunta(int $preguntaId): array {
        $stmt = DB::conn()->prepare('SELECT * FROM opciones_pregunta WHERE pregunta_id = ? ORDER BY orden ASC');
        $stmt->execute([$preguntaId]);
        return $stmt->fetchAll();
    }

    public static function create(int $preguntaId, array $data): void {
        $stmt = DB::conn()->prepare(
            'INSERT INTO opciones_pregunta (pregunta_id, texto, valor, es_correcta, orden) VALUES (?,?,?,?,?)'
        );
        $stmt->execute([
            $preguntaId,
            $data['texto'],
            $data['valor'],
            $data['es_correcta'],
            $data['orden']
        ]);
    }
}
