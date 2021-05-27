    <div class="modal-header">
        <h5 class="modal-title"><?php echo e($variation->product->name); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>
<?php echo Form::open(['id'=>'updateFile','class'=>'ajax-form','method'=>'PATCH']); ?>

    <div class="modal-body">
         <div class="card">
             <div class="card-body">
                 <div class="row">
                     <div class="form-group col-sm-6">
                         <label for="unit_id">Unit</label>
                         <select required name="unit_id" class="form-control">
                             <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($unit->id); ?>" <?php if($variation->unit_id ==$unit->id ): ?> selected <?php endif; ?> ><?php echo e($unit->name); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="weight">Amount</label>
                         <input type="number" min="0" class="form-control" required id="weight" name="weight" placeholder="Amount.." value="<?php echo e($variation->weight); ?>">
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="price">Price</label>
                         <input type="number" min="0" class="form-control" required id="price" name="price" placeholder="Price.." value="<?php echo e($variation->price); ?>">
                     </div>
                     <div class="form-group col-sm-6">
                         <label for="special_price">Special Price</label>
                         <input type="number" min="0" class="form-control" id="special_price" name="special_price" placeholder="Special Price.." value="<?php echo e($variation->special_price); ?>">
                     </div>
                 </div>
             </div>
         </div>    
</div>
    <div class="modal-footer">
        <button type="button" id="update-form" class="btn btn-success">Update changes</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    </div>
                <?php echo Form::close(); ?>

<script>
    $('#update-form').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('updatevariation', $variation->id)); ?>',
            container: '#updateFile',
            type: "POST",
            data: $('#updateFile').serialize(),
            success: function (response) {
                $('#editContactModal').modal('hide');
                    location.reload();
            }
        })
    });
</script><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/product/editvariation.blade.php ENDPATH**/ ?>