<?php
// app/Models/Admin.php
class Admin {
    private static function rolesTableExists(): bool {
        static $exists = null;
        if ($exists !== null) {
            return $exists;
        }
        $stmt = DB::conn()->query("SHOW TABLES LIKE 'admin_roles'");
        $exists = (bool)$stmt->fetch();
        return $exists;
    }

    public static function roleOptions(): array {
        return [
            'ADMIN' => 'Administrador',
            'COURSES' => 'Cursos',
            'EVALUATIONS' => 'Evaluaciones',
            'RESULTS' => 'Resultados',
            'USERS' => 'Usuarios',
        ];
    }

    public static function findByEmail(string $email): ?array {
        $stmt = DB::conn()->prepare('SELECT * FROM admins WHERE email = ? AND activo = 1 LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public static function findByEmailAny(string $email): ?array {
        $stmt = DB::conn()->prepare('SELECT * FROM admins WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public static function findById(int $id): ?array {
        $stmt = DB::conn()->prepare('SELECT * FROM admins WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $admin = $stmt->fetch();
        return $admin ?: null;
    }

    public static function all(): array {
        if (!self::rolesTableExists()) {
            $stmt = DB::conn()->query('SELECT * FROM admins ORDER BY id DESC');
            $rows = $stmt->fetchAll();
            foreach ($rows as &$row) {
                $row['roles'] = ['ADMIN'];
            }
            return $rows;
        }
        $stmt = DB::conn()->query(
            'SELECT a.*, GROUP_CONCAT(ar.role) AS roles
             FROM admins a
             LEFT JOIN admin_roles ar ON ar.admin_id = a.id
             GROUP BY a.id
             ORDER BY a.id DESC'
        );
        $rows = $stmt->fetchAll();
        foreach ($rows as &$row) {
            $row['roles'] = $row['roles'] ? explode(',', $row['roles']) : ['ADMIN'];
        }
        return $rows;
    }

    public static function create(array $data): int {
        $stmt = DB::conn()->prepare(
            'INSERT INTO admins (nombre, email, password_hash, activo, created_at) VALUES (?,?,?,?,NOW())'
        );
        $stmt->execute([
            trim($data['nombre'] ?? ''),
            trim($data['email'] ?? ''),
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['activo'] ?? 1,
        ]);
        $id = (int)DB::conn()->lastInsertId();
        self::setRoles($id, $data['roles'] ?? []);
        return $id;
    }

    public static function update(int $id, array $data): void {
        $fields = [
            'nombre' => trim($data['nombre'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'activo' => $data['activo'] ?? 1,
        ];
        if (!empty($data['password'])) {
            $stmt = DB::conn()->prepare(
                'UPDATE admins SET nombre = ?, email = ?, activo = ?, password_hash = ? WHERE id = ?'
            );
            $stmt->execute([
                $fields['nombre'],
                $fields['email'],
                $fields['activo'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $id,
            ]);
        } else {
            $stmt = DB::conn()->prepare('UPDATE admins SET nombre = ?, email = ?, activo = ? WHERE id = ?');
            $stmt->execute([
                $fields['nombre'],
                $fields['email'],
                $fields['activo'],
                $id,
            ]);
        }
        self::setRoles($id, $data['roles'] ?? []);
    }

    public static function updatePasswordByEmail(string $email, string $password): void {
        $stmt = DB::conn()->prepare('UPDATE admins SET password_hash = ? WHERE email = ?');
        $stmt->execute([password_hash($password, PASSWORD_DEFAULT), $email]);
    }

    public static function setStatus(int $id, int $activo): void {
        $stmt = DB::conn()->prepare('UPDATE admins SET activo = ? WHERE id = ?');
        $stmt->execute([$activo, $id]);
    }

    public static function rolesByAdmin(int $id): array {
        if (!self::rolesTableExists()) {
            return ['ADMIN'];
        }
        $stmt = DB::conn()->prepare('SELECT role FROM admin_roles WHERE admin_id = ?');
        $stmt->execute([$id]);
        $roles = array_column($stmt->fetchAll(), 'role');
        return $roles ?: ['ADMIN'];
    }

    public static function setRoles(int $id, array $roles): void {
        if (!self::rolesTableExists()) {
            return;
        }
        $pdo = DB::conn();
        $pdo->beginTransaction();
        $pdo->prepare('DELETE FROM admin_roles WHERE admin_id = ?')->execute([$id]);
        $stmt = $pdo->prepare('INSERT INTO admin_roles (admin_id, role) VALUES (?, ?)');
        foreach ($roles as $role) {
            $stmt->execute([$id, $role]);
        }
        $pdo->commit();
    }

    public static function ensureDefault(): void {
        $stmt = DB::conn()->query('SELECT COUNT(*) AS total FROM admins');
        $count = (int)$stmt->fetch()['total'];
        if ($count === 0) {
            $hash = password_hash('Admin@1234', PASSWORD_DEFAULT);
            $stmt = DB::conn()->prepare(
                'INSERT INTO admins (nombre, email, password_hash, activo, created_at) VALUES (?,?,?,?,NOW())'
            );
            $stmt->execute(['Administrador', 'admin@tjaech.gob.mx', $hash, 1]);
            $adminId = (int)DB::conn()->lastInsertId();
            self::setRoles($adminId, ['ADMIN']);
        }
    }

    public static function updateLastLogin(int $id): void {
        $stmt = DB::conn()->prepare('UPDATE admins SET last_login_at = NOW() WHERE id = ?');
        $stmt->execute([$id]);
    }
}


