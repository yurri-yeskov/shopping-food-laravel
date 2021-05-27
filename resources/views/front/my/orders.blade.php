@extends('layouts.grace')
@push('header-script')

@endpush
@section('page-title')

@endsection
@section('content')
<nav aria-label="breadcrumb" class="breadcrumb mb-0">
    <div class="container">
        <ol class="d-flex align-items-center mb-0 p-0">
            <li class="breadcrumb-item"><a href="{{url('')}}" class="text-success">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Orders</li>
        </ol>
    </div>
</nav>
<section class="py-4 osahan-main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                   @include('front.my._sidemenu')
                </div>
                <div class="col-lg-8 p-4 bg-white rounded shadow-sm">
                    <h4 class="mb-4 profile-title">My Orders</h4>
                    <div class="order-body">
                        @foreach($orders as $order)    
                        <div class="pb-3">
                                <a href="status_complete.html" class="text-decoration-none text-dark">
                                    <div class="p-3 rounded shadow-sm bg-white">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($order->delivery_status == 'Pending')
                                            <p class="bg-danger text-white py-1 px-2 rounded small m-0">Pending</p>
                                            @else
                                            <p class="bg-success text-white py-1 px-2 mb-0 rounded small">Delivered</p>
                                            @endif
                                            <p class="text-muted ml-auto small mb-0"><i class="icofont-clock-time"></i> {{$order->created_at->format('d M Y')}}</p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="text-muted m-0">Transaction. ID<br>
                                                <span class="text-dark font-weight-bold">#{{$order->order_code}}</span>
                                            </p>
                                            <p class="text-muted m-0 ml-auto">Delivered to<br>
                                                <span class="text-dark font-weight-bold">{{$order->address_id}}</span>
                                            </p>
                                            <p class="text-muted m-0 ml-auto">Total Payment<br>
                                                <span class="text-dark font-weight-bold">${{$order->total_amount}}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')

@endpush