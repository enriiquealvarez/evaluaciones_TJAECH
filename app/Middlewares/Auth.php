<?php
// app/Middlewares/Auth.php
class AuthMiddleware {
    public static function requireAdmin(): void {
        if (!Session::get('admin_id')) {
            Session::flash('error', 'Debe iniciar sesión.');
            redirect('/admin/login');
        }
    }
}


