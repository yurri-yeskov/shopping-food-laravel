@extends('layouts.leo')
@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="page-header-title">
                <i class="ik ik-bell bg-blue"></i>
                <div class="d-inline">
                    <h5>Send SMS</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hpanel">
    @if($errors->any())
    <div class='alert alert-danger'>
        <ul>
            @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
    @endif
    @if( session( 'success' ) )
    <div class='.col-md-6 .col-md-offset-3 alert alert-success'>
        {{ session( 'success' ) }}
    </div>

    @endif
    <div class="row">
        <div class="row col-sm-6">
        <div class="col-sm-6">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Twilio Balance</h6>
                                                <h2 class="text-success">{{$balance}}</h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-dollar-sign"></i>
                                            </div>
                                        </div>
                                        <small class="text-small mt-10 d-block">You can send upto {{round($balance/0.055,0)}} messages</small>
                                    </div>
                                    
                                </div>
                            </div>
        <div class="col-sm-6">
                                <div class="widget">
                                    <div class="widget-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="state">
                                                <h6>Messages</h6>
                                                <h2 class="text-danger"><div id="gracebish"> 0 </div></h2>
                                            </div>
                                            <div class="icon">
                                                <i class="ik ik-message-square"></i>
                                            </div>
                                        </div>
                                        <small class="text-small mt-10 d-block">You can send upto {{round($balance/0.055,0)}} messages</small>
                                    </div>
                                    
                                </div>
                            </div>
        <div class="col-sm-12 hidden m-t-10" id="twiliowarning">
                        <div class="stats-title pull-left">
                            <h4>Your Twilio Balance is not enough to send messages</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="pe-7s-attention text-danger fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <a href="https://www.twilio.com/console" target="_blank" class="btn btn-danger">Add credits to your Twilio Account</a>
                        </div>
                </div>
                    <div class="col-sm-12 m-t-10">

            <form action='{{route('sendsms')}}' method='post' id="smsform">
                            @csrf
                                <input type="checkbox" name="device_type[]" value="ios" id="1"> <label for="1"> IOS</label>
                                <input type="checkbox" name="device_type[]" value="android" id="2"> <label for="2">Android</label>
                                <textarea name='message' required rows="5" maxlength="160" class="form-control" placeholder="Message"></textarea>
                                <span class="contador"></span>
                                
                                <div><button type='submit' class="btn btn-success " id="sendbutton" disabled>Send Sms Now!</button>
                                </div>
                        </form>
            </div>
        </div>
        <div class="col-sm-6">
            <table cellpadding="1" cellspacing="1" class=" table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Message</th>
                        <th>Total Recipient</th>
                        <th>Device</th>
                        <th>Sent at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    <tr>
                        <td>{{$loop->iteration}}
                        </td>
                        <td> {{$message->message}}
                        </td>
                        <td> {{$message->total_receiver}}
                        </td>
                        <td>@foreach($message->device as $value)
                            <label class="label label-success">{{$value}}</label>
                            @endforeach

                        </td>
                        <td> {{$message->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>

@endsection

@push('scripts')
<script>
        $('.toggle-filter').click(function () {
            $('#new-sms-filter').slideToggle();
        });


$(document).ready(function () {
        $('textarea').bind('input propertychange', function () {
            atualizaTextoContador($(this));
        });

        $('textarea').each(function () {
            atualizaTextoContador($(this));
        });
    });

    function atualizaTextoContador(textarea) {
        var spanContador = textarea.next('span.contador');
        var maxlength = textarea.attr('maxlength');
        if (!spanContador || !maxlength)
            return;
        var numCaracteres = textarea.val().length;
        spanContador.html(numCaracteres + ' / ' + maxlength);
    }
</script>
<script type="text/javascript">

var getfilters = function (device_type) {
        
  $.ajax({
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url:'{{route('gettotalsmsnumber')}}',

            data: {"device_type": device_type,
                    "_token": "{{ csrf_token() }}"
            },
            error: function(e) {
                console.log(e.responseText);
            },
            success: function (data) {
                console.log(data);
                $('#gracebish').html(data)
            var balance = {{$balance}};
            var data    = data;
            var cost    = data * 0.055;
                if( cost > balance)
                    {
                        $('#sendbutton').attr('disabled','disabled');
                        $('#twiliowarning').removeClass('hidden');
                    } else{
                        $('#sendbutton').removeAttr('disabled');
                        $('#twiliowarning').addClass('hidden');
                    }
            }});

}

$(document).ready(function() {
  $('input[type="checkbox"]').on('change', function(event) {
    event.preventDefault();
    var device_type = [];
    $.each($("input[name='device_type[]']:checked"), function() {            
      device_type.push($(this).val());
    });
    $('#myResponse').html(); 
    getfilters(device_type);
  });
});
</script>

@endpush