  <link rel="stylesheet" href="{{asset('plugins/slim/slim.css')}}">
    <div class="modal-header">
        <h5 class="modal-title">Create FAQ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'POST']) !!}
    <div class="modal-body">
        <div class="form-group row bg-white">
            <label class="col-sm-2 control-label text-right">Question</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="question" name="question" placeholder="Question..">
            </div>
        </div>
        <div class="form-group row bg-white">
            <label class="col-sm-2 control-label text-right">Answer</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" id="answer" name="answer" rows="8"></textarea>
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
<script src="{{asset('plugins/slim/slim.js')}}"></script>
<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('faq.store')}}',
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