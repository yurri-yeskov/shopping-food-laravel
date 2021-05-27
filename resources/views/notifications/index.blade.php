@extends('layouts.leo')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="page-header-title">
                <i class="ik ik-bell bg-blue"></i>
                <div class="d-inline">
                    <h5>Notifications</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.message')
<div class="row layout-wrap" id="layout-wrap">

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
<form action="{{ route('storeNotification') }}" method="get" enctype="multipart/form-data" id="form">
{{csrf_field()}}

<div class="row">
    <div class="col-lg-12">
                    <div class="form-body">
                        <div class="row p-t-20 custom_notification">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Notification Title</label>
                                    <input type="text" name="title" class="form-control noti_validate" required>
                                    <input type="hidden" name="user_id" value="{{$user_id}}">
                                </div>
                            </div>
                        </div>

                        <div class="row event_notification">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea name="description" class="form-control event_validate" required style="height: 200px"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn waves-effect waves-light btn-success"> <i class="fa fa-check"></i> Send</button>
                    </div>
    </div>
</div>
</form>            </div>
            </div>
            </div>
    <div class="col-md-7">
    <div class="table-responsive m-t-40 bg-white">
                            <table class="table" >
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th style="width:180px;" >Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	@foreach($notifications as $notification)
                                    	<tr>
                                            <td>{{ $notification->title}}</td>
                                            <td>{{ $notification->description}}</td>
                                            {{-- <td>{{ ($notification->state=="") ? "-" : $notification->state}}</td>
                                            <td>{{ ($notification->city=="") ? "-" : $notification->city}}</td>
                                            <td>{{ ($notification->user_type=="single") ? "Selection" : ucfirst($notification->user_type)}}</td> --}}
                                            <td>{{ date('d-m-Y H:i a',strtotime($notification->created_at))}}</td>
										</tr>
                                	@endforeach
                                </tbody>
                            </table>
                        </div>            
                    </div>
            </div>
      
@endsection

@push('scripts')

@endpush