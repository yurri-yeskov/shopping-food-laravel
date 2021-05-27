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
            <li class="breadcrumb-item active" aria-current="page">My Addresses</li>
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
                    <div class="osahan-my_address">
                        <h4 class="mb-4 profile-title">My Addresses</h4>
                        <div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
                            <input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input" checked>
                            <label class="custom-control-label w-100" for="customRadioInline1">
                                <div>
                                    <div class="p-3 bg-white rounded shadow-sm w-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="mb-0 h6">Home</p>
                                            <p class="mb-0 badge badge-success ml-auto">Default</p>
                                        </div>
                                        <p class="small text-muted m-0">1001 Veterans Blvd</p>
                                        <p class="small text-muted m-0">Redwood City, CA 94063</p>
                                        <p class="pt-2 m-0 text-right"><span class="small"><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-decoration-none text-success"><i class="icofont-edit"></i> Edit</a></span>
                                            <span class="small ml-3"><a href="#" data-toggle="modal" data-target="#Delete" class="text-decoration-none text-danger"><i class="icofont-trash"></i> Delete</a></span>
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
                            <input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
                            <label class="custom-control-label w-100" for="customRadioInline2">
                                <div>
                                    <div class="p-3 rounded bg-white shadow-sm w-100">
                                        <div class="d-flex align-items-center mb-2">
                                            <p class="mb-0 h6">Work</p>
                                        </div>
                                        <p class="small text-muted m-0">Model Town, Ludhiana</p>
                                        <p class="small text-muted m-0">Punjab 141002, India</p>
                                        <p class="pt-2 m-0 text-right"><span class="small"><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-decoration-none text-success"><i class="icofont-edit"></i> Edit</a></span>
                                            <span class="small ml-3"><a href="#" data-toggle="modal" data-target="#Delete" class="text-decoration-none text-danger"><i class="icofont-trash"></i> Delete</a></span>
                                        </p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')

@endpush