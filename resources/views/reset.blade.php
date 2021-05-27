@extends('layouts.app') 
@section('title', 'Change Password') 
@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
        <div class="card-body">
                <div class="login-form">
                            <h4>Reset Password</h4>
                            @include('layouts.message')
                            <form class="form-valide" method="post" action="{{route('resetPost')}}">
                                {{csrf_field()}}
                                <input type="hidden" name="val-email" value="{{$email}}">
                                <div class="form-group row">
                                    <label class="col-form-label" for="val-password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="val-password" name="val-password" placeholder="Choose a safe one..">
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label" for="val-confirm-password">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="val-confirm-password" name="val-confirm-password" placeholder="..and confirm it!">
                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Confirm</button>
                            </form>
                        </div>
            </div>
            </div>
        </div>
  </div>
@endsection
 @push('scripts') 
<script type="text/javascript">
        $('div.alert').delay(3000).slideUp(300);
</script>
@endpush