<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>
    Okimyn
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
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" >
    <a class="navbar-brand" href="/">Okymin</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>
    </button>
          <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">


              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Grades</a>
                <div class="dropdown-menu">
                  <form action="/grades"  method="get" class="form-inline my-2 my-lg-0" >
                  @foreach($grades as $grade )
                  <input type="submit" name="grade" value="{{ $grade->grade }}" class="dropdown-item" href="{{ route('courses.grades',$grade->grade) }}">
                @endforeach

                  </form>
                </div>
              </li>




              <li class="nav-item">
                <form action="/search" method="get" class="form-inline my-2 my-lg-0" style="height: 35px;width: 250px; margin-top: 4px; ">
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
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarColor02">
              <ul class="navbar-nav ml-auto">

          @if (Auth::check())


                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu" style="margin-left: -90px;">
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
                  </li>

          @else


      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

      <!-- jQuery Modal -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />

        <li class="nav-item active">
      <a href="#log" rel="modal:open" class="nav-link" id="logBut" >Login</a>
            <div id="log" class="modal" style="height: 200px;">


              <form action="{{ route('auth.login') }}" method="post">
                {{ csrf_field() }}
                <input class="dropdown-item" type="email" name="email" placeholder="Email" style=" border: 2px ;border-radius: 4px;background-color: #c7d9ff; height: 35px;" />
                <br>
                <input class="dropdown-item" type="password" name="password" placeholder="Password" style="border: 2px ;border-radius: 4px;background-color: #c7d9ff; height: 35px;"/>
                <br>
                <input class="dropdown-item" type="submit" value="Login" class="btn btn-info" style=" padding-top: 3px; height: 35px; width:100px;text-align: center;border-radius: 50px; text-align: center;background-color: #34bbe2;margin-left: 170px;">


              </form>
            </div>
        </li>

                <script>
                 $('#logBut').click(function(){
                  setTimeout("$('#log').show()",2000) ;
                 });
                </script>
        <li class="nav-item active">
      <a href="{{ route('auth.register') }}?redirect_url={{ route('courses.show',"math-7-grade") }}"
         class="nav-link"> Register </a>
        </li>


          @endif
              </ul>

          </div>

  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">


      <!-- /.col-lg-3 -->
      <div class="col-lg-3">

        @yield('sidebar')


      </div>

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
