<?php

namespace Database\Factories;

use App\Models\Outing;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Outing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $allowed = ['public', 'friends','tagged'];
        
        return [
                "title" => $this->faker->sentence(),
                "description" => $this->faker->paragraph(),
                "date" => $this->faker->dateTime(),
                "join_status" => $allowed[rand(0,2)],
                "user_id" => \App\Models\User::factory()->create()->first()->id
        ];
    }
}
