<?php

$factory->define(App\Question::class, function (Faker\Generator $faker) {
    return [
        "question" => $faker->text(50). '?',
        "score" => 1,
    ];
});
