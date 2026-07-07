<?php

namespace App\Enums;

/**
 * Single source of truth for permission names. Referenced everywhere instead of
 * raw strings so a rename happens in one place.
 */
enum PermissionName: string
{
    case ViewNotes = 'view player notes';
    case CreateNotes = 'create player notes';
    case ViewDashboard = 'view notes dashboard';
}
