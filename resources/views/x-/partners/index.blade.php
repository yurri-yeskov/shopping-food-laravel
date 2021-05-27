@extends('admin.layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{trans('form_messages.partner')}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('/admin')}}"><i class="fa fa-dashboard"></i> {{trans('form_messages.home')}}</a></li>
        <li class="active">{{trans('form_messages.partner')}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <div class="pull-left">
              <a href="{{URL::to('admin/partners/create')}}" class="btn btn-primary">{{trans('form_messages.add_new')}}</a></div>
              <div class="pull-right"><form action="{{URL::to('admin/partners')}}" method="POST" role="search" id="search_form">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="search" value="{{Session::get('keyword')}}"
                        placeholder="Search by name, email, phone"> <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
              </form>
            </div>

            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body table-responsive">
                <table class="table table-bordered">
                <tr>
                <th style="width: 10px"><input type="checkbox" id="ckbCheckAll" /></th>
                  <th style="width: 10px">#</th>
                  <th> @sortablelink('name', trans('form_messages.name'))</th>
                  <th> @sortablelink('email', trans('form_messages.email'))</th>
                  <th> @sortablelink('phone', trans('form_messages.phone'))</th>
                  <th> Logo</th>
                  <th class="text-center"> @sortablelink('status', trans('form_messages.status'))</th>
                  <th class="text-center"> {{trans('form_messages.action')}} </th>
                </tr>
                <?php $i = ($data->currentPage() - 1) * ($data->perPage());?>
                @if(!empty($data))
                @foreach($data as $row)
                <?php $i = $i + 1;?>
                <tr>
                <td><input type="checkbox" class="checkBoxClass" name='all_ids[]' value='{{$row->id}}' /></td>
                  <td>{{$i}}</td>
                  <td>{{$row->name}}</td>
                  <td>{{$row->email}}</td>
                  <td>{{$row->phone}}</td>
                  <td><img src="{!! URL::to('uploads/partners/'.$row->logo) !!}" alt="" width="50"></td>
                  <td class="text-center"><span class="badge {{ $row->status==1 ? 'bg-green' : 'bg-yellow' }}">{{Config::get('constants.STATUS.'.$row->status)}}</span></td>
                  <td class="text-center"><a href="{{URL::to('admin/partners/edit/'.base64_encode($row->id))}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                    <a href="{{URL::to('admin/partners/view/'.base64_encode($row->id))}}" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>
                  <a class="delete-modal btn btn-xs btn-danger" onclick="delete({{base64_encode($row->id)}})" data-id="{{base64_encode($row->id)}}"
                    data-name="{{$row->name}}">
                    <span class="fa fa-trash"></span>
                </a>
                </td>
                </tr>
                @endforeach
                @endif
               
              </table>
              <button id="delete_all" type="button" data-action='partners' class="btn btn-danger">Bulk Delete</button>
              @if(!empty($data)) {{$data->links()}} @endif
              </div>




<div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form">
              <div class="form-group clearfix">
                <label class="control-label col-sm-2" for="id">{{trans('form_messages.id')}}:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="fid" disabled>
                </div>
              </div>
              <div class="form-group clearfix">
                <label class="control-label col-sm-2" for="name">{{trans('form_messages.name')}}:</label>
                <div class="col-sm-10">
                  <input type="name" class="form-control" id="n">
                </div>
              </div>
            </form>
            <div class="deleteContent">
              {{trans('form_messages.sure_delete')}} <span class="dname" style="display: none;"></span> ? <span
                class="hidden did" style="display: none;"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn actionBtn" data-dismiss="modal">
                <span id="footer_action_button" class='glyphicon'> </span>
              </button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> {{trans('form_messages.close')}}
              </button>
            </div>
          </div>
        </div>
</div>
</div>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript" src="{{asset('assets/admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript">

        $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.did').text($(this).data('id'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
});


        $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            method: 'post',
            url: '{{URL::to("/admin/partners/destroy") }}',
            data: {
                '_token': "{{csrf_token()}}",
                'id': $('.did').text()
            },
            success: function(data) {
              if(data.status=='success'){
              window.location.reload();
               $('#main').html('<div class="alert alert-success col-ssm-12" >' + data.message + '</div>');
             }
             else{
                $('.item' + $('.did').text()).remove();
                $('#main').html('<div class="alert alert-danger col-ssm-12" >' + data.message + '</div>');
             }
            }
        });
    });
        $('#search').blur(function(){
          $('#search_form').submit();
        });
    </script>
@stop