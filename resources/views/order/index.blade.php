@extends('layouts.leo')
@section('content')
@include('layouts.message')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="{{route('orders.index')}}">
                                <div class="widget bg-{{\Request::segment(3)!='' ? 'secondary' : 'info'}}">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Total Orders</h6>
                                                <h2>{{$totalorders}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-grid"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                            <a href="{{route('pendingOrder')}}">
                                <div class="widget bg-{{\Request::segment(3) == 'pending' ? 'yellow' : 'secondary'}}">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Pending</h6>
                                                <h2>{{$pendingorders}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        </a>
                            </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
                                <a href="{{route('deliveredOrder')}}">

                                <div class="widget bg-{{\Request::segment(3) == 'delivered' ? 'success' : 'secondary'}}">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Delivered</h6>
                                                <h2>{{$deliveredorders}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            </a>
                            </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <a href="{{route('cancelledOrder')}}">
                                <div class="widget bg-{{\Request::segment(3) == 'cancelled' ? 'danger' : 'secondary'}}">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Cancelled</h6>
                                                <h2>{{$cancelledorders}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-x-circle"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </a>
                            </div>
    </div>
</div>
    <div class="box box-default">
        <div class="box-header with-border">                    
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th style="width:20px; text-align:left; " >Action</th>
                                    <th>Status</th>
                                    <th>Order Code</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>                                
                                        <div class="table-actions">
                                        @if($order->delivery_status == 'Pending')
                                        <a href="javascript:void(0)" class="changeStatus toolTip text-danger" data-status="{{$order->status}}" data-id="{{$order->id}}"><button type="button" class="btn btn-danger"><i class="fa fa-times"></i>Cancel</button>
                                        </a>
                                        
                                        @endif
                                        @if($order->delivery_status == 'Delivered')
                                        <a href="{{route('sendInvoice', ['id' => $order->id])}}"><button type="button" class="btn btn-secondary"><i class="fa fa-share"></i>Invoice</button></a>
                                        @endif
                                        </div>
                                    </td>
                                    <td> {!!$order->orderstatus!!}</td>
                                    <td><a href="{{route('editOrder', ['id' => $order->id])}}" class="toolTip text-success" data-toggle="tooltip" data-placement="left" title="Check Order"><span class="badge badge-dark">{{$order->order_code}}</span></a></td>
                                    <td><a href="">{{$order->get_orders->name}}</a></td>
                                    <td>{{$order->get_orders->mobile_number}}</td>
                                    <td>{{(isset($order->useraddress->house_no))?$order->useraddress->house_no.", ":""}}
                                        {{(isset($order->useraddress->apartment_name))?$order->useraddress->apartment_name.", ":""}}
                                        {{(isset($order->useraddress->street_details))?$order->useraddress->street_details.", ":""}}
                                        {{(isset($order->useraddress->landmark_details))?$order->useraddress->landmark_details.", ":""}}
                                        {{(isset($order->useraddress->area_details))?$order->useraddress->area_details.", ":""}}
                                        {{(isset($order->useraddress->city))?$order->useraddress->city.", ":""}}
                                        {{(isset($order->useraddress->pincode))?$order->useraddress->pincode." ":""}}
                                    </td>
                                    <td>{{$order->updated_at->diffForHumans()}}</td>
                                    <td>$ {{$order->total_amount}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> {{$orders->links()}}
                </div>
           
        </div>
    </div>

<div class="modal fade" id="userStatusModal" tabindex="-1" role="dialog" aria-labelledby="userStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userStatusModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-valide" method="post" id="blockForm" action="{{route('cancelOrder')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="val-id" id="val-id">
                    {{-- <input type="hidden" name="val-status" id="val-status"> --}}
                    <div class="form-group">
                        <label class="col-form-label" for="val-reason"><span class='userstatus'></span></label>
                        <textarea class="form-control" id="val-reason" name="val-reason" rows="5"></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary btn-flat cancelBtn m-b-30 m-t-30" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info btn-flat blockBtn m-b-30 m-t-30">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush