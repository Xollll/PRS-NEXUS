<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'matric_no' => fake()->unique()->bothify('M######'),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'programme' => 'Bachelor of Education',
            'role_title' => 'Member',
            'status' => 'active',
        ];
    }
}
