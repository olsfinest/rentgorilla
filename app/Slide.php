<?php

namespace RentGorilla;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{

    const IMAGE_PATH = '/img/slides/';


    const WIDTH = 436;
    const HEIGHT = 181;
    const MAX_COUNT = 5;


    public function landingPage()
    {
        return $this->belongsTo('RentGorilla\LandingPage');
    }

    public function deleteSlide()
    {
        $file = public_path() . self::IMAGE_PATH . $this->name;
        if(file_exists($file)) {
            unlink($file);
        }
     }
}
