<?php

use Illuminate\Http\Request;

Route::get('quiz/{slug}',['uses'=> 'Api\QuizController@index','as'=>'quiz.index']);


Route::get('user/{id}',['uses'=> 'Api\UserController@detail','as'=>'user.detail']);


Route::get('lessons',['uses'=> 'Api\LessonController@list','as'=>'lesson.index']);
Route::get('lessons/{id}',['uses'=> 'Api\LessonController@detail','as'=>'lesson.detail']);


Route::get('courses',['uses'=> 'Api\CourseController@list','as'=>'course.index']);
Route::get('courses/{course_id}',['uses'=> 'Api\CourseController@detail','as'=>'course.detail']);
Route::get('courses/{user_id}/purchasedcourses',['uses'=> 'Api\CourseController@purchasedCourses','as'=>'course.purchased']);


Route::middleware('auth:api')->get('/user',function(Request $request){
    return $request->user();
});