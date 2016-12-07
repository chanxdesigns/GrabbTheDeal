<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category;
        $category->category_id = "fashion";
        $category->category_name = "Fashion";
        $category->category_slug = "fashion";
        $category->save();
    }
}
