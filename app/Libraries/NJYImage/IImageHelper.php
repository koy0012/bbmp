<?php

namespace App\Libraries\NJYImage;

interface IImageHelper {
    public function generateImage(array $options) : string;
}