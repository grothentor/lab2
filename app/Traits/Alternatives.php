<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait Alternatives {

    protected static $withAlternatives;

    public function alternatives() {
        return new HasMany(
            $this->newQuery(false)->select('id', 'title', 'uk_title', $this->getAlternativeKey()),
            $this, $this->getTable() . '.' . $this->getAlternativeKey(), 'id'
        );
    }

    public static function query($withoutAlternatives = true)
    {
        return (new static)->newQuery($withoutAlternatives);
    }

    public function newQuery($withoutAlternatives = true)
    {
        $query = parent::newQuery();
        if ($withoutAlternatives) $query->whereNull(static::getTableName() . '.' . $this->getAlternativeKey());
        return $query;
    }

    public static function getAlternative($id) {
        return static::query(false)->where('id', $id)->firstOrFail();
    }

    public static function getAlternativeKey() {
        if (isset(static::$alternativeKey)) return static::$alternativeKey;
        else return 'parent_id';
    }

    public static function getWithAlternatives($forParsing = false) {
        if (static::$withAlternatives) return static::$withAlternatives;
        $values = [];
        static::query()->with('alternatives')->get()->map(function($entity) use (&$values, $forParsing){
            $values[static::getTitle($entity, $forParsing)] = $entity->id;
            $entity->alternatives->map(function($alternative) use (&$values, $entity, $forParsing) {
                $values[static::getTitle($alternative, $forParsing)] = $entity->id;
            });
        });
        static::$withAlternatives = $values;
        return $values;
    }

    private static function getTitle($entity, $forParsing) {
        $title = $entity->getOriginal('title');
        if ($forParsing) {
            $title = mb_strtolower($title);
        }
        return $title;
    }

    public static function getYrlValues() {
        return array_flip(static::getWithAlternatives());
    }
}