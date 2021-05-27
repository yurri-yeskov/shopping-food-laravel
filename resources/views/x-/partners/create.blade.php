@extends('admin.layouts.app') 
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{trans('form_messages.add')}} {{trans('form_messages.partner')}}
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
            <h3 class="box-title pull-left">{{trans('form_messages.add')}} {{trans('form_messages.partner')}}</h3>
            <div class="pull-right"><a href="{!! URL::to('admin/partners') !!}" class="btn btn-xs-3 btn-primary">{{trans('form_messages.back')}}</a></div>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          {!!Form::open(array('method'=>'post','files'=>true))!!}

          <div class="box-body">
            <div class="form-group clearfix">
              {!!Form::label('name',trans('form_messages.name'))!!}<span class="required">*</span> {!!Form::text('name',null,array('class'=>'form-control','id'=>'name','placeholder'=>trans('form_messages.placname')))!!}
              <span class="text-danger">{!! $errors->first('name') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('email',trans('form_messages.email'))!!}<span class="required">*</span> {!!Form::email('email',null,array('class'=>'form-control','id'=>'email','placeholder'=>trans('form_messages.placemail')))!!}
              <span class="text-danger">{!! $errors->first('email') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('address',trans('form_messages.address'))!!}<span class="required">*</span> {!!Form::text('address',null,array('class'=>'form-control','id'=>'address','placeholder'=>trans('form_messages.placaddress')))!!}
              <span class="text-danger">{!! $errors->first('address') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('phone',trans('form_messages.phone'))!!}<span class="required">*</span> {!!Form::text('phone',null,array('class'=>'form-control','id'=>'phone','placeholder'=>trans('form_messages.placphone')))!!}
              <span class="text-danger">{!! $errors->first('phone') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('logo',trans('form_messages.logo'))!!}<span class="required">*</span> {!!Form::file('logo',null,array('class'=>'form-control','id'=>'logo'))!!}
              <span class="text-danger">{!! $errors->first('logo') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('lang',trans('form_messages.lang'))!!}<span class="required">*</span> {!!Form::select('lang',Config::get('constants.LANGUAGETYPE'),Session::get('language'),array('class'=>'form-control','id'=>'lang'))!!}
              <span class="text-danger">{!! $errors->first('lang') !!}</span>
            </div>
            <div class="form-group clearfix">
              {!!Form::label('status',trans('form_messages.status'))!!}<span class="required">*</span> {!!Form::select('status',Config::get('constants.STATUS'),null,array('class'=>'form-control','id'=>'status'))!!}
              <span class="text-danger">{!! $errors->first('status') !!}</span>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            {!! Form::submit(trans('form_messages.submit'), ['class' => 'btn btn-primary']) !!}
          </div>
          {!!Form::close()!!}
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