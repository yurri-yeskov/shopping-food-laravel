    <style>
        @media print {
    #printbtn {
        display :  none;
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

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
        <div class="col-12" style="text-align:center;">
            <button onclick="window.print()" id ="printbtn">Print this page</button>
        </div>

    <div class="invoice-box">
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
                                Order Date : {{ $order->updated_at->format('D d M Y h:i A') }}<br>
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
                                ABN: 75 936 896 193
                                Shop 14/72<br>
                                Main Hurstbridge Rd<br>
                                Diamond Creek VIC 3089
                            </td>

                            <td style="text-align:right">
                                <b>{{$order->user->name}}</b><br>
                                   0{{$order->user->mobile_number}}<br>
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
                    Delivery Or Pick Up
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
                <td colspan="3">
                    {{$order->delivery_pickup}}
                </td>
                <td>
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
                <td colspan="3">
                    {{$order->payment_method}}
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

        </table>
    </div>
<script>window.print();</script>