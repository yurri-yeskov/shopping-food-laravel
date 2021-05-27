@extends('layouts.leo')
@section('content')

     <section class="content-header">
      <h1>
        Add New Driver
      </h1>
    </section>


    <!-- Start Page Content -->
        <section class="content">
              <div class="box box-default">
                <div class="box-header with-border">
    @include('layouts.message') {!!Form::open(array('method'=>'post','files'=>true))!!}
                <div class="card-body">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('drivers')}}">Back</a>
                    </div> <br>
                    <div class="form-group clearfix">
                        {!!Form::label('name','Driver Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>
					<div class="form-group clearfix">
                        {!!Form::label('email','Email')!!}<span class="required">*</span> {!!Form::email('email',null,array('class'=>'form-control','id'=>'email','placeholder'=>'Email'))!!}
                        <span class="text-danger">{!! $errors->first('email') !!}</span>
                    </div>
					<div class="form-group clearfix">
                        {!!Form::label('mobile','Mobile Number')!!}<span class="required">*</span> {!!Form::text('mobile_number',null,array('class'=>'form-control','id'=>'mobile','placeholder'=>'Mobile'))!!}
                        <span class="text-danger">{!! $errors->first('mobile_number') !!}</span>
                    </div>
					<div class="form-group clearfix">
                        {!!Form::label('password','Password')!!}<span class="required">*</span> {!!Form::password('password',array('class'=>'form-control','id'=>'password','placeholder'=>'Password'))!!}
                        <span class="text-danger">{!! $errors->first('password') !!}</span>
                    </div>

                    <div class="box-footer">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
</section>
<!-- End Page Content -->
@endsection
 @push('scripts')
@endpush