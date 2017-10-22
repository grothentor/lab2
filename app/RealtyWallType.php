<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyWallType extends CustomModel
{
    use Translatable,
        Alternatives;

    protected $guarded = ['id'];
    public $timestamps = false;
}
