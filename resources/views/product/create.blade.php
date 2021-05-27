<link rel="stylesheet" href="{{asset('plugins/slim/slim.css')}}">
<link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <div class="modal-header">
        <h5 class="modal-title">New Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        {!! Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'POST']) !!}
        
        <div class="form-group row">
            <label class="col-sm-2 control-label text-right">Product Name</label>
            <div class="col-sm-4"><input type="text" name="name" class="form-control" placeholder="Product Name"></div>
            <label class="col-sm-2 control-label text-right">Category</label>
            <div class="col-sm-4">
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach ($categories as $cat)
                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label text-right">Featured</label>
            <div class="col-sm-1">
                <input type="checkbox"  class="ac-kapa" name="is_featured"/>
            </div>
            <label class="col-sm-2 control-label text-right">Quick Grab</label>
            <div class="col-sm-1">
                <input type="checkbox" class="ac-kapa" name="is_quick_grab"/>
            </div>
            <label class="col-sm-2 control-label text-right">Offered</label>
            <div class="col-sm-1">
                <input type="checkbox"  class="ac-kapa" name="is_offered"/>
            </div>
            <label class="col-sm-2 control-label text-right">Status</label>
            <div class="col-sm-1">
                <input type="checkbox" class="ac-kapa" name="val-status"/>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 control-label text-right">Product Image</label>
            <div class="col-sm-2">
                <div class="slim" data-label="Drop Product Image here" data-size="800, 800" data-ratio="1:1">
                    <input type="file" name="image" />
                    <small>Click on Image to change</small>
                </div>
            </div>
            <label class="col-sm-2 control-label text-right">Description</label>
            <div class="col-sm-6">
                <textarea id="summernote" class="form-control summernote" name="description" placeholder="Information..."></textarea>
            </div>
        </div>
                {!! Form::close() !!}
        <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>


<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
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

    jQuery(document).ready(function() {

        $('.summernote').summernote({
              dialogsInBody: true,
            height: 140, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
            toolbar: [
                ["style", ["style"]],
                ["font", ["bold", "underline", "clear"]],
                ["para", ["ul", "ol", "paragraph"]]
            ],
        });

    });

    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('product.store')}}',
            container: '#updateFile',
            type: "POST",
            data: $('#updateFile').serialize()
        })
    });
</script>
