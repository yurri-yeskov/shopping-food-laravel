  <link rel="stylesheet" href="{{asset('plugins/slim/slim.css')}}">
    <div class="modal-header">
        <h5 class="modal-title">New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'newFile','class'=>'ajax-form','method'=>'POST']) !!}
    <div class="modal-body">
        <div class="form-group row bg-white">
            <label class="col-sm-4 control-label text-right">Category Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" placeholder="name..">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Category Image</label>
            <div class="col-sm-6">
                <div class="slim" data-label="Drop Category Image here" data-size="200, 200" data-ratio="1:1">
                    <input type="file" name="image" />
                    <small>Click on Image to add or change</small>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
                {!! Form::close() !!}
<script src="{{asset('plugins/slim/slim.js')}}"></script>
<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('category.store')}}',
            container: '#newFile',
            type: "POST",
            data: $('#newFile').serialize(),
            success: function (response) {
                $('#editContactModal').modal('hide');
                    location.reload();
            }
        })
    });
</script>