@extends('admin.layouts.app') 
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{trans('form_messages.view')}} {{trans('form_messages.partner')}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{URL::to('/admin')}}"><i class="fa fa-dashboard"></i> {{trans('form_messages.home')}}</a></li>
      <li class="active">{{trans('form_messages.partner')}}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title pull-left">{{trans('form_messages.view')}} {{trans('form_messages.partner')}}</h3>
            <div class="pull-right"><a href="{!! URL::to('admin/partners') !!}" class="btn btn-xs-3 btn-primary">{{trans('form_messages.back')}}</a></div>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="box-body">
            <div class="form-group clearfix">
              {!!Form::label('name',trans('form_messages.name'), array('class'=>'col-md-2'))!!} {!! $data->name !!}
            </div>
            <div class="form-group clearfix">
              {!!Form::label('email',trans('form_messages.email'), array('class'=>'col-md-2'))!!} {!! $data->email !!}
            </div>
            <div class="form-group clearfix">
              {!!Form::label('address',trans('form_messages.address'), array('class'=>'col-md-2'))!!} {!! $data->address !!}
            </div>
            <div class="form-group clearfix">
              {!!Form::label('phone',trans('form_messages.phone'), array('class'=>'col-md-2'))!!} {!! $data->phone !!}
            </div>
            <div class="form-group clearfix">
              {!!Form::label('logo',trans('form_messages.logo'), array('class'=>'col-md-2'))!!}
              <img src="{!! URL::to('uploads/partners/'.$data->logo) !!}" alt="" width="100">
            </div>
            <div class="form-group clearfix">
              {!!Form::label('status',trans('form_messages.status'), array('class'=>'col-md-2'))!!} {!! Config::get('constants.STATUS.'.$data->status)
              !!}
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!--/.col (left) -->

    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript" src="{!!asset('assets/admin/bower_components/jquery/dist/jquery.min.js')!!}"></script>



@stop