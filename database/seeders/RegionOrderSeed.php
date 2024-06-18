<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionOrderSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::where('name', 'REGION I')->update(['order' => 1001]);
        Region::where('name', 'REGION II')->update(['order' => 1002]);
        Region::where('name', 'REGION III')->update(['order' => 1003]);
        Region::where('name', 'REGION IV-A')->update(['order' => 1004]);
        Region::where('name', 'REGION IV-B')->update(['order' => 1005]);
        Region::where('name', 'REGION V')->update(['order' => 1006]);
        Region::where('name', 'REGION VI')->update(['order' => 1007]);
        Region::where('name', 'REGION VII')->update(['order' => 1008]);
        Region::where('name', 'REGION VIII')->update(['order' => 1009]);
        Region::where('name', 'REGION IX')->update(['order' => 10010]);
        Region::where('name', 'REGION X')->update(['order' => 10011]);
        Region::where('name', 'REGION XI')->update(['order' => 10012]);
        Region::where('name', 'REGION XII')->update(['order' => 10013]);
        Region::where('name', 'REGION XIII')->update(['order' => 10014]);
        Region::where('name', 'BARMM')->update(['order' => 10015]);
        Region::where('name', 'NCR')->update(['order' => 11006]);
        Region::where('name', 'CAR')->update(['order' => 10017]);

        Region::where('name', 'REGION I')->update(['order' => 1]);
        Region::where('name', 'REGION II')->update(['order' => 2]);
        Region::where('name', 'REGION III')->update(['order' => 3]);
        Region::where('name', 'REGION IV-A')->update(['order' => 4]);
        Region::where('name', 'REGION IV-B')->update(['order' => 5]);
        Region::where('name', 'REGION V')->update(['order' => 6]);
        Region::where('name', 'REGION VI')->update(['order' => 7]);
        Region::where('name', 'REGION VII')->update(['order' => 8]);
        Region::where('name', 'REGION VIII')->update(['order' => 9]);
        Region::where('name', 'REGION IX')->update(['order' => 10]);
        Region::where('name', 'REGION X')->update(['order' => 11]);
        Region::where('name', 'REGION XI')->update(['order' => 12]);
        Region::where('name', 'REGION XII')->update(['order' => 13]);
        Region::where('name', 'REGION XIII')->update(['order' => 14]);
        Region::where('name', 'BARMM')->update(['order' => 15]);
        Region::where('name', 'NCR')->update(['order' => 16]);
        Region::where('name', 'CAR')->update(['order' => 17]);

        DB::statement("ALTER TABLE regions AUTO_INCREMENT = 17;");
    }
}
