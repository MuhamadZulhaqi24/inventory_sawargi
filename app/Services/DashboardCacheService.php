<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class DashboardCacheService
{
    private const KEYS_TRACKER = 'dashboard_cache_keys_tracker';

    /**
     * Clear all tracked dashboard cache keys.
     */
    public function clearDashboardCache(): void
    {
        $keys = Cache::get(self::KEYS_TRACKER, []);
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Also clear common keys that don't depend on date range
        Cache::forget('dashboard_low_stock');
        Cache::forget('dashboard_recent_sales');

        // Reset the tracker
        Cache::forget(self::KEYS_TRACKER);
    }

    /**
     * Track a cache key.
     */
    public static function trackKey(string $key): void
    {
        $keys = Cache::get(self::KEYS_TRACKER, []);
        if (!in_array($key, $keys)) {
            $keys[] = $key;
            Cache::forever(self::KEYS_TRACKER, $keys);
        }
    }
}
