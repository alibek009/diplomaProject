<?php
//©Alibek009
namespace App\Http\Controllers\Api;

use App\Lesson;
use App\Question;
use App\QuestionsOption;
use App\Test;
use App\TestsResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function question($lesson_id, Request $request){
        $lesson = Lesson::where('id', $lesson_id)->firstOrFail();

        $questions = $lesson->test->questions;
        return response()->json($questions);
    }

    public function options($question_id, Request $request){
        $question = Question::where('id', $question_id)->firstOrFail();

        $options = $question->options;
        return response()->json($options);
    }
}
