<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::set('store_name', 'TB. Sawargi Jaya');
        Setting::set('store_address', 'Jl. Koperasi No.1B, Kertasari, Kec. Ciamis, Kabupaten Ciamis, Jawa Barat 46213');
        Setting::set('store_phone', '0265426243');
        Setting::set('opening_balance_date', now()->startOfYear()->toDateString());
        Setting::set('opening_balance_amount', '10000000');
    }
}
