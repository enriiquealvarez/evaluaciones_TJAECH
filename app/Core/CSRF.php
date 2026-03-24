<?php
// app/Core/CSRF.php
class CSRF {
    public static function token(): string {
        $token = Session::get('_csrf');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            Session::set('_csrf', $token);
        }
        return $token;
    }

    public static function validate(?string $token): bool {
        $stored = Session::get('_csrf');
        return $stored && $token && hash_equals($stored, $token);
    }
}


