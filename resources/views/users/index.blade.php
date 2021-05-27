@extends('layouts.leo')
@push('head-script')
@endpush
@section('content')
<div class="page-header">
  <div class="row justify-content-between">
                            <div class="col-3">
                                <div class="widget bg-success">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Total Users</h6>
                                                <h2>{{$totaluser}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 offset-md-5">
                                <div class="widget bg-info">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>IOS</h6>
                                                <h2>{{$totalios}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="fab fa-apple"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="widget bg-danger">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Android</h6>
                                                <h2>{{$totalandroid}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="fab fa-android"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>
</div>
    <section class="content">
        <div class="box box-default">
        <div class="card">
                @include('layouts.message')
                <div class="table-responsive m-t-40">
                <table class="table text-center" id="leo">
                        <thead>
                            <tr><th></th>                         
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Suburb</th>
                                <th>Total Order</th>
                                <th>Favorites</th>
                                <th>Device Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td><img src="{{$user->profileImage}}" class="img-thumbnail" width="50" /></td>
                                <td>
                                    <a href="{{route('view'.ucfirst($usertype),['id'=>$user->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail">{{$user->name}}</a>
                                </td>
                                <td><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                <td>{{$user->mobile_number}}</td>
                                <td>{{$user->city}}</td>
                                <td><span class="badge badge-{{$user->orders->count() ? 'success' : 'danger'}}">{{$user->orders->count()}}</span></td>
                                <td><span class="badge badge-{{$user->products->count() ? 'success' : 'danger'}}">{{$user->products->count()}}</span></td>
                                <td>{!!$user->device_type == 'android' ? '<i class="fab fa-android fa-2x text-danger"></i>' : '<i class="fab fa-apple fa-2x text-info"></i>'!!}</td>
                                <td>{!!$user->status =='AC' ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'  !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')

@endpush