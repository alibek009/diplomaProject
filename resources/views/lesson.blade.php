@extends('layouts.home')
@section('title', $lesson-> title )
@section('sidebar')
    <div class="container" style="margin-top: 50px;margin-left: -50px;">
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
        <div class="row">
    <h2>{{ $lesson-> title }} </h2>
        </div>
    @if ($purchased_course || $lesson->free_lesson ==1 )

    {!! $lesson-> full_text !!}
            <br>
            @foreach($lesson->getMedia('downloadable_files') as $media)
                <div class="row">

                    <iframe width="854" height="480" src="{{$media->getUrl()}}" frameborder="0" allowfullscreen></iframe>
                </div>
            @endforeach

        @if($test_exists)
        <hr />
                    <div class="row">
        <form action="{{ route('lessons.test',[$lesson->slug]) }}" method="post">
            {{ csrf_field() }}


            <h3>Test: {{ $lesson->test->title }}</h3>
            @if (!is_null($test_result))
                <br>
            <div class="alert alert-info">Your test score is {{ $test_result->test_results }}</div>
                <br>
            @else

            @foreach($lesson->test->questions as $question)
                <b>{{ $loop->iteration }}. {{$question->question}}</b>
                <br>
                @foreach($question->options as $option)

                    <input type="radio" name="questions[{{ $question->id }}]" value="{{ $option->id }}"/>
                    {{ $option->option_text }}
                    <br>
                @endforeach
            @endforeach
            <input type="submit" value="Submit results"  class="btn btn-success"/>
        </form>
        @endif
        </div>
        <hr />

    @endif
        @else
        <h2>Please,<a href="{{ route('courses.show',[$lesson->course->slug])}}">go back </a> and buy the course</h2>
    @endif

    @if($previous_lesson)
    <p><a href="{{ route('lessons.show',[$previous_lesson->course_id,$previous_lesson->slug]) }}"> << {{$previous_lesson->title}}</a></p>
    @endif
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    @if($next_lesson)
        <p><a href="{{ route('lessons.show',[$next_lesson->course_id,$next_lesson->slug]) }}">  {{$next_lesson->title}} >> </a></p>
    @endif
@endsection