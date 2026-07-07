<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // The uuid is the role's public identifier; the integer id never leaves the backend.
    protected $hidden = ['id'];

    protected static function booted(): void
    {
        static::creating(function (Role $role): void {
            $role->uuid ??= (string) Str::uuid();
        });
    }

    // Route-model binding resolves roles by uuid, so URLs/API never expose the id.
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
