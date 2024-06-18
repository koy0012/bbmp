<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Municipal;
use App\Models\Province;
use Faker\Guesser\Name;

class CountrySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path() . "/misc/ph.json";

        $json = json_decode(file_get_contents($path), true);

        foreach ($json as $region => $region_data) {
            $region_model = Region::create(["name" => $region_data['region_name']]); 
            foreach ($region_data['province_list'] as $province => $province_data) {
                // echo $province . "\n";
                $province_model = Province::create(["name" => $province, "region_id" => $region_model['id']]);
                foreach ($province_data['municipality_list'] as $municipal => $municipal_data) {
                    // echo $municipal . "\n";
                    $municipal_model = Municipal::create(["name" => $municipal, "region_id" => $region_model['id'], "province_id" => $province_model['id']]);
                    foreach ($municipal_data['barangay_list'] as $barangay) {
                        // echo $barangay . "\n";
                        Barangay::create(['name' => $barangay, 'municipal_id' => $municipal_model['id']]);
                    }
                }
            } 
            echo "ADDED {$region_data['region_name']} \n"; 
        }
    }
}
