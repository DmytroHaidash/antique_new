<?php

/* @var $factory Factory */

use App\Model;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(\App\Models\Author::class, function (Faker $faker) {
    $name = $faker->name;

    return [
        'slug' => SlugService::createSlug(\App\Models\Author::class, 'slug',
            $name),
        'name' => [
            'ru' => $name,
            'uk' => $name,
            'en' => $name,
        ],
        'lives_from' => $faker->year('1990')
    ];
});
