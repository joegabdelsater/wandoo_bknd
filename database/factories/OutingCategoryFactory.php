<?php

namespace Database\Factories;

use App\Models\OutingCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutingCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OutingCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "outing_id" => \App\Models\Outing::factory()->create()->first()->id,
            "user_id" => \App\Models\User::factory()->create()->first()->id,
            "is_joining" => rand(0,1)
        ];
    }
}
