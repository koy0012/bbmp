<?php

namespace App\Libraries\NJYImage\Driver;

use App\Libraries\NJYImage\IImageHelper;
use App\Libraries\NJYImage\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class Generic implements IImageHelper
{
    public function generateImage(array $config): string
    {
        $manager = new ImageManager(Driver::class);
        // echo public_path("img/templates/bbm_default_id.jpg");
        // die();
        $base = $manager->read(public_path("img/templates/generic_default_id.png"));
        // echo $profile_img;
        // die();
        $profile = $manager->read($config['profile_img']);

        $url = url("back/valid_id/{$config['user_id']}/id/1.jpg");
        $qr = $manager->read(file_get_contents("/qrcode?url={$url}"));
       
       // $qr = $manager->read(file_get_contents("/qrcode?url=http://127.0.0.1:8000/storage/public/appsun_Set_rise.jpg"));
        $qr->cover(150, 150);

        $profile->cover(300, 300); 

        //max char 20
        $base->text($config['sub_group_text'], $base->width() / 2 - 90, $base->height() / 2, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#777');
            $font->size(30);
            $font->align('left');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $base->text($config['user']['contact_number'] . "ewqewq", $base->width() / 2 - 90, $base->height() / 2 + 40, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#777');
            $font->size(30);
            $font->align('left');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $this->multiline($base,-90,-100,$config['name'],"left",40,color:"#111");
        $this->multiline(
            $base,
            -90,
            110,
            $config['user']['address'],
            "left",
            30,
            font_height:20,
            max_len:40
        );

        $base->place($profile, 'left', 100, 0);
        $base->place($qr, 'top-right', 10, 10);

        if (!Storage::exists("draft/{$config['user_id']}")) {
            Storage::makeDirectory("draft/{$config['user_id']}");
        } else {
            ImageHelper::deleteOldPhotos("draft/{$config['user_id']}");
        }

        $base->toPng()->save(storage_path("app/draft/{$config['user_id']}/{$config['timestamp']}.png"));

        return "app/draft/{$config['user_id']}/{$config['timestamp']}.png";
    }

    public static function multiline($base, $x, $y, $text, $align,$font_size,$color = "#777",$font_height = 24, $max_len = 24)
    {
        $center_x    = $base->width() / 2 + $x;
        $center_y    = $base->height() / 2 + $y; 

        $lines = explode("\n", wordwrap($text, $max_len), 2);
        $y     = $center_y - ((count($lines) - 1) * $font_height);

        $counter = 0;
        foreach ($lines as $line) { 
            if($counter == (count($lines) - 1)){
                $line = substr($line,0,$max_len);
            }
            $counter++;
            $base->text($line, $center_x, $y, function (FontFactory $font) use ($font_size,$align,$color) {
                $font->filename(public_path('css/Roboto-Black.ttf'));
                $font->color($color);
                $font->size($font_size);
                $font->align($align);
                $font->valign('middle');
                $font->lineHeight(1.6);
            });

            $y += $font_height * 2;
        }
        
        // die();
    }
}
