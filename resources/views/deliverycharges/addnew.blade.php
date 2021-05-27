@extends('layouts.leo')
@section('title', 'Add New Product DeliveryCharge')
@section('content')
      <section class="content-header">
      <h1>
        Add New Delivery Charge
      </h1>
    </section>

    <!-- Start Page Content -->

        <section class="content">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message') {!!Form::open(array('method'=>'post','files'=>true))!!}

                <div class="card-body">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('deliverycharges')}}">Back</a>
                    </div> <br>
                    <div class="form-group clearfix">
                        {!!Form::label('delivery_charge','Delivery Charge')!!}<span class="required">*</span> {!!Form::text('delivery_charge',null,array('class'=>'form-control','id'=>'delivery_charge','placeholder'=>'Delivery Charge'))!!}
                        <span class="text-danger">{!! $errors->first('delivery_charge') !!}</span>
                    </div>

                     <div class="form-group clearfix">
                        {!!Form::label('from_amount','From Amount')!!}<span class="required">*</span> {!!Form::text('from_amount',null,array('class'=>'form-control','id'=>'from_amount','placeholder'=>'From Amount'))!!}
                        <span class="text-danger">{!! $errors->first('from_amount') !!}</span>
                    </div>

                     <div class="form-group clearfix">
                        {!!Form::label('to_amount','To Amount')!!}<span class="required">*</span> {!!Form::text('to_amount',null,array('class'=>'form-control','id'=>'to_amount','placeholder'=>'To Amount'))!!}
                        <span class="text-danger">{!! $errors->first('to_amount') !!}</span>
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
<!-- End PAge Content -->
</div>
</section>
@endsection
 @push('scripts')
@endpush