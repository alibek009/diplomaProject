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
        $output = '<style>
body{
font-family: DejaVu Sans;
}
</style>

<div style="width:2100px; height:1200px; padding:20px; text-align:center; border: 10px solid #787878">
<div style="width:2050px; height:1150px; padding:20px; text-align:center; border: 5px solid #787878">
<br><br><br><br><br><br>
       <span style="font-size:50px; font-weight:bold">Бітіру сертификаты</span>
       <br><br>
       
       <span style="font-size:30px"><b>' . \Auth::user()->name.' '. \Auth::user()->surname .'</b></span><br/><br/>
       <span style="font-size:25px"><i>оқушысына</i></span>
       <br><br>
       <span style="font-size:30px"> <b>'.$course->title.'</b> курсын</span> <br/><br/>
       <span style="font-size:25px"><i>бітіргені үшін  берілді</i></span> <br/><br/>
       <span style="font-size:25px"><i>Берілген күн:</i></span><br>
      '.date('d-m-Y', strtotime($course->updated_at)) .'
</div>
</div>
                ';

        return $output;
    }
}
