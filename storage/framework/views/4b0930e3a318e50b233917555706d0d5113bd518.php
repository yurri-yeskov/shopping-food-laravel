<?php $__env->startPush('head-script'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-10">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Products ( <?php echo e($totalproducts); ?> )</h5>
                    <span>You have got <?php echo e(Count($products)); ?> products on this page</span>
                </div>
            </div>
        </div>
            <div class="col-lg-2">
                <a href="<?php echo e(route('product.create')); ?>" class="float-right var-modal"> <button type="button" class="btn btn-success">New Product</button></a>
            </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-lg-12 text-center bg-white p-2 border-top  make-me-sticky"><?php $__currentLoopData = range('A','Z'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $initial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(url('admin/product?initial='.$initial)); ?>" class="badge badge-<?php echo e(app('request')->input('initial')== $initial ? 'danger' : 'info'); ?>" style="font-weight:900;"><?php echo e($initial); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

        <div class="card">
                <table class="table" id="leo">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Variations</th>
                            <th>Category</th>
                            <th>Favorited</th>
                            <th>Featured</th>
                            <th>Quick Grab</th>
                            <th>Offered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo e(route('product.show',$product->id)); ?>" class="toolTip " data-toggle="tooltip" data-placement="bottom" title="Show Product"><i class="ik ik-eye"></i></a>
                                    <a href="<?php echo e(route('product.edit',$product->id)); ?>" class="toolTip var-modal" data-toggle="tooltip" data-placement="bottom" title="Edit Product"><i class="ik ik-edit"></i></a>
                                    <a href="#" class="toolTip delete" data-toggle="tooltip" data-placement="bottom" title="Delete" data-var-id="<?php echo e($product->id); ?>"><i class="ik ik-trash-2"></i></a>

                                </div>
                            </td>
                            <td>
                            <img src="<?php echo e($product->productImage); ?>" class="table-user-thumb">                                
                            </td>
                            <td><a href="<?php echo e(route('product.show',$product->id)); ?>"> <?php echo ucfirst(str_limit($product->name, 20)); ?></a></td>
                            <td> <span class="badge badge-<?php echo e(Count($product->variations) == '0' ? 'danger' : 'success'); ?>"><?php echo e(Count($product->variations)); ?></span></td>
                            <td><a href="<?php echo e(route('category.show',$product->category->id)); ?>"> <?php echo e(ucfirst($product->category->name)); ?></a></td>
                            <td><span class="badge bg-yellow text-white"> <?php echo e($product->users->count()); ?> </span></td>
                            <td><input type="checkbox" class="js-switch change-product-featured-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->is_featured=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-quick-grab-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->is_quick_grab=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-offered-status" data-product-id="<?php echo e($product->id); ?>"  <?php echo e(($product->is_offered=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-product-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->status=='AC')?'checked':''); ?> /></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
        </div>
            <?php echo e($products->links()); ?>

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
<script type="text/javascript">
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

        $(function() {
            $('body').on('click', '.delete', function(){
                var id = $(this).data('var-id');
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover the deleted product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                }, function(isConfirm){
                    if (isConfirm) {
                        var url   = "<?php echo e(route('product.destroy',':id')); ?>";
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
    
    $('.change-product-featured-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '<?php echo e(route('changeProductFeaturedStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
    });
    $('.change-quick-grab-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '<?php echo e(route('changeQuickGrabStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
    });
    $('.change-offered-status').change(function () {
        var id = $(this).data('product-id');

        if($(this).is(':checked'))
            var moduleStatus = '1';
        else
            var moduleStatus = '0';

        var url = '<?php echo e(route('changeOfferedStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
    });
    
    $('.var-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });


</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.leo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/product/index.blade.php ENDPATH**/ ?>