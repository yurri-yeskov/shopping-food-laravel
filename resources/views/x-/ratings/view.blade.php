@extends('layouts.app')
@section('title', 'Reviews & Rating - '.$rating->booking->booking_code)

@section('content')
	<div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Reviews & Rating</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('ratings')}}">Reviews & Ratings</a></li>
                    <li class="breadcrumb-item active">Reviews & Rating</li>
                </ol>
            </div>
        </div>
        <!-- Start Page Content -->
        <div class="row">

            <div class="col-lg-12 col-xlg-12 col-md-12">
                <div class="card">
                    @include('layouts.message')
                    <div class="card-body">
                        <div class="">
                            <h6 class="p-t-30 db">{{$rating->user->name}} rated {{$rating->parent->name}}</h6>
                            <h6>
                                <a class="text-primary" href="/admin/user/{{$rating->user->id}}" target="_blank">
                                    {{$rating->user->email}}
                                </a> -&gt;
                                <a class="text-primary" href="/admin/user/{{$rating->parent->id}}" target="_blank">
                                    {{$rating->parent->email}}
                                </a>
                            </h6>
                            <small class="p-t-30 db">Booking Code</small>
                            <h6>{{$rating->booking_code}}</h6>
                            <small class="p-t-30 db">Rating</small>
                            <h6>{{$rating->rating}}</h6>
                            <small class="p-t-30 db">Comment</small>
                            <h6>{{($rating->comment!='')?$rating->comment:'-'}}</h6>
                            <small class="p-t-30 db">Complement</small>
                            <h6>{{$rating->complement->name}}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
@endsection