
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">


    <title>
        Okimyn
    </title>

    <link rel="icon" href="https://cdn1.iconfinder.com/data/icons/color-bold-style/21/34-128.png"  type = "image/x-icon" />

    <!--Snell Roundhand, cursive-->

</head>

<body>
    <div class="container" style="margin-top: 40px;margin-bottom: 40px;">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">


       <h1> <p>Certificate to  {{ Auth::user()->name }} {{ Auth::user()->surname }}</p></h1>
        <br>
        <h2>Course: {{ $course->title }}</h2>


    </div>
