@extends('layouts.home')
@section('title', $course->title)
@section('main')

    <div class="container" style="margin-top: 40px;margin-bottom: 40px;">
            <h2>{{ $course-> title }} </h2>
            <p>{{$course-> description}}</p>

            @if ( \Auth::check() && $course->students()->where('user_id',\Auth::id())->count()>0)
                Рейтинг: {{ $course->rating }} / 5

                <hr>
                <b>Сабақты бағалаңыз</b>

                <br />
                <form action="{{ route('courses.rating',[$course->id]) }}" method="post">
                    {{csrf_field()}}
                    <select name="rating" >
                        <option value="1">1 - Өте жаман</option>
                        <option value="2">2 - Жаман</option>
                        <option value="3">3 - Ойдағыдай емес</option>
                        <option value="4" selected>4 - Жақсы</option>
                        <option value="5">5 - Тамаша</option>
                    </select>
                    <input type="submit" value="Бағалау" class="btn btn-success">
                </form>
                <hr>

                @endif



            @if ( \Auth::check())
                @if ($course->students()->where('user_id',\Auth::id())->count()==0)
                    <form action="{{ route('courses.payment') }}" method="POST">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('PUB_STRIPE_API_KEY') }}"
                                data-amount="{{ $course->price * 100 }}"
                                data-currency="kzt"
                                data-name="Okymin"
                                data-label="Сатып алу ({{ $course->price }}KZT)"
                                data-description ="Course {{ $course->title }}"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto"
                                data-zip-code="false"
                        >
                        </script>

                        {{ csrf_field() }}
                    </form>
                @endif
            @else
                <a href="{{ route('auth.register') }}?redirect_url={{ route('courses.show',[$course->slug]) }}"
                   class="btn btn-primary"> Сатып алу ({{ $course->price }} KZT)</a>
                @endif





    <div class="col-lg-13">
    @foreach($course->publishedLessons as $lesson)
     {{ $loop-> iteration }}.<a href="{{ route('lessons.show',[$lesson->course_id,$lesson->slug]) }}"> {{$lesson->title}} </a>
            @if ($lesson->free_lesson )(FREE!) @endif

    <p>{{ $lesson->short_text }}</p>
    <br>

    @endforeach
    </div>
    </div>
@endsection