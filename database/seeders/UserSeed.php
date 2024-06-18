<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserInfo;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            "name" => "James Yanga",
            "email" => "yanganoah404@gmail.com",
            "password" => "superadmin",
            "role" => "national", 
            "state" => 'approved',
            "username" => 'superadmin' 
        ]);

        UserInfo::factory()->create([
            "user_id" => $user->id 
        ]);

        $user = User::factory()->create([
            "name" => "John Ru",
            "email" => "yanganoah404@gmail.com",
            "password" => "admin",
            "role" => "regional", 
            "state" => 'approved',
            "username" => 'admin'
        ]);

        UserInfo::factory()->create([
            "user_id" => $user->id 
        ]);

        $user = User::factory()->create([
            "name" => "James Yanga",
            "email" => "yanganoah404@gmail.com",
            "password" => "manager",
            "role" => "municipal", 
            "state" => 'approved',
            "username" => 'manager'
        ]);

        UserInfo::factory()->create([
            "user_id" => $user->id 
        ]);
    }
}
