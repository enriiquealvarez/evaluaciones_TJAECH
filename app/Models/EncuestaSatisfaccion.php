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

    private static function mapToScale(string $val, array $mapping): string {
        if (isset($mapping[$val])) {
            return $mapping[$val];
        }
        return $val;
    }

    public static function dashboard(array $rows): array {
        $scaleOptions = ['5', '4', '3', '2', '1'];

        $q1 = array_fill_keys($scaleOptions, 0);
        $q2 = array_fill_keys($scaleOptions, 0);
        $q3 = array_fill_keys($scaleOptions, 0);
        $q4 = array_fill_keys($scaleOptions, 0);
        $q5 = array_fill_keys($scaleOptions, 0);

        $total = count($rows);
        $scoreSum = 0;
        $scoreCount = 0;
        $recomendaria = 0;
        $comentarios = 0;
        $porCurso = [];

        foreach ($rows as $row) {
            $v1 = trim((string)($row['q1_satisfaccion_general'] ?? ''));
            $v2 = trim((string)($row['q2_calidad_contenidos'] ?? ''));
            $v3 = trim((string)($row['q3_organizacion_actividades'] ?? ''));
            $v4 = trim((string)($row['q4_utilidad_funciones'] ?? ''));
            $v5 = trim((string)($row['q5_recomendacion'] ?? ''));
            $curso = (string)($row['curso_nombre'] ?? 'Sin curso');

            // Map old options to 1-5 scale strings
            $v1 = self::mapToScale($v1, [
                'Muy satisfecho/a' => '5',
                'Satisfecho/a' => '4',
                'Ni satisfecho/a ni insatisfecho/a' => '3',
                'Insatisfecho/a' => '1',
            ]);
            $v2 = self::mapToScale($v2, [
                'Muy buena' => '5',
                'Buena' => '4',
                'Regular' => '3',
                'Deficiente' => '1',
            ]);
            $v3 = self::mapToScale($v3, [
                'Excelente' => '5',
                'Buena' => '4',
                'Regular' => '3',
                'Deficiente' => '1',
            ]);
            $v4 = self::mapToScale($v4, [
                'Muy utiles' => '5',
                'Muy útiles' => '5',
                'Utiles' => '4',
                'Útiles' => '4',
                'Poco utiles' => '3',
                'Poco útiles' => '3',
                'Nada utiles' => '1',
                'Nada útiles' => '1',
            ]);
            $v5 = self::mapToScale($v5, [
                'Si, definitivamente' => '5',
                'Sí, definitivamente' => '5',
                'Probablemente si' => '4',
                'Probablemente sí' => '4',
                'Probablemente no' => '2',
                'No' => '1',
            ]);

            if (isset($q1[$v1])) $q1[$v1]++;
            if (isset($q2[$v2])) $q2[$v2]++;
            if (isset($q3[$v3])) $q3[$v3]++;
            if (isset($q4[$v4])) $q4[$v4]++;
            if (isset($q5[$v5])) $q5[$v5]++;

            // Accumulate numeric score for KPI average
            if ($v1 !== '') {
                $scoreSum += (int)$v1;
                $scoreCount++;
            }

            // recommendation percent threshold (>= 4)
            if ($v5 === '5' || $v5 === '4') {
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
