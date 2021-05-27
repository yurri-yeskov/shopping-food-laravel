@extends('layouts.app') 
@section('title', 'Change Password') 
@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
                <section id="wrapper">
            <div class="login-register" style="background-image:url({{ asset('/images/background/login-register.jpg') }});padding: 20px;">
                <div class="login-box card">
                    <div class="card-body">
                        <div class="login-form">
                            <h4>Forgot Password</h4>
                            @include('layouts.message')
                            <form class="form-valide" method="post" action="{{route('forgotPost')}}">
                                {{csrf_field()}}
                                <div class="form-group row m-t-40">
                                    <input type="text" class="form-control" id="val-email" name="val-email" placeholder="Your Email *">
                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Send Mail</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
            </div>
        </div>
  </div>
@endsection
 @push('scripts') 
<script type="text/javascript">
        $('div.alert').delay(3000).slideUp(300);
</script>
@endpush