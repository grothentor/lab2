<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyHeating extends CustomModel
{
    use Translatable,
        Alternatives;

    public static $yrlTrueValue = 1;
    public static $yrlFalseValue = 6;
    protected $guarded = ['id'];
    public $timestamps = false;
}
