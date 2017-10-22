<?php

use Database\Seeds\CustomSeeder;

class RealtyTypesTableSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ["1", "квартира", "квартира", "6"],
            ["2", "дом", "будинок", "2",],
            ["6", "комната", "кімната", "7",],
            ["8", "участок", "ділянка", "4",],
            ["9", "здание", "будівля", "12",],
            ["11", "гаражи/стоянки", "гаражі/стоянки", "9",],
            ["18", "коммерческая недвижимость", "комерційна нерухомість", "16",],
            ["32", "офис", "Офіс", "17",],
            ["33", "магазин", "Магазин", "19",],
            ["34", "склад", "Склад", "20",]
        ];

        DB::table('realty_types')->insert($this->generateEntities(array_column($values, 1), [
            'id' => array_column($values, 0),
            'uk_title' => array_column($values, 2),
            'yrl_realty_type_id' => array_column($values, 3),
        ]));
    }
}
