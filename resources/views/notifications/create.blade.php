@extends('layouts.leo')

@section("css")
@endsection

@section('content')

        <section class="content">
              <div class="box box-default">
                <div class="box-header with-border">

<form action="{{ route("storeNotification") }}" method="get" enctype="multipart/form-data" id="form">
{{csrf_field()}}

{{-- @include("layouts.filter") --}}


<div class="row">
    <div class="col-lg-12">
        @if(session("success"))
            @alert(["type" => "alert-success"])
                {{ session("success") }}
            @endalert
        @elseif(session("danger"))
            @alert(["type" => "alert-danger"])
                {{ session("danger") }}
            @endalert
        @endif

        <div class="card">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Send Notification</h4>
            </div>
            <div class="card-body">
                    <div class="form-body">
                        @if($user_id==0)
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_type">User Type</label>
                                 {{ Form::select("user_type",["user"=>"User","all"=>"All"],(isset($_GET['user_type'])) ? $_GET['user_type'] : "",["class"=>"form-control","id"=>"user_type"]) }}
                                </div>
                            </div>
                        </div>
                        @else
                            <input type="hidden" name="user_type" value="single">
                        @endif

                        <div class="row p-t-20 custom_notification">
                            <div class="col-md-6">
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
                                    <label class="control-label">Description</label>
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
    </div>
</div>
<!-- Row -->


</form>
</div>
</div>
</section>
@endsection

@push('scripts')
@endpush