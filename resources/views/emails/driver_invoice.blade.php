<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700');
</style>
<table cellspacing="0" style="margin: -8px auto 0; width: 700px; font-family: 'Roboto', sans-serif;">
   <!--  <tr>
        <td style="text-align: center;">
            <img src="{{$data->path_image}}" alt="google-map">
        </td>
    </tr> -->
    <tr>
        <td style="border-bottom: 1px solid #ccc; padding-bottom: 30px;">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <img style="margin: 30px auto 0;    display: block;" src="{{URL::asset('/images/templte-logo.png')}}" alt="logo">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="margin: 30px 0;display: block;padding: 0 25px;">
        <td>
            <p style="font-size: 30px;font-weight: bold;margin-bottom: 0px;">{{Config::get('constants.CURRENCY_SYMBOL')}}  {{$data->total}}</p>
            <p style="color: #5f5e5e;">Thanks for completing another ride, {{$data->driver_name}}</p>
            <p style="color: #5f5e5e;">{{date("M d, Y",strtotime($data->created_at))}} | Rigo Ride</p>
        </td>
    </tr>
    <tr style="background-color: #e8e8e8; display: block; padding: 20px 25px;">
        <td>
            <div style="width: 6%;display: inline-block;">
                <img src="{{URL::asset('/images/template-indicator.png')}}" alt="">
            </div>
            <div style="width: 90%;display: inline-block;vertical-align: top;">
                <p style="margin: 0;">{{date("h:i a",strtotime($data->created_at))}} |
                    <a  style="color: #0d53ce;" href="#">{{$data->pickup_address}}</a>
                </p>
                <p>{{date("h:i a",strtotime($data->updated_at))}} |
                    <a  style="color: #0d53ce;" href="#">{{$data->dropoff_address}}</a>
                </p>
            </div>

        </td>
    </tr>
    <tr style="margin: 0;">
        <td>
            <div style="text-align: center;margin-top: 50px;">
                <img src="{{$data->driver_profile_picture}}" alt="">
            </div>
            <div style="text-align: center;">
                <p>You rode with {{$data->name}}</p>
            </div>
            <ul style="list-style: none;padding-left:0;text-align: center;">
                <li style="display: inline-block;padding: 0 25px;border-right: 1px solid #ccc;">{{$data->distance}}
                    <span style="display: block;width: 100%;">Kilometers</span>
                </li>
                <li style="display: inline-block;padding: 0 25px;border-right: 1px solid #ccc;">{{$data->trip_time}}
                    <span style="display: block;width: 100%;">Trip time</span>
                </li>
                <li style="display: inline-block;padding: 0 25px;">{{$data->driver_vehicle}}
                    <span style="display: block;width: 100%;">Vehicle</span>
                </li>
            </ul>
            <div style="text-align: center;margin-top: 50px;">
                <img src="{{URL::asset('/images/template-ratngs.jpg')}}" alt="">
            </div>
        </td>
    </tr>

    <tr style="background-color: #e8e8e8;margin-top: 50px;padding: 15px 25px;display: block;">
        <td>
            <table style="width:100%;">
                <tr>
                    <td>
                        <div style="display: inline-block;width: 10%;">
                            <img src="{{URL::asset('/images/tmplate-mail-icon.png')}}" alt="">
                        </div>
                        <div style="display: inline-block;width: 89%;color: #5f5e5e;">
                            <p>Fares are inclusive of GST.
                            </p>
                        </div>
                    </td>
                </tr>
                <tr style="background-color: #e8e8e8;">
                    <td style="padding: 10px 25px;border-top: 1px solid #ccc;">
                        <div>
                            <h2 style="color: #262626; font-weight: normal;">Your Fare</h2>
                        </div>
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">Trip Fare</p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->total_without_tax}}</p>
                        </div>
                    </td>
                </tr>

                <tr style="background-color: #e8e8e8;">
                    <td style="padding: 10px 25px;display: block;border-top: 1px solid #ccc;">
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">Subtotal</p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->total_without_tax}}</p>
                        </div>
                        <!-- <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">Wait Time (?)</p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">&#x20B9 3.69</p>
                        </div> -->
                    </td>
                </tr>

                <tr style="background-color: #e8e8e8;">
                    <td style="padding: 10px 25px;display: block;border-top: 1px solid #ccc;">
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">Before Taxes</p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->total_without_tax}}</p>
                        </div>
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">CGST ({{$data->cgst_percent}}%)</p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->cgst}}</p>
                        </div>
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">SGST/UTGST ({{$data->sgst_percent}}%) </p>
                            <p style="float: right;width: 50%;text-align: right; font-size: 14px;color: #5f5e5e;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->sgst}}</p>
                        </div>
                    </td>
                </tr>

                <tr style="background-color: #e8e8e8;">
                    <td style="padding: 10px 25px;display: block;border-top: 1px solid #ccc;">
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">COLLECTED</p>
                        </div>
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%; font-size: 14px;color: #5f5e5e;">
                                <img src="{{URL::asset('/images/template-cash-icon.png')}}" alt="">
                                <span style="margin-left: 15px;margin-top: -25px;display: inline-block;">{{$data->payment_mode}}</span>
                            </p>
                            <p style="margin-top:0px;float: right;width: 50%;text-align: right;font-size: 30px;font-weight: bold;color: #262626;">{{Config::get('constants.CURRENCY_SYMBOL')}} {{$data->total}}</p>
                        </div>
                    </td>
                </tr>

                <tr style="background-color: #e8e8e8;">
                    <td style="padding: 10px 25px;display: block;border-top: 1px solid #ccc;">
                        <div style="display: inline-block;width: 100%;">
                            <p style="float: left;width: 50%;color: #5f5e5e;font-size: 12px;">License Plate: {{$data->driver_number_plate}}</p>
                        </div>
                    </td>
                </tr>
            </table>


        </td>
    </tr>



   <!--  <tr style="text-align: center;margin: 50px 0;">
        <td style="margin-top: 45px;margin-bottom: 60px;display: block;padding: 0 100px;">
            <div>
                <img src="{{URL::asset('/images/template-car-icon.png')}}" alt="">
            </div>
            <p style="color: #5f5e5e;font-size: 16px;line-height: 1.5;">Invite your friends and family. Share the Rigo Ride love and give friends free rides to try Rigo Ride, worth
                up to {{Config::get('constants.CURRENCY_SYMBOL')}}25 each! </p>
            <p style="color: #ff3800;font-size: 26px;">Share code: akshaykj8545ue</p>
        </td>
    </tr> -->

    <tr style="">
        <td style="background-color: #4d4d4d;padding: 15px 25px;">
            <table style="width:100%">
                <tr>
                    <td style="padding-bottom: 25px;">
                        <div style="float: left;width: 50%;">
                            <img src="{{URL::asset('/images/template-footer-logo.png')}}" alt="">
                        </div>
                        <div style="float: right;width: 50%;text-align: right;margin-top: 15px;">
                            <ul style="list-style: none;">
                                <li style="display: inline-block;margin: 0 5px;">
                                    <a href="#">
                                        <img src="{{URL::asset('/images/fb-icon.png')}}" alt="">
                                    </a>
                                </li>
                                <li style="display: inline-block;margin: 0 5px;">
                                    <a href="#">
                                        <img src="{{URL::asset('/images/twit-icon.png')}}" alt="">
                                    </a>
                                </li>
                                <li style="display: inline-block;margin: 0 5px;">
                                    <a href="#">
                                        <img src="{{URL::asset('/images/insta-icon.png')}}" alt="">
                                    </a>
                                </li>
                                <li style="display: inline-block;margin: 0 5px;">
                                    <a href="#">
                                        <img src="{{URL::asset('/images/google-icon.png')}}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <!-- <tr>
                    <td style="background-color: #4d4d4d;padding: 15px 25px;text-align: center;border-top: 1px solid #fff;">
                        <p style="color: #fff; font-size: 22px;">Need help?</p>
                        <p style="color: #a2a1a1;font-size:14px;">Tap Help in your app to contact support with</p>
                        <p style="color: #a2a1a1;font-size:14px;">questions about your trip.</p>
                    </td>
                </tr> -->
            </table>

        </td>
    </tr>


</table>