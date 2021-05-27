@extends('layouts.leo')
@push('head-script')
<style>
    @media print {
        #printbtn {
            display: none;
        }
    }

    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(5) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 0px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    .box {
  position: relative;
  background: #fff;
  box-shadow: 0 0 15px rgba(0,0,0,.1);
}

/* common */
.ribbon {
  width: 150px;
  height: 150px;
  overflow: hidden;
  position: absolute;
}
.ribbon::before,
.ribbon::after {
  position: absolute;
  z-index: -1;
  content: '';
  display: block;
  border: 5px solid #2980b9;
}
.ribbon span {
  position: absolute;
  display: block;
  width: 225px;
  padding: 15px 0;
  background-color: #000000;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
  color: #fff;
  font: 700 18px/1 'Open Sans', sans-serif;
  text-shadow: 0 1px 1px rgba(0,0,0,.2);
  text-transform: uppercase;
  text-align: center;
}

/* top left*/
.ribbon-top-left {
  top: -10px;
  left: 55px;
}
.ribbon-top-left::before,
.ribbon-top-left::after {
  border-top-color: transparent;
  border-left-color: transparent;
}
.ribbon-top-left::before {
  top: 0;
  right: 0;
}
.ribbon-top-left::after {
  bottom: 0;
  left: 0;
}
.ribbon-top-left span {
  right: -25px;
  top: 30px;
  transform: rotate(-45deg);
}

/* top right*/
.ribbon-top-right {
  top: -10px;
  right: -10px;
}
.ribbon-top-right::before,
.ribbon-top-right::after {
  border-top-color: transparent;
  border-right-color: transparent;
}
.ribbon-top-right::before {
  top: 0;
  left: 0;
}
.ribbon-top-right::after {
  bottom: 0;
  right: 0;
}
.ribbon-top-right span {
  left: -25px;
  top: 30px;
  transform: rotate(45deg);
}

/* bottom left*/
.ribbon-bottom-left {
  bottom: -10px;
  left: -10px;
}
.ribbon-bottom-left::before,
.ribbon-bottom-left::after {
  border-bottom-color: transparent;
  border-left-color: transparent;
}
.ribbon-bottom-left::before {
  bottom: 0;
  right: 0;
}
.ribbon-bottom-left::after {
  top: 0;
  left: 0;
}
.ribbon-bottom-left span {
  right: -25px;
  bottom: 30px;
  transform: rotate(225deg);
}

/* bottom right*/
.ribbon-bottom-right {
  bottom: -10px;
  right: -10px;
}
.ribbon-bottom-right::before,
.ribbon-bottom-right::after {
  border-bottom-color: transparent;
  border-right-color: transparent;
}
.ribbon-bottom-right::before {
  bottom: 0;
  left: 0;
}
.ribbon-bottom-right::after {
  top: 0;
  right: 0;
}
.ribbon-bottom-right span {
  left: -25px;
  bottom: 30px;
  transform: rotate(-225deg);
}
</style>
@endpush
@section('content')
@include('layouts.message')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-5">
            @if($type=='edit' && empty($order->driver_id))
            <form method="POST" action="{{route('assignOrder',request()->route('id'))}}">
                {{csrf_field()}}
                <div class="form-group clearfix">
                    {!!Form::label('driver_id','Select Driver')!!}
                    <select required name="driver_id" class="form-control col-md-4">
                        <option value="">Select Driver</option>
                        @foreach ($drivers as $driver)
                        <option value="{{$driver->id}}" @if($order->driver_id==$driver->id) selected @endif>{{$driver->name}}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{!! $errors->first('driver_id') !!}</span>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
            @else
            @foreach ($drivers as $driver)
            @if($order->driver_id==$driver->id)
            <p>Selected Driver Name :{{$driver->name}}</p>
            @endif
            @endforeach

            @endif
        </div>
    </div>
</div>

<div class="row layout-wrap">
<div class="col-sm-2">
<a href="{{route('showInvoice',$order->id)}}showInvoice" target="_blank" class="btn btn-primary btn-block" style="margin-right: 5px;"><i class="fa fa-print"></i> Print</a>
        @if($type=='edit' && $order->delivery_status == "Pending")
            <form method="POST" class="form-valide" action="{{route('statusOrder',request()->route('id'))}}">
                {{csrf_field()}}
                <input type="hidden" name="user_id" value="{{$order->user_id}}">
                    {!!Form::label('order_status','Select Status')!!}<span class="required">*</span><br>
                    <select required name="status" class="form-control">
                        <option value="">Select Status</option>
                        @foreach ($status as $key=>$value)
                        <option value="{{$value}}" @if($order->delivery_status==$value) selected @endif>{{$value}}</option>
                        @endforeach
                    </select>
                        <button type="submit" class="btn btn-success">Update</button>
            </form>
            @else
            <h4>Delivery Status :
                @if($order->delivery_status=="Delivered")
                <span style="color: green">{{$order->delivery_status}}</span>
                @elseif($order->delivery_status=="Canceled" || $order->delivery_status=="Failed")
                <span style="color: red">{{$order->delivery_status}}</span>
                @else
                <span>{{$order->delivery_status}}</span>
                @endif
            </h4>
            @endif
</div>
<div class="col-sm-10">
<div class="invoice-box bg-white">
          <div class="ribbon ribbon-top-left"><span>Pickup</span></div>
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="5">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{URL::asset('/images/logo-invoice.png')}}">
                        </td>
                        <td style="text-align:right">
                            Invoice # : {{$order->order_code}}<br>
                            Order Date : {{ $order->updated_at->format('D d M Y h:i:s A') }}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="information">
            <td colspan="5">
                <table>
                    <tr>
                        <td>
                            ABN: 75 936 896 193<br>
                            Shop 14/72<br>
                            Main Hurstbridge Rd<br>
                            Diamond Creek VIC 3089
                        </td>

                        <td style="text-align:right">
                            <b>{{$order->user->name}}</b><br>
                            {{$order->mobile_number}}<br>
                            @if($order->delivery_pickup == 'delivery')<b>{!!$order->address->fulladdress!!}</b><br>@endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td style="width:40%">
                Product
            </td>
            <td style="width:15%">

            </td>
            <td style="width:15%;">
                Price
            </td>
            <td style="width:10%">
                Qty
            </td>
            <td style="width:20%">
                Subtotal
            </td>
        </tr>
        @foreach($order->cartitems as $cart)
        <tr class="item">
            <td>
                {{$cart->product->name}}
            </td>
            <td>
                {{$cart->variation->weight}} {{$cart->variation->unit->code}}
            </td>
            <td>
                {{$cart->variation->price}}
            </td>
            <td>
                {{$cart->quantity}}
            </td>
            <td>
                $ {{$cart->total_with_tax}}
            </td>
        </tr>
        @endforeach
        <tr class="total">
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                Total: $ {{$order->cost}}
            </td>
        </tr>
        <tr class="heading">
            <td>
                Payment Method
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <tr class="details">
            <td>
                {{$order->payment_method}}
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <tr class="heading">
            <td>
                Delivery or Pickup
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <tr class="details">
            <td>
                {{$order->delivery_pickup}}
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <tr class="heading">
            <td colspan="5">
                Order Note
            </td>
        </tr>
        <tr class="item">
            <td colspan="5">
                {!!$order->comment!!}
            </td>
        </tr>
        <tr class="heading">
            <td colspan="5">
                Bank Details
            </td>
        </tr>
        <tr class="item">
            <td colspan="5">
                V.Granieri Local Fine Foods 633 000 / 171 301 195
            </td>
        </tr>
    </table>
</div>
</div>
    </div>

@endsection
@push('scripts')

@endpush