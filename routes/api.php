<?php

Route::get('quiz/{slug}',['uses'=> 'Api\QuizController@index','as'=>'quiz.index']);


Route::get('lessons',['uses'=> 'Api\LessonController@list','as'=>'lesson.index']);
Route::get('lessons/{id}',['uses'=> 'Api\LessonController@detail','as'=>'lesson.detail']);


Route::get('courses',['uses'=> 'Api\CourseController@list','as'=>'course.index']);
Route::get('courses/{course_id}',['uses'=> 'Api\CourseController@detail','as'=>'course.detail']);

