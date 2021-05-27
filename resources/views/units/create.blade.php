  <link rel="stylesheet" href="{{asset('plugins/slim/slim.css')}}">
    <div class="modal-header">
        <h5 class="modal-title">New Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'newFile','class'=>'ajax-form','method'=>'POST']) !!}
    <div class="modal-body bg-white">
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Unit Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="name" name="name" placeholder="Unit Name..">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Unit Code</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="code" name="code" placeholder="Unit Code..">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 control-label text-right">Status</label>
            <div class="col-sm-6">
                <input type="checkbox" class="ac-kapa" name="val-status"/>
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
    var elem = Array.prototype.slice.call(document.querySelectorAll('.ac-kapa'));
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
            url: '{{route('units.store')}}',
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