<?php

if (!function_exists('t_label')) {
    /**
     * Get tenant aware label based on business type and current locale.
     *
     * @param string $key
     * @return string
     */
    function t_label(string $key): string {
        return \App\Helpers\TenantHelper::getLabel($key);
    }
}
