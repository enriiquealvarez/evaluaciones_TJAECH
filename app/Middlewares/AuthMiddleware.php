<?php
// app/Middlewares/AuthMiddleware.php
class AuthMiddleware {
    private static array $roleMap = [
        'ADMIN' => ['*'],
        'COURSES' => ['courses'],
        'EVALUATIONS' => ['evaluations'],
        'RESULTS' => ['results'],
        'USERS' => ['users'],
    ];

    public static function requireAdmin(): void {
        if (!Session::get('admin_id')) {
            Session::flash('error', 'Debe iniciar sesión.');
            redirect('/admin/login');
        }
    }

    public static function roles(): array {
        $adminId = (int)Session::get('admin_id');
        if (!$adminId) {
            return [];
        }
        $roles = Session::get('admin_roles');
        if (is_array($roles) && $roles) {
            return $roles;
        }
        $roles = Admin::rolesByAdmin($adminId);
        Session::set('admin_roles', $roles);
        return $roles;
    }

    public static function can(string $capability): bool {
        $roles = self::roles();
        foreach ($roles as $role) {
            $caps = self::$roleMap[$role] ?? [];
            if (in_array('*', $caps, true) || in_array($capability, $caps, true)) {
                return true;
            }
        }
        return false;
    }

    public static function requireRole(string $capability): void {
        self::requireAdmin();
        if (!self::can($capability)) {
            Session::flash('error', 'No tienes permisos para esta sección.');
            redirect('/admin');
        }
    }
}
