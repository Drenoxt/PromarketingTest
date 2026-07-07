# Player Notes

Internal module that lets support agents leave notes about players. Built with
**Laravel 13 · Livewire 4 · spatie/laravel-permission**, following the repository
pattern and role-based access control.

## Features

- List a player's notes (date, author, content), newest first.
- Add a note through a Livewire form with validation (required, max 1000 chars).
- The list refreshes automatically after a save — no page reload.
- The "Add note" form is only shown to users with the right permission, and the
  server re-checks it on save.
- Admin dashboard aggregating every note across all players.

## Architecture

| Layer | Where | Notes |
|-------|-------|-------|
| Data | `app/Models/{Player,PlayerNote,User,Role}.php` | Relations: a note belongs to a player and to an author (`User`). |
| Repository | `app/Repositories/**` | `PlayerNoteRepositoryInterface` + Eloquent implementation, bound in `RepositoryServiceProvider`. Components depend on the interface (DI), not the concrete class. |
| Livewire | `app/Livewire/{CreatePlayerNote,PlayerNoteList}.php` | The form **emits** `note-created`; the list **listens** and refreshes via `$refresh`. |
| Access control | `app/Enums/{RoleName,PermissionName}.php` | Role and permission names live in enums — no magic strings. Roles carry a UUID and expose only that (never the integer id). |

## Roles

| Role | View notes | Add notes | Dashboard |
|------|:----------:|:---------:|:---------:|
| `admin` | ✅ | — | ✅ |
| `agent` | ✅ | ✅ | — |
| `viewer` | ✅ | — | — |

## Setup

```bash
composer install
npm install && npm run build
php artisan migrate:fresh --seed
php artisan serve
```

Seeded demo accounts (password from `DEMO_PASSWORD` in `.env`, default `1234$`):

- `admin@example.com` — reviews notes + dashboard
- `agent@example.com` — views and adds notes
- `viewer@example.com` — read-only

## Tests

```bash
php artisan test --filter=PlayerNotes
```

Covers note persistence, empty-note validation, and the list refreshing on the
emitted event. Runs on an in-memory SQLite connection.
