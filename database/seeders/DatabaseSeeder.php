<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(10)
            ->create()
            ->each(function ($category) {
                \App\Models\Outing::factory(3)
                    ->create()
                    ->each(function ($outing) use ($category) {
                        $outing->categories()->save($category);
                    });
            });

        $users = \App\Models\User::all(); 

        $users->each(function($user){

        });
    }
}
