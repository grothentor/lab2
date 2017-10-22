<?php

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->describe('Display an inspiring quote');

use libphonenumber\PhoneNumberFormat;

Artisan::command('avers-phones-parse', function ()
{
    $phones = require(storage_path('app/phones.php'));

    foreach($phones as $item) {
        $phone = $item['phone'];

        $validator = validator([
            'phone' => $phone,
        ], [
            'phone' => 'phone:UA',
        ]);

        if (!$validator->fails()) {
            $phone = phone($phone, 'UA', $format = PhoneNumberFormat::E164);

            $phone = substr($phone, 4);

            $phone = \App\MediatorPhone::query()->firstOrCreate([
                'phone' => $phone,
            ]);
        }
    }

})->describe('Распарсить телефоны');
