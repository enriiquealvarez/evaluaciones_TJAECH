---
description: "General instructions for the TJAECH Evaluations System"
---

# TJAECH Evaluations System - Instrucciones para Copilot

## Project Overview
Sistema de evaluaciones y cursos para el Tribunal de Justicia Administrativa del Estado de Chiapas (TJAECH).

## Technology Stack
- **Framework**: PHP custom (MVC)
- **Database**: MySQL/MariaDB
- **Frontend**: Vanilla JS, Bootstrap CSS
- **Server**: Apache/Nginx (Laragon compatible)

## Project Structure
```
app/
  ├── Controllers/      # Lógica de negocio
  ├── Models/          # Acceso a datos
  ├── Views/           # Plantillas PHP
  ├── Core/            # Funciones core (Router, DB, Mailer, etc)
  └── Middlewares/     # Autenticación, CSRF
config/               # Configuración (mail, database)
database/             # Migraciones y schema
public/               # Punto de entrada, assets
storage/              # Archivos subidos, logs
```

## Important Modules

### Authentication
- **Controller**: `AdminAuthController.php` y `AdminDashboardController.php`
- **Middleware**: `AuthMiddleware.php`
- **Routes**: Login, logout, forgot password, reset password

### Courses (Cursos)
- **Controller**: `CourseController.php`
- **Model**: `Curso.php`, `CursoArchivo.php`
- **Views**: `admin/cursos/`, `public/curso_registro.php`

### Evaluations
- **Controller**: `EvaluationBuilderController.php`
- **Model**: `Evaluacion.php`, `Pregunta.php`, `OpcionPregunta.php`
- **Views**: `admin/evaluaciones/`, builder interface

### Results & Scoring
- **Controller**: `ResultsController.php`
- **Model**: `Respuesta.php`, `RespuestaDetalle.php`
- **Views**: `admin/resultados/`

### Satisfaction Survey
- **Controller**: `SatisfaccionController.php`
- **Model**: `EncuestaSatisfaccion.php`
- **Views**: `satisfaccion_form.php`

## Naming Conventions
- **Classes**: PascalCase (e.g., `AdminAuthController`, `CourseModel`)
- **Methods**: camelCase (e.g., `sendResetLink()`, `validateToken()`)
- **Database tables**: snake_case (e.g., `admin_password_resets`)
- **Database columns**: snake_case (e.g., `created_at`, `user_id`)
- **PHP files**: PascalCase matching class name
- **Views**: snake_case.php (e.g., `forgot_password.php`)

## Code Style
- 4 spaces for indentation
- Semicolons required
- Type hints where possible
- Return type declarations
- PHPDoc comments for public methods

## Custom Agents Available
- **Copy Password Recovery**: Copia la funcionalidad de recuperación de contraseña a otro proyecto
  - Ask: "Copy the password recovery functionality to the other project"

## Key Helper Functions
Located in `app/Core/helpers.php`:
- `redirect($url)` - Redirige a una URL
- `auth()` - Obtiene el usuario autenticado
- `csrf_token()` - Genera token CSRF
- `view($name, $data)` - Renderiza una vista
- `escape()` / `e()` - Escapa HTML

## Database Connection
```php
// En app/Core/DB.php
DB::query($sql, $params);
DB::first($sql, $params);  // Un resultado
DB::get($sql, $params);    // Múltiples resultados
```

## Email Configuration
Ubicado en `config/mail.php` - Utiliza SMTP configurado en `.env`

## Important Files to Know
- `index.php` - Bootstrap del sistema
- `public/index.php` - Punto de entrada HTTP
- `app/Core/Router.php` - Manejo de rutas
- `app/Core/DB.php` - Abstracción de base de datos
- `app/Middlewares/AuthMiddleware.php` - Protección de rutas

## Common Tasks

### Adding a new route
Edit `routes` definition in `Router.php` or bootstrap section

### Creating a new page
1. Crear Controlador en `app/Controllers/`
2. Crear Modelo en `app/Models/` si necesita datos
3. Crear Vista(s) en `app/Views/`
4. Registrar ruta
5. Aplicar middleware si es necesario

### Database migrations
Place SQL files in `database/` and run manually via PHP scripts in `public/`

## Security Best Practices
✅ Siempre usar prepared statements
✅ Sanitizar entrada de usuarios
✅ Validar lado servidor
✅ CSRF token en todos los formularios POST
✅ Contraseñas con hash (usar `password_hash()`)
✅ Rate limiting en login y recuperación de contraseña
✅ Logging de acciones sensibles

## Performance Notes
- Caché de consultas mediante DB::query()
- Assets servidos desde `/public/assets/`
- Uploads servidos desde `/public/uploads/`
- Logs en `/public/logs/`

## Debugging Tips
- Enable debug mode in `.env` for detailed errors
- Check `/public/logs/` for application logs
- Use `var_dump()` or `dd()` helper (if available) for debugging
- Database queries logged in development mode
