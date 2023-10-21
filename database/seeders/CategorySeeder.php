<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Clothes', 'Electronics', 'Mobiles', 'Grocery'];

        foreach ($categories as $categoryName) {
            DB::table('categories')->insert([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'status' => '1'
            ]);
        }

    }
}
