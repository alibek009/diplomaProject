<?php

use Illuminate\Http\Request;

Route::get('quiz/{lesson_id}',['uses'=> 'Api\QuizController@question','as'=>'quiz.index']);
Route::get('quiz/options/{question_id}',['uses'=> 'Api\QuizController@options','as'=>'quiz.index']);


Route::get('user/{id}',['uses'=> 'Api\UserController@detail','as'=>'user.detail']);


Route::get('lessons',['uses'=> 'Api\LessonController@list','as'=>'lesson.index']);
Route::get('lessons/{id}',['uses'=> 'Api\LessonController@detail','as'=>'lesson.detail']);


Route::get('courses',['uses'=> 'Api\CourseController@list','as'=>'course.index']);
Route::get('courses/{course_id}',['uses'=> 'Api\CourseController@detail','as'=>'course.detail']);
Route::get('courses/{user_id}/purchasedcourses',['uses'=> 'Api\CourseController@purchasedCourses','as'=>'course.purchased']);

Route::post('login','Api\PassportController@login');
Route::post('register','Api\PassportController@register');

Route::group(['middleware'=>'auth:api'],function(){
    Route::post('get-details','Api\PassportController@details');
});