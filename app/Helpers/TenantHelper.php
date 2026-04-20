<?php

namespace App\Helpers;

use App\Enums\BusinessType;
use Illuminate\Support\Facades\Auth;

class TenantHelper
{
    public static function getLabel(string $key): string
    {
        $user = Auth::user();
        if (!$user || !$user->company_id) {
            // Default to RETAIL labels for super admin or unassigned users
            return BusinessType::RETAIL->labels()[$key] ?? $key;
        }

        $businessType = BusinessType::from($user->company->business_type);
        return $businessType->labels()[$key] ?? $key;
    }

    public static function getBusinessType(): string
    {
        $user = Auth::user();
        return $user && $user->company_id ? $user->company->business_type : 'retail';
    }
}
