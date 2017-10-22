<?php

namespace Database\Seeds;
use Illuminate\Database\Seeder;
use League\Flysystem\Exception;

class CustomSeeder extends Seeder
{
    public static function generateEntities($titles, $otherFields = [], $titleField = 'title')
    {
        foreach ($otherFields as $field => &$values) {
            if (is_string($values)) $values = array_fill(0, count($titles), $values);
            if (count($values) != count($titles)) throw new Exception('Wrong elements count in ' . $field);
        }

        $entities = [];
        foreach ($titles as $title) {
            $i = count($entities);
            $entities[$i] = [$titleField => $title];
            foreach ($otherFields as $field => &$values) {
                $entities[$i][$field] = $values[$i];
            }
        }

        return $entities;
    }
}