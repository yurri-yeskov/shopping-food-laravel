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
            <li class="breadcrumb-item active" aria-current="page">My Favorites</li>
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
                    
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')

@endpush