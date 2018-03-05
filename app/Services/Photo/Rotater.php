<?php namespace RentGorilla\Services\Photo;

use Image;
use RentGorilla\Photo;

class Rotater
{
    public function rotate(Photo $photo, $orientation)
    {
        $image = Image::make($photo->getPublicPath('large'));

        $image->rotate((float) $orientation)->save()
            ->fit(Photo::MEDIUM_WIDTH, Photo::MEDIUM_HEIGHT)
            ->save($photo->getPublicPath('medium'))
            ->fit(Photo::SMALL_WIDTH, Photo::SMALL_HEIGHT)
            ->save($photo->getPublicPath('small'));
    }
}