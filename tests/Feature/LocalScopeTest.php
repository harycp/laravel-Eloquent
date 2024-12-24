<?php

namespace Tests\Feature;

use App\Models\Voucher;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class LocalScopeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::table('vouchers')->delete();
    }

    public function testLocalScope()
    {
        $voucher = new Voucher();

        $voucher->name = "Voucher 2";
        $voucher->discount = "20%";
        $voucher->is_active = true;
        $voucher->save();

        $total = Voucher::active()->count();
        self::assertEquals(1, $total);

        $total = Voucher::nonActive()->count();
        self::assertEquals(0, $total);

        Log::info("Voucher 2 is active: " . $voucher->is_active);

    }
}
