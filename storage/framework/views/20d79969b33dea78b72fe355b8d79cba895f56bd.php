<?php $__env->startPush('head-script'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h5><input type="checkbox" class="js-switch change-product-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->status=='AC')?'checked':''); ?> /> <?php echo e($product->name); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <a href="<?php echo e(route('product.edit',$product->id)); ?>" class="float-right var-modal"> <button type="button" class="btn btn-success">Edit</button></a>
            </div>
        </div>
    </div>
    <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="row">
        <div class="col-lg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="<?php echo e($product->productImage); ?>" class="img-thumbnail" width="150"> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    <p><?php echo $product->description; ?></p>
                </div>
            </div>            
        </div>
    </div>
<h5 class="mt-30">Variations</h5>
            <div class="row clearfix" >
                <?php $__currentLoopData = $product->variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12">
                    <div class="widget">
                        <div class="widget-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="state col-sm-1">
                                    <h6><input type="checkbox" class="js-switch change-variation-status" data-var-id="<?php echo e($var->id); ?>" <?php echo e(($var->status=='AC')?'checked':''); ?> /></h6>
                                </div>
                                <div class="state col-sm-3">
                                    <h6><?php echo e($var->weight); ?> <?php echo e($var->unit->name); ?> ( <?php echo e($var->unit->code); ?> )</h6>
                                    <h2>$ <?php echo e($var->price); ?></h2>
                                </div>
                                <div class="icon col-sm-3">
                                    <?php if($var->special_price): ?>
                                    <i class="ik ik-arrow-down text-danger"></i>$ <?php echo e($var->special_price); ?>

                                    <?php else: ?>
                                    <i class="ik ik-more-vertical text-success"></i>$ <?php echo e($var->price); ?>

                                    <?php endif; ?>
                                </div>
                                <div class="state col-sm-4">
                                    <h6><?php echo e($var->created_at); ?></h6>
                                </div>
                                <div class="state col-sm-1">
                                    <h6>
                                        <a href="<?php echo e(route('editvariation',$var->id)); ?>" class="toolTip small-modal" data-toggle="tooltip" data-placement="bottom" title="Edit" ><i class="ik ik-edit"></i></a>
                                        <a href="#" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete" data-var-id="<?php echo e($var->id); ?>"><i class="ik ik-trash-2"></i></a></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php echo Form::open(['id'=>'addNewVariation','class'=>'ajax-form','method'=>'POST']); ?>

         <input type="hidden" id="product_id" name="product_id" value="<?php echo e($product->id); ?>">
         <div class="card">
             <div class="card-body">
                 <div class="row">
                     <div class="form-group col-sm-2">
                         <label for="unit_id">Unit</label>
                         <select  name="unit_id" class="form-control">
                             <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name); ?></option>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                     </div>
                     <div class="form-group col-sm-2">
                         <label for="weight">Amount</label>
                         <input type="number" min="0" class="form-control"  id="weight" name="weight" placeholder="Amount..">
                     </div>
                     <div class="form-group col-sm-2">
                         <label for="price">Price</label>
                         <input type="number" min="0" class="form-control"  id="price" name="price" placeholder="Price..">
                     </div>
                     <div class="form-group col-sm-2">
                         <label for="special_price">Special Price</label>
                         <input type="number" min="0" class="form-control" id="special_price" name="special_price" placeholder="Special Price..">
                     </div>
                     <div class="form-group col-sm-2">
                         <label for="button">&nbsp;&nbsp;</label>
                         <button type="submit" class="btn btn-primary" id="new-variation"> <i class="fa fa-plus"></i>Add New Price</button>
                     </div>
                 </div>
             </div>
         </div>
        <?php echo Form::close(); ?> 
<div class="modal fade text-center" id="smallModal">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade text-center" id="theModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
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
    
    $('.change-product-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '<?php echo e(route('changeProductStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
    });
    
    $('.change-variation-status').change(function () {
        var id = $(this).data('var-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '<?php echo e(route('changeVariationStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
    });
    
    $('#addNewVariation').on('submit', function(e) {
        return false;
    })
        $('#new-variation').click(function () {
        $.easyAjax({
            url: '<?php echo e(route('addnewvariation')); ?>',
            container: '#addNewVariation',
            type: "POST",
            data: $('#addNewVariation').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
        }
            }
        })
    });
    
        $(function() {
            $('body').on('click', '.delete', function(){
                var id = $(this).data('var-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted price variation!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "<?php echo e(route('deleteproductvariation',':id')); ?>";
                        url       = url.replace(':id', id);
                        var token = "<?php echo e(csrf_token()); ?>";
                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                        window.location.reload();
                                }
                            }
                        });

                    }
                });
            });
        });
    $('.var-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
    $('.small-modal').on('click', function(e){
      e.preventDefault();
      $('#smallModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.leo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/product/show.blade.php ENDPATH**/ ?>