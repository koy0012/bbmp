<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ValidIdentity>
 */
class ValidIdentityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ids = [];
        foreach(config('constants.valid_ids') as $id){
            $ids[] = $id;
        }

        // $imageContent = file_get_contents(fake()->imageUrl());
        // $image = Str::uuid() . ".png";
        
        // Storage::disk('public')->put($image,$imageContent);
        // $url = "/storage/public/$image";

        return [
            'user_id' => '',
            'no' => fake()->creditCardNumber(),
            'type' => fake()->randomElement($ids),
            'image' => "sample"
        ];
    }
}
