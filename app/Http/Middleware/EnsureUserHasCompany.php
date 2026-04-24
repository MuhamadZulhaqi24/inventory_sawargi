<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasCompany
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan proses logout tetap berjalan meskipun akun ditangguhkan
        if ($request->routeIs('logout')) {
            return $next($request);
        }

        if (Auth::check()) {
            $user = Auth::user();

            // 1. Super Admin selalu lolos (Dewa Platform)
            if ($user->is_super_admin) {
                return $next($request);
            }

            // 2. Cek Global Maintenance Mode
            if (\App\Models\Setting::getGlobal('maintenance_mode') === '1') {
                return response()->view('errors.maintenance', [
                    'message' => \App\Models\Setting::getGlobal('maintenance_message', 'Sistem sedang dalam pemeliharaan rutin.')
                ], 503);
            }

            // 3. Cek apakah user punya perusahaan
            if (!$user->company_id || !$user->company) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak terikat dengan perusahaan manapun.');
            }

            $company = $user->company;

            // 3. Cek Status Perusahaan
            if ($company->status !== 'active') {
                return response()->view('errors.suspended', [
                    'title' => 'Akun Ditangguhkan',
                    'message' => 'Maaf, akses perusahaan Anda telah dinonaktifkan oleh Administrator Platform.'
                ], 403);
            }

            // 4. Cek Masa Berlaku (Expired)
            if ($company->expired_at && $company->expired_at->isPast()) {
                return response()->view('errors.suspended', [
                    'title' => 'Masa Aktif Habis',
                    'message' => 'Masa berlaku langganan Anda telah habis pada ' . $company->expired_at->format('d M Y') . '. Silakan hubungi Administrator untuk perpanjangan.'
                ], 403);
            }
        }

        return $next($request);
    }
}
