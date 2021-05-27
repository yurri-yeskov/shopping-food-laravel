<!DOCTYPE html>
<html lang="en" lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="viewport" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,width=device-width,user-scalable=no" />
    <title>Local Fine Foods</title>
    <link rel="shortcut icon" href="{{URL::asset('/images/favicon.png')}}" type="image/x-icon" />
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700');
    </style>
    <!-- <link async rel="stylesheet" href="https://css.virtuousreviews.com/bootstrap/css/bootstrap.min.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->

    <style type="text/css">
        body {
            font-size: 16px;
            margin: 0 auto;
            padding: 0px;
            font-weight: 400;
            font-family: 'Roboto';
        }

        .bookingpanel {
            background-color: #fff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, .10);
            width: 80%;
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 1em 0;
            text-align: center;
            max-width: 100%;
        }
    </style>

</head>

<body>
    <section class="bookingpanel">
        
    @if(Session::has('success'))
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>Success! </strong> {{Session::get("success")}}
        </div>
    </div>
    @elseif(Session::has('error'))
    <div class="row">
        <div class="col-md-12 text-center">
            <strong>Alert !</strong> {{Session::get("error")}}
        </div>
    </div>
    @endif

        <div class="font30"><img src="{{ asset('images/logo.png')}}"></div>
        <div class="font30">
            <h2>Local Fine Foods</h2>14/72 Main Hurstbridge Road Diamond Creek, VIC 
        </div>
        <div class="font30"><br>
            <hr>
            <strong>We deliver to</strong> <br>
            @foreach($suburbs as $suburb)
                {{$suburb->name}},  
            @endforeach
            <br><br>
        </div>
        <div class="font30">
            <a href="https://play.google.com/store/apps/details?id=com.localfinefoods.localfinafoods" target="_blank"> <img src="{{ asset('images/google.png')}}" width="200px"></a>
            <a href="https://apps.apple.com/au/app/local-fine-foods/id1527048365" target="_blank"> <img src="{{ asset('images/apple.png')}}" width="200px"></a></div>
        @auth
        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"><i class="fa fa-power-off  dropdown-icon"></i> Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>

        @endauth
    </section>
</body>

</html>