<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Local Fine Foods | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{URL::asset('/public/assets/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{URL::asset('/public/assets/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{URL::asset('/public/assets/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{URL::asset('/public/assets/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{URL::asset('/public/assets/dist/css/skins/_all-skins.min.css')}}">


  <link href="{{URL::asset('/public/plugins/summernote/dist/summernote.css')}}" rel="stylesheet" />
  @stack('styles')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .form-horizontal .control-label {
      padding-top: 0px !important;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    @include('layouts.header')
    @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    @yield('content')
  </div>
  <!-- /.content-wrapper -->

    @include('layouts.footer')


  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
{{-- <script src="{{URL::asset('/public/plugins/jquery/jquery.min.js')}}"></script> --}}
<!-- jQuery 3 -->
<script src="{{URL::asset('/public/assets/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{URL::asset('/public/js/custom.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::asset('/public/assets/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{URL::asset('/public/assets/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{URL::asset('/public/assets/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{URL::asset('/public/assets/dist/js/demo.js')}}"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
    <script src="{{URL::asset('/public/plugins/summernote/dist/summernote.min.js')}}"></script>

<script src="{{URL::asset('/public/js/jquery.validate.min.js')}}"></script>
<script src="{{URL::asset('/public/js/jquery.validate-init.js')}}"></script>
{{-- <script src="{{URL::asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> --}}

    @stack('scripts')
    <script type="text/javascript">
        $('div.alert').delay(10000).slideUp(500);
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#stateFilter').change(function(){
                var state = $(this).val();
                $.ajax({
                    url: "{{route('getCity')}}",
                    type: "POST",
                    data: {state: state},
                    success: function(data){
                        var cities = JSON.parse(data);
                        var options = "<option value='all'>All</option>";
                        for (var i = 0; i < cities.length; i++) {
                            options += "<option value='" + cities[i] + "'>" + cities[i] + "</option>";
                        }
                        $('#cityFilter').html(options);
                        window.location.reload();
                        // $('.preloader').show();
                        // $('#main-wrapper').load(window.location.href);
                    }
                })
            });

            $('#cityFilter').change(function(){
                var city = $(this).val();
                $.ajax({
                    url: "{{route('setCitySession')}}",
                    type: "POST",
                    data: {city: city},
                    success: function(data){
                        window.location.reload();
                    }
                })
            });
    </script>

</body>
</html>
