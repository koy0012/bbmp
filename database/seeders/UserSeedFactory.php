<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use App\Models\ValidIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserSeedFactory extends Seeder
{
    
    public static function downloadImage($url,$dir) {
        $imageContent = file_get_contents($url);
        $image = Str::uuid() . ".jpg";
        
        Storage::disk('public')->put($image,$imageContent);
        return "$dir/$image";
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100000; $i++) {
            // $user = User::factory()->create([
            //     'profile' => "/storage/" . $this->downloadImage("https://thispersondoesnotexist.com/",'public')
            // ]); 

            $user = User::factory()->create(); 

            $approved_by = $user->state == 'approved' ? User::where('state','approved')->inRandomOrder()->first()->id : null;

            UserInfo::factory()->create([
                'user_id' => $user->id,
                'approved_by' => $approved_by
            ]);

            ValidIdentity::factory()->count(rand(1, 2))->create([
                'user_id' => $user->id
            ]);
        }
    }
}
