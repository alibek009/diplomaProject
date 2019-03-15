<?php

$factory->define(App\QuestionsOption::class, function (Faker\Generator $faker) {
    return [
        "question_id" => factory('App\Question')->create(),
        "option_text" => $faker->name,
        "correct" => rand(0,1),
    ];
});
