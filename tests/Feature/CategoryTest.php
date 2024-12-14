<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CategoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM categories');
    }

    public function testInsertCategory()
    {
        $category = new Category();
        $category->id = Str::uuid();
        $category->name = "GAWAI";
        $category->save();

        $encryptId = Crypt::encrypt($category->id);
        Log::info($encryptId);
        $decryptId = Crypt::decrypt($encryptId);
        Log::info($decryptId);

        $category->each(function ($cat){
            Log::info(json_encode($cat));
        });

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => $category->name,
        ]);
    }
}
