<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Local Fine Foods</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    @include('layouts.message')
                        <form class="form-horizontal form-material form-valide" method="post" id="loginform" action="{{route('login')}}">
                            {{csrf_field()}}
                            <div class="form-group row">
                                <label class="col-form-label" for="val-email">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="val-email" name="val-email" placeholder="Your Email">
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label" for="val-pass">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="val-pass" name="val-pass" placeholder="Your Password">
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="checkbox checkbox-info pull-left p-t-0">
                                        <input id="checkbox-signup" type="checkbox" class="filled-in chk-col-light-blue" name="val-remember" {{ old( 'remember')
                                            ? 'checked' : '' }}>
                                        <label for="checkbox-signup"> Remember me </label>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="pull-right">
                                            <a href="{{route('forgotGet')}}">Forgot Password?</a>
                                        </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-flat m-b-30 m-t-30">Sign in</button>
                            <!-- <div class="register-link m-t-15 text-center">
                                    <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                                </div> -->
                        </form>
{{--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>
 --}}
  </div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
