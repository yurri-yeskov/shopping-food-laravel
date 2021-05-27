@extends('layouts.leo')
@push('head-script')

@endpush
@section('content')
<div class="row clearfix">
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>Orders </h6>
                        <h2>{{$totalOrders}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>Products</h6>
                        <h2>{{$productCount}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-box"></i>
                    </div>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>Users</h6>
                        <h2>{{$userCount}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-users"></i>
                    </div>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12">
        <div class="widget">
            <div class="widget-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="state">
                        <h6>{{"0".substr("1234567890",-9)}}</h6>
                        <h2>{{$earnings}}</h2>
                    </div>
                    <div class="icon">
                        <i class="ik ik-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
<div class="col-sm-9">
    <div class="card">
        <div class="card-header">
            <h3>Daily Order Report</h3>
        </div>
        <div class="card-block">
            <canvas id="dailyOrders" width="400" height="100"></canvas>
        </div>
    </div>
</div>
<div class="col-sm-3">
                                <div class="card sale-card">
                                    <div class="card-header">
                                        <h3>Total Revenue</h3>
                                    </div>
                                    <div class="card-block text-center">
                                        <h6 class="mt-10">Today’s Total Sales</h6>
                                        <h3 class="fw-700 mb-40">{{$todayOrders}}</h3>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-5">Last Week</p>
                                                <h4 class="fw-700 text-yellow">${{$earningLastWeek}}</h4>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-5">{{$lastMonth}}</p>
                                                <h4 class="fw-700 text-yellow">${{$earningLastMonth}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
<div class="row clearfix">
<div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h3>Orders by Suburbs</h3>
        </div>
        <div class="card-block">
            <canvas id="suburbChart" width="400" height="350"></canvas>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h3>Users by Suburbs</h3>
        </div>
        <div class="card-block">
            <canvas id="userChart" width="400" height="350"></canvas>
        </div>
    </div>
</div>
</div>

@endsection
@push('scripts')
<script>
var ctx = document.getElementById("dailyOrders").getContext('2d');
var dailyOrders = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            @foreach ($dailyOrder as $dat) 
                "{!! $dat->date !!}",
                @endforeach],
        datasets: [{
            label: '# of Orders',
            data: [@foreach ($dailyOrder as $dat) 
                {!! $dat->count !!},
                @endforeach],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }],
            xAxes: [{
                type: 'time',
                time: {
                    unit: 'month'
                }
            }]

        }
    }
});
</script>
<script>
    var labels = [
        @foreach($suburbOrders as $order)
        "{{ $order->city }} ({{ $order->totalOrder }})",
        @endforeach
    ];
    var data = [@foreach($suburbOrders as $order)
        "{!! $order->totalOrder !!}",
        @endforeach
    ];
    var pie = document.getElementById("suburbChart").getContext('2d');
    var myChart = new Chart(pie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
            backgroundColor: [ @foreach($colors as $color) "{{$color}}", @endforeach],
            }]
        },
        options: {
        }
    });
</script>
<script>
    var labels = [
        @foreach($suburbUsers as $user)
        "{{ $user->city }}",
        @endforeach
    ];
    var data = [@foreach($suburbUsers as $user)
        "{!! $user->total !!}",
        @endforeach
    ];
    var pie = document.getElementById("userChart").getContext('2d');
    var myChart = new Chart(pie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
            backgroundColor: [ @foreach($colors2 as $color) "{{$color}}", @endforeach],
            }]
        },
        options: {
        }
    });
</script>
@endpush