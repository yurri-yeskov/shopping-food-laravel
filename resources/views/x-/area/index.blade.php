@extends('layouts.app')
@section('title', 'Areas')
@section('content')

     <section class="content-header">
      <h1>
        Areas
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('index')}}">Home</a></li>
        <li class="active">Areas</li>
      </ol>
    </section>


    <!-- Start Page Content -->
        <section class="content">
              <div class="box box-default">
                <div class="box-header with-border">
    @include('layouts.message')
                    <h4 class="card-title">All Areas</h4>
                    <div id="main">
                    </div>
                    <div class="box-tools pull-right">
                        <a class="btn waves-effect waves-light  btn-success" href="{{route('createArea')}}">Add New</a></div>

                    <div class="table-responsive m-t-40">
                        <table id="cmsTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    {{-- <th><input type="checkbox" id="ckbCheckAll" /></th> --}}
                                    <th></th>
                                    <th>Area Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    {{-- <th><button id="delete_all" type="button" data-action='areas' class="btn btn-danger">Delete</button></th> --}}
                                    <th></th>
                                    <th>Area Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($locations as $cat)
                                <tr>
                                    {{-- <td><input type="checkbox" class="checkBoxClass" name='all_ids[]' value='{{$cat->id}}' /></td> --}}
                                    <td></td>
                                    <td>{{$cat->name}}</td>
                                    <td>{{ucfirst(config('constants.STATUS.'.$cat->status))}}</td>
                                    <td>
                                        <a href="{{route('editArea', ['id' => $cat->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="Edit Area"><i class="fa fa-pencil"></i></a>                                        &nbsp;&nbsp;&nbsp;
                                        <a href="{{route('viewArea', ['id' => $cat->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Area"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete Area" id="sa-warning" data-id="{{$cat->id}}"><i class="fa fa-remove"></i> </a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
 @push('scripts')

<script src="{{URL::asset('public/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript">
    $(function(){
    		var table = $('#cmsTable').DataTable({
		        dom: 'Bfrtip',
		        buttons: [
		            {extend: 'copy',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'csv',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'excel',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'pdf',exportOptions: {columns: 'th:not(:last-child)'}},
                    // {extend: 'print',exportOptions: {columns: 'th:not(:last-child)'}}
		        ],
                "columnDefs": [
                    {"targets": 3,"orderable": false},
                    {"targets": 0,"orderable": false}
                    ],
                "aaSorting": []
		    });

    	});
$(document).on('click', '.delete', function() {
    var con =confirm('Are you sure to delete!!');
    if(con) {
        $.ajax({
            method:'post',
            url: '{{URL::to("/admin/area/destroy") }}',
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
        else
        {
            $('.item' + $('.did').text()).remove();
            $('#main').html('<div class="alert alert-danger col-ssm-12">' + data.message + '</div>');
            }
            }
            });
            }
            return false;
            });

</script>
@endpush