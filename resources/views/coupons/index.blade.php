@extends('layouts.leo')
@push('head-script')
@endpush
@section('content')
@include('sections.settings')
@include('layouts.message')

<span class=" float-right">
                <a href="{{route('coupons.create')}}" class="var-modal btn btn-success float-right btn-xs">New Coupon</a>
            </span>
<div class="card">
            <table class="table" id="leo">
        <thead>
            <tr>
                <th style="width:80px;">Action</th>
                <th>Code</th>
                <th>Title</th>
                <th>Description</th>
                <th style="width:100px;">Start</th>
                <th style="width:100px;">End</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($coupons as $coupon)
            <tr>
                <td>
                    <div class="table-actions">
                        <a href="{{route('coupons.edit',$coupon->id)}}" class="toolTip var-modal" data-toggle="tooltip" data-placement="bottom" title="Edit coupon"><i class="ik ik-edit"></i></a>
                        <a href="#" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete" data-coupon-id="{{$coupon->id}}"><i class="ik ik-trash-2"></i></a>
                    </div>
                </td>
                <td>{{$coupon->coupon_code}} - {{$coupon->discount_value}}% </td>
                <td>{{$coupon->title}}</td>
                <td>{{$coupon->description}}</td>
                <td>{{$coupon->start_date}}</td>
                <td>{{$coupon->end_date}}</td>
                <td><input type="checkbox" class="js-switch change-coupon-status" data-coupon-id="{{ $coupon->id }}" {{($coupon->status=='AC')?'checked':''}} /></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade text-center" id="theModal">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
    var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elem.forEach(function(html) {
        var switchery = new Switchery(html, {
            color: '#2ed8b6',
            jackColor: '#fff',
            size: 'small'
        });
    });
    });

      $(function() {
            $('body').on('click', '.delete', function(){
                var id = $(this).data('coupon-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted slider!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "{{ route('coupons.destroy',':id') }}";
                        url       = url.replace(':id', id);
                        var token = "{{ csrf_token() }}";
                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                        window.location.reload();
                                }
                            }
                        });

                    }
                });
            });
        });
   

$('.change-coupon-status').change(function () {
        var id = $(this).data('coupon-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '{{route('changeCouponStatus', ':id')}}';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '{{ csrf_token() }}' }
        })
    });    

    $('.var-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
</script>
@endpush