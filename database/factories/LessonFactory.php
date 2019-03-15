<?php

$factory->define(App\Lesson::class, function (Faker\Generator $faker) {
    $name = $faker->text(50);
    return [
        "course_id" => factory('App\Course')->create(),
        "title" => $name,
        "slug" => str_slug($name),
        "short_text" => $faker->paragraph(),
        "full_text" => $faker->text(1000),
        "position" => rand(1,10),
        "free_lesson" =>  rand(0,1),
        "published" =>  1,
    ];
});
