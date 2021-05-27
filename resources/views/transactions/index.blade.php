@extends('layouts.app')
@section('title', 'Transactions')

@section('content')
	<div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-primary">Transactions</h3> </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </div>
        </div>

<form action="" method="get" id="filter_form">
@include("layouts.filter")
</form>
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @include('layouts.message')
                    <div class="card-body">
                        <h4 class="card-title">Transactions</h4>
                        <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                        <div class="table-responsive m-t-40">
                            <table id="ridesTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Transaction Code</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>Amount</th>
                                        <th>Transaction Status</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Transaction Code</th>
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Mobile Number</th>
                                        <th>Amount</th>
                                        <th>Transaction Status</th>
                                        <th>Date Time</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                	@foreach($transactions as $transaction)
                                    	<tr>
                                            <td>{{$transaction->id}}</td>
											<td>{{$transaction->transaction_code}}</td>
                                            <td>{{ucfirst($transaction->user->name)}}</td>
                                            <td>{{$transaction->user->email}}</td>
                                            <td>{{$transaction->user->mobile_number}}</td>
                                            <td>{{$transaction->amount}}</td>
                                            <td>{{ucfirst($transaction->transaction_status)}}</td>
                                            <td>{{date('Y M, d h:i a', strtotime($transaction->created_at))}}</td>
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
    		var table = $('#ridesTable').DataTable({
		        dom: 'Bfrtip',
		        buttons: [
                    {extend: 'copy',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'csv',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'excel',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'pdf',exportOptions: {columns: 'th:not(:last-child)'}},
                    {extend: 'print',exportOptions: {columns: 'th:not(:last-child)'}}
                ],
                "columnDefs": [
                    {"targets": [0], visible: false},
                    {"targets": [1,2,3,4,5], "searchable": true},
                ],
                "aaSorting": []
		    });

    	});
    </script>
@endpush