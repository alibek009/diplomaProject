@extends('layouts.home')
@section('title', 'Okymin')
@section('sidebar')
<style>
    @media screen and (max-width: 768px) { /* 400 px */

        .visible-lg {
            display: none;
        }

    }
</style>

    <div class="visible-lg"  style="margin-top: 50px;text-align: center;">

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#sidebar-wrapper"
                aria-controls="sidebar-wrapper" aria-expanded="true" aria-label="Toggle navigation">

            <h3>Пәндер</h3>
        </button>
        <div class="list-group list-group-flush" id="sidebar-wrapper" >
            <form action="/search" method="get">
                <input type="submit" name="search" value="Математика"  class="list-group-item list-group-item-action bg-light-blue-active"
                       href="{{ route('courses.search',"math") }}">
            <input type="submit" name="search" value="Физика" class="list-group-item list-group-item-action bg-light-blue-active"
                   href="{{ route('courses.search',"physics") }}">
            <input type="submit" name="search" value="Ағылшын тілі" class="list-group-item list-group-item-action bg-light-blue-active"
                   href="{{ route('courses.search',"english") }}">
            <input type="submit" name="search" value="Биология" class="list-group-item list-group-item-action bg-light-blue-active"
                   href="{{ route('courses.search',"biology") }}">
            <input type="submit" name="search" value="Қазақ тілі" class="list-group-item list-group-item-action bg-light-blue-active"
                       href="{{ route('courses.search',"kazakh") }}">
            <input type="submit" name="search" value="Орыс тілі" class="list-group-item list-group-item-action bg-light-blue-active"
                       href="{{ route('courses.search',"russian") }}">
            </form>
        </div>


    </div>
@endsection
@section('main')


      <!-- /.col-lg-3 -->
  <div class="container" style="margin-top: 50px;">



        @if(!is_null($purchased_courses))

          <h3>Менің сабақтарым</h3>
          <div class="row" id="dat">

            @foreach($purchased_courses as $course)

              <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-dark">
                  <a href="{{ route('courses.show', [$course->slug]) }}" >
                    <img class="card-img-top" src="{{ $course->course_image }}" alt="" style="height: 110px;" ></a>
                  <div class="card-body">
                    <h4 class="card-title">
                      <a href="{{ route('courses.show', [$course->slug]) }}" style="text-decoration: none;">{{ $course -> title }}</a>
                    </h4>
                    <p class="card-text">{{ $course -> description }}</p>
                  </div>
                  <div class="card-footer">
                    <p>Прогресс: {{ Auth::user()->lessons()->where('course_id',$course->id)->count() }}
                       сабақтан оқылды: {{ $course->lessons->count() }}</p>

                      <div class="progress">
                          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{round(( Auth::user()->lessons()->where('course_id',$course->id)->count()) / ($course->lessons->count())*100) }}%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                  </div>

                </div>
              </div>

            @endforeach
          </div>
          <hr />
        @endif


        <h3>Барлық сабақтар</h3>
        <div class="row" id="table_data">
          @foreach($courses as $course)

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 border-dark" >
              <a href="{{ route('courses.show', [$course->slug]) }}">
                <img class="card-img-top" src="{{ $course->course_image }}" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="{{ route('courses.show', [$course->slug]) }}" style="text-decoration: none;">{{ $course -> title }}</a>
                </h4>
                <h5>{{ $course -> price }} KZT </h5>
                <p class="card-text">{{ $course -> description }}</p>
              </div>
              <div class="card-footer">
                  <p class="text-right"> Оқушылар: {{ $course->students()->count() }} </p>
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
            {!! $courses->links() !!}

      <script>
          $(document).ready(function(){

              $(document).on('click', '.pagination a', function(event){
                  event.preventDefault();
                  var page = $(this).attr('href').split('page=')[1];
                  fetch_data(page);
              });

              function fetch_data(page)
              {
                  $.ajax({
                      url:"/?page="+page,
                      success:function(data)
                      {
                          $('.row').html(data);
                      }
                  });
              }

          });
      </script>
  </div>
            <div class="container">
                <span class="text-muted">© Alibek Amangeldiyev,Kuanysh Yerezhep,Rauan Zhumabay</span>
            </div>
@endsection