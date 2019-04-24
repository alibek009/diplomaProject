<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Test;
use App\Videos;
use App\Course;
use App\Question;
use App\QuestionsOption;
use App\TestsResult;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function show($course_id,$lesson_slug){
        $lesson = Lesson::where('slug',$lesson_slug)->where('course_id',$course_id)->firstOrFail();

        $course =Course::where('published',1)->orderBy('id','desc')->firstOrFail();
        $grades = Course::select('grade')->whereNotNull('grade')->groupBy('grade')->get();


        if(\Auth::check())
        {
            if($lesson->students()->where('id',\Auth::id())->count()==0) {
                $lesson->students()->attach(\Auth::id());
            }
        }
        $test_result= NULL;
        $max_result = 0;
        if($lesson->test){
            $test_result = TestsResult::where('test_id',$lesson->test->id)
                ->where('user_id',\Auth::id())
                ->first();

        }
        $all_results = TestsResult::all()->where('user_id',\Auth::id());

        $test_exists =FALSE;
        if($lesson->test && $lesson->test->questions){
            $test_exists =TRUE;
            $max_result = $lesson->test->questions->count();
        }


        $purchased_courses = Course::whereHas('students',function($query){
            $query->where('id',\Auth::id());
        })->with('lessons')
            ->orderBy('id','desc')
            ->get();
        $purchased_course = $purchased_courses->where('id',$course_id);
        return view('test',compact('lesson','test_result','all_results','purchased_course','max_result','test_exists','grades','course'))->render();

        }

    public function test($lesson_slug, Request $request)
    {
        $lesson = Lesson::where('slug', $lesson_slug)->firstOrFail();
        $answers = [];
        $test_score = 0;
        foreach ($request->get('questions') as $question_id => $answer_id) {
            $question = Question::find($question_id);

            $correct = QuestionsOption::where('question_id', $question_id)
                    ->where('id', $answer_id)
                    ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'option_id' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                $test_score += $question->score;
            }

        }
        $test_result = TestsResult::create([
            'test_id' => $lesson->test->id,
            'user_id' => \Auth::id(),
            'test_results' => $test_score
        ]);
        $test_result->answers()->createMany($answers);
        return redirect()->route('tests.show',  [$lesson->course_id,$lesson_slug])->with('message', 'Test score: ' . $test_score . ' ');

    }


}
