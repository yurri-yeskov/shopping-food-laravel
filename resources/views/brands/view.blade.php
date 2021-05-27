@extends('layouts.leo')
@section('title', 'Brand - ' . $productbrands->name)
@section('content')
    <section class="content-header">
      <h1>
        Brand
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li><a href="{{route('brands')}}">Brands</a></li>
        <li class="active">{{$productbrands->name}}</li>
      </ol>
    </section>

    <!-- Start Page Content -->
        <section class="content">
    <div class="row">
        <div class="col-sm-6">
              <div class="box box-default">
                <div class="box-header with-border">
            <div class="card">
    @include('layouts.message')
                <div class="card-body" id="editsection">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('brands')}}">Back</a>
                    </div> <br> <br> {!!Form::model($productbrands, array('route'=>array('editBrand',request()->route('id')),'method'=>'post','files'=>true))!!}

                    <div class="form-group clearfix">
                        {!!Form::label('name','Brand Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Name'))!!}
                        <span class="text-danger">{!! $errors->first('name') !!}</span>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4">Status</label>
                        <input type="checkbox" @if($type=='edit' ) @if(isset($productbrands) && $productbrands->status ==
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
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('brands')}}">Back</a>
                    </div> <br> <br>
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-left col-md-6">Brand Name:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static">{{$productbrands->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn btn-danger edit_brand"> <i class="fa fa-pencil"></i> Edit</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                </div>
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