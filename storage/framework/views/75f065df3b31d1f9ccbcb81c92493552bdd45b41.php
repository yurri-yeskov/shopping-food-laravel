<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-6">
            <div class="page-header-title">
                <div class="d-inline">
                    <h5><input type="checkbox" class="js-switch change-category-status" data-category-id="<?php echo e($category->id); ?>" <?php echo e(($category->status=='AC')?'checked':''); ?> /> <?php echo e($category->name); ?></h5>
                </div>
            </div>
        </div>
        
            <div class="col-lg-6">
<a href="<?php echo e(route('category.edit',$category->id)); ?>" class="float-right var-modal"> <button type="button" class="btn btn-success">Edit</button></a>            </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card  make-me-sticky">
                <ul class="list-group list-group-flush">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center <?php if($cat->id == $category->id): ?> active <?php endif; ?>"><a href="<?php echo e(route('category.show',$cat->id)); ?>"><?php echo e($cat->name); ?></a><span class="badge badge-danger badge-pill"><?php echo e($cat->products->count()); ?></span></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card">
                <table class="table" id="leo">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Variations</th>
                            <th>Featured</th>
                            <th>Quick Grab</th>
                            <th>Offered</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                            <td><input type="checkbox" class="js-switch change-product-featured-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->is_featured=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-quick-grab-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->is_quick_grab=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-offered-status" data-product-id="<?php echo e($product->id); ?>"  <?php echo e(($product->is_offered=='1')?'checked':''); ?> /></td>
                            <td><input type="checkbox" class="js-switch change-product-status" data-product-id="<?php echo e($product->id); ?>" <?php echo e(($product->status=='AC')?'checked':''); ?> /></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
        </div>
        </div>
    </div>
<div class="modal fade text-center" id="theModal">
  <div class="modal-dialog">
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
    
$('.change-category-status').change(function () {
        var id = $(this).data('category-id');

        if($(this).is(':checked'))
            var moduleStatus = 'AC';
        else
            var moduleStatus = 'IN';

        var url = '<?php echo e(route('changeCategoryStatus', ':id')); ?>';
        url = url.replace(':id', id);
        $.easyAjax({
            url: url,
            type: "POST",
            data: { 'id': id, 'status': moduleStatus, '_method': 'POST', '_token': '<?php echo e(csrf_token()); ?>' }
        })
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
   

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.leo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/category/show.blade.php ENDPATH**/ ?>