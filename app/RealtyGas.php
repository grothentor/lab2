<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyGas extends CustomModel
{
    use Translatable,
        Alternatives;
    protected $table = 'realty_gases';
    protected $guarded = ['id'];
    public $timestamps = false;
}
