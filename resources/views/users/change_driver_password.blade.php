@extends('layouts.app') 
@section('title', 'Change Password') 
@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Change Password</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                {{--
                <li class="breadcrumb-item"><a href="{{route('category')}}">Categories</a></li> --}}
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </div>
    </div>
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-sm-6">
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
                    {!!Form::close()!!}
            </div>

        </div>

    </div>
</div>
<!-- End PAge Content -->
</div>
@endsection
 @push('scripts') 
@endpush