<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('front/css/landing/landing.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{--    <script href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}
    <title>A-Translate - HomePage</title>
</head>
<body>
<div class="container-fluid main">

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" style="color: #0d45a5; text-decoration: 1px tomato solid" href="{{ route('dashboard.index') }}">Login/SignUp</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">

{{--                                        <li><a href=""></a></li>--}}
                    {{--                    <li><a href="#">About</a></li>--}}
{{--                    <li><a href="#">Contact Us</a></li>--}}
                </ul>
            </div>
        </div>
    </nav>

    <div id="myCarousel" class="carousel carousel-fade slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner" role="listbox">
            <div class="item active background a"></div>
            <div class="item background b"></div>
            <div class="item background c"></div>
        </div>
    </div>

    <div class="covertext">
        <div class="col-lg-10" style="float:none; margin:0 auto;">
            <h1 class="title">A-Translate</h1>
            <h3 class="subtitle">Select Your Pdf , Upload , Tokenize , Translate , Print All Unknown Words</h3>
            <h3 class="subtitle" style="color: tomato">You Must Log in First !</h3>
            <br>
            <hr>
            <h4 class="subtitle" style="color: black">Trial Version  1.1</h4>
        </div>
        <div class="col-xs-12 explore">
            <a href="{{ route('dashboard.index') }}"><button type="button" class="btn btn-lg explorebtn" style="color: black">Start</button></a>
        </div>

    </div>


</div>

@section('js')
    <script>
        /* When your mouse cursor enter the background, the fading won't pause and keep playing */
        $('.carousel').carousel({
            pause: "false" /* Change to true to make it paused when your mouse cursor enter the background */
        });
    </script>
@endsection

</body>
</html>
