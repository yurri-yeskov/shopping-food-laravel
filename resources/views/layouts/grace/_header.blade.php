<div class="bg-white shadow-sm osahan-main-nav">
        <nav class="navbar navbar-expand-lg navbar-light bg-white osahan-header py-0 container">
            <a class="navbar-brand mr-0" href="{{url('')}}"><img class="img-fluid" width="100" src="{{asset('images/logo-invoice.png')}}"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ml-3 d-flex align-items-center">
                <div class="dropdown mr-3">
                    <a class="text-dark dropdown-toggle d-flex align-items-center osahan-location-drop" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div><i class="icofont-location-pin d-flex align-items-center bg-light rounded-pill p-2 icofont-size border shadow-sm mr-2"></i></div>
                        <div>
                            <p class="text-muted mb-0 small">Select Location</p>
                            Diamond Creek...
                        </div>
                    </a>
                    <div class="dropdown-menu osahan-select-loaction p-3" aria-labelledby="navbarDropdown">
                        <span>Select your city to start shopping</span>
                        <form class="form-inline my-2">

                            <div class="input-group p-0 col-lg-12">
                                <input type="text" class="form-control form-control-sm" id="inlineFormInputGroupUsername2" placeholder="Search Location">
                                <div class="input-group-prepend">
                                    <div class="btn btn-success rounded-right btn-sm"><i class="icofont-location-arrow"></i> Detect</div>
                                </div>
                            </div>
                        </form>
                        <div class="city pt-2">
                            <h6>We deliver to</h6>
                            <p class="border-bottom m-0 py-1"><a href="#" class="text-dark">Eltham</a></p>
                            <p class="border-bottom m-0 py-1"><a href="#" class="text-dark">Mernda</a></p>
                            <p class="border-bottom m-0 py-1"><a href="#" class="text-dark">Doreen</a></p>
                            <p class="m-0 py-1"><a href="#" class="text-dark"></a></p>
                        </div>
                    </div>
                </div>

                <div class="input-group mr-sm-2 col-lg-12">
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Search for Products..">
                    <div class="input-group-prepend">
                        <div class="btn btn-success rounded-right"><i class="icofont-search"></i></div>
                    </div>
                </div>
            </div>
            <div class="ml-auto d-flex align-items-center">

                @guest
                <a href="#" data-toggle="modal" data-target="#login" class="mr-2 text-dark bg-light rounded-pill p-2 icofont-size border shadow-sm">
                    <i class="icofont-login"></i>
                </a>
                @endguest
                @auth
                <div class="dropdown mr-3">
                    <a href="#" class="dropdown-toggle text-dark" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{auth()->user()->profile_picture ? asset('/uploads/profiles/'.auth()->user()->profile_picture) : asset('/uploads/profiles/nouser.png' )}}" class="img-fluid rounded-circle header-user mr-2"> Hi {{auth()->user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right top-profile-drop" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('my.account')}}">My Account</a>
                        <a class="dropdown-item" href="{{route('my.favorites')}}">My Favorites</a>
                        <a class="dropdown-item" href="{{route('my.orders')}}">My Orders</a>
                        <a class="dropdown-item" href="{{route('my.addresses')}}">My Addresses</a>
                        <a class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="#">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    </div>
                </div>
                <div class="dropdown">
                    <a href="#" class="text-dark dropdown-toggle not-drop" id="dropdownMenuNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icofont-notification d-flex align-items-center bg-light rounded-pill p-2 icofont-size border shadow-sm">

                        </i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-0 osahan-notifications-main" aria-labelledby="dropdownMenuNotification">

                        <div class="osahan-notifications bg-white border-bottom p-2">
                            <div class="position-absolute ml-n1 py-2"><i class="icofont-check-circled text-white bg-success rounded-pill p-1"></i></div>
                            <a href="status_complete.html" class="text-decoration-none text-dark">
                                <div class="notifiction small">
                                    <div class="ml-3">
                                        <p class="font-weight-bold mb-1">Yay! Order Complete</p>
                                        <p class="small m-0"><i class="icofont-ui-calendar"></i> Today, 05:14 AM</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="osahan-notifications bg-white border-bottom p-2">
                            <a href="status_onprocess.html" class="text-decoration-none text-muted">
                                <div class="notifiction small">
                                    <div class="ml-3">
                                        <p class="font-weight-bold mb-1">Yipiee. order Success</p>
                                        <p class="small m-0"><i class="icofont-ui-calendar"></i> Monday, 08:30 PM</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="osahan-notifications bg-white p-2">
                            <a href="status_onprocess.html" class="text-decoration-none text-muted">
                                <div class="notifiction small">
                                    <div class="ml-3">
                                        <p class="font-weight-bold mb-1">New Promos Coming</p>
                                        <p class="small m-0"><i class="icofont-ui-calendar"></i> Sunday, 10:30 AM</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                @endauth
                <a href="{{route('front.cart')}}" class="ml-2 text-dark bg-light rounded-pill p-2 icofont-size border shadow-sm">
                    <i class="icofont-shopping-cart"></i>
                </a>
            </div>
        </nav>

        @include('layouts.grace._menu')
    </div>