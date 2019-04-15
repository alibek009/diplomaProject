<?php

Route::get('quiz/{slug}',['uses'=> 'Api\QuizController@index','as'=>'quiz.index']);


