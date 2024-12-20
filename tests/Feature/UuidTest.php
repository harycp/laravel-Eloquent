<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UuidTest extends TestCase
{
    public function setUp(): void
    {
        parent::setup();
        DB::table('vouchers')->delete();
    }

    public function testInsert()
    {
        $voucher = new Voucher();
        $voucher->name = "Sebelas-sebelas";
        $voucher->discount = "20%";
        $voucher->voucher_code = "HEHEHEHEHEHEHEHEHE";
        $result = $voucher->save();

        self::assertNotNull($result);
    }
    
    public function testInsertUUIDNonPrimary()
    {
        $voucher = new Voucher();
        $voucher->name = "Sebelas-maret";
        $voucher->discount = "20%";
        $voucher->save();

        $findVoucher = Voucher::find($voucher->id);
        $findVoucher->voucher_code = "HALO HALO TES UPDATED AT";
        $findVoucher->update();
        self::assertNotNull($findVoucher->id);

        self::assertNotNull($voucher->id);
        self::assertNotNull($voucher->voucher_code);
    }


}
