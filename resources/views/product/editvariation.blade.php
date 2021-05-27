    <div class="modal-header">
        <h5 class="modal-title">{{$variation->product->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
{!! Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'PATCH']) !!}
    <div class="modal-body">
         <div class="card">
             <div class="card-body">
                 <div class="row">
                     <div class="form-group col-sm-6">
                         <label for="unit_id">Unit</label>
                         <select required name="unit_id" class="form-control">
                             @foreach ($units as $unit)
                             <option value="{{$unit->id}}" @if($variation->unit_id ==$unit->id ) selected @endif >{{$unit->name}}</option>
                             @endforeach
                         </select>
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="weight">Amount</label>
                         <input type="number" min="0" class="form-control" required id="weight" name="weight" placeholder="Amount.." value="{{$variation->weight}}">
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="price">Price</label>
                         <input type="number" min="0" class="form-control" required id="price" name="price" placeholder="Price.." value="{{$variation->price}}">
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="special_price">Special Price</label>
                         <input type="number" min="0" class="form-control" id="special_price" name="special_price" placeholder="Special Price.." value="{{$variation->special_price}}">
                     </div>
                 </div>
             </div>
         </div>    
</div>
    <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Update changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
                {!! Form::close() !!}
<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '{{route('updatevariation', $variation->id)}}',
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