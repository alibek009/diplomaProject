@extends('layouts.home')
@section('title', 'Okymin')
@section('main')


      <!-- /.col-lg-3 -->
  <div class="container" style="margin-left: -100px;">



        @if(!is_null($purchased_courses))

          <h3>My courses</h3>
          <div class="row">

            @foreach($purchased_courses as $course)

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                  <a href="{{ route('courses.show', [$course->slug]) }}">
                    <img class="card-img-top" src="{{ $course->course_image }}" alt="" ></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="{{ route('courses.show', [$course->slug]) }}">{{ $course -> title }}</a>
                    </h4>
                    <p class="card-text">{{ $course -> description }}</p>
                  </div>
                  <div class="card-footer">
                    <p>Progress: {{ Auth::user()->lessons()->where('course_id',$course->id)->count() }}
                      of {{ $course->lessons->count() }} lessons</p>
                  </div>
                </div>
              </div>

            @endforeach
          </div>
          <hr />
        @endif


        <h3>All courses</h3>
        <div class="row">
          @foreach($courses as $course)

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="{{ route('courses.show', [$course->slug]) }}">
                <img class="card-img-top" src="{{ $course->course_image }}" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="{{ route('courses.show', [$course->slug]) }}">{{ $course -> title }}</a>
                </h4>
                <h5>{{ $course -> price }} KZT </h5>
                <p class="card-text">{{ $course -> description }}</p>
              </div>
              <div class="card-footer">
                  <p class="text-right"> Students: {{ $course->students()->count() }} </p>
                <div class="the-icons" style="margin-top: -40px;">

                  @for($star=1;$star<=5;$star++)
                    @if($course->rating>=$star)
                          <i class="fa fa-star"></i>
                      @else

                          <i class="fa fa-star-o"></i>
                      @endif

                    @endfor

                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
  </div>
@endsection