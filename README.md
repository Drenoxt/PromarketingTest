# Player Notes

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
