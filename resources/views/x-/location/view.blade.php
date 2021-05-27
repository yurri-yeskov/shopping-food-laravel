@extends('layouts.app')
@section('title', 'Apartment - ' . $Location->name)
@section('content')

     <section class="content-header">
      <h1>{{$Location->name}}</h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li><a href="{{route('locations')}}">Apartments</a></li>
        <li class="active">{{$Location->name}}</li>
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
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('locations')}}">Back</a>
                    </div> <br> {!!Form::model($Location, array('route'=>array('editLocation',request()->route('id')),'method'=>'post','files'=>true))!!}
                    {{ csrf_field() }}
                    <div class="card-body">


                        <div class="form-group clearfix">
                            {!!Form::label('name','Apartment Name')!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>'Name'))!!}
                            <span class="text-danger">{!! $errors->first('name') !!}</span>
                        </div>

                        <div class="form-group clearfix">
                            {!!Form::label('name','Select Area Name')!!}<span class="required">*</span><br>
                            <select required name="prnt_id" class="form-control">
                                <option value="">Select Area</option>
                                @foreach ($areas as $city)
                             <option value="{{$city->id}}" @if($Location->prnt_id==$city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{!! $errors->first('prnt_id') !!}</span>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Status</label>
                            <input type="checkbox" @if($type=='edit' ) @if(isset($Location) && $Location->status == 'AC')
                            checked @endif @else checked @endif class="js-switch" data-color="rgb(26, 180, 27)" data-size="small"
                            name="val-status"/>
                        </div>


                        <!-- /.box-body -->
                        <div class="box-footer">
                            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
                <div class="card-body" id="viewsection">
                    <div class="pull-right">
                        <a class="btn waves-effect waves-light btn-primary " href="{{route('locations')}}">Back</a>
                    </div> <br><br>
                    <form class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label text-left col-md-6">Apartment Name:</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static"> {{$Location->name}} </p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label text-left col-md-6">Area Name:</label>
                                        <div class="col-md-6">
                                            @foreach ($areas as $city) @if($Location->prnt_id==$city->id)
                                            <p class="form-control-static">
                                                {{$city->name}} </p>
                                            @endif @endforeach

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
                                            <button type="submit" class="btn btn-danger edit_category"> <i class="fa fa-pencil"></i> Edit</button>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"> </div>
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

    <!-- End PAge Content -->

@endsection
 @push('scripts')
<script type="text/javascript">
    @if($type == 'edit')
    $('#viewsection').hide();
     $(".click2edit").summernote({ minHeight: '100px' });
      @else
      $('#editsection').hide();
    @endif
$('.edit_category').click(function(e){
e.preventDefault();
$('#editsection').show();
$('#viewsection').hide();
});

        window.edit = function() {
            $(".click2edit").summernote({
                minHeight: '100px'
            });
            $('#edit').hide();
        }

</script>














































@endpush