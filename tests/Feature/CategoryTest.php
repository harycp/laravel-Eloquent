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

        $selectCate = Category::select('id', 'name')->get();
        Log::info(json_encode($selectCate));
    }

    public function testUpdateSelect()
    {
        for($i=0; $i < 10; $i++){
            $category = new Category();
            $category->id = Str::uuid();
            $category->name = "Category $i";
            $category->save();
        }

        $categories = Category::whereNull('description')->select('id', 'name')->get();
        $categories->each(function ($cat){
            $cat->description = "UP BROS";
            $cat->update();
        });
        self::assertCount(10, $categories);
        Log::info(json_encode($categories));
    }

    public function testUpdateMany()
    {
        for($i=0; $i < 10; $i++){
            $category = new Category();
            $category->id = Str::uuid();
            $category->name = "Category $i";
            $category->save();
        }

        $result = Category::whereNull('description')
                ->update([
                    "description" => "UPDATED BROSKI"
                ]);
        
        self::assertNotNull($result);

        $total = Category::where("description", "UPDATED BROSKI")->count();
        self::assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::find('TEST-2');
        if(empty($category)){
            self::fail("category not found");
        }else{
            $result = $category->delete();
            self::assertEquals(true, $result);

            $total = Category::get()->count();
            self::assertEquals(10, $total);
        }
    }

    public function testDeleteMany()
    {
        $categories = [];
        for($i=0; $i < 10; $i++){
            $categories[] = [
                "id" => Str::uuid(),
                "name" => "Category $i",
            ];
        }

        Category::insert($categories);
        $total = Category::get()->count();
        self::assertEquals(10, $total);

        Category::select("id")->delete();

        $total = Category::get()->count();
        self::assertEquals(0, $total);
    }

    public function testUUID()
    {
        
    }

    public function testInsert()
    {
        // Asosiative array
        $data = [
            "id" => "FAD-90",
            "name" => "Food",
            "description" => "Food Estate"
        ];

        $result = new Category($data);
        $result->save();

        self::assertNotNull($result->id);

        Log::info(json_encode($result));
    }

    public function testCreate()
    {
        $result = [
            "id" => "FAD-90",
            "name" => "Food",
            "description" => "Food Estate"
        ];

        // akan langsung tersimpan kedatabase saat menggunakan create
        $result = Category::create($result);

        self::assertNotNull($result->id);

        Log::info(json_encode($result));

    }

    public function testManyUpdate()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            "id" => "DATA UPDATED",
            "name" => "DATA UPDATED",
            "description" => "DATA UPDATED"
        ];

        $category = Category::find("TEST-2");
        $category->fill($request);
        $category->save();

        self::assertEquals($category->id, "DATA UPDATED");
        Log::info(json_encode($category));
    }

    

}

