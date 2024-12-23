<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Database\Seeders\VoucherSeeder;
use Illuminate\Support\Facades\Log;
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

        $voucher = Voucher::where("name", "Voucher 1")->first();
        $voucher->delete();

        $result = Voucher::where("name", "Voucher 1")->first();
        self::assertNull($result);
    }

    public function testQuerySoftDelete()
    {
        $this->seed(VoucherSeeder::class);

        $voucher = Voucher::where("name", "Voucher 1")->first();
        $voucher->delete();
        
        $result = Voucher::withTrashed()->get();
        self::assertCount(4, $result);
        Log::info($result);
    }
}
