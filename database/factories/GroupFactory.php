<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { 
        return [
            'name' => fake()->sentence(2),
            'short_name' => mb_strimwidth(fake()->word() . "-" . fake()->word(),0,19,""),
            'description' => fake()->sentence(3), 
            'group_type' => Region::class
        ];
    }
}
