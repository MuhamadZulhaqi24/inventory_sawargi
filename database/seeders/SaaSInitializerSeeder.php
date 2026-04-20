<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SaaSInitializerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Super Admin (Kamu)
        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'email' => 'superadmin@gemini.com',
                'name' => 'Super Admin Platform',
                'password' => Hash::make('password'),
                'is_super_admin' => true,
                'company_id' => null,
            ]
        );

        // 2. Buat Contoh Perusahaan (Klinik)
        $klinik = Company::updateOrCreate(
            ['slug' => 'klinik-sehat'],
            [
                'name' => 'Klinik Sehat Sejahtera',
                'business_type' => 'health',
                'status' => 'active',
                'expired_at' => now()->addYear(),
            ]
        );

        // 3. Buat User untuk Klinik tersebut
        User::updateOrCreate(
            ['username' => 'adminklinik'],
            [
                'email' => 'admin.klinik@example.com',
                'name' => 'Admin Klinik Sehat',
                'password' => Hash::make('password'),
                'is_super_admin' => false,
                'company_id' => $klinik->id,
            ]
        );

        // 4. Buat Contoh Perusahaan (Toko Retail)
        $toko = Company::updateOrCreate(
            ['slug' => 'toko-material'],
            [
                'name' => 'Toko Material Jaya',
                'business_type' => 'retail',
                'status' => 'active',
                'expired_at' => now()->addYear(),
            ]
        );

        User::updateOrCreate(
            ['username' => 'admintoko'],
            [
                'email' => 'admin.toko@example.com',
                'name' => 'Admin Toko Material',
                'password' => Hash::make('password'),
                'is_super_admin' => false,
                'company_id' => $toko->id,
            ]
        );
    }
}
