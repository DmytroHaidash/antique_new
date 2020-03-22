<?php

/* @var $factory Factory */

use App\Model;
use App\Models\Exhibit;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Exhibit::class, function (Faker $faker) {
    $number = $faker->isbn10;
    $country = $faker->country;
    $time = '1930-е гг.';

    return [
        'slug' => $faker->slug,
        'author_id' => rand(1, 50),
        'title' => [
            'ru' => ucfirst($faker->words(rand(6, 20), true)),
            'uk' => ucfirst($faker->words(rand(6, 20), true)),
            'en' => ucfirst($faker->words(rand(6, 20), true)),
        ],
        'body' => [
            'ru' => '<p>'.implode('</p><p>', $faker->sentences(rand(2, 4))).'</p>',
            'uk' => '<p>'.implode('</p><p>', $faker->sentences(rand(2, 4))).'</p>',
            'en' => '<p>'.implode('</p><p>', $faker->sentences(rand(2, 4))).'</p>',
        ],
        'props' => [
            'ru' => [
                'number' => $number,
                'origin' => $country,
                'time' => $time,
                'technique' => 'Масляная живопись',
                'material' => 'Холст',
                'dimensions' => '62x45 см',
            ],
            'uk' => [
                'number' => $number,
                'origin' => $country,
                'time' => $time,
                'technique' => 'Масляная живопись',
                'material' => 'Холст',
                'dimensions' => '62x45 см',
            ],
            'en' => [
                'number' => $number,
                'origin' => $country,
                'time' => $time,
                'technique' => 'Масляная живопись',
                'material' => 'Холст',
                'dimensions' => '62x45 см',
            ],
        ]
    ];
});
