<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(\App\Product::class,300)->create();
        factory(\App\User::class,300)->create();
        $this->call(CategoriesTableSeeder::class);
    }
}
