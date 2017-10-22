<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyElectricity extends CustomModel
{
    use Translatable,
        Alternatives;

    protected $guarded = ['id'];
    public $timestamps = false;
    public static $yrlTrueValue = 2;
    public static $yrlFalseValue = 1;
}
