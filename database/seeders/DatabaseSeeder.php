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
        $categories = \App\Models\Category::factory(10)
            ->create()
            ->each(function ($category) {
                \App\Models\Outing::factory(3)
                    ->create()
                    ->each(function ($outing) use ($category) {
                        $outing->categories()->save($category);
                    });
            });

        $users = \App\Models\User::all();

        $users->each(function ($user) use ($users, $categories) {
            $friends = $users->whereNotIn([$user->id], 'id')->random(3);
            $cats = $categories->whereNotIn([$user->id], 'id')->random(3);

            /** create user categories */
            $cats->each(function ($cat) use ($user) {
                \App\Models\UserCategory::create([
                    "user_id" => $user->id,
                    "category_id" => $cat->id
                ]);
            });

            /** create friends */
            $friends->each(function ($friend) use ($user) {
                \App\Models\UserFriend::create([
                    "user_id" => $user->id,
                    "friend_id" => $friend->id
                ]);
            });
        });
    }
}
