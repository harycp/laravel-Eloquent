<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->nullable(false)->primary();
            $table->string('name')->nullable(false);
            $table->string('discount')->nullable(false);
            $table->string('voucher_code')->nullable(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
        Schema::table('vouchers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
