<?php
// app/Models/InscripcionCurso.php
class InscripcionCurso {
    private static function ensureTable(): void {
        static $ready = false;
        if ($ready) {
            return;
        }

        $pdo = DB::conn();
        $exists = $pdo->query("SHOW TABLES LIKE 'inscripciones_curso'")->fetch();
        if (!$exists) {
            $pdo->exec(
                "CREATE TABLE IF NOT EXISTS inscripciones_curso (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    curso_id INT NOT NULL,
                    nombre_completo VARCHAR(160) NOT NULL,
                    edad TINYINT UNSIGNED NOT NULL,
                    genero VARCHAR(40) NOT NULL,
                    correo VARCHAR(120) NOT NULL,
                    telefono VARCHAR(30) NOT NULL,
                    institucion VARCHAR(200) NOT NULL,
                    cargo_puesto VARCHAR(160) NOT NULL,
                    grado_estudios VARCHAR(80) NOT NULL,
                    grado_otro VARCHAR(160) NULL,
                    colectivos_json TEXT NULL,
                    created_at DATETIME NOT NULL,
                    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
                    UNIQUE KEY uk_inscripcion_curso_correo (curso_id, correo),
                    UNIQUE KEY uk_inscripcion_curso_telefono (curso_id, telefono),
                    INDEX idx_inscripciones_curso (curso_id)
                ) ENGINE=InnoDB"
            );
        }

        $ready = true;
    }

    public static function create(array $data): int {
        self::ensureTable();

        $stmt = DB::conn()->prepare(
            'INSERT INTO inscripciones_curso (
                curso_id, nombre_completo, edad, genero, correo, telefono, institucion,
                cargo_puesto, grado_estudios, grado_otro, colectivos_json, created_at
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,NOW())'
        );
        $stmt->execute([
            $data['curso_id'],
            $data['nombre_completo'],
            $data['edad'],
            $data['genero'],
            $data['correo'],
            $data['telefono'],
            $data['institucion'],
            $data['cargo_puesto'],
            $data['grado_estudios'],
            $data['grado_otro'],
            $data['colectivos_json']
        ]);
        return (int)DB::conn()->lastInsertId();
    }

    public static function existsByCorreoOrTelefono(int $cursoId, string $correo, string $telefono): bool {
        self::ensureTable();

        $correo = mb_strtolower(trim($correo));
        $telefono = preg_replace('/\D+/', '', $telefono);

        if ($cursoId <= 0 || ($correo === '' && $telefono === '')) {
            return false;
        }

        $parts = [];
        $params = [$cursoId];

        if ($correo !== '') {
            $parts[] = 'LOWER(correo) = ?';
            $params[] = $correo;
        }
        if ($telefono !== '') {
            $parts[] = "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')',''),'+','') = ?";
            $params[] = $telefono;
        }

        $stmt = DB::conn()->prepare(
            'SELECT id FROM inscripciones_curso WHERE curso_id = ? AND (' . implode(' OR ', $parts) . ') LIMIT 1'
        );
        $stmt->execute($params);
        return (bool)$stmt->fetch();
    }

    public static function findByContacto(int $cursoId, string $correo, string $telefono): ?array {
        self::ensureTable();

        $correo = mb_strtolower(trim($correo));
        $telefono = preg_replace('/\D+/', '', $telefono);
        if ($cursoId <= 0 || $correo === '' || $telefono === '') {
            return null;
        }

        $stmt = DB::conn()->prepare(
            "SELECT *
             FROM inscripciones_curso
             WHERE curso_id = ?
               AND LOWER(correo) = ?
               AND REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(telefono,' ',''),'-',''),'(',''),')',''),'+','') = ?
             LIMIT 1"
        );
        $stmt->execute([$cursoId, $correo, $telefono]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    private static function buildFilterQuery(array $filters = []): array {
        self::ensureTable();

        $where = [];
        $params = [];

        $cursoId = (int)($filters['curso_id'] ?? 0);
        if ($cursoId > 0) {
            $where[] = 'ic.curso_id = ?';
            $params[] = $cursoId;
        }

        $q = trim((string)($filters['q'] ?? ''));
        if ($q !== '') {
            $like = '%' . $q . '%';
            $searchIn = (string)($filters['search_in'] ?? 'all');
            $columnMap = [
                'nombre' => 'ic.nombre_completo',
                'correo' => 'ic.correo',
                'telefono' => 'ic.telefono',
                'institucion' => 'ic.institucion',
                'cargo' => 'ic.cargo_puesto',
            ];

            if ($searchIn !== 'all' && isset($columnMap[$searchIn])) {
                $where[] = $columnMap[$searchIn] . ' LIKE ?';
                $params[] = $like;
            } else {
                $where[] = '(ic.nombre_completo LIKE ? OR ic.correo LIKE ? OR ic.telefono LIKE ? OR ic.institucion LIKE ? OR ic.cargo_puesto LIKE ?)';
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
                $params[] = $like;
            }
        }

        $sql = "FROM inscripciones_curso ic
                INNER JOIN cursos c ON c.id = ic.curso_id";
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        return [$sql, $params];
    }

    public static function allWithFilters(array $filters = [], ?array $pagination = null): array {
        [$baseSql, $params] = self::buildFilterQuery($filters);

        $sql = "SELECT ic.*, c.nombre AS curso_nombre " . $baseSql . ' ORDER BY ic.created_at DESC, ic.id DESC';

        if ($pagination !== null) {
            $perPage = max(1, (int)($pagination['per_page'] ?? 20));
            $page = max(1, (int)($pagination['page'] ?? 1));
            $offset = ($page - 1) * $perPage;
            $sql .= ' LIMIT ' . $perPage . ' OFFSET ' . $offset;
        }

        $stmt = DB::conn()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public static function countWithFilters(array $filters = []): int {
        [$baseSql, $params] = self::buildFilterQuery($filters);
        $stmt = DB::conn()->prepare('SELECT COUNT(*) AS total ' . $baseSql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    public static function delete(int $id): bool {
        self::ensureTable();

        if ($id <= 0) {
            return false;
        }

        $stmt = DB::conn()->prepare('DELETE FROM inscripciones_curso WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }

    public static function dashboardStats(array $rows): array {
        $gender = [
            'Mujer' => 0,
            'Hombre' => 0,
            'No binario/otro' => 0,
            'Prefiero no responder' => 0,
            'Otro/No especificado' => 0,
        ];
        $ageRanges = [
            '10-17' => 0,
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-60' => 0,
            '61+' => 0,
        ];
        $colectivos = [];

        $sumAge = 0;
        $countAge = 0;
        $minAge = null;
        $maxAge = null;

        foreach ($rows as $row) {
            $rawGender = trim((string)($row['genero'] ?? ''));
            $g = mb_strtolower($rawGender);
            if ($g === 'mujer' || $g === 'femenino') {
                $gender['Mujer']++;
            } elseif ($g === 'hombre' || $g === 'masculino') {
                $gender['Hombre']++;
            } elseif (str_contains($g, 'prefiero no responder')) {
                $gender['Prefiero no responder']++;
            } elseif (str_contains($g, 'no binario') || $g === 'otro' || $g === 'no binario/otro') {
                $gender['No binario/otro']++;
            } else {
                $gender['Otro/No especificado']++;
            }

            $age = (int)($row['edad'] ?? 0);
            if ($age > 0) {
                $sumAge += $age;
                $countAge++;
                $minAge = $minAge === null ? $age : min($minAge, $age);
                $maxAge = $maxAge === null ? $age : max($maxAge, $age);

                if ($age <= 17) {
                    $ageRanges['10-17']++;
                } elseif ($age <= 25) {
                    $ageRanges['18-25']++;
                } elseif ($age <= 35) {
                    $ageRanges['26-35']++;
                } elseif ($age <= 45) {
                    $ageRanges['36-45']++;
                } elseif ($age <= 60) {
                    $ageRanges['46-60']++;
                } else {
                    $ageRanges['61+']++;
                }
            }

            $colectivosRaw = json_decode((string)($row['colectivos_json'] ?? ''), true);
            if (is_array($colectivosRaw)) {
                foreach ($colectivosRaw as $colectivo) {
                    $label = trim((string)$colectivo);
                    if ($label === '') {
                        continue;
                    }
                    $colectivos[$label] = (int)($colectivos[$label] ?? 0) + 1;
                }
            }
        }

        if (!empty($colectivos)) {
            arsort($colectivos);
        }

        return [
            'total' => count($rows),
            'gender' => $gender,
            'age_ranges' => $ageRanges,
            'colectivos' => $colectivos,
            'age_avg' => $countAge > 0 ? round($sumAge / $countAge, 1) : 0,
            'age_min' => $minAge ?? 0,
            'age_max' => $maxAge ?? 0,
        ];
    }
}
