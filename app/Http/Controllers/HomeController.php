<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $purchased_courses = NULL;
        if(\Auth::check()){
            $purchased_courses = Course::whereHas('students',function($query){
               $query->where('id',\Auth::id());
            })->with('lessons')
              ->orderBy('id','desc')
              ->get();
        }
        $courses =Course::where('published',1)->orderBy('id','desc')->paginate(6);
        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();

        return view('index',compact('courses','purchased_courses','grades'));
    }

}
