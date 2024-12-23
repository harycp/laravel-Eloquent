<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i = 0; $i < 4; $i++){
            $result[] = [
                "id" => Str::uuid(),
                "name" => "Voucher $i",
                "discount" => 10,
                "voucher_code" => Str::random(10)
            ];
        }
        Voucher::insert($result);
    }
}
