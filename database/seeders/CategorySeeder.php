<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(3)
            ->create()
            ->each(function ($category) {
                Category::factory(rand(1, 3))->create(
                    [
                        'category_id' => $category->id,
                    ]
                )
            ->each(function ($subcategory) {
                Category::factory(rand(1, 3))->create(
                    [
                        'category_id' => $subcategory->id,
                    ]
                );
            });
        });
    }
}
