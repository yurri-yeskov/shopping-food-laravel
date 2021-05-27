@extends('layouts.leo')
@section('content')

      <section class="content-header">
      <h1>
         Delivery Charge
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li><a href="{{route('deliverycharges')}}">Delivery Charge</a></li>
        <li class="active">{{$DeliveryCharge->delivery_charge}}</li>
      </ol>
    </section>

    <!-- Start Page Content -->

        <section class="content">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message')
                <div class="card-body" id="editsection">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('deliverycharges')}}">Back</a>
                    </div> <br> <br> {!!Form::model($DeliveryCharge, array('route'=>array('editDeliveryCharge',request()->route('id')),'method'=>'post','files'=>true))!!}
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
                    <div class="form-group">
                        <label class="col-md-4">Status</label>
                        <input type="checkbox" @if($type=='edit' ) @if(isset($DeliveryCharge) && $DeliveryCharge->status == 'AC') checked @endif @else checked @endif class="js-switch" data-color="rgb(26, 180, 27)" data-size="small"
                        name="val-status"/>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
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
<script type="text/javascript">
    @if($type == 'edit')
 $('#viewsection').hide();
 $(".click2edit").summernote({ minHeight: '100px' });
 @else
  $('#editsection').hide();
@endif
$('.edit_brand').click(function(e){
    e.preventDefault();
    $('#editsection').show();
    $('#viewsection').hide();
    });

</script>
@endpush