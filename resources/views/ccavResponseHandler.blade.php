<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{URL::asset('/images/favicon.png')}}">
    <title>Grocery Store - CCAvenue Payment</title>
    <link href="{{URL::asset('/public/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="{{URL::asset('/public/plugins/chartist-js/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css')}}" rel="stylesheet">
    <!--c3 CSS -->
    <link href="{{URL::asset('/public/plugins/c3-master/c3.min.css')}}" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <!-- <link href="{{URL::asset('/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet"> -->
    <!-- Custom CSS -->
    <link href="{{URL::asset('/public/css/style.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/plugins/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('/public/css/pages/dashboard2.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/css/colors/default-dark.css')}}" id="theme" rel="stylesheet">
    <link href="{{URL::asset('/public/css/toastr/toastr.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/plugins/summernote/dist/summernote.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('/public/css/pages/file-upload.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/public/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"
        rel="stylesheet">
    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .displayOverlay {
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99;
            background: rgba(255, 255, 255, 0.8);
            font-size: 1.5em;
            text-align: center;
            padding-top: 100px;
        }

        .editableDiv {
            border: 1px solid #ced4da;
            overflow: auto;
            min-height: 100px;
            resize: both;
            width: 70%;
        }

        iframe {
            border: 1px solid lightgray;
        }
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border text-center">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Grocery Store</p>
        </div>
    </div>
    <div id="main-wrapper" class="d-flex flex-column align-items-center justify-content-center">



@if($order_status === "Success")
	<br>Thank you for shopping with us. <br>Your credit card has been charged and your transaction is successful. <br>We will be shipping your order to you soon.

@elseif ($order_status === "Aborted")
	<br>Thank you for shopping with us. <br>We will keep you posted regarding the status of your order through e-mail

@elseif ($order_status === "Failure")
	<br>Thank you for shopping with us. <br>However,the transaction has been declined.
@else
	<br>Security Error. <br>Illegal access detected
@endif
<br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="border table-responsive text-left">
        <table cellspacing="4" cellpadding="4" class="table table-striped">
        @for ($i = 0; $i < $dataSize; $i++)
        	@php
        	$information = explode('=', $decryptValues[$i]);
        	@endphp
        	@if(in_array($information[0], ['status_message','currency','amount','billing_name','billing_address','billing_city','billing_state','billing_telephone','billing_email','delivery_name','delivery_address', 'delivery_city', 'delivery_state']))
        	    <tr><td>{{ucwords(implode(' ', explode('_',$information[0])))}}</td><td>{{urldecode($information[1])}}</td></tr>
        	@endif
        @endfor

        </table>
        </div>
    </div>
</div>
</div>
    <script src="{{URL::asset('/public/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="{{URL::asset('/public/plugins/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{URL::asset('/public/js/perfect-scrollbar.jquery.min.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{URL::asset('/public/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{URL::asset('/public/js/sidebarmenu.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/moment/moment.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{URL::asset('/public/js/custom.min.js')}}"></script>
    <script src="{{URL::asset('/public/js/custom.js')}}"></script>
    <script src="{{URL::asset('/public/js/jasny-bootstrap.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/switchery/dist/switchery.min.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/summernote/dist/summernote.min.js')}}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.10.0/jquery.validate.js" type="text/javascript"></script>
    <script src="{{URL::asset('/public/js/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('/public/js/jquery.validate-init.js')}}"></script>
    <script src="{{URL::asset('/public/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

</body>

</html>