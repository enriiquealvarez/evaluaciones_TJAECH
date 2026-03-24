<?php
// app/Controllers/AdminAuthController.php
class AdminAuthController extends BaseController {
    public function showLogin(): void {
        try {
            Admin::ensureDefault();
        } catch (Throwable $e) {
            error_log($e->getMessage());
        }
        $this->render('admin/login', [
            'error' => Session::flash('error'),
            'flash' => Session::flash('flash')
        ], 'admin');
    }

    public function showForgot(): void {
        $this->render('admin/forgot', [
            'flash' => Session::flash('flash')
        ], 'admin');
    }

    public function requestCode(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('flash', 'Token invalido.');
            redirect('/admin/forgot');
        }
        $email = trim($_POST['email'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('flash', 'Correo invalido.');
            redirect('/admin/forgot');
        }
        try {
            $admin = Admin::findByEmailAny($email);
            if ($admin) {
                $code = (string)random_int(100000, 999999);
                AdminPasswordReset::create((int)$admin['id'], $email, $code, 15);
                $mailer = new Mailer();
                $subject = 'Recuperacion de acceso - Sistema de Evaluacion de Capacitaciones TJAECH';
                $name = $admin['nombre'] ?? $email;
                $html = $this->buildResetEmail($name, $code);
                $mailer->send($email, $name, $subject, $html);
            }
        } catch (Throwable $e) {
            error_log($e->getMessage());
        }
        Session::flash('flash', 'Si el correo existe, enviaremos un codigo de recuperacion.');
        redirect('/admin/forgot');
    }

    public function showReset(): void {
        $this->render('admin/reset', [
            'flash' => Session::flash('flash')
        ], 'admin');
    }

    public function resetPassword(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('flash', 'Token invalido.');
            redirect('/admin/reset');
        }
        $email = trim($_POST['email'] ?? '');
        $code = trim($_POST['code'] ?? '');
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password_confirm'] ?? '';
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('flash', 'Correo invalido.');
            redirect('/admin/reset');
        }
        $admin = Admin::findByEmailAny($email);
        if (!$admin) {
            Session::flash('flash', 'Correo invalido.');
            redirect('/admin/reset');
        }
        if ($code === '' || !preg_match('/^\d{6}$/', $code)) {
            Session::flash('flash', 'Codigo invalido.');
            redirect('/admin/reset');
        }
        if ($password === '' || strlen($password) < 8) {
            Session::flash('flash', 'La contrasena debe tener al menos 8 caracteres.');
            redirect('/admin/reset');
        }
        if ($password !== $password2) {
            Session::flash('flash', 'Las contrasenas no coinciden.');
            redirect('/admin/reset');
        }
        try {
            if (!AdminPasswordReset::verify((int)$admin['id'], $code)) {
                Session::flash('flash', 'Codigo invalido o vencido.');
                redirect('/admin/reset');
            }
            Admin::updatePasswordByEmail($email, $password);
            AdminPasswordReset::markUsed((int)$admin['id']);
            Session::flash('flash', 'Contrasena actualizada. Ya puedes iniciar sesion.');
            redirect('/admin/login');
        } catch (Throwable $e) {
            error_log($e->getMessage());
            Session::flash('flash', 'No se pudo completar la operacion. Intenta mas tarde.');
            redirect('/admin/reset');
        }
    }

    private function buildResetEmail(string $name, string $code): string {
        $safeName = e($name);
        $safeCode = e($code);
        return <<<HTML
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recuperacion de acceso</title>
</head>
<body style="margin:0;background:#f5f6f9;font-family:Arial,sans-serif;color:#1a1a1a;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="560" cellspacing="0" cellpadding="0" style="background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e6d7b3;">
          <tr>
            <td style="background:#1b3f66;color:#fff;padding:18px 24px;">
              <strong>Sistema de Evaluacion de Capacitaciones TJAECH</strong><br>
              <span style="font-size:12px;opacity:0.9;">Tribunal de Justicia Administrativa del Estado de Chiapas</span>
            </td>
          </tr>
          <tr>
            <td style="padding:24px 24px 8px;">
              <h2 style="margin:0 0 8px 0;">Recuperacion de acceso</h2>
              <p style="margin:0 0 12px 0;">Hola {$safeName},</p>
              <p style="margin:0 0 12px 0;">Se recibio una solicitud para restablecer la contrasena de tu cuenta. Para continuar, ingresa el siguiente codigo de verificacion:</p>
            </td>
          </tr>
          <tr>
            <td align="center" style="padding:8px 24px 16px;">
              <div style="display:inline-block;padding:10px 20px;border:2px dashed #d9c08d;border-radius:12px;font-size:24px;letter-spacing:4px;font-weight:700;">{$safeCode}</div>
            </td>
          </tr>
          <tr>
            <td style="padding:0 24px 18px;">
              <p style="margin:0;font-size:13px;color:#334;">Vigencia del codigo: 15 minutos.</p>
              <p style="margin:8px 0 0 0;font-size:13px;color:#334;">Si no solicitaste este cambio, puedes ignorar este mensaje.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:14px 24px;background:#faf7ef;font-size:12px;color:#334;">
              Area de Informatica - Tribunal de Justicia Administrativa del Estado de Chiapas
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
    }

    public function login(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token invalido.');
            redirect('/admin/login');
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $admin = Admin::findByEmail($email);
        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            Session::flash('error', 'Credenciales invalidas.');
            redirect('/admin/login');
        }
        Session::regenerate();
        Session::set('admin_id', $admin['id']);
        Session::set('admin_roles', Admin::rolesByAdmin((int)$admin['id']));
        Admin::updateLastLogin((int)$admin['id']);
        redirect('/admin');
    }

    public function logout(): void {
        if (!CSRF::validate($_POST['_csrf'] ?? null)) {
            Session::flash('error', 'Token invalido.');
            redirect('/admin');
        }
        Session::remove('admin_id');
        Session::remove('admin_roles');
        redirect('/admin/login');
    }
}
