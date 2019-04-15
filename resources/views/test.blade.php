@extends('layouts.home')
@section('title', $lesson-> title )
@section('sidebar')
    <div class="container" style="margin-top: 50px;">
        <h4 class="my-2">{{ $lesson->course->title }}</h4>
        <div class="list-group">
            @foreach ($lesson->course->publishedLessons as $list_lesson)
                <a href="{{ route('lessons.show',[$list_lesson->course_id,$list_lesson->slug]) }}" class="list-group-item"
                   @if ($list_lesson->id == $lesson->id) style="font-weight: bold;" @endif> {{$loop->iteration}}.{{ $list_lesson->title }} </a>
            @endforeach
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
                        <div class="alert alert-info">Your test score is {{ $test_result->test_results }}</div>
                        <br>

                        @foreach($lesson->test->questions as $question)

                            <b>{{ $loop->iteration }}. {{$question->question}}</b>
                            <img src="{{ $question->question_image }}" alt="">
                            <br>
                            @foreach($question->options as $option)
                                @if($option->correct == 1)
                                <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}" />
                                    <p style="background-color: green; "><b>{{ $option->option_text }}</b></p>

                                    @else
                                    <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}"/>
                                     {{ $option->option_text }}
                                    <br>
                                @endif
                            @endforeach


                        @endforeach
                    @else

                        <div class="ques">

                        @foreach($lesson->test->questions as $question)

                                <b>{{ $loop->iteration }}. {{$question->question}}</b>
                                <img src="{{ $question->question_image }}" alt="">
                                <br>
                                @foreach($question->options as $option)

                                    <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}"/>
                                    {{ $option->option_text }}
                                    <br>
                                @endforeach


                        @endforeach
                        </div>
                        <input type="submit" value="Submit results"  class="btn btn-success btn-submit"/>
                </form>
            @endif



            @endif
        <br>
        <p><a href="{{ route('lessons.show',[$lesson->course_id,$lesson->slug]) }}" style="text-decoration: none;"> Back to the lesson <b>( {{$lesson->title}})</b>  </a></p>


    </div>
@endsection