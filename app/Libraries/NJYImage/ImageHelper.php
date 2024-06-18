<?php

namespace App\Libraries\NJYImage;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Typography\FontFactory;

use function PHPUnit\Framework\directoryExists;

class ImageHelper
{
    public IImageHelper $driver;

    public function __construct(IImageHelper $driver)
    {
        $this->driver = $driver; 
    }

    static function cropProfile(string $input)
    {
        $manager = new ImageManager(Driver::class);

        $path = storage_path("app/$input"); 

        $image = $manager->read($path);

        $image->cover(300, 300);

        $image->toPng()->save($path);
    }

   
    public function generateImage(array $config) : string
    {   
        return $this->driver->generateImage($config);
    }

    public static function deleteOldPhotos(string $file_dir){
        $files =   Storage::allFiles($file_dir); 
        Storage::delete($files);
    }
}
