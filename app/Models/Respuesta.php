<?php
// app/Models/Respuesta.php
class Respuesta {
    public static function create(array $data): int {
        $stmt = DB::conn()->prepare(
            'INSERT INTO respuestas (curso_id, evaluacion_id, folio, nombre_completo, correo, telefono, municipio, cargo_puesto, comentarios, ip, user_agent, created_at)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['curso_id'],
            $data['evaluacion_id'],
            $data['folio'],
            $data['nombre_completo'],
            $data['correo'],
            $data['telefono'],
            $data['municipio'],
            $data['cargo_puesto'],
            $data['comentarios'],
            $data['ip'],
            $data['user_agent']
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function findByFolio(string $folio): ?array {
        $stmt = DB::conn()->prepare(
            'SELECT r.*, c.nombre AS curso_nombre FROM respuestas r JOIN cursos c ON c.id = r.curso_id WHERE folio = ? LIMIT 1'
        );
        $stmt->execute([$folio]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function countAll(): int {
        $stmt = DB::conn()->query('SELECT COUNT(*) AS total FROM respuestas');
        return (int)$stmt->fetch()['total'];
    }

    public static function existsByContacto(int $evaluacionId, string $correo, string $telefono, int $cursoId = 0): bool {
        $correo = mb_strtolower(trim($correo));
        $telefono = preg_replace('/\D+/', '', $telefono);

        $conditions = [];
        $params = [];

        if ($cursoId > 0) {
            $params[] = $cursoId;
        } else {
            $params[] = $evaluacionId;
        }

        if ($correo !== '') {
            $conditions[] = 'LOWER(correo) = ?';
            $params[] = $correo;
        }

        if ($telefono !== '') {
            $conditions[] = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')',''),'+','') = ?";
            $params[] = $telefono;
        }

        if (empty($conditions)) {
            return false;
        }

        $scope = $cursoId > 0 ? 'curso_id = ?' : 'evaluacion_id = ?';
        $sql = 'SELECT id FROM respuestas WHERE ' . $scope . ' AND (' . implode(' OR ', $conditions) . ') LIMIT 1';
        $stmt = DB::conn()->prepare($sql);
        $stmt->execute($params);
        return (bool)$stmt->fetch();
    }

    public static function existsByContactoPair(int $cursoId, string $correo, string $telefono): bool {
        $correo = mb_strtolower(trim($correo));
        $telefono = preg_replace('/\D+/', '', $telefono);

        if ($cursoId <= 0 || $correo === '' || $telefono === '') {
            return false;
        }

        $stmt = DB::conn()->prepare(
            "SELECT id
             FROM respuestas
             WHERE curso_id = ?
               AND LOWER(correo) = ?
               AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')',''),'+','') = ?
             LIMIT 1"
        );
        $stmt->execute([$cursoId, $correo, $telefono]);
        return (bool)$stmt->fetch();
    }

    public static function latest(int $limit = 5): array {
        $stmt = DB::conn()->prepare(
            'SELECT r.id, r.folio, r.nombre_completo, r.created_at, c.nombre AS curso_nombre
             FROM respuestas r JOIN cursos c ON c.id = r.curso_id
             ORDER BY r.created_at DESC LIMIT ?'
        );
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function filter(array $filters): array {
        // legacy, keep for backward compatibility - simply call the admin variant
        return self::filterAdmin($filters);
    }

    /**
     * Filter results for admin interface.
     * Supports curso_id, desde/hasta, correo, telefono, nombre and status.
     */
    public static function filterAdmin(array $filters): array {
        $sql = 'SELECT r.*, c.nombre AS curso_nombre,
                    SUM(CASE WHEN p.tipo IN ("opcion","si_no") THEN 1 ELSE 0 END) AS evaluables,
                    SUM(CASE WHEN p.tipo IN ("opcion","si_no") AND op.es_correcta = 1 THEN 1 ELSE 0 END) AS aciertos
             FROM respuestas r
             JOIN cursos c ON c.id = r.curso_id
             LEFT JOIN respuestas_detalle d ON d.respuesta_id = r.id
             LEFT JOIN preguntas p ON p.id = d.pregunta_id
             LEFT JOIN opciones_pregunta op
                ON op.pregunta_id = p.id
               AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
             WHERE 1=1';
        $params = [];

        if (!empty($filters['curso_id'])) {
            $sql .= ' AND r.curso_id = ?';
            $params[] = $filters['curso_id'];
        }
        if (!empty($filters['desde'])) {
            $sql .= ' AND r.created_at >= ?';
            $params[] = $filters['desde'] . ' 00:00:00';
        }
        if (!empty($filters['hasta'])) {
            $sql .= ' AND r.created_at <= ?';
            $params[] = $filters['hasta'] . ' 23:59:59';
        }
        if (!empty($filters['correo'])) {
            $sql .= ' AND LOWER(r.correo) LIKE ?';
            $params[] = '%' . mb_strtolower($filters['correo']) . '%';
        }
        if (!empty($filters['telefono'])) {
            $clean = preg_replace('/\D+/', '', $filters['telefono']);
            $sql .= ' AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(r.telefono," ",""),"-",""),"(",""),")",""),"+","") LIKE ?';
            $params[] = '%' . $clean . '%';
        }
        if (!empty($filters['nombre'])) {
            $sql .= ' AND LOWER(r.nombre_completo) LIKE ?';
            $params[] = '%' . mb_strtolower($filters['nombre']) . '%';
        }

        $sql .= ' GROUP BY r.id, r.folio, r.nombre_completo, r.created_at, c.nombre';
        $sql .= ' ORDER BY r.created_at DESC';

        $stmt = DB::conn()->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        foreach ($rows as &$row) {
            $evaluables = (int)($row['evaluables'] ?? 0);
            $aciertos = (int)($row['aciertos'] ?? 0);
            $porcentaje = $evaluables > 0 ? (int)round(($aciertos / $evaluables) * 100) : 0;
            $row['puntuacion'] = $porcentaje;
            if ($evaluables <= 0) {
                $row['estatus'] = 'pendiente';
            } elseif ($porcentaje >= 70) {
                $row['estatus'] = 'aprobado';
            } else {
                $row['estatus'] = 'reprobado';
            }
        }
        unset($row);

        if (!empty($filters['status']) && in_array($filters['status'], ['aprobado', 'reprobado', 'pendiente'], true)) {
            $rows = array_filter($rows, fn($r) => $r['estatus'] === $filters['status']);
        }

        return $rows;
    }

    public static function findWithDetails(int $id): ?array {
        $stmt = DB::conn()->prepare(
            'SELECT r.*, c.nombre AS curso_nombre, e.titulo AS evaluacion_titulo
             FROM respuestas r JOIN cursos c ON c.id = r.curso_id
             JOIN evaluaciones e ON e.id = r.evaluacion_id
             WHERE r.id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $resp = $stmt->fetch();
        if (!$resp) {
            return null;
        }
        try {
            // Use subqueries to avoid duplicating detail rows when a question has multiple options.
            $stmt = DB::conn()->prepare(
                'SELECT d.*, p.texto AS pregunta_texto, p.tipo AS pregunta_tipo,
                        (SELECT op.texto
                         FROM opciones_pregunta op
                         WHERE op.pregunta_id = p.id
                           AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
                         LIMIT 1) AS opcion_texto,
                        (SELECT op.es_correcta
                         FROM opciones_pregunta op
                         WHERE op.pregunta_id = p.id
                           AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
                         LIMIT 1) AS opcion_correcta
                 FROM respuestas_detalle d
                 JOIN preguntas p ON p.id = d.pregunta_id
                 WHERE d.respuesta_id = ? ORDER BY p.orden ASC'
            );
            $stmt->execute([$id]);
        } catch (\Throwable $e) {
            error_log('Respuesta::findWithDetails error: ' . $e->getMessage());
            $stmt = DB::conn()->prepare(
                'SELECT d.*, p.texto AS pregunta_texto, p.tipo AS pregunta_tipo,
                        (SELECT op.texto
                         FROM opciones_pregunta op
                         WHERE op.pregunta_id = p.id
                           AND op.valor = d.valor_opcion
                         LIMIT 1) AS opcion_texto,
                        (SELECT op.es_correcta
                         FROM opciones_pregunta op
                         WHERE op.pregunta_id = p.id
                           AND op.valor = d.valor_opcion
                         LIMIT 1) AS opcion_correcta
                 FROM respuestas_detalle d
                 JOIN preguntas p ON p.id = d.pregunta_id
                 WHERE d.respuesta_id = ? ORDER BY p.orden ASC'
            );
            $stmt->execute([$id]);
        }
        $resp['detalles'] = $stmt->fetchAll();
        return $resp;
    }

    public static function statsByCurso(): array {
        $stmt = DB::conn()->query(
            'SELECT c.nombre AS curso_nombre, COUNT(r.id) AS total
             FROM cursos c
             LEFT JOIN respuestas r ON r.curso_id = c.id
             GROUP BY c.id
             ORDER BY c.nombre ASC'
        );
        return $stmt->fetchAll();
    }

    public static function latestWithStatus(int $limit = 5): array {
        $stmt = DB::conn()->prepare(
            "SELECT r.id, r.folio, r.nombre_completo, r.created_at, c.nombre AS curso_nombre,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') THEN 1 ELSE 0 END) AS evaluables,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') AND op.es_correcta = 1 THEN 1 ELSE 0 END) AS aciertos
             FROM respuestas r
             JOIN cursos c ON c.id = r.curso_id
             LEFT JOIN respuestas_detalle d ON d.respuesta_id = r.id
             LEFT JOIN preguntas p ON p.id = d.pregunta_id
             LEFT JOIN opciones_pregunta op
                ON op.pregunta_id = p.id
               AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
             GROUP BY r.id, r.folio, r.nombre_completo, r.created_at, c.nombre
             ORDER BY r.created_at DESC
             LIMIT ?"
        );
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        foreach ($rows as &$row) {
            $evaluables = (int)($row['evaluables'] ?? 0);
            $aciertos = (int)($row['aciertos'] ?? 0);
            $porcentaje = $evaluables > 0 ? (int)round(($aciertos / $evaluables) * 100) : 0;
            $row['porcentaje'] = $porcentaje;

            if ($evaluables <= 0) {
                $row['estatus'] = 'Pendiente';
                $row['estatus_key'] = 'pendiente';
            } elseif ($porcentaje >= 70) {
                $row['estatus'] = 'Aprobado';
                $row['estatus_key'] = 'aprobado';
            } else {
                $row['estatus'] = 'No aprobado';
                $row['estatus_key'] = 'no_aprobado';
            }
        }
        unset($row);

        return $rows;
    }

    public static function dashboardSummary(int $months = 6): array {
        $months = max(3, min(12, $months));
        $stmt = DB::conn()->query(
            "SELECT r.id, r.created_at,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') THEN 1 ELSE 0 END) AS evaluables,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') AND op.es_correcta = 1 THEN 1 ELSE 0 END) AS aciertos
             FROM respuestas r
             LEFT JOIN respuestas_detalle d ON d.respuesta_id = r.id
             LEFT JOIN preguntas p ON p.id = d.pregunta_id
             LEFT JOIN opciones_pregunta op
                ON op.pregunta_id = p.id
               AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
             GROUP BY r.id, r.created_at
             ORDER BY r.created_at DESC"
        );
        $rows = $stmt->fetchAll();

        $total = count($rows);
        $scoreSum = 0.0;
        $scoreCount = 0;
        $completedCount = 0;

        $periods = [];
        $now = new DateTimeImmutable('first day of this month');
        for ($i = $months - 1; $i >= 0; $i--) {
            $month = $now->modify("-{$i} months");
            $key = $month->format('Y-m');
            $periods[$key] = [
                'label' => $month->format('M'),
                'totales' => 0,
                'aprobados' => 0,
            ];
        }

        foreach ($rows as $row) {
            $evaluables = (int)($row['evaluables'] ?? 0);
            $aciertos = (int)($row['aciertos'] ?? 0);
            $porcentaje = $evaluables > 0 ? ($aciertos / $evaluables) * 100 : 0;

            if ($evaluables > 0) {
                $completedCount++;
                $scoreSum += $porcentaje;
                $scoreCount++;
            }

            $createdAt = (string)($row['created_at'] ?? '');
            $monthKey = substr($createdAt, 0, 7);
            if (isset($periods[$monthKey])) {
                $periods[$monthKey]['totales']++;
                if ($evaluables > 0 && $porcentaje >= 70) {
                    $periods[$monthKey]['aprobados']++;
                }
            }
        }

        return [
            'promedio_puntuacion' => $scoreCount > 0 ? (int)round($scoreSum / $scoreCount) : 0,
            'tasa_finalizacion' => $total > 0 ? (int)round(($completedCount / $total) * 100) : 0,
            'actividad_mensual' => array_values($periods),
        ];
    }

    public static function statusByCurso(): array {
        $stmt = DB::conn()->query(
            "SELECT r.id, c.nombre AS curso_nombre,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') THEN 1 ELSE 0 END) AS evaluables,
                    SUM(CASE WHEN p.tipo IN ('opcion','si_no') AND op.es_correcta = 1 THEN 1 ELSE 0 END) AS aciertos
             FROM respuestas r
             JOIN cursos c ON c.id = r.curso_id
             LEFT JOIN respuestas_detalle d ON d.respuesta_id = r.id
             LEFT JOIN preguntas p ON p.id = d.pregunta_id
             LEFT JOIN opciones_pregunta op
                ON op.pregunta_id = p.id
               AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
             GROUP BY r.id, c.nombre
             ORDER BY c.nombre ASC"
        );
        $rows = $stmt->fetchAll();

        $stats = [];
        foreach ($rows as $row) {
            $curso = (string)($row['curso_nombre'] ?? 'Sin curso');
            if (!isset($stats[$curso])) {
                $stats[$curso] = [
                    'curso' => $curso,
                    'aprobados' => 0,
                    'reprobados' => 0,
                ];
            }

            $evaluables = (int)($row['evaluables'] ?? 0);
            $aciertos = (int)($row['aciertos'] ?? 0);
            if ($evaluables <= 0) {
                continue;
            }

            $porcentaje = ($aciertos / $evaluables) * 100;
            if ($porcentaje >= 70) {
                $stats[$curso]['aprobados']++;
            } else {
                $stats[$curso]['reprobados']++;
            }
        }

        return array_values($stats);
    }

    public static function delete(int $id): void {
        $stmt = DB::conn()->prepare('DELETE FROM respuestas WHERE id = ?');
        $stmt->execute([$id]);
    }

    /**
     * Buscar respuestas por contacto (correo y/o teléfono) con cálculo de puntuación
     */
    public static function searchByContact(string $correo = '', string $telefono = '', string $status = '', int $cursoId = 0): array {
        $correo = mb_strtolower(trim($correo));
        $telefono = preg_replace('/\D+/', '', (string)$telefono);

        $sql = 'SELECT r.*, c.nombre AS curso_nombre,
                    SUM(CASE WHEN p.tipo IN ("opcion","si_no") THEN 1 ELSE 0 END) AS evaluables,
                    SUM(CASE WHEN p.tipo IN ("opcion","si_no") AND op.es_correcta = 1 THEN 1 ELSE 0 END) AS aciertos
             FROM respuestas r
             JOIN cursos c ON c.id = r.curso_id
             LEFT JOIN respuestas_detalle d ON d.respuesta_id = r.id
             LEFT JOIN preguntas p ON p.id = d.pregunta_id
             LEFT JOIN opciones_pregunta op
                ON op.pregunta_id = p.id
               AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
             WHERE 1=1';

        $params = [];

        if ($correo !== '') {
            $sql .= ' AND LOWER(r.correo) = ?';
            $params[] = $correo;
        }

        if ($telefono !== '') {
            $sql .= ' AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(r.telefono," ",""),"-",""),"(",""),")",""),"+","") = ?';
            $params[] = $telefono;
        }

        if ($cursoId > 0) {
            $sql .= ' AND r.curso_id = ?';
            $params[] = $cursoId;
        }

        $sql .= ' GROUP BY r.id, r.folio, r.nombre_completo, r.created_at, c.nombre, c.id
                 ORDER BY r.created_at DESC';

        $stmt = DB::conn()->prepare($sql);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        // Agregar cálculo de puntuación y estado
        foreach ($rows as &$row) {
            $row['puntuacion'] = self::calculateScoreForRow($row);
            $row['estatus'] = $row['evaluables'] <= 0 ? 'pendiente' : ($row['puntuacion'] >= 70 ? 'aprobado' : 'reprobado');
            $row['etiqueta_estatus'] = $row['evaluables'] <= 0 ? 'Pendiente' : ($row['puntuacion'] >= 70 ? 'Aprobado' : 'No aprobado');
        }
        unset($row);

        // Filtrar por status si se especifica
        if ($status !== '' && in_array($status, ['aprobado', 'reprobado', 'pendiente'], true)) {
            $rows = array_filter($rows, fn($r) => $r['estatus'] === $status);
        }

        return $rows;
    }

    /**
     * Calcular puntuación a partir de datos de fila
     */
    private static function calculateScoreForRow(array $row): int {
        $evaluables = (int)($row['evaluables'] ?? 0);
        $aciertos = (int)($row['aciertos'] ?? 0);
        return $evaluables > 0 ? (int)round(($aciertos / $evaluables) * 100) : 0;
    }

    /**
     * Obtener calificación completa de una respuesta
     */
    public static function getDetailedScore(int $respuestaId): ?array {
        $stmt = DB::conn()->prepare(
            'SELECT r.*, c.nombre AS curso_nombre, e.titulo AS evaluacion_titulo
             FROM respuestas r
             JOIN cursos c ON c.id = r.curso_id
             JOIN evaluaciones e ON e.id = r.evaluacion_id
             WHERE r.id = ? LIMIT 1'
        );
        $stmt->execute([$respuestaId]);
        $respuesta = $stmt->fetch();

        if (!$respuesta) {
            return null;
        }

        // Obtener detalles de respuestas
        $stmt = DB::conn()->prepare(
            'SELECT d.*, p.texto AS pregunta_texto, p.tipo AS pregunta_tipo,
                    (SELECT op.texto
                     FROM opciones_pregunta op
                     WHERE op.pregunta_id = p.id
                       AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
                     LIMIT 1) AS opcion_texto,
                    (SELECT op.es_correcta
                     FROM opciones_pregunta op
                     WHERE op.pregunta_id = p.id
                       AND (op.valor = d.valor_opcion OR op.valor = CAST(d.valor_num AS CHAR))
                     LIMIT 1) AS es_correcta
             FROM respuestas_detalle d
             JOIN preguntas p ON p.id = d.pregunta_id
             WHERE d.respuesta_id = ? ORDER BY p.orden ASC'
        );
        $stmt->execute([$respuestaId]);
        $detalles = $stmt->fetchAll();

        // Calcular puntuación
        $evaluables = 0;
        $aciertos = 0;
        foreach ($detalles as $detalle) {
            if (in_array($detalle['pregunta_tipo'], ['opcion', 'si_no'], true)) {
                $evaluables++;
                if ((int)($detalle['es_correcta'] ?? 0) === 1) {
                    $aciertos++;
                }
            }
        }

        $respuesta['evaluables'] = $evaluables;
        $respuesta['aciertos'] = $aciertos;
        $respuesta['detalles'] = $detalles;
        $respuesta['puntuacion'] = $evaluables > 0 ? (int)round(($aciertos / $evaluables) * 100) : 0;
        $respuesta['estatus'] = $evaluables <= 0 ? 'Pendiente' : ($respuesta['puntuacion'] >= 70 ? 'Aprobado' : 'No aprobado');

        return $respuesta;
    }
}
