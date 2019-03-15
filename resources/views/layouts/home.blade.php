<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Bootstrap core CSS -->
  <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="/css/shop-homepage.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" >
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="navbar-brand" href="/">Okymin
                </a>
              </li>
              <li class="nav-item ">
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Grades
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      @foreach($grades as $grade )
                      <a class="dropdown-item" href="{{ route('courses.grades',$grade->grade) }}">{{ $grade->grade }}</a>
                        @endforeach
                    </div>
                  </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contacts</a>
              </li>
            </ul>
          </div>
        </div>
        </div>
      <div class="row">
        <div class="col-lg-8 text-right">
          <div class="collapse navbar-collapse" id="navbarResponsive">

          @if (Auth::check())


            <form action="{{ route('auth.logout') }}" method="post">

              {{ csrf_field() }}
              <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                @if(!\Auth::user()->isStudent())
                <a class="navbar-brand text-right" href="#" >{{ Auth::user()->name }}</a>
                  @else
                <a class="navbar-brand text-right" href="/admin/home" >{{ Auth::user()->name }}</a>
                @endif
              </li>
              <li class="nav-item">
              <input type="submit" value="Logout" class="btn btn-danger" style="height: 30px; margin-top: 6px; text-align: center;">
              </li>
              </ul>
            </form>
          @else

            <form action="{{ route('auth.login') }}" method="post">
              {{ csrf_field() }}
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
              <input type="email" name="email" placeholder="Email" style="border: 2px solid darkgrey;border-radius: 4px; margin-right: 4px;" />
                </li>
                <li class="nav-item">
              <input type="password" name="password" placeholder="Password" style="border: 2px solid darkgrey;border-radius: 4px;margin-right: 4px;"/>
                </li>
                <li class="nav-item">
              <input type="submit" value="Login" class="btn btn-info" style="height: 30px; padding-top: 3px; margin-bottom: 2px;">
                </li>
              </ul>
            </form>
          @endif
        </div>
      </div>
      </div>
    </div>


  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        @yield('sidebar')


      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9">

         @yield('main')

      </div>

        </div>
        <!-- /.row -->

      </div>
      <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright 2019 &copy; Alibek Amangeldiyev | Kuanysh Yerezhep | Zhumabay Rauan </p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
