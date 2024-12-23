<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Scopes\IsActiveScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GlobalScopeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        DB::delete('DELETE FROM categories');
    }

    public function testQueryGlobalScope()
    {
        $category = new Category();

        $category->id = "AB-123";
        $category->name = "Category 1";
        $category->description = "Description 1";
        $category->is_active = false;

        $category->save();

        $finding = Category::find("AB-123");

        self::assertNull($finding);
        Log::info($finding);
    }
    public function testQueryGlobalScopeWithoutGlobalScope()
    {
        $category = new Category();

        $category->id = "AB-123";
        $category->name = "Category 1";
        $category->description = "Description 1";
        $category->is_active = false;

        $category->save();

        $finding = Category::find("AB-123");

        self::assertNull($finding);
        Log::info($finding);
        
        $findWithoutGlobalScope = Category::withoutGlobalScope(IsActiveScope::class)->find("AB-123");
        self::assertNotNull($findWithoutGlobalScope);
        Log::info($findWithoutGlobalScope);
    }
}
