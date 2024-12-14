<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    public function testInsertManyCategories()
    {
        $categories = [];
        for($i = 0; $i < 10; $i++){
            $categories[] = [
                'id' => Str::uuid(),
                'name' => "GAWAI $i",
            ];
        }

        Category::query()->insert($categories);

        $this->assertDatabaseCount('categories', 10);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::get()->first();
        $FIND = Category::find('TEST-2');

        self::assertNotNull($FIND);
        Log::info(json_encode($FIND));
        Log::info(json_encode($category));
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);
        $category = Category::find('TEST-2');

        if(empty($category)){
            self::fail("category not found");
        }

        $category->name = "IPAD 9 PRO";
        $category->id = "GAD-90";
        // $category->save(); bisa ini
        $result = $category->update(); // bisa ini juga

        self::assertEquals(true, $result);

    }
    
    public function testSelect()
    {
        // kita tetap menggunakan query builder jika ingin mengambil data lebih dari satu

        for($i=0; $i < 10; $i++){
            $category = new Category();
            $category->id = Str::uuid();
            $category->name = "Category $i";
            $category->save();
        }

        $categories = Category::whereNull('description')->get();
        self::assertCount(10, $categories);
        Log::info(json_encode($categories));
    }
}
