# Player Notes

*[Leer en español](README.es.md)*

Internal module that lets support agents leave and review notes about
individual players. Built with **Laravel 13 · Livewire 4 ·
spatie/laravel-permission**, following the repository pattern and
role-based access control.

## What it does

- Pick a player from an index and review their notes — date, author, and
  content — scoped to that player only.
- Add a note through a Livewire form: required, max 1000 characters,
  validated server-side.
- The list refreshes automatically after saving — no page reload.
- The "Add note" form only renders for users with the right permission; the
  server re-checks it on save regardless of what the UI shows.
- Admins get a dashboard aggregating every note across all players.
- Interface is available in English and Spanish, switchable at runtime.

## Architecture

| Layer | Where | Notes |
|-------|-------|-------|
| Data | `app/Models/{Player,PlayerNote,User,Role}.php` | A note belongs to a player and to an author (`User`). Players and roles are identified by UUID; the integer id never leaves the backend. |
| Repository | `app/Repositories/**` | `PlayerNoteRepositoryInterface` + Eloquent implementation, bound in `RepositoryServiceProvider`. Livewire components depend on the interface, not the concrete class. |
| Livewire | `app/Livewire/{CreatePlayerNote,PlayerNoteList}.php` | Two components communicate via `emit`/`listeners`: the form **dispatches** `note-created`, the list **listens** and refreshes via `$refresh` — no page reload. |
| Access control | `app/Enums/{RoleName,PermissionName}.php` | Role and permission names live in enums, not magic strings. |
| i18n | `lang/{en,es}/notes.php` | All UI strings translated; `SetLocale` middleware applies the language stored in session. |

## Roles

| Role | View notes | Add notes | Dashboard |
|------|:----------:|:---------:|:---------:|
| `admin` | ✅ | — | ✅ |
| `agent` | ✅ | ✅ | — |
| `viewer` | ✅ | — | — |

## Test accounts

Seeded automatically. Password for all three is `1234$` (configurable via
`DEMO_PASSWORD` in `.env`):

| Email | Password | Role |
|-------|----------|------|
| `admin@example.com` | `1234$` | admin |
| `agent@example.com` | `1234$` | agent |
| `viewer@example.com` | `1234$` | viewer |

Three demo players (`ninja_gaiden`, `shadow_fox`, `pixel_queen`) are seeded
as well, each with an independent notes list.

## Running the project

Requirements: PHP 8.3+, Composer, Node.js.

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
npm run build

php artisan serve
```

Open `http://localhost:8000`, sign in with any account above, and use the
language switcher (EN/ES) in the top bar or login screen.

## Tests

```bash
php artisan test
```

Covers note persistence, empty-note validation, and the list refreshing on
the emitted event. Runs on an in-memory SQLite connection, so no database
server is required.

# Player Notes

*[Read this in English](README.md)*

Módulo interno que permite a los agentes de soporte dejar y revisar notas
sobre jugadores individuales. Construido con **Laravel 13 · Livewire 4 ·
spatie/laravel-permission**, siguiendo el patrón de repositorio y control de
acceso basado en roles.

## Qué hace

- Elegir un jugador desde un índice y revisar sus notas — fecha, autor y
  contenido — acotadas a ese jugador específico.
- Agregar una nota mediante un formulario Livewire: obligatoria, máximo 1000
  caracteres, validada del lado del servidor.
- La lista se refresca automáticamente al guardar — sin recargar la página.
- El formulario "Agregar nota" solo se muestra a usuarios con el permiso
  correspondiente; el servidor lo revalida al guardar sin importar lo que
  muestre la interfaz.
- Los administradores tienen un dashboard con todas las notas de todos los
  jugadores.
- La interfaz está disponible en inglés y español, con cambio en tiempo real.

## Arquitectura

| Capa | Dónde | Notas |
|------|-------|-------|
| Datos | `app/Models/{Player,PlayerNote,User,Role}.php` | Una nota pertenece a un jugador y a un autor (`User`). Jugadores y roles se identifican por UUID; el id entero nunca sale del backend. |
| Repositorio | `app/Repositories/**` | `PlayerNoteRepositoryInterface` + implementación Eloquent, vinculada en `RepositoryServiceProvider`. Los componentes Livewire dependen de la interfaz, no de la clase concreta. |
| Livewire | `app/Livewire/{CreatePlayerNote,PlayerNoteList}.php` | Dos componentes se comunican vía `emit`/`listeners`: el formulario **emite** `note-created`, la lista **escucha** y se refresca con `$refresh` — sin recargar la página. |
| Control de acceso | `app/Enums/{RoleName,PermissionName}.php` | Los nombres de roles y permisos viven en enums, no como strings sueltos. |
| i18n | `lang/{en,es}/notes.php` | Todos los textos de la interfaz están traducidos; el middleware `SetLocale` aplica el idioma guardado en sesión. |

## Roles

| Rol | Ver notas | Agregar notas | Dashboard |
|-----|:---------:|:--------------:|:---------:|
| `admin` | ✅ | — | ✅ |
| `agent` | ✅ | ✅ | — |
| `viewer` | ✅ | — | — |

## Cuentas de prueba

Se crean automáticamente al sembrar. La contraseña de las tres es `1234$`
(configurable con `DEMO_PASSWORD` en `.env`):

| Email | Contraseña | Rol |
|-------|------------|-----|
| `admin@example.com` | `1234$` | admin |
| `agent@example.com` | `1234$` | agent |
| `viewer@example.com` | `1234$` | viewer |

También se siembran tres jugadores de prueba (`ninja_gaiden`, `shadow_fox`,
`pixel_queen`), cada uno con su propia lista de notas independiente.

## Cómo levantar el proyecto

Requisitos: PHP 8.3+, Composer, Node.js.

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
npm run build

php artisan serve
```

Abre `http://localhost:8000`, inicia sesión con cualquiera de las cuentas de
arriba, y usa el selector de idioma (EN/ES) en la barra superior o en la
pantalla de login.

## Tests

```bash
php artisan test
```

Cubre la persistencia de notas, la validación de nota vacía, y el refresco de
la lista al recibir el evento. Corre sobre una conexión SQLite en memoria, sin
necesitar un servidor de base de datos.
