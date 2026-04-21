<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'permissions',
        'is_default',
        'is_immutable',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_default' => 'boolean',
        'is_immutable' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        $perms = $this->permissions;
        
        if (empty($perms)) {
            return false;
        }

        // Handle flat array: ['access_pos', 'view_reports']
        if (isset($perms[0])) {
            return in_array($permission, $perms);
        }

        // Handle associative array: ['access_pos' => true]
        return isset($perms[$permission]) && ($perms[$permission] === true || $perms[$permission] === "1" || $perms[$permission] === 1);
    }
}
