<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {  
        return [
            'user_id' => '',
            'position' => fake()->sentence(1),
            'address' => fake()->sentence(),
            'birthday' => fake()->date(),
            'birthplace' => fake()->sentence(),
            'civil_status' => fake()->randomElement(config('constants.civil_status')),
            'nationality' => 'Filipino',
            'contact_number' => fake()->phoneNumber(),
            'voters_id' => fake()->creditCardNumber(),
            'company_name' => fake()->sentence(2),
            'company_position' => fake()->sentence(3),
            'affiliations' => fake()->sentence(2),
            'educational_attainment' => fake()->sentence(2),
            'special_skills' => fake()->sentence(5),
            'approved_by' => null,
            'referred_by' => rand(0,1) ? User::inRandomOrder()->first() : null
        ];
    }
}
