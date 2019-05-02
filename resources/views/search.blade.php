@extends('layouts.home')
@section('title', 'Okymin')
@section('main')


      <!-- /.col-lg-3 -->
  <div class="container" style="margin-top: 40px;">

          <h3>Search results:</h3>


          @foreach($courses as $course)
      <div class="row">
        <div class="card mb-3" style="max-width: 540px;">
          <div class="row no-gutters">
            <div class="col-md-4">
              <a href="{{ route('courses.show', [$course->slug]) }}">
              <img class="card-img-top" src="{{ $course->course_image }}" alt="" style="height: 100%;" ></a>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title"><a href="{{ route('courses.show', [$course->slug]) }}">{{ $course -> title }}</a></h5>
                <p class="card-text">{{ $course -> description }}</p>
                <p class="card-text"><small class="text-muted"><h5>{{ $course -> price }} KZT </h5></small></p>
              </div>
            </div>
          </div>
        </div>
      </div>

          @endforeach

  </div>

@endsection