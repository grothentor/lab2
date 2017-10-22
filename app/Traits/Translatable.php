<?php

namespace App\Traits;

trait Translatable
{
    public function getTitleAttribute($value) {
        return $this->translateAttribute('title', $value);
    }

    protected function translateAttribute($attribute, $value) {
        if ('uk' === app()->getLocale() &&
            method_exists($this, 'hasAttribute') &&
            $this->hasAttribute("uk_$attribute")) return $this->{"uk_$attribute"};
        else return $value;
    }

    public function getTranslated() {
        $attributes = $this->getOriginal();

        return self::translateAttributes($attributes);
    }

    public static function translateAttributes($attributes) {
        $skipTranslating = isset(static::$skipTranslating) ? static::$skipTranslating : [];
        $entity = [];
        $locale = app()->getLocale();
        foreach ($attributes as $attribute => $value) {
            if (in_array($attribute, $skipTranslating) || starts_with($attribute, 'uk_')) continue;
            $entity[$attribute] = 'uk' === $locale && isset($attributes["uk_$attribute"]) ? $attributes["uk_$attribute"] : $value;
        }

        return $entity;
    }
}