# Toastmasters Club Management (Laravel + Backpack PRO)

Gestión de clubes Toastmasters: miembros, sesiones, discursos, evaluaciones, roles, asistencia, visitantes, comité ejecutivo y metas DCP; incluye reportes básicos.

## Requisitos
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/MariaDB o PostgreSQL

## Instalación
```bash
cp .env.example .env
composer install
php artisan key:generate
# Configura DB_* en .env
php artisan migrate --seed
npm install && npm run build
php artisan serve
```
Panel de administración: `/admin`

**Usuario semilla:**
- Email: `admin@example.com`
- Password: `password` (cámbialo)

## Reportes
`/admin/reports/overview` — KPIs: Miembros, Sesiones/mes, Discursos/mes, Asistencia promedio.

## Nuevas tablas
- `member_progress`
- `pathways_projects`

## Rutas de CRUD
Generadas en `routes/backpack/custom.php` para todos los CrudControllers en `App\Http\Controllers\Admin`.

## Sidebar (Backpack)
El menú lateral se sobreescribe en `resources/views/vendor/backpack/ui/inc/menu_items.blade.php` e incluye todos los CRUDs detectados y el enlace a Reportes.





## Explicacion de diagrama de rutas

🌍 Usuario (URL: /admin/dashboard)
               │
               ▼
📌 Route: busca coincidencia en rutas
(Route::get('dashboard', [DashboardController::class, 'index']))
               │
               ▼
🛡️ Middleware: filtros de acceso
 - web  → sesiones, cookies, CSRF
 - auth → debe estar logueado
 - role → (opcional) verificar rol
               │
               ▼
🧭 Controller
App\Http\Controllers\Admin\DashboardController
               │
               ▼
🛠️ Método (acción)
index() → return view('dashboard')
               │
               ▼
🎨 Respuesta
HTML (vista), JSON o Redirección
