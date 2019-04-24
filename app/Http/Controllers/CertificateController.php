<?php

namespace App\Http\Controllers;

use App\Course;
use App\Lesson;
use App\User;
use Illuminate\Http\Request;
use PDF;
class CertificateController extends Controller
{
    //


    public function show($course_slug){

        $course = Course::where('slug',$course_slug)->with('publishedLessons')->firstOrFail();
        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();

        return view('certificate',compact('course','grades'));
    }
    public function pdf($course_id){
        $course = Course::where('id',$course_id)->with('publishedLessons')->firstOrFail();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert__data_to_html($course))->setPaper(array(0,0,800,1100),'landscape')->setOptions(['isRemoteEnabled' => true,'dpi' => 150, 'defaultFont' => 'Comic Sans MS']);

        return $pdf->stream('certificate.pdf');
    }

    function convert__data_to_html($course){
        $teacher_name = $course->teachers()->get();
        $output = '<br><br><br>
                <h1 style="text-align: center; font-size:4em;"  > Certificate of Completion </h1>
                <br>
                <h2 style="text-align: center;font-size: 3em;">to</h2>
                <br>
                <h2 style="text-align: center; font-size:4em;"  > ' .  \Auth::user()->name  .' '. \Auth::user()->surname . '</h2>
                <br>
                <h2 style="text-align: center;font-size: 3em;">Course : '.$course->title.'</h2>
                <br> 
                <img src="https://images-eu.ssl-images-amazon.com/images/I/21E7kl6XtNL._AC_SS350_.jpg" alt="" style="margin-left: 1400px;">
                <img src="https://previews.123rf.com/images/nalinn/nalinn1508/nalinn150800026/44272485-red-grunge-approved-rubber-stamp-isolated-on-white-background.jpg" alt="" style="margin-right:400px; margin-top:-300 px;;width: 200px;height: 200px;">
                
                ';

        return $output;
    }
}
