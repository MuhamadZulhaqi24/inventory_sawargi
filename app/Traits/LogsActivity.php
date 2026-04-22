<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Record a new activity log.
     */
    protected function recordActivity(string $action, string $module, string $description): void
    {
        if (Auth::check()) {
            ActivityLog::create([
                'company_id' => Auth::user()->company_id,
                'user_id' => Auth::id(),
                'action' => $action,
                'module' => $module,
                'description' => $description,
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        }
    }
}
