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
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
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
                    <h4 class="mb-4 profile-title">My account</h4>
                    <div id="edit_profile">
                        <div class="p-0">
                            <form action="">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" value="{{auth()->user()->name}}" name="name">
                                </div>
                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number</label>
                                    <input type="number" class="form-control" id="mobile_number" value="{{auth()->user()->mobile_number}}" name="mobile_number">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" value="{{auth()->user()->email}}" name="email">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-block btn-lg">Save Changes</button>
                                </div>
                            </form>
                        </div>
                        <div class="additional mt-3">
                            <div class="change_password mb-1">
                                <a href="change_password.html" class="p-3 btn-light border btn d-flex align-items-center">Change Password
                                    <i class="icofont-rounded-right ml-auto"></i></a>
                            </div>
                            <div class="deactivate_account">
                                <a href="deactivate_account.html" class="p-3 btn-light border btn d-flex align-items-center">Deactivate Account
                                    <i class="icofont-rounded-right ml-auto"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('footer-script')

@endpush