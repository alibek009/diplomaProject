<?php

namespace App\Http\Controllers\Api;

use App\Course;
use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function list(){
        $lessons = Course::all();
        return response()->json($lessons);
    }

    public function detail($course_id){


        $course = Course::where('id',$course_id)->with('publishedLessons')->firstOrFail();
        return response()->json($course);
    }

    public function purchasedCourses($user_id){

        $purchased_courses = Course::whereHas('students',function($query) use ($user_id) {
            $query->where('id',$user_id);
        })->with('lessons')
            ->orderBy('id','desc')
            ->get();
        return response()->json($purchased_courses);
    }
}
