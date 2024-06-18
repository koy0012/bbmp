<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(Region::get() as $region){
            for($i =0; $i < min(3,10); $i++){
                Group::factory()->create([
                    "group_id" => $region->id 
                ]);
            }
        }
    }
}
