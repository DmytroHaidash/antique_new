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
         $this->call([
             UsersTableSeeder::class,
             CitiesTableSeeder::class,
             SectionsTableSeeder::class,
             CategoriesTableSeeder::class,
             PostsTableSeeder::class,
             PagesTableSeeder::class,
         ]);

         if (config('app.env') === 'local') {
             $this->call([
                 AuthorsTableSeeder::class,
//                 ExhibitsTableSeeder::class,
             ]);
         }
    }
}
