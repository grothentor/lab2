<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;

class RealtyBuildPlan extends CustomModel
{
    use Translatable,
        Alternatives;

    protected $guarded = ['id'];
    public $timestamps = false;
}
