<?php

/* @var $factory Factory */

use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'slug' => $faker->slug,
        'title' => [
            'ru' => ucfirst($faker->words(rand(6, 20), true)),
            'uk' => ucfirst($faker->words(rand(6, 20), true)),
            'en' => ucfirst($faker->words(rand(6, 20), true)),
        ],
        'description' => [
            'ru' => $faker->sentence(rand(6, 12)),
            'uk' => $faker->sentence(rand(6, 12)),
            'en' => $faker->sentence(rand(6, 12)),
        ],
        'body' => [
            'ru' => '<p>'.implode('</p><p>', $faker->sentences(rand(3, 10))).'</p>',
            'uk' => '<p>'.implode('</p><p>', $faker->sentences(rand(3, 10))).'</p>',
            'en' => '<p>'.implode('</p><p>', $faker->sentences(rand(3, 10))).'</p>',
        ]
    ];
});
