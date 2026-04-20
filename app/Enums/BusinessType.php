<?php

namespace App\Enums;

enum BusinessType: string
{
    case RETAIL = 'retail';
    case HEALTH = 'health';
    case LIBRARY = 'library';

    public function labels(): array
    {
        return match($this) {
            self::RETAIL => [
                'customer' => 'Pelanggan',
                'product' => 'Produk',
                'sale' => 'Penjualan',
                'supplier' => 'Pemasok',
            ],
            self::HEALTH => [
                'customer' => 'Pasien',
                'product' => 'Obat/Layanan',
                'sale' => 'Rekam Medis/Transaksi',
                'supplier' => 'Distributor Farmasi',
            ],
            self::LIBRARY => [
                'customer' => 'Anggota',
                'product' => 'Buku',
                'sale' => 'Peminjaman',
                'supplier' => 'Penerbit',
            ],
        };
    }
}
