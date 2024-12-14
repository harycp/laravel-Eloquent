<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(10)->create();
        $category = new Category();
        $category->id = "TEST-2";
        $category->name = "GAWAI";
        $category->save();
    }
}
