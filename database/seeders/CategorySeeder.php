<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // DB::table('category')->insert([
        //     'name' => 'Buku Komik',
        //     'slug' => 'buku-komik'
        // ]);

        Category::create([
            'name' => 'Test 1',
            'slug' => 'test-1'
        ]);
    }
}
