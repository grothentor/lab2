<?php

use Database\Seeds\CustomSeeder;

class YrlRealtyTypesTableSeeder extends CustomSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $values = [
            ['title' => 'дача', 'id' => '1', 'display_title' => null],
            ['title' => 'дом', 'id' => '2', 'display_title' => null],
            ['title' => 'дом с участком', 'id' => '3', 'display_title' => null],
            ['title' => 'участок', 'id' => '4', 'display_title' => null],
            ['title' => 'часть дома', 'id' => '5', 'display_title' => null],
            ['title' => 'квартира', 'id' => '6', 'display_title' => null],
            ['title' => 'комната', 'id' => '7', 'display_title' => null],
            ['title' => 'таунхаус', 'id' => '8', 'display_title' => null],
            ['title' => 'гараж', 'id' => '9', 'display_title' => null],
            ['title' => 'auto repair', 'id' => '10', 'display_title' => 'автосервис'],
            ['title' => 'business', 'id' => '11', 'display_title' => 'готовый бизнес'],
            ['title' => 'free purpose', 'id' => '12', 'display_title' => 'помещения свободного назначения'],
            ['title' => 'hotel', 'id' => '13', 'display_title' => 'гостиница'],
            ['title' => 'land', 'id' => '14', 'display_title' => 'земли коммерческого назначения'],
            ['title' => 'legal address', 'id' => '15', 'display_title' => 'юридический адрес'],
            ['title' => 'manufacturing', 'id' => '16', 'display_title' => 'производственное помещение'],
            ['title' => 'office', 'id' => '17', 'display_title' => 'офисные помещения'],
            ['title' => 'public catering', 'id' => '18', 'display_title' => 'общепит'],
            ['title' => 'retail', 'id' => '19', 'display_title' => 'торговые помещения'],
            ['title' => 'warehouse', 'id' => '20', 'display_title' => 'склад'],
        ];

        DB::table('yrl_realty_types')->insert($values);
    }
}
