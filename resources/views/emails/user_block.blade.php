<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto:400,500,700');
</style>
<table cellspacing="0" style="margin: -8px auto 0; width: 700px; font-family: 'Roboto', sans-serif;">

    <tr>
        <td style="border-top: 7px solid #ff3800;">

        </td>
    </tr>

    <tr>
            <td style="border-bottom: 1px solid #ccc; padding-bottom: 30px;">
                    <table style="float:left;width: 50%;">
                        <tr>
                            <td>
                                <img style="margin:0px;display: block;width:40%" src="{{URL::asset('/images/logo.jpg')}}" alt="logo">
                            </td>
                        </tr>
                    </table>
                </td>
    </tr>


    <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <p style="font-weight: bold; font-size: 18px; margin-top: 60px;">Hi {{$data->name}},</p>
                            <p style="font-size: 16px;color: #5f5e5e;line-height: 1.5;margin-top: 10px;">You are blocked from Local Fine Foods App. </p>
                            <b style="font-size: 16px;color: #5f5e5e;line-height: 1.5;margin-top: 10px;">Reason :</b>
                            <p style="font-size: 16px;color: #5f5e5e;line-height: 1.5;margin-top: 10px;">{{$reason}}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="">
                <td style="background-color: #4d4d4d;padding: 15px 25px;">
                    <table style="width:100%">
                        <tr>
                            <td style="padding-bottom: 25px;">
                                <div style="float: left;width: 50%;">
                                    <img src="{{URL::asset('/images/logo.png')}}" style="width:40%" alt="">
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
                        <tr>
                            <td style="background-color: #4d4d4d;padding: 15px 25px;text-align: center;border-top: 1px solid #fff;">
                                <p style="color: #fff; font-size: 22px;">Need help?</p>
                                <p style="color: #a2a1a1;font-size:14px;">Tap Help in your app to contact support with</p>
                                <p style="color: #a2a1a1;font-size:14px;"><b>Help Line:</b> +91 0987654321</p>
                                <p style="color: #a2a1a1;font-size:14px;"><b>24 X 7:</b> <a href="mailto:noreply@LocalFineFoods.com" style="color:#fff;">noreply@LocalFineFoods.com</a></p>
                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
</table>