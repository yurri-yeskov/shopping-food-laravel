@extends('layouts.leo') 
@section('title', 'Change Password') 
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="page-header-title">
                <i class="ik ik-lock bg-blue"></i>
                <div class="d-inline">
                    <h5>Change Password</h5>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
    @include('layouts.message')
                <form method="POST" action="{{route('resetPassword')}}" novalidate class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="card-body">
                        {{--
                        <div class="pull-right">
                            <a class="btn waves-effect waves-light btn-primary " href="{{route('category')}}">Back</a>
                        </div> <br> --}}

                        <div class="form-group clearfix">
                            {!!Form::label('password','Current Password')!!}<span class="required">*</span><br> {!!Form::password('old_password',array('class'=>'form-control','id'=>'password','placeholder'=>'Password',"autofill"=>false))!!}
                            <br>
                            <span class="text-danger">{!! $errors->first('old_password') !!}</span>
                        </div>


                        <div class="form-group clearfix">
                            {!!Form::label('new_password','New Password')!!}<span class="required">*</span><br> {!!Form::password('new_password',array('class'=>'form-control','id'=>'cpassword',
                            'placeholder'=>'New Password',"autofill"=>false))!!}
                            <br>
                            <span class="text-danger">{!! $errors->first('new_password') !!}</span>
                        </div>
                        <div class="form-group clearfix">
                            {!!Form::label('change_password','Confirm New Password')!!}<span class="required">*</span><br>{!!Form::password('change_password',array('class'=>'form-control','id'=>'cpassword',
                            'placeholder'=>'Confirm New Password',"autofill"=>false))!!}
                            <br>

                        </div>


                        <!-- /.box-body -->
                        <div class="box-footer">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                </form>
            </div>
        </div>
  </div>
    
@endsection
 @push('scripts') 
@endpush