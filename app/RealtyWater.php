<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyWater extends CustomModel
{
    use Translatable,
        Alternatives;

    protected $guarded = ['id'];
    public $timestamps = false;
    public static $yrlTrueValue = 8;
    public static $yrlFalseValue = 6;
}
