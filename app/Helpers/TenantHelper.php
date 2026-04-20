<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class TenantHelper
{
    public static function getLabel(string $key): string
    {
        $user = Auth::user();
        $businessType = 'retail';

        if ($user && $user->company_id) {
            $businessType = $user->company->business_type;
        }

        // Memanggil file lang/messages.php bagian business.[tipe].[key]
        // Contoh: messages.business.health.customer
        $langKey = "messages.business.{$businessType}.{$key}";
        
        // Cek apakah translasi ada, jika tidak gunakan default key
        $label = __($langKey);

        return $label === $langKey ? $key : $label;
    }

    public static function getBusinessType(): string
    {
        $user = Auth::user();
        return $user && $user->company_id ? $user->company->business_type : 'retail';
    }
}
