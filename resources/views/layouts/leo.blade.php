<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Local Fine Foods</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/ionicons/dist/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/icon-kit/dist/css/iconkit.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalert/sweetalert.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="{{asset('dist/css/theme.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/mohithg-switchery/dist/switchery.min.css')}}">
        <script src="{{asset('src/js/vendor/modernizr-2.8.3.min.js')}}"></script>
@stack('head-script')
</head>
    
<body class="hold-transition sidebar-mini text-sm layout-fixed">
    <div class="wrapper">
  @include('sections.header')

            <div class="page-wrap">
  @include('sections.menu')
                <div class="main-content">
                    <div class="container-fluid">

    @yield('content')
                </div>
                </div>
  @include('sections.footer')
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="{{asset('plugins/popper.js/dist/umd/popper.min.js')}}"></script>
        <script src="{{asset('plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalert/sweetalert.js')}}"></script>
        <script src="{{asset('plugins/moment/moment.js')}}"></script>
        <script src="{{asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')}}"></script>
        <script src="{{asset('plugins/mohithg-switchery/dist/switchery.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('dist/js/search.js') }}"></script>
        <script type="text/javascript"><!--
            var url_search = '{{ url("admin/quicksearch") }}';
        </script>
        <script src="{{asset('dist/js/theme.js')}}"></script>
        <script src="{{asset('dist/js/helper.js')}}" defer></script>

    @stack('scripts')
</body>
</html>
