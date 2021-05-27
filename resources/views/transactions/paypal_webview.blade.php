<!DOCTYPE html>
<html>
<head>
     <title>Paypal</title>
</head>
<body>
<form id="paynow_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
     <INPUT TYPE="hidden" name="charset" value="utf-8"/>
     <input type="hidden" name="cmd" value="_xclick"/>
     <input type="hidden" name="business" value="grocerystore2017@gmail.com"/>
     <input type="hidden" name="amount" value="{{$data->amount}}"/>
     <input type="hidden" name="first_name" value="{{$data->name}}"/>
     <input type="hidden" name="last_name" value=""/>
     <input type="hidden" name="email" value="{{$data->email}}"/>
     <input type="hidden" name="currency_code" value="AUD"/>
     <input type="hidden" name="quantity" value="1" />
     <input type="hidden" name="item_name" value="Local Fine Foods" />

     <input type="hidden" name="custom" value="{{$data->transaction_code}}" />
     <input type="hidden" name="item_name" value="Local Fine Foods Order"/>
     <INPUT TYPE="hidden" NAME="return" value="https://<?=$_SERVER['HTTP_HOST']?>/api/payment_success" />
     <INPUT TYPE="hidden" NAME="cancel" value="https://<?=$_SERVER['HTTP_HOST']?>/api/payment_failed"/>
     <!-- <input type="hidden" name="notify_url" value="https://www.pearlcab.com/ipn"> -->
     {{-- <input type="submit" value="Button"> --}}
     <p>Please wait...</p>
    </form>
     <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
       <script type="text/javascript">
            $(document).ready(function (){
               setTimeout(
                 function() 
                 {
                    document.getElementById('paynow_form').submit();
                 }, 2000);
            });
       </script>
</body>
</html>