@extends('layouts.home')
@section('title', 'Okymin')
@section('main')


      <!-- /.col-lg-3 -->
  <div class="container" style="margin-left: -50px;">

        <h3>All courses</h3>
        <div class="row">
          @foreach($grades as $grade)

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="{{ route('courses.show', [$grade->slug]) }}">
                <img class="card-img-top" src="{{ $grade->course_image }}" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="{{ route('courses.show', [$grade->slug]) }}">{{ $grade -> title }}</a>
                </h4>
                <h5>{{ $grade -> price }} KZT </h5>
                <p class="card-text">{{ $grade -> description }}</p>
              </div>
              <div class="card-footer">
                  <p class="text-right"> Students: {{ $grade->students()->count() }} </p>
                <div class="the-icons" style="margin-top: -40px;">

                  @for($star=1;$star<=5;$star++)
                    @if($grade->rating>=$star)
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