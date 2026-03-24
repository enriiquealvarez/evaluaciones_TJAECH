<?php
// app/Controllers/AdminUsersController.php
class AdminUsersController extends BaseController {
    public function index(): void {
        AuthMiddleware::requireRole('users');
        $this->render('admin/usuarios/index', [
            'admins' => Admin::all(),
            'roles' => Admin::roleOptions(),
            'flash' => Session::flash('success'),
            'error' => Session::flash('error'),
        ], 'admin');
    }

    public function create(): void {
        AuthMiddleware::requireRole('users');
        $this->render('admin/usuarios/form', [
            'admin' => null,
            'roles' => Admin::roleOptions(),
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
        ], 'admin');
    }

    public function store(): void {
        AuthMiddleware::requireRole('users');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/usuarios');
        }
        $validator = new Validator();
        $validator->required('nombre', $_POST['nombre'] ?? '', 'Nombre obligatorio.');
        $validator->required('email', $_POST['email'] ?? '', 'Correo obligatorio.');
        $validator->email('email', $_POST['email'] ?? '', 'Correo inválido.');
        $validator->required('password', $_POST['password'] ?? '', 'Contraseña obligatoria.');
        $roles = $_POST['roles'] ?? [];
        if (!is_array($roles) || empty($roles)) {
            $validator->required('roles', '', 'Selecciona al menos un rol.');
        }
        $allowedRoles = array_keys(Admin::roleOptions());
        foreach ($roles as $role) {
            if (!in_array($role, $allowedRoles, true)) {
                $validator->required('roles', '', 'Rol inválido.');
                break;
            }
        }
        if (Admin::findByEmailAny(trim($_POST['email'] ?? ''))) {
            $validator->required('email', '', 'El correo ya está registrado.');
        }
        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/admin/usuarios/crear');
        }
        Admin::create([
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'roles' => $roles,
        ]);
        Session::flash('success', 'Usuario creado.');
        redirect('/admin/usuarios');
    }

    public function edit(): void {
        AuthMiddleware::requireRole('users');
        $id = (int)($_GET['id'] ?? 0);
        $admin = $id ? Admin::findById($id) : null;
        if (!$admin) {
            redirect('/admin/usuarios');
        }
        $admin['roles'] = Admin::rolesByAdmin($id);
        $this->render('admin/usuarios/form', [
            'admin' => $admin,
            'roles' => Admin::roleOptions(),
            'errors' => Session::flash('errors') ?? [],
            'old' => Session::flash('old') ?? [],
        ], 'admin');
    }

    public function update(): void {
        AuthMiddleware::requireRole('users');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/usuarios');
        }
        $id = (int)($_POST['id'] ?? 0);
        $admin = $id ? Admin::findById($id) : null;
        if (!$admin) {
            redirect('/admin/usuarios');
        }
        $validator = new Validator();
        $validator->required('nombre', $_POST['nombre'] ?? '', 'Nombre obligatorio.');
        $validator->required('email', $_POST['email'] ?? '', 'Correo obligatorio.');
        $validator->email('email', $_POST['email'] ?? '', 'Correo inválido.');
        $roles = $_POST['roles'] ?? [];
        if (!is_array($roles) || empty($roles)) {
            $validator->required('roles', '', 'Selecciona al menos un rol.');
        }
        $allowedRoles = array_keys(Admin::roleOptions());
        foreach ($roles as $role) {
            if (!in_array($role, $allowedRoles, true)) {
                $validator->required('roles', '', 'Rol inválido.');
                break;
            }
        }
        $existing = Admin::findByEmailAny(trim($_POST['email'] ?? ''));
        if ($existing && (int)$existing['id'] !== $id) {
            $validator->required('email', '', 'El correo ya está registrado.');
        }
        if ($validator->hasErrors()) {
            Session::flash('errors', $validator->errors());
            Session::flash('old', $_POST);
            redirect('/admin/usuarios/editar?id=' . $id);
        }
        Admin::update($id, [
            'nombre' => trim($_POST['nombre']),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'] ?? '',
            'activo' => isset($_POST['activo']) ? 1 : 0,
            'roles' => $roles,
        ]);
        Session::flash('success', 'Usuario actualizado.');
        redirect('/admin/usuarios');
    }

    public function toggleStatus(): void {
        AuthMiddleware::requireRole('users');
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token inválido.');
            redirect('/admin/usuarios');
        }
        $id = (int)($_POST['id'] ?? 0);
        $activo = (int)($_POST['activo'] ?? 0);
        if ($id && $id === (int)Session::get('admin_id')) {
            Session::flash('error', 'No puedes desactivar tu propio usuario.');
            redirect('/admin/usuarios');
        }
        if ($id) {
            Admin::setStatus($id, $activo);
        }
        Session::flash('success', 'Estado actualizado.');
        redirect('/admin/usuarios');
    }
}
