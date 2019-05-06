<?php
//©Alibek009
namespace App\Http\Controllers\Api;

use App\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    public function list(){
        $lessons = Lesson::all();
        return response()->json($lessons);
    }

    public function detail($id){
        $lesson = Lesson::findOrFail($id);
        return response()->json($lesson);
    }


}
