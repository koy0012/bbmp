<?php

namespace App\Libraries\NJYImage\Driver;

use App\Libraries\NJYImage\IImageHelper as NJYImageIImageHelper;
use App\Libraries\NJYImage\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Typography\FontFactory;

class RSAP implements NJYImageIImageHelper
{
    // string $name, string $user_id, string $timestamp, $profile_img, string $sub_group_text = ""
    public function generateImage(array $config): string
    {
        $manager = new ImageManager(Driver::class);
        // echo public_path("img/templates/bbm_default_id.jpg");
        // die();
        $base = $manager->read(public_path("img/templates/rsap_default_id.jpg"));
        // echo $profile_img;
        // die();
        $profile = $manager->read($config['profile_img']);

        $url = url("back/valid_id/{$config['user_id']}/id");
        $qr = $manager->read(file_get_contents("/qrcode?url={$url}"));

        $profile->cover(310, 310);
        $qr->cover(200, 200);

        if(strlen($config['name']) <= 16){
            Generic::multiline($base, 0, 70, strtoupper($config['name']), 'middle', 60, '#111');
        }else {
            Generic::multiline($base, 0, 80, strtoupper($config['name']), 'middle', 50, '#111',max_len:15);
        }
        

        //max char 20
        $base->text("ID NO: {$config['sub_group_text']}", $base->width() / 2, $base->height() / 2 + 10, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#111');
            $font->size(40);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $position = $config['user']['position'] ?? "MEMBER";

        $base->text(strtoupper($position), $base->width() / 2, $base->height() / 2 + 200, function (FontFactory $font) {
            $font->filename(public_path('css/Roboto-Black.ttf'));
            $font->color('#111');
            $font->size(40);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
        });

        $base->place($profile, 'top', 2, 175);
        $base->place($qr, 'top', 2, 740);

        if (!Storage::exists("draft/{$config['user_id']}")) {
            Storage::makeDirectory("draft/{$config['user_id']}");
        } else {
            ImageHelper::deleteOldPhotos("draft/{$config['user_id']}");
        }

        $base->toPng()->save(storage_path("app/draft/{$config['user_id']}/{$config['timestamp']}.png"));

        return "app/draft/{$config['user_id']}/{$config['timestamp']}.png";
    }
}
