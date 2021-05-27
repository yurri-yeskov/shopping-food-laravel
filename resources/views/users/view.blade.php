@extends('layouts.leo')
@section('content')
@include('layouts.message')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-file-text bg-blue"></i>
                    <div class="d-inline">
                        <h5>Profile</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{$user->profileImage}}" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-10">{{$user->name}}</h4>
                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">
                    <small class="text-muted d-block">Email address </small>
                    <h6>{{$user->email}}</h6>
                    <small class="text-muted d-block pt-10">Phone</small>
                    <h6>{{$user->mobile_number}}</h6>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                            <h6>Total Spend: <span class="fw-700 text-yellow">$ {{$user->deliveredorders->sum('total_amount')}}</span> </h6>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#favorites" role="tab" aria-controls="profile" aria-selected="false">
                            <h6><i class="fa fa-star text-yellow"></i> Favorites ( {{$user->products->count()}} )</h6>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                            <div class="row clearfix">
                                @foreach($user->orders as $order)
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <a href="{{route('editOrder', ['id' => $order->id])}}">
                                        <div class="widget bg-{{$order->delivery_status == 'Delivered' ? 'success' : 'danger'}}">
                                            <div class="widget-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="state">
                                                        <h6>{{$order->order_code}}</h6>
                                                        <h2>$ {{$order->total_amount}}</h2>
                                                        <small class="text-small mt-10 d-block">{{$order->created_at}}</small>
                                                    </div>
                                                    <div class="icon">
                                                        <i class="fa fa-{{$order->delivery_status == 'Delivered' ? 'check' : 'clock'}}"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="favorites" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                            <div class="row clearfix">
                                <table class="table" id="leo">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product</th>
                                            <th>Variations</th>
                                            <th>Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->products as $product)
                                        <tr>
                                            <td>
                                                <img src="{{$product->productImage}}" class="table-user-thumb">
                                            </td>
                                            <td><a href="{{route('product.show',$product->id)}}"> {!! ucfirst(str_limit($product->name, 20)) !!}</a></td>
                                            <td> <span class="badge badge-{{Count($product->variations) == '0' ? 'danger' : 'success' }}">{{ Count($product->variations) }}</span></td>
                                            <td><a href="{{route('category.show',$product->category->id)}}"> {{ucfirst($product->category->name)}}</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')


@endpush