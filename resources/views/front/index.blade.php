@extends('layouts.grace')
@push('header-script')

@endpush
@section('page-title')

@endsection
@section('content')
<div class="title d-flex align-items-center py-3">
    <h5 class="m-0">Categories</h5>
</div>
<div class="pick_today">
    <div class="row">
        @foreach($categories as $cat)
        <div class="col-6 col-md-2 mb-3 text-center">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                <div class="list-card-image">
                    <a href="{{route('front.category',$cat->id)}}" class="text-dark">
                        <div class="p-3">
                            <img src="{{$cat->categoryimage}}" class="img-fluid item-img w-100 mb-3 rounded">
                            <h6>{{$cat->name}}</h6>
                            
                        </div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@if(count($sliders) > 3)
<div class="py-3 osahan-promos">
    <div class="promo-slider pb-0 mb-0">
        @foreach($sliders as $slider)
        <div class="osahan-slider-item mx-2">
            <a href="#"><img src="{{asset('uploads/sliders/'.$slider->image)}}" class="img-fluid mx-auto rounded" alt="Responsive image"></a>
        </div>
        @endforeach
    </div>
</div>
@endif
<div class="col-lg-12">
    <div class="osahan-vegan">

        <div class="fresh-vegan pb-2">
            <div class="d-flex align-items-center mb-2">
                <h5 class="m-0">Featured Products {{$featured->count()}}</h5>
                <a href="#" class="ml-auto text-success">See more</a>
            </div>
            <div class="trending-slider">
             @foreach($featured as $f)
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"></div>
                            <a href="{{route('front.product',$f->id)}}" class="text-decoration-none text-dark">
                                <img src="{{$f->productimage}}" class="img">
                                <h5 class="text-success">{{$f->name}}</h5>
                                <div class="d-flex align-items-center">
                                    <div class="btn-group osahan-radio btn-group-toggle" data-toggle="buttons">
                                        @foreach($f->activevariations as $var)
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="variation" id="{{$var->id}}"> {{$var->weight.' '.$var->unit->name.' $'.$var->price}}
                                        </label>
                                        @endforeach
                                    </div>
                                    <a class="ml-auto" href="#">
                                        <form id='myform' class="cart-items-number d-flex" method='POST' action='#'>
                                            <input type='number' name='quantity' value='1' class='qty form-control' />
                                        </form>
                                    </a>
                                    <a href="#" class="btn btn-warning rounded  d-flex align-items-center justify-content-center"><i class="icofont-plus m-0 mr-2"></i></a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="d-flex align-items-center mt-4 mb-2">
                <h5 class="m-0">Quick Grab</h5>
            </div>
            <div class="trending-slider">
                @foreach($quickgrab as $q)
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"><span class="badge badge-success">10%</span></div>
                            <a href="{{route('front.product',$q->id)}}" class="text-decoration-none text-dark">
                                <img src="{{$q->productimage}}" class="img">
                                <h5 class="text-success">{{$q->name}}</h5>
                                <h6 class="mb-1 font-weight-bold">$0.14 <del class="small">$0.22</del></h6>
                                <p class="text-gray mb-0 small">{!!$q->description!!}</p>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="d-flex align-items-center mt-4 mb-2">
                <h5 class="m-0">Offered Products</h5>
            </div>
            <div class="trending-slider">
                @foreach($offered as $o)
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"><span class="badge badge-dark">10%</span></div>
                            <a href="{{route('front.product',$o->id)}}" class="text-decoration-none text-dark">
                                <img src="{{$o->productimage}}" class="img">
                                <h5 class="text-success">{{$f->name}}</h5>
                                <h6 class="mb-1 font-weight-bold">$0.14 <del class="small">$0.22</del></h6>
                                <p class="text-gray mb-0 small">{!!$o->description!!}</p>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-script')

@endpush