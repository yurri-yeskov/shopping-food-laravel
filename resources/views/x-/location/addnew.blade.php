@extends('layouts.app')
@section('title', 'Add Apartment ')
@section('content')

    <section class="content-header">
      <h1>
        Add New Apartment
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li><a href="{{route('locations')}}">Apartments</a></li>
        <li class="active">Add Apartment</li>
      </ol>
    </section>

    <!-- Start Page Content -->
        <section class="content">
    <div class="row">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message') {!!Form::open(array('route'=>'createLocation','method'=>'post','files'=>true))!!}

                <div class="card-body">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('locations')}}">Back</a>
                    </div> <br>

                    <div class="form-group clearfix">
                        {!!Form::label('name','Apartment Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>

                    <div class="form-group clearfix">
                        {!!Form::label('name','Select Area Name')!!}<span class="required">*</span><br>
                        <select name="prnt_id" class="form-control">
                                <option value="">Select Area</option>
                                @foreach ($areas as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select><br>
                        <span class="text-danger">{!! $errors->first('prnt_id') !!}</span>
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
<!-- End PAge Content -->
</div>
</section>

@endsection
 @push('scripts')
@endpush