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
        // 1. Selalu izinkan route esensial untuk diakses
        if ($request->routeIs(['login', 'logout', 'password.*', 'language.switch'])) {
            return $next($request);
        }

        if (Auth::check()) {
            $user = Auth::user();

            // 2. Super Admin SELALU lolos (Bypass Maintenance & Tenant checks)
            if ($user->is_super_admin) {
                return $next($request);
            }

            // 3. Cek Global Maintenance Mode HANYA untuk user biasa
            if (\App\Models\Setting::getGlobal('maintenance_mode') === '1') {
                return response()->view('errors.maintenance', [
                    'message' => \App\Models\Setting::getGlobal('maintenance_message', 'Sistem sedang dalam pemeliharaan rutin.')
                ], 503);
            }

            // 4. Cek apakah user punya perusahaan
            if (!$user->company_id || !$user->company) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak terikat dengan perusahaan manapun.');
            }

            $company = $user->company;

            // 5. Cek Status Perusahaan
            if ($company->status !== 'active') {
                return response()->view('errors.suspended', [
                    'title' => 'Akun Ditangguhkan',
                    'message' => 'Maaf, akses perusahaan Anda telah dinonaktifkan oleh Administrator Platform.'
                ], 403);
            }

            // 6. Cek Masa Berlaku (Expired)
            if ($company->expired_at && $company->expired_at->isPast()) {
                return response()->view('errors.suspended', [
                    'title' => 'Masa Aktif Habis',
                    'message' => 'Masa berlaku langganan Anda telah habis pada ' . $company->expired_at->format('d M Y') . '. Silakan hubungi Administrator untuk perpanjangan.'
                ], 403);
            }
        } else {
            // Jika belum login, dan sistem sedang maintenance, cegah masuk ke landing page dashboard
            // Namun biarkan akses ke halaman login tetap terbuka
            if (\App\Models\Setting::getGlobal('maintenance_mode') === '1' && !$request->routeIs('login')) {
                 // Kamu bisa memutuskan apakah Guest boleh melihat Landing Page atau tidak saat maintenance
                 // Untuk keamanan SaaS, biasanya diarahkan ke maintenance jika mencoba akses area ber-auth
            }
        }

        return $next($request);
    }
}
