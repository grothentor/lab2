<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomModel extends Model 
{

    public static $validationRules = [];
    protected static $cacheTime = 60; //minutes

    protected static $allValues = [];

	public static function getPossibleEnumValues($name, $forJson = false){
	    $tableName = static::getTableName();
        $cacheName = "enums.$tableName" .  app()->getLocale() . ".$name.$forJson";
        if (!$enum = cache($cacheName)) {
            $type = DB::select(DB::raw("SHOW COLUMNS FROM $tableName WHERE Field = '$name'"))[0]->Type;
            preg_match('/^enum\((.*)\)$/', $type, $matches);
            $enum = [];
            foreach (explode(',', $matches[1]) as $value) {
                $v = trim($value, "'");
                if (!$forJson) $enum[$v] = __("enums.$v");
                else $enum[] = ['id' => $v, 'title' => __("enums.$v")];
            }
            cache([$cacheName => $enum], static::$cacheTime);
        }
	    return $enum;
	}

    /**
     * save array of entities and get ids of new entities in 2 query
     * work only with autoincrement id
     *
     * @param array $entities
     * @param bool $getOnlyIds
     * @return array
     */
	public static function saveGetIds(array $entities, $getOnlyIds = false) {
	    if (!count($entities)) return $entities;
	    end($entities);
	    $lastKey = key($entities);
	    reset($entities);

	    $lastEntity = array_pop($entities);
	    static::insert($entities);
        $lastId = static::insertGetId($lastEntity);

        $i = count($entities);
        $entities[$lastKey] = $lastEntity;
        $ids = [];

        foreach ($entities as &$entity) {
            $id = $lastId - $i;
            $ids[] = $id;
            $entity['id'] = $id;
            $i--;
        }
        return $getOnlyIds ? $ids : $entities;
    }

    /**
     * Save only new entities (novelty of entity checks by uniqueness value of $field)
     * and get ids of all entities
     * Values of $field must be in $entities array
     *
     * @param $entities
     * @param $field
     * @return array
     */
    public static function saveNewByField($entities, $field) {
        $fieldValues = array_column($entities, $field);

        $oldEntities = static::query()
            ->whereIn($field, $fieldValues)
            ->pluck('id', $field);

        $newEntities = $entities;
        foreach ($entities as $key => $entity) {
            if (isset($oldEntities[$entity[$field]])) {
                $entities[$key]['id'] = $oldEntities[$entity[$field]];
                unset($newEntities[$key]);
            }
        }

        $newEntities = static::saveGetIds($newEntities);
        foreach ($newEntities as $key => $entity) {
            $entities[$key] = $entity;
        }

        return $entities;
    }

    /**
     * get all entities with cache (for day)
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll() {
        $cacheName = static::getCacheAllName();
        if (!$entities = cache($cacheName)) {
            $entities = self::query()->get();
            cache([$cacheName => $entities], self::$cacheTime);
        }
        return $entities;
    }

    public static function pluckAttribute($attribute = 'title', $original = true) {
        $attribute .= get_called_class();
        if (isset(static::$allValues[$attribute])) {
            return static::$allValues[$attribute];
        }
        $entities = static::getAll();
        $entities = $entities->map(function ($entity) use ($attribute, $original) {
            return [
                $attribute => $original ? $entity->getOriginal($attribute) : $entity->$attribute,
                'id' => $entity->id,
            ];
        })->pluck($attribute, 'id');
        if ($entities->count() < 100) static::$allValues[$attribute] = $entities;
        return $entities;
    }

    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }

    public static function getTableName() {
        $instance = new static;
        return $instance->getTable();
    }

    public static function clearGetAllCache() {
        cache()->forget(static::getCacheAllName());
    }

    protected static function getCacheAllName() {
        return get_called_class() . '-all-' . app()->getLocale();
    }
}