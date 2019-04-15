<?php

namespace App\Http\Controllers\Api;

use App\Lesson;
use App\Test;
use App\TestsResult;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    public function index($lesson_slug, Request $request){
        $lesson = Lesson::where('slug', $lesson_slug)->firstOrFail();

        $tests = $lesson->test->questions;
        return response()->json($tests);
    }
}
