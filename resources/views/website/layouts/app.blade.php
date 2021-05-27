<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>Rigo Ride</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

    <link rel="stylesheet" href="{{URL::asset('/public/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('/public/css/website_style.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('/public/css/owl.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <style type="text/css">
        .driverImage,
        .driverDoc {
            display: none;
        }

        .docUpload {
            float: left;
        }

        .docUpload .images {
            width: 100%;
        }

        .lastDoc .images {
            width: 47%;
        }

        .lastDoc {
            text-align: center;
        }
    </style>
</head>

<body>
    @include('website.layouts.header') @yield('content')
    @include('website.layouts.footer')
    </div>
    </div>
    <script src="{{URL::asset('/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('/js/bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('/js/owl.carousel.js')}}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
    <script src="{{URL::asset('/js/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('/js/jquery.validate-init.js')}}"></script>
    @stack('scripts')
    <script>
        $(document).ready(function () {
                var owl = $('.whyRigoSlide');
                owl.owlCarousel({
                    margin: 20,
                    nav: true,
                    loop: false,
                    slideBy: 2,
                    navigation: false,
                    autoplay:true,
                    autoplayTimeout:5000,
                    responsive: {
                        0: {
                            items: 1
                        },
                        500: {
                            items: 1
                        },
                        768: {
                            items: 2
                        }
                    }
                })

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#driverState').change(function(){
                    var state = $(this).val();
                    $.ajax({
                        url: "{{route('getDriverCity')}}",
                        type: "POST",
                        data: {state: state},
                        success: function(data){
                            var cities = JSON.parse(data);
                            var options = "<option value=''>-Select City-</option>";
                            for (var i = 0; i < cities.length; i++) {
                                options += "<option value='" + cities[i] + "'>" + cities[i] + "</option>";
                            }
                            $('#driverCity').html(options);
                        }
                    })
                });

                $('#driverCity').change(function(){
                    var city = $(this).val();
                    var state = $('#driverState').val();
                    $.ajax({
                        url: "{{route('getDriverVehicle')}}",
                        type: "POST",
                        data: {city: city, state: state},
                        success: function(data){
                            var vehicles = JSON.parse(data);
                            var options = "<option value=''>-Select Vehicle-</option>";
                            for (var i = 0; i < vehicles.length; i++) {
                                options += "<option value='" + vehicles[i].id + "'>" + vehicles[i].vehicle_type + "</option>";
                            }
                            $('#driverVehicle').html(options);
                        }
                    })
                });
                $("body").addClass("homePage")
            });
    </script>
</body>

</html>