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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        .display-comment .display-comment {
            margin-left: 40px
        }
    </style>
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



                                    @if($lesson->video)
                                                <video controls style="width: 100%;">
                                                    <source src="/{{$lesson->video}}">
                                                    Your browser does not support the video tag.
                                                </video>
                                    @endif



            @if($test_exists)
                <h3><a href="{{route('tests.show',[$lesson->course_id,$lesson->slug])}}" style="text-decoration: none;">Өзіңді сына</a></h3>
            @endif

            <hr />

            @if($previous_lesson)
                <p><a href="{{ route('lessons.show',[$previous_lesson->course_id,$previous_lesson->slug]) }}" style="text-decoration: none;"> << {{$previous_lesson->title}}</a></p>
            @endif

            @if($next_lesson)
                <p><a href="{{ route('lessons.show',[$next_lesson->course_id,$next_lesson->slug]) }}" style="text-decoration: none;">  {{$next_lesson->title}} >> </a></p>

            @endif
            @if(\Auth::check())
            <hr />
            <h4>Сурақ және жауап</h4>
            @include('partials._comment_replies', ['comments' => $lesson->comments, 'post_id' => $lesson->id])

            <hr />
            <h4>Сурақ қою</h4>
            <form method="post" action="{{ route('comment.add') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="comment_body" class="form-control" />
                    <input type="hidden" name="post_id" value="{{ $lesson->id }}" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-warning btn-submit" value="Сурау" />
                </div>
            </form>
                @endif
        @else
            <h2 style="color: red;">Сабақты көру үшін <a href="{{ route('courses.show',[$lesson->course->slug])}}">сатып алыңыз </a> </h2>
        @endif


        <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    </div>
@endsection