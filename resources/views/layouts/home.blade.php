<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>
    @yield('title')
  </title>

  <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/color-bold-style/21/34-128.png"  type = "image/x-icon" />

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
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" >
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="navbar-brand" href="/">Okymin
                </a>
              </li>


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Grades</a>
                <div class="dropdown-menu">
                  @foreach($grades as $grade )
                  <a class="dropdown-item" href="{{ route('courses.grades',$grade->grade) }}">{{ $grade->grade }}</a>
                @endforeach
              </li>




              <li class="nav-item">
                <form action="/search" method="get" class="form-inline my-2 my-lg-0" style="height: 35px;width: 250px;margin-left: 40px; margin-top: 4px; ">
                    <div class="input-group" >
                      <input type="search" name="search" class="form-control" style=" height: 35px;margin-top: 2px;">
                      <span class="input-group-prepend">
                        <button class="btn btn-secondary " type="submit" style=" height: 37px; border-radius: 4px; margin-top: 1px;" >
                          <i class="fa fa-search" style="color: black; "></i>
                        </button>
                      </span>
                    </div>
                </form>
              </li>
            </ul>
          </div>
        </div>
        </div>
      <div class="row">
        <div class="col-lg-8 text-right">
          <div class="collapse navbar-collapse" id="navbarResponsive">

          @if (Auth::check())

              <button id="btnGroupDrop1" type="button" class="btn btn-primary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 150px;"> {{ Auth::user()->name }} </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                <form action="{{ route('auth.logout') }}" method="post" >

                  {{ csrf_field() }}
                      @if(!Auth::user()->isStudent())
                        <a class="dropdown-item" href="#" style="text-align:center; color:black;" >{{ Auth::user()->name }}</a>
                      @else
                        <a class="dropdown-item" href="/admin/home" style="text-align:center; color:black;" >{{ Auth::user()->name }}</a>
                      @endif

                      <input type="submit" value="Logout" class="dropdown-item" style=" text-align: center; color:black;">

                </form>
              </div>

          @else

              <button id="btnGroupDrop1" type="button" class="btn btn-primary " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 150px;"> Login </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px); width: 250px;">
                <form action="{{ route('auth.login') }}" method="post">
                  {{ csrf_field() }}
                      <input class="dropdown-item" type="email" name="email" placeholder="Email" style=" border: 2px ;border-radius: 4px;background-color: #c7d9ff; height: 35px;" />
                  <br>
                      <input class="dropdown-item" type="password" name="password" placeholder="Password" style="border: 2px ;border-radius: 4px;background-color: #c7d9ff; height: 35px;"/>
                  <br>
                      <input class="dropdown-item" type="submit" value="Login" class="btn btn-info" style=" padding-top: 3px; height: 35px; text-align: center;">


                </form>
              </div>


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


    <!-- /.row -->


  <!-- /.container -->

  <!-- Footer -->


  <!-- Bootstrap core JavaScript -->
  <script src="/vendor/jquery/jquery.min.js"></script>

  <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</body>

</html>
