<?php

use Illuminate\Database\Seeder;
use App\Question;
use App\QuestionsOption;
class QuestionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Question::class, 5)->create()->each(function ($question){

            $question ->options() -> saveMany(factory(QuestionsOption::class,4)->create());
            $question ->tests()->attach(rand(1,50));
        });
    }
}
