<?php
// app/Models/EncuestaSatisfaccion.php
class EncuestaSatisfaccion {
    public static function existsByRespuesta(int $respuestaId): bool {
        if ($respuestaId <= 0) {
            return false;
        }
        $stmt = DB::conn()->prepare('SELECT id FROM encuestas_satisfaccion WHERE respuesta_id = ? LIMIT 1');
        $stmt->execute([$respuestaId]);
        return (bool)$stmt->fetch();
    }

    public static function findByRespuesta(int $respuestaId): ?array {
        if ($respuestaId <= 0) {
            return null;
        }
        $stmt = DB::conn()->prepare('SELECT * FROM encuestas_satisfaccion WHERE respuesta_id = ? LIMIT 1');
        $stmt->execute([$respuestaId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int {
        $stmt = DB::conn()->prepare(
            'INSERT INTO encuestas_satisfaccion (
                respuesta_id, curso_id, evaluacion_id, folio,
                q1_satisfaccion_general, q2_calidad_contenidos, q3_organizacion_actividades,
                q4_utilidad_funciones, q5_recomendacion, comentarios, created_at
            ) VALUES (?,?,?,?,?,?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['respuesta_id'],
            $data['curso_id'],
            $data['evaluacion_id'],
            $data['folio'],
            $data['q1_satisfaccion_general'],
            $data['q2_calidad_contenidos'],
            $data['q3_organizacion_actividades'],
            $data['q4_utilidad_funciones'],
            $data['q5_recomendacion'],
            $data['comentarios'] ?? null
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function filter(array $filters): array {
        $sql = "SELECT es.*, c.nombre AS curso_nombre, r.nombre_completo
                FROM encuestas_satisfaccion es
                JOIN cursos c ON c.id = es.curso_id
                JOIN respuestas r ON r.id = es.respuesta_id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['curso_id'])) {
            $sql .= ' AND es.curso_id = ?';
            $params[] = (int)$filters['curso_id'];
        }
        if (!empty($filters['desde'])) {
            $sql .= ' AND es.created_at >= ?';
            $params[] = $filters['desde'] . ' 00:00:00';
        }
        if (!empty($filters['hasta'])) {
            $sql .= ' AND es.created_at <= ?';
            $params[] = $filters['hasta'] . ' 23:59:59';
        }

        $sql .= ' ORDER BY es.created_at DESC';
        $stmt = DB::conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function dashboard(array $rows): array {
        $q1Options = ['Muy satisfecho/a', 'Satisfecho/a', 'Ni satisfecho/a ni insatisfecho/a', 'Insatisfecho/a'];
        $q2Options = ['Muy buena', 'Buena', 'Regular', 'Deficiente'];
        $q3Options = ['Excelente', 'Buena', 'Regular', 'Deficiente'];
        $q4Options = ['Muy utiles', 'Utiles', 'Poco utiles', 'Nada utiles'];
        $q5Options = ['Si, definitivamente', 'Probablemente si', 'Probablemente no', 'No'];

        $q1 = array_fill_keys($q1Options, 0);
        $q2 = array_fill_keys($q2Options, 0);
        $q3 = array_fill_keys($q3Options, 0);
        $q4 = array_fill_keys($q4Options, 0);
        $q5 = array_fill_keys($q5Options, 0);

        $scoreMap = [
            'Muy satisfecho/a' => 4,
            'Satisfecho/a' => 3,
            'Ni satisfecho/a ni insatisfecho/a' => 2,
            'Insatisfecho/a' => 1,
        ];

        $total = count($rows);
        $scoreSum = 0;
        $scoreCount = 0;
        $recomendaria = 0;
        $comentarios = 0;
        $porCurso = [];

        foreach ($rows as $row) {
            $v1 = (string)($row['q1_satisfaccion_general'] ?? '');
            $v2 = (string)($row['q2_calidad_contenidos'] ?? '');
            $v3 = (string)($row['q3_organizacion_actividades'] ?? '');
            $v4 = (string)($row['q4_utilidad_funciones'] ?? '');
            $v5 = (string)($row['q5_recomendacion'] ?? '');
            $curso = (string)($row['curso_nombre'] ?? 'Sin curso');

            if (isset($q1[$v1])) $q1[$v1]++;
            if (isset($q2[$v2])) $q2[$v2]++;
            if (isset($q3[$v3])) $q3[$v3]++;
            if (isset($q4[$v4])) $q4[$v4]++;
            if (isset($q5[$v5])) $q5[$v5]++;

            if (isset($scoreMap[$v1])) {
                $scoreSum += $scoreMap[$v1];
                $scoreCount++;
            }
            if ($v5 === 'Si, definitivamente' || $v5 === 'Probablemente si') {
                $recomendaria++;
            }
            if (trim((string)($row['comentarios'] ?? '')) !== '') {
                $comentarios++;
            }
            $porCurso[$curso] = ($porCurso[$curso] ?? 0) + 1;
        }

        arsort($porCurso);

        return [
            'total' => $total,
            'promedio_satisfaccion' => $scoreCount > 0 ? round(($scoreSum / $scoreCount), 2) : 0,
            'porcentaje_recomendacion' => $total > 0 ? round(($recomendaria / $total) * 100, 1) : 0,
            'con_comentarios' => $comentarios,
            'q1' => $q1,
            'q2' => $q2,
            'q3' => $q3,
            'q4' => $q4,
            'q5' => $q5,
            'por_curso' => $porCurso
        ];
    }
}
