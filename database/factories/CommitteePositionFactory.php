<?php

namespace Database\Factories;

use App\Models\CommitteePosition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CommitteePosition>
 */
class CommitteePositionFactory extends Factory
{
    protected $model = CommitteePosition::class;

    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle(),
            'category' => 'executive',
            'sort_order' => fake()->numberBetween(0, 20),
            'description' => fake()->sentence(),
        ];
    }
}
