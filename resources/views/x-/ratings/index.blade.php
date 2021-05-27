@extends('layouts.app')
@section('title', 'Reviews & Ratings')

@section('content')
	<div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Reviews & Ratings</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Reviews & Ratings</li>
                </ol>
            </div>
        </div>
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @include('layouts.message')
                    <div class="card-body">
                        <h4 class="card-title">Reviews & </h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <table id="ratingTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Booking Code</th>
                                        <th>Rated By</th>
                                        <th>Rated To</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Complement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Booking Code</th>
                                        <th>Rated By</th>
                                        <th>Rated To</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Complement</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                	@foreach($ratings as $rating)
                                    	<tr>
											<td>{{ $rating->booking->booking_code}}</td>
                                            <td>{{isset($rating->user->name) ? $rating->user->name : '-'}}</td>
											<td>{{isset($rating->parent->name) ? $rating->parent->name : '-'}}</td>
                                            <td>{{ $rating->rating }}</td>
                                            <td>{!! $rating->comment !!}</td>
                                            <td>{{isset($rating->complement->name) ? $rating->complement->name : '-'}}</td>
                                            <td>
												<a href="{{route('viewRating',['id'=>$rating->id])}}" class="toolTip" data-toggle="tooltip" data-placement="bottom" title="View Detail"><i class="fa fa-eye"></i></a>
                                            </td>
										</tr>
                                	@endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>

@endsection

@push('scripts')

    <script src="{{URL::asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
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
    		var table = $('#ratingTable').DataTable({
		        dom: 'Bfrtip',
		        buttons: [
                    {extend: 'copy',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'csv',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'excel',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'pdf',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'print',exportOptions: {columns: 'th:not(:last-child)'}}
                ],
                "columnDefs": [
                    {"targets": 6,"orderable": false},
                    {"targets": [4,5], visible: false},
                    {"targets": [4], searchable: false},
                ],
                "aaSorting": []
		    });

    	});
    </script>
@endpush