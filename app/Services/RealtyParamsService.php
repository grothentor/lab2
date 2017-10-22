<?php
/**
 * Created by PhpStorm.
 * User: grothentor
 * Date: 10/21/17
 * Time: 9:16 PM
 */

namespace App\Services;


use App\RealtyType;
use App\YrlRealtyType;

class RealtyParamsService
{
    public function getRealtyParams() {
        $tables = self::getEditableTables(false, false);
        $tablesData = [];

        foreach ($tables as $tableName) {
            $table = generateTableClass($tableName);
            $tablesData[$tableName] = $table::query()
                ->with('alternatives')
                ->orderBy('title')
                ->get();
        }

        $realtyTypes = RealtyType::query()
            ->whereNotNull('parent_id')
            ->with('alternatives', 'yrlRealtyType')
            ->orderBy('title')
            ->get()
            ->groupBy('parent_id');

        $tablesData['realty_types'] = $realtyTypes;

        return $tablesData;
    }

    public function createRealtyType($fields) {
        return RealtyType::query()->create($fields);
    }

    public function createRealtyParam($tableName, $fields) {
        return generateTableClass($tableName)::query()->create($fields);
    }

    public function getRealtyTypes() {
        return RealtyType::query()->whereNull('parent_id')->pluck('title', 'id');
    }

    public function getYrlRealtyTypes($json = false) {
        $yrlTypes = YrlRealtyType::query()->get();
        if (!$json) {
            return $yrlTypes->pluck('title', 'id');
        } else {
            return $yrlTypes->map(function($yrlType) {
                return [
                    'id' => $yrlType->id,
                    'title' => $yrlType->title,
                ];
            });
        }
    }

    public function createAlternative($table, $alternative) {
        $alternative = $table::query()->create($alternative);
        return $alternative;
    }

    public static function getEditableTables($delimiter = false, $full = true, $translated = false) {
        $tables = ['realty_bathrooms', 'realty_build_plans', 'realty_build_types', 'realty_electricities', 'realty_gases',
            'realty_heatings', 'realty_repairs', 'realty_sewerages', 'realty_wall_types', 'realty_waters',
        ];
        if ($full) {
            $tables[] = 'realty_types';
        }
        if ($translated) {
            $translatedTables = [];
            foreach ($tables as $tableName) {
                $translatedTables[$tableName] = generateForeignKey($tableName, true);
            }
            $tables = $translatedTables;
        }
        if ($delimiter) return implode($delimiter, $tables);
        return $tables;
    }
}