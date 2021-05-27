  <link rel="stylesheet" href="{{asset('plugins/slim/slim.css')}}">
    <div class="modal-header">
        <h5 class="modal-title">{{$category->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'PATCH']) !!}
    <div class="modal-body">
        <div class="form-group row bg-white">
            <label class="col-sm-4 control-label text-right">Category Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" placeholder="name.." value="{{$category->name}}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Category Image</label>
            <div class="col-sm-6">
                <div class="slim" data-label="Drop Category Image here" data-size="200, 200" data-ratio="1:1">
                    @if ($category->image)
                    <img src="{!! asset('uploads/categories/'.$category->image) !!}" />
                    @endif
                    <input type="file" name="image" />
                    <small>Click on Image to change</small>
                </div>
            </div>
        </div>
</div>
    <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Update changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
                {!! Form::close() !!}
<script src="{{asset('plugins/slim/slim.js')}}"></script>
<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('category.update', $category->id)}}',
            container: '#updateFile',
            type: "POST",
            data: $('#updateFile').serialize(),
            success: function (response) {
                $('#editContactModal').modal('hide');
                    location.reload();
            }
        })
    });
</script>