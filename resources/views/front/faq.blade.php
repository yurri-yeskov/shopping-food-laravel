@extends('layouts.grace')
@push('header-script')

@endpush
@section('page-title')

@endsection
@section('content')

<div class="col-lg-8 mx-auto p-4 bg-white rounded shadow-sm">
    <h4 class="mb-4 profile-title">Frequently Asked Questions</h4>
    <div id="basics">

        <div id="basicsAccordion">

            @foreach($faqs as $faq)
            <div class="box border rounded mb-1 bg-white">
                <div id="basicsHeading{{$faq->id}}">
                    <h5 class="mb-0">
                        <button class="shadow-none btn btn-block d-flex align-items-center justify-content-between card-btn p-3 collapsed" data-toggle="collapse" data-target="#basicsCollapse{{$faq->id}}" aria-expanded="false" aria-controls="basicsCollapse{{$faq->id}}">
                            <strong>{{$faq->question}}</strong> <i class="icofont-simple-down"></i>
                        </button>
                    </h5>
                </div>
                <div id="basicsCollapse{{$faq->id}}" class="collapse" aria-labelledby="basicsHeading{{$faq->id}}" data-parent="#basicsAccordion" style="">
                    <div class="card-body border-top p-3 text-muted">
                       {!!$faq->answer!!}
                    </div>
                </div>
            </div>

            @endforeach


        </div>

    </div>
</div>
@endsection
@push('footer-script')

@endpush