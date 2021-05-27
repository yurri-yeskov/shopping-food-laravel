<div class="modal-header">
        <h5 class="modal-title">Create Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'POST']) !!}
    <div class="modal-body">
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Coupon Code</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Coupon Code.." ><small>Min 4 max 8 characters</small>
            </div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Title</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="title" name="title" placeholder="Title.." >
            </div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Description</label>
            <div class="col-sm-9">
                <textarea type="text" class="form-control" id="description" name="description" placeholder="Description.." rows="3"></textarea></div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Discount Value</label>
            <div class="col-sm-4">
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">%</div>
                    </div>
                    <input type="text" class="form-control" id="discount_value" name="discount_value">
                </div>
            </div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Starts</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="date-input" name="start_date">
            </div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-3 control-label text-right">Ends</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="end_date" name="end_date">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 control-label text-right">Status</label>
            <div class="col-sm-1">
                <input type="checkbox" class="ac-kapa" name="val-status"/>
            </div>

        </div>

    </div>
    <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
                {!! Form::close() !!}
<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('coupons.store')}}',
            container: '#updateFile',
            type: "POST",
            data: $('#updateFile').serialize(),
            success: function (response) {
                $('#editContactModal').modal('hide');
                    location.reload();
            }
        })
    });
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
    
</script> 