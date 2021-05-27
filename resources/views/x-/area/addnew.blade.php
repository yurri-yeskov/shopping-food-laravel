@extends('layouts.app')
@section('title', 'Add Area ')
@section('content')

    <section class="content-header">
      <h1>
        Add New Area
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li><a href="{{route('areas')}}">Areas</a></li>
        <li class="active">Add New Area</li>
      </ol>
    </section>


    <!-- Start Page Content -->
        <section class="content">
    <div class="row">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message') {!!Form::open(array('method'=>'post','files'=>true))!!}

                <div class="card-body">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('areas')}}">Back</a>
                    </div> <br>

                    <div class="form-group clearfix">
                        {!!Form::label('name','Area Name')!!}
                        <span class="required">*</span> {!!Form::text('name',null,array( 'class'=>'form-control','id'=>'name',
                        'placeholder'=>'Area Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>


                    <div class="form-group clearfix">
                        {!!Form::label('name','Select City Name')!!}<span class="required">*</span><br>
                        <select required name="city_id" class="form-control">
                                <option value="">Select City</option>
                                @foreach ($Cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        <span class="text-danger">{!! $errors->first('city_id') !!}</span>
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
    </div>
</div>

<!-- End Page Content -->

@endsection
 @push('scripts')
@endpush