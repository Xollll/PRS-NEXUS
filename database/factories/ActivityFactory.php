<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'activity_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'status' => 'planned',
        ];
    }
}
