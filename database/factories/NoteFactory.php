<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'description' => $faker->paragraph(rand(1, 3)),
    ];
});
