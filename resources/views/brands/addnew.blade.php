@extends('layouts.leo')
@section('content')

        <section class="content-header">
      <h1>
        Add New Brand
      </h1>
    </section>
        <section class="content">

    <div class="row">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message') {!!Form::open(array('method'=>'post','files'=>true))!!}

                <div class="card-body">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('brands')}}">Back</a>
                    </div> <br>
                    <div class="form-group clearfix">
                        {!!Form::label('name','Brand Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>

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
</section>
@endsection
 @push('scripts')
@endpush