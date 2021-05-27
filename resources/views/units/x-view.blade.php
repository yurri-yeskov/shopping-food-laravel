@extends('layouts.leo')
@section('content')
      <section class="content-header">
      <h1>
        Product Unit
      </h1>
    </section>
        <section class="content">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message')
                <div class="card-body" id="editsection">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('units')}}">Back</a>
                    </div> <br> <br> {!!Form::model($ProductUnit, array('route'=>array('editUnit',request()->route('id')),'method'=>'post','files'=>true))!!}
                    <div class="form-group clearfix">
                        {!!Form::label('name','Unit Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Unit Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>
                    <div class="form-group clearfix">
                        {!!Form::label('code','Unit Code')!!}<span class="required">*</span> {!!Form::text('code',null,array('class'=>'form-control','id'=>'code','placeholder'=>'Unit Code'))!!}
                        <span class="text-danger">{!! $errors->first('code') !!}</span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Status</label>
                        <input type="checkbox" @if($type=='edit' ) @if(isset($ProductUnit) && $ProductUnit->status ==
                        'AC') checked @endif @else checked @endif class="js-switch" data-color="rgb(26, 180, 27)" data-size="small"
                        name="val-status"/>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!!Form::close()!!}
                </div>
                <div class="card-body" id="viewsection">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('units')}}">Back</a>
                    </div> <br> <br>
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-left col-md-6">Unit Name:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">{{$ProductUnit->name}}</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                            <label class="control-label text-left col-md-6">Unit Code:</label>
                                            <div class="col-md-6">
                                                <p class="form-control-static">{{$ProductUnit->code}}</p>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </form>
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