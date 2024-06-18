<?php

namespace App\Libraries\NJYImage\Driver;

use App\Libraries\NJYImage\IImageHelper as NJYImageIImageHelper;
use App\Libraries\NJYImage\ImageHelper;
use App\Models\User;
use chillerlan\QRCode\QRCode;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class BBMP implements NJYImageIImageHelper
{
    
    public function getBaseTemplate(array $config){ 
        $path = public_path("/json/bbmp_templates.json"); 
        $json = [];
        
        if(File::exists($path)){
            $json = json_decode(file_get_contents($path), true);
        } 

        foreach($json as $row => $key){
           if($config['user']['id'] == $row ||
            User::hasTargetReferrer($row,$config['user']['referred_by'])){ 
                if(empty($key)){
                    Log::error("unable to fetch base template for bbmp id: key is empty.", $json);
                    break;
                }
                return $key;
           }
        } 

        return public_path("img/templates/bbmp_default_id.jpg"); 
    }

    // string $name, string $user_id, string $timestamp, $profile_img, string $sub_group_text = ""
    public function generateImage(array $config): string
    {
        $manager = new ImageManager(Driver::class);
        // echo public_path("img/templates/bbm_default_id.jpg");
        // die();
        $base = $manager->read($this->getBaseTemplate($config));
        // echo $profile_img;
        // die();
        
        try{
            $profile = $manager->read($config['profile_img']);
        }catch(\Exception $ex){
            abort(403,"Invalid Profile Picture");
        } 
 
        $url = url('/') . "/register/{$config['user']['municipal_id']}?ref={$config['user']['id']}";

        $qr = null;
        try{
            $profile = $manager->read($config['profile_img']);
        }catch(\Exception $ex){
            abort(403,"Invalid Profile Picture");
        }

        // $qr = $manager->read(file_get_contents("/qrcode?url={$url}"));

        $qr = $manager->read((new QRCode)->render($url));
        $qr->cover(300,300);

        $profile->cover(300, 300);

        $center_x    = $base->width() / 2;
        $center_y    = $base->height() / 2;
        $max_len     = 27;
        $font_size   = 50;
        $font_height = 24; 

        $lines = explode("\n", wordwrap(strtoupper($config['name']), $max_len), 2);
        $y     = $center_y - ((count($lines) - 1) * $font_height);

        if(count($lines) == 1 && strlen($lines[0]) < 20){
            $font_size = 70;
        } else if(count($lines) == 1 && strlen($lines[0]) < 25){
            $font_size = 60;
        }

        foreach ($lines as $line) {
            $base->text($line, $center_x, $y - 35, function (FontFactory $font) use ($font_size) {
                $font->filename(public_path('css/Roboto-Black.ttf'));
                $font->color('#111');
                $font->size($font_size);
                $font->align('center');
                $font->valign('middle');
                $font->lineHeight(1.6);
            });

            $y += $font_height * 2;
        } 

        //max char 20
        $base->text($config['sub_group_text'], $base->width() / 2, $base->height() / 2 + 100, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#fff');
            $font->size(50);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $position = $config['user']['position'] ?? env('ID_DEFAULT_MEMBER', '');

        Generic::multiline(
            $base,
            0,
            33,
            strtoupper($position),
            'center',
            30,
            color: '#111',
            max_len:50,
            font_height:12
        );

        $base->place($profile, 'top', 12, 300);
        $base->place($qr, 'top', 330, 300);

        if (!Storage::exists("draft/{$config['user_id']}")) {
            Storage::makeDirectory("draft/{$config['user_id']}");
        } else {
            ImageHelper::deleteOldPhotos("draft/{$config['user_id']}");
        }

        $base->toPng()->save(storage_path("app/draft/{$config['user_id']}/{$config['timestamp']}.png"));

        return "app/draft/{$config['user_id']}/{$config['timestamp']}.png";
    }
}
