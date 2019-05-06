<?php
//©Alibek009
namespace App\Http\Controllers\Api;

use App\Lesson;
use App\QuestionsOption;
use App\Test;
use App\TestsResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function index($lesson_id, Request $request){
        $lesson = Lesson::where('id', $lesson_id)->firstOrFail();

        $questions = $lesson->test->questions;
        return response()->json($questions);
    }
}
