---
name: "Password Recovery Instructions"
applyTo: "**/AdminPasswordReset*,**/forgot.php,**/reset.php,**/*auth*password*"
description: "Project-specific conventions for password recovery and authentication modules. Contains database schema, email config, and validation rules."
---

# Password Recovery Module - Proyecto Evaluaciones TJAECH

## Current Implementation Status

### Source System (evaluaciones.tjaech.gob.mx)
✅ **100% Implementado y funcional**

- **Controller**: `AdminAuthController::forgotPassword()`, `resetPassword()`
- **Model**: `AdminPasswordReset.php` - maneja tokens y validación
- **Views**: 
  - `forgot.php` - Formulario de email
  - `reset.php` - Formulario de nueva contraseña
- **Database**: Tabla `admin_password_resets` con campos:
  - `id`, `email`, `token`, `created_at`, `expires_at`
- **Mailer**: Configurado en `config/mail.php`

### Target System (tjaech_transparencia_combinado)
Necesita la funcionalidad completa copiada y adaptada

## Database Schema

```sql
CREATE TABLE admin_password_resets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    used BOOLEAN DEFAULT FALSE,
    INDEX (email, token)
);
```

## Email Configuration

Ubicación: `config/mail.php`

```php
// Template para email de recuperación
return [
    'from' => 'no-reply@tjaech.gob.mx',
    'subject' => 'Recupera tu contraseña - TJAECH',
    'template' => 'emails/password-reset',
];
```

## Token Generation & Validation

- Tokens: `bin2hex(random_bytes(32))` - 64 caracteres hexadecimales
- Expiración: 1 hora por defecto
- Validación: Verificar email + token + no expirado + no usado

## Routes Pattern

```php
// Sistema actual
Route::post('/forgot-password', 'AdminAuthController@sendResetLink');
Route::get('/reset/:token', 'AdminAuthController@showResetForm');
Route::post('/reset', 'AdminAuthController@updatePassword');
```

## Security Considerations

1. **Rate limiting**: Máximo 3 intentos por email/hora
2. **Token usage**: Solo se usa una vez
3. **Email verification**: Verificar que el email existe antes de enviar
4. **Logging**: Registrar intentos fallidos
5. **CSRF protection**: Todos los formularios con token CSRF

## Validation Rules

```php
// Email
- Requerido
- Formato válido de email
- Debe existir en tabla admin

// Password (nuevo)
- Requerido
- Mínimo 8 caracteres
- Debe incluir mayúscula, minúscula, número
- No igual a la contraseña anterior

// Token
- Requerido
- Debe existir y ser válido
- No debe estar expirado
- No debe haber sido usado
```

## Error Handling

| Error | Mensaje |
|-------|---------|
| Email no existe | "No encontramos una cuenta con ese email" |
| Token inválido | "El enlace de recuperación es inválido o ha expirado" |
| Token expirado | "El enlace de recuperación ha expirado. Solicita uno nuevo" |
| Contraseña débil | "La contraseña no cumple los requisitos de seguridad" |
| Rate limit | "Demasiados intentos. Intenta más tarde" |

## Copy Instructions for Target Project

When copying to `tjaech_transparencia_combinado`:

1. **Adapt class names** if naming convention differs
2. **Update namespace** to match target project
3. **Verify Mailer config** is set up in target
4. **Database migration** must be created and run
5. **Routes** must be registered in target's router
6. **Email templates** must be created in target's templates folder
7. **Frontend assets** (CSS/JS) may need adjusting to match target design

## Testing Checklist

- [ ] Email field validates correctly
- [ ] Reset link is generated and sent
- [ ] Token expires after 1 hour
- [ ] Invalid tokens are rejected
- [ ] Password validation rules enforced
- [ ] Successful reset redirects to login
- [ ] Rate limiting works (max 3/hour)
- [ ] Email appears in logs
