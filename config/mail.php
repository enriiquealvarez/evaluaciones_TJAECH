<?php
$env = static function ($key, $default = null) {
    return Env::get($key, $default);
};
$boolEnv = static function ($key, $default = false) {
    $value = Env::get($key, null);
    if ($value === null) {
        return $default;
    }
    $value = strtolower(trim((string)$value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
};

return [
    'mode' => $env('MAIL_MODE', 'log'),
    'host' => $env('MAIL_HOST', 'mail.tjaech.gob.mx'),
    'port' => (int)$env('MAIL_PORT', 465),
    'encryption' => $env('MAIL_ENCRYPTION', 'ssl'),
    'username' => $env('MAIL_USERNAME', 'informatica@tjaech.gob.mx'),
    'password' => $env('MAIL_PASSWORD', ''),
    'from_email' => $env('MAIL_FROM_EMAIL', 'informatica@tjaech.gob.mx'),
    'from_name' => $env('MAIL_FROM_NAME', 'Informatica - Soporte del Area de Informatica'),
    'app_url' => $env('APP_URL', 'http://localhost'),
    'log_path' => $env('MAIL_LOG_PATH', __DIR__ . '/../storage/mail.log'),
    'log_errors' => $boolEnv('MAIL_LOG_ERRORS', false),
];
