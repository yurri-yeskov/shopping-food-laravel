@extends('layouts.leo')
@section('content')

@push('styles')
@endpush
@include('sections.settings')
<section class="content">
    <div class="row">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
                    <div class="card">
                    @include('layouts.message')
                    {!!Form::open(array('method'=>'post','files'=>true))!!}
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group clearfix">
                                {!!Form::label('delivery_charges','Delivery Charges')!!}<span class="required">*</span>
                                {!!Form::text('delivery_charges',$setting[0]->rule_value,array('class'=>'form-control','id'=>'delivery_charges','placeholder'=>'Delivery Charges'))!!}
                                <span class="text-danger">{!! $errors->first('delivery_charges') !!}</span>
                            </div>
                            <div class="form-group clearfix">
                                {!!Form::label('minimum_order_amount','Minimum Order Amount')!!}<span class="required">*</span>
                                {!!Form::text('minimum_order_amount',$setting[1]->rule_value,array('class'=>'form-control','id'=>'minimum_order_amount','placeholder'=>'Minimum Order Amount'))!!}
                                <span class="text-danger">{!! $errors->first('minimum_order_amount') !!}</span>
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