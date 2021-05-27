@extends('layouts.leo')
@section('content')
@include('sections.settings')
        <section class="content">
              <div class="box box-default">
                <div class="box-header with-border">
    @include('layouts.message')
                    <h4 class="card-title">All Delivery Charges</h4>
                    <div id="main">
                    </div>
                    <div class="box-tools pull-right">

                        <a class="btn waves-effect waves-light  btn-success" href="{{route('addnewDeliveryCharge')}}">Add New</a></div>


                    <div class="table-responsive m-t-40">
                        <table id="cmsTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{-- <input type="checkbox" id="ckbCheckAll" /> --}}</th>
                                    <th>Delivery Charge</th>
                                    <th>From Amount</th>
                                    <th>To Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>{{-- <button id="delete_all" type="button" data-action='deliverycharges' class="btn btn-danger">Delete</button> --}}</th>
                                    <th>Delivery Charge</th>
                                    <th>From Amount</th>
                                    <th>To Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach($deliverycharges as $cat)
                                <tr>
                                    <td>{{-- <input type="checkbox" class="checkBoxClass" name='all_ids[]' value='{{$cat->id}}' /> --}}</td>
                                    <td>{{$cat->delivery_charge}}</td>
                                    <td>{{$cat->from_amount}}</td>
                                    <td>{{$cat->to_amount}}</td>
                                    <td>{{ucfirst(config('constants.STATUS.'.$cat->status))}}</td>
                                    <td>
                                        <a href="{{route('editDeliveryCharge', ['id' => $cat->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit Page">Edit</a>                                        {{-- &nbsp;&nbsp;&nbsp;
                                        <a href="{{route('viewDeliveryCharge', ['id' => $cat->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Page"><i class="fa fa-eye"></i></a> --}}&nbsp;&nbsp;&nbsp;
                                        <a href="" class="img-responsive model_img delete" id="sa-warning" data-id="{{$cat->id}}">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </section>
    <!-- End PAge Content -->
@endsection
 @push('scripts')


<script type="text/javascript">

           $(document).on('click', '.delete', function() {
            var con =confirm('Are you sure to delete!!');
            if(con) {
                $.ajax({
                    method:'post',
                    url: '{{URL::to("/admin/deliverycharge/destroy") }}',
                    data: {
                        '_token': "{{csrf_token()}}",
                        'id': $(this).data('id')
            },
            success: function(data) {
                if(data.status=='success')
                {
                    window.location.reload();
                $('#main').html('<div class="alert alert-success col-ssm-12">' + data.message + '</div>');
                }
                else{
                    $('.item' + $('.did').text()).remove();
                    $('#main').html('<div class="alert alert-danger col-ssm-12">' + data.message + '</div>'); } } }); }
                    return false;
        });

</script>
@endpush