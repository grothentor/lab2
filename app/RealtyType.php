<?php

namespace App;

use App\Traits\Alternatives;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;

class RealtyType extends CustomModel
{
    use Translatable,
        Alternatives {
        getYrlValues as defaultYrlValues;
    }

    protected static $yrlValues;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected static $alternativeKey = 'alternative_id';

    public static $yrlLivingTypes = [1, 2, 6, 8, 11,];

    public static $ids = [
        'flats' => [1],
        'rooms' => [6],
        'houses' => [2],
        'areas' => [8],
        'buildings' => [9],
        'garages' => [11],
        'commerces' => [18],
        'offices' => [32],
        'shops' => [33],
        'warehouses' => [34],
        'all' => null,
    ];

    public static $studioId = 10;

    private static $parentIds = null;

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function yrlRealtyType() {
        return $this->belongsTo(YrlRealtyType::class);
    }

    public static function getByType($realty_type)
    {
        if (!isset(self::$ids[$realty_type])) abort(422, __('Can\'t process your data'));
        if ('all' === $realty_type) return self::query()->first(); //TODO: normal logic for 'all'
        return self::query()
            ->whereIn('id', self::$ids[$realty_type])
            ->first();
    }

    /**
     * @param $realtyTypeId
     * @return string
     */
    public static function getTypeById($realtyTypeId) {
        $realtyType = self::query()->find($realtyTypeId);
        $realtyTypeId = $realtyType->parent_id ?? $realtyType->id;
        $type = array_filter(self::$ids, function ($realtyIds) use ($realtyTypeId){
            return !$realtyIds || is_array($realtyIds) && in_array($realtyTypeId, $realtyIds);
        });
        $type = array_keys($type)[0];
        return $type;
    }

    public function getSubTypes()
    {
        return $this->hasMany(RealtyType::class, 'parent_id');
    }

    public function scopeOriginal(Builder $query) {
        return $query->whereNull('parent_id');
    }

    public static function getYrlValues() {
        if (static::$yrlValues) return static::$yrlValues;
        $values = self::query()
            ->with('yrlRealtyType', 'parent')
            ->get()
            ->map((function ($value) {
                return [
                    'id' => $value->id,
                    'title' => $value->yrlRealtyType ? $value->yrlRealtyType->getOriginal('title') :
                        ($value->parent && $value->parent->yrlRealtyType ? $value->parent->yrlRealtyType->getOriginal('title') : ''),
                ];
            }))
            ->pluck('title', 'id');
        static::$yrlValues = $values;
        return $values;
    }

    public static function getParentIdById($id) {
        if (!self::$parentIds) self::$parentIds = self::query()
            ->select('id', \DB::raw('ifnull(parent_id, id) as parent_id'))
            ->get()
            ->pluck('parent_id', 'id')
            ->toArray();
        return self::$parentIds[$id];
    }
}
