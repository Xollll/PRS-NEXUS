<?php

namespace Database\Factories;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meeting>
 */
class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'meeting_date' => fake()->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'location' => fake()->city(),
            'summary' => fake()->paragraph(),
        ];
    }
}
