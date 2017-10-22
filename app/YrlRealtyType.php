<?php
/**
 * Created by PhpStorm.
 * User: grothentor
 * Date: 9/29/17
 * Time: 1:05 PM
 */

namespace App;


class YrlRealtyType extends CustomModel
{
    public $timestamps = false;

    public function getTitleAttribute($value) {
        if ($this->display_title) return $this->display_title;
        else return $value;
    }
}