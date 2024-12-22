<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucher = new Voucher();

        $voucher->name = "Sebelas";
        $voucher->discount = "11%";
        $voucher->voucher_code = "SEBELAS-11";
        $voucher->save();
    }
}
