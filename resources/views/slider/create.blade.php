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
            <label class="col-sm-4 control-label text-right">Slider Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" placeholder="name..">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Slider Image</label>
            <div class="col-sm-6">
                <div class="slim" data-label="Drop Category Image here" data-size="800, 800" data-ratio="8:5">
                    <input type="file" name="image" />
                    <small>Click on Image to add or change</small>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Status</label>
            <div class="col-sm-6">
             <input type="checkbox" class="js-switch" name="val-status"/>
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


    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('slider.store')}}',
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