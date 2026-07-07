<?php

namespace App\Enums;

/**
 * Roles and the permissions each one grants. Seeders build straight from here,
 * so there are no role/permission strings hardcoded anywhere else.
 */
enum RoleName: string
{
    case Admin = 'admin';
    case Agent = 'agent';
    case Viewer = 'viewer';

    /**
     * @return PermissionName[]
     */
    public function permissions(): array
    {
        return match ($this) {
            self::Admin => [PermissionName::ViewNotes, PermissionName::ViewDashboard],
            self::Agent => [PermissionName::ViewNotes, PermissionName::CreateNotes],
            self::Viewer => [PermissionName::ViewNotes],
        };
    }
}
