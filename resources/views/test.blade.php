@extends('layouts.home')
@section('title', $lesson-> title )
@section('sidebar')
    <div class="container" style="margin-top: 50px;">
        <h4 class="my-2">Your progress</h4>
        <div class="list-group">
            @if (!is_null($test_result))
                @foreach ($lesson->course->publishedLessons as $list_lesson)
                    @if($list_lesson->test != NULL)
                        @foreach($all_results as $res)
                            @if($list_lesson->test->id == $res->test_id)
                                @if($res->test_results < $list_lesson->test->questions->count())
                                    <a href="{{ route('tests.show',[$list_lesson->course_id,$list_lesson->slug]) }}"
                                       class="list-group-item">

                                        {{$list_lesson->title}} - <b style="font-size: 1em; color: #1745ff;">{{round($res->test_results/ $list_lesson->test->questions->count() * 100,2)}} %</b></a>
                                        @else
                                    <a href="{{ route('tests.show',[$list_lesson->course_id,$list_lesson->slug]) }}"
                                       class="list-group-item">
                                            {{$list_lesson->title}} - <b style="font-size: 1em; color: #1745ff;">100 % </b></a>

                            @endif

                            @endif
                        @endforeach
                    @endif
                @endforeach
                @endif
        </div>
    </div>
@endsection
@section('main')
    <div class="container" style="margin-top: 40px;margin-bottom: 40px;">



        <link rel="stylesheet" href="{{ asset('css/app.css') }}">



        @if($test_exists)


                <form action="{{ route('tests.test',[$lesson->slug]) }}" method="post">
                    {{ csrf_field() }}


                    <h3>Test: {{ $lesson->test->title }}</h3>

                    @if (!is_null($test_result))
                        <br>
                        @if( $test_result->test_results < $max_result)
                        <div class="alert alert-info">Your test score is {{ round($test_result->test_results/$max_result * 100,2) }} % </div>
                        <br>
                        @else
                            <div class="alert alert-info">Your test score is 100 % </div>
                            <br>
                            @endif
                        @foreach($lesson->test->questions as $question)

                            <h4><b>{{ $loop->iteration }}. {{$question->question}}</b></h4>
                            <br>
                            @foreach($question->options as $option)
                                @if($option->correct == 1)
                                <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" />

                                    <p style="background-color: green; "><b>{{ $option->option_text }}</b></p>
                                    @else
                                    <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" />

                                    <b>{{ $option->option_text }}</b>
                                    <br>
                                @endif


                                    @endforeach


                        @endforeach



                                @foreach($purchased_course as $c)
                            @if($test_result->test_results >= ($max_result/2) and (\Auth::user()->lessons()->where('course_id',$c->id)->count() == $c->lessons->count()))

                                <h2><a href="{{ route('certificate.pdf',[$lesson->course_id])}}">Certificate</a>

                                </h2>
                                @endif
                        @endforeach
                    @else

                        <div class="ques">

                        @foreach($lesson->test->questions as $question)

                                <b>{{ $loop->iteration }}. {{$question->question}}</b>
                                <img src="{{ $question->question_image }}" alt="">
                                <br>
                                @foreach($question->options as $option)

                                    <input type="checkbox" name="questions[{{ $question->id }}]" value="{{ $option->id }}"/>
                                    {{ $option->option_text }}
                                    <br>
                                @endforeach


                        @endforeach
                        </div>
                        <input type="submit" value="Submit results"  class="btn btn-success btn-submit"/>
                </form>
            @endif




        <br>
        <p><a href="{{ route('lessons.show',[$lesson->course_id,$lesson->slug]) }}" style="text-decoration: none;"> Back to the lesson <b>( {{$lesson->title}})</b>  </a></p>



        @endif


    </div>
@endsection