<?php
// app/Models/AdminPasswordReset.php
class AdminPasswordReset {
    public static function ensureTable(): void {
        $sql = "CREATE TABLE IF NOT EXISTS admin_password_resets (
            id INT AUTO_INCREMENT PRIMARY KEY,
            admin_id INT NOT NULL,
            email VARCHAR(190) NOT NULL,
            token_hash VARCHAR(255) NOT NULL,
            expires_at DATETIME NOT NULL,
            used_at DATETIME NULL,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            INDEX (admin_id),
            INDEX (email),
            INDEX (expires_at),
            CONSTRAINT admin_password_resets_ibfk_1 FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        DB::conn()->exec($sql);
    }

    public static function create(int $adminId, string $email, string $code, int $minutes): void {
        self::ensureTable();
        $hash = password_hash($code, PASSWORD_DEFAULT);
        $stmt = DB::conn()->prepare(
            "INSERT INTO admin_password_resets (admin_id, email, token_hash, expires_at) VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE))"
        );
        $stmt->execute([$adminId, $email, $hash, $minutes]);
    }

    public static function verify(int $adminId, string $code): bool {
        self::ensureTable();
        $stmt = DB::conn()->prepare(
            "SELECT * FROM admin_password_resets WHERE admin_id = ? AND used_at IS NULL AND expires_at > NOW() ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([$adminId]);
        $row = $stmt->fetch();
        if (!$row) {
            return false;
        }
        return password_verify($code, $row['token_hash']);
    }

    public static function markUsed(int $adminId): void {
        self::ensureTable();
        $stmt = DB::conn()->prepare(
            "UPDATE admin_password_resets SET used_at = NOW() WHERE admin_id = ? AND used_at IS NULL"
        );
        $stmt->execute([$adminId]);
    }
}
