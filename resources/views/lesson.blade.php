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
        <div class="row">
            <h2>{{ $lesson-> title }} </h2>
        </div>
        @if ($purchased_course || $lesson->free_lesson ==1 )

            {!! $lesson-> full_text !!}
            <br>
            @foreach($lesson->getMedia('downloadable_files') as $media)
                <div class="row">

                    <iframe src="{{$media->getUrl()}}" width="640" height="360" autoplay="0" frameborder="0" allowfullscreen ></iframe>
                </div>
            @endforeach


        @else
            <h2 style="color: red;">Please,<a href="{{ route('courses.show',[$lesson->course->slug])}}">go back </a> and buy the course</h2>
        @endif


        <link rel="stylesheet" href="{{ asset('css/app.css') }}">


        <h3><a href="{{route('tests.show',[$lesson->course_id,$lesson->slug])}}" style="text-decoration: none;">Check yourself via TEST</a></h3>






        @if($previous_lesson)
            <p><a href="{{ route('lessons.show',[$previous_lesson->course_id,$previous_lesson->slug]) }}" style="text-decoration: none;"> << {{$previous_lesson->title}}</a></p>
        @endif

        @if($next_lesson)
            <p><a href="{{ route('lessons.show',[$next_lesson->course_id,$next_lesson->slug]) }}" style="text-decoration: none;">  {{$next_lesson->title}} >> </a></p>

    @endif
    </div>
@endsection