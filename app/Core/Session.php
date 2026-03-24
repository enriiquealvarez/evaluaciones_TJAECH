<?php
// app/Core/Session.php
class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            $secure = Env::get('SESSION_SECURE', 'false') === 'true';
            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'httponly' => true,
                'secure' => $secure,
                'samesite' => 'Lax'
            ]);
            session_start();
        }
    }

    public static function set(string $key, $value): void {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove(string $key): void {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, $value = null) {
        if ($value === null) {
            $val = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $val;
        }
        $_SESSION['_flash'][$key] = $value;
        return null;
    }

    public static function regenerate(): void {
        session_regenerate_id(true);
    }
}


