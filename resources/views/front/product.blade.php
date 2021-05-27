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
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('front.category',$product->category->id)}}" class="text-success">{{$product->category->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </div>
    </nav>
    <section class="py-4 osahan-main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="recommend-slider mb-3">
                        <div class="osahan-slider-item">
                            <img src="{{$product->productimage}}" class="img-fluid mx-auto shadow-sm rounded" alt="Responsive image">
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <div class="pt-0">
                            <h2 class="font-weight-bold">{{$product->name}}</h2>
                        </div>
                        <div class="pt-3">
                                <p class="font-weight-bold mb-2">Product Details</p>
                                <p class="text-muted small mb-0">{!!$product->description!!}</p>
                            </div>
                        <div class="details">
                            <div class="pt-3 bg-white">
                                <div class="d-flex align-items-center">
                                    <div class="btn-group osahan-radio btn-group-toggle" data-toggle="buttons">
                                        @foreach($product->activevariations as $var)
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="variation" id="{{$var->id}}"> {{$var->weight.' '.$var->unit->name.' $'.$var->price}}
                                        </label>
                                        @endforeach
                                    </div>
                                    <a class="ml-auto" href="#">
                                        <form id='myform' class="cart-items-number d-flex" method='POST' action='#'>
                                            <input type='button' value='-' class='qtyminus btn btn-success btn-sm' field='quantity' />
                                            <input type='text' name='quantity' value='1' class='qty form-control' />
                                            <input type='button' value='+' class='qtyplus btn btn-success btn-sm' field='quantity' />
                                        </form>
                                    </a>
                                    <a href="#" class="btn btn-warning rounded  d-flex align-items-center justify-content-center mr-3 btn-sm"><i class="icofont-plus m-0 mr-2"></i> ADD TO CART</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="mt-3 mb-3">You might like these</h5>
            <div class="row">
                @foreach($suggested as $pro)
                <div class="col-sm-3 col-md-3 mb-3">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-image">
                            <a href="{{route('front.product',$pro->id)}}" class="text-dark">
                                <div class="member-plan position-absolute"><span class="badge m-3 badge-danger">10%</span></div>
                                <div class="p-3">
                                    <img src="{{$pro->productimage}}" class="img-fluid item-img w-100 mb-3 rounded">
                                    <h6> {{$pro->name}}</h6>
                                    <div class="d-flex align-items-center">
                                        <h6 class="price m-0 text-success">$0.8/kg</h6>
                                        <a data-toggle="collapse" href="#product{{$pro->id}}" role="button" aria-expanded="false" aria-controls="product{{$pro->id}}" class="btn btn-success btn-sm ml-auto">+</a>
                                        <div class="collapse qty_show" id="product{{$pro->id}}">
                                            <div>
                                                <span class="ml-auto" href="#">
                                                    <form id='myform' class="cart-items-number d-flex" method='POST' action='#'>
                                                        <input type='button' value='-' class='qtyminus btn btn-success btn-sm' field='quantity' />
                                                        <input type='text' name='quantity' value='1' class='qty form-control' />
                                                        <input type='button' value='+' class='qtyplus btn btn-success btn-sm' field='quantity' />
                                                    </form>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
@push('footer-script')

@endpush