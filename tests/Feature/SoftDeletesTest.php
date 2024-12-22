<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Database\Seeders\VoucherSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SoftDeletesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM vouchers');
    }

    public function testSoftDeletes()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where("name", "Sebelas")->first();
        $voucher->delete();

        $result = Voucher::where("name", "Sebelas")->first();
        self::assertNull($result);
        
    }
}
