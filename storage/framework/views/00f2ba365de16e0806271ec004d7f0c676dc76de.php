<?php $__env->startSection('content'); ?>
<div id="leo">
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-12">
            <div class="page-header-title">
                <i class="ik ik-box bg-blue"></i>
                <div class="d-inline">
                    <h5>Product Categories ( <?php echo e(count($categories)); ?> )</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="row layout-wrap" id="layout-wrap">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3">
        <div class="card">
            <a href="<?php echo e(route('category.show',$cat->id)); ?>">
            <div class="card-body text-center">
                <div class="profile-pic mb-20">
                    <img src="<?php echo e($cat->categoryImage); ?>" width="120" class="img-thumbnail rounded">
                    <h6 class="mt-10 mb-0"><?php echo e($cat->name); ?></h6>
                </div>
                <div class="badge badge-pill badge-info" style="font-weight:900"><?php echo e($cat->products_count); ?></div>
            </div>
            </a>
            <div class="p-4 border-top">
                <div class="row text-center">
                    <div class="col-4 border-right">
                        <a href="<?php echo e(route('category.edit',$cat->id)); ?>" class="var-modal link d-flex align-items-center justify-content-center"><i class="ik ik-edit f-20 mr-5"></i>Edit</a>
                    </div>
                    <div class="col-4 border-right">
                        <a href="#" class="link d-flex align-items-center justify-content-center"><i class="ik ik-trash f-20 mr-5"></i>Delete</a>
                    </div>
                    <div class="col-4">
                        <input type="checkbox" class="js-switch change-category-status" data-category-id="<?php echo e($cat->id); ?>" <?php echo e(($cat->status=='AC')?'checked':''); ?> />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-3">
        <a href="<?php echo e(route('category.create')); ?>" class="var-modal">
            <div class="widget social-widget">
                <div class="widget-body">
                    <div class="icon"><i class="ik ik-plus-circle text-success"></i></div>
                    <div class="content">
                        <h5 class="mt-10 mb-0">Add New Category</h5>
                    </div>
                </div>
            </div>
        </a>
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

$(document).on('click', '.delete', function() {
    var con =confirm('Are you sure to delete!!');
    var id = $(this).data('cat-id');
    if(con) {
                        var url = "<?php echo e(route('category.destroy',':id')); ?>";
                        url = url.replace(':id', id);
                        var token = "<?php echo e(csrf_token()); ?>";
                        $.easyAjax({
                            type: 'POST',
                            url: url,
                            data: {'_token': token, '_method': 'DELETE'},
                            success: function (response) {
                                if (response.status == "success") {
                                    $( "#leo" ).load(window.location.href + " #leo" );
                                }
                            }
                        });
        
    }
            return false;
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

    $('.var-modal').on('click', function(e){
      e.preventDefault();
      $('#theModal').modal('show').find('.modal-content').load($(this).attr('href'));
    });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.leo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/category/index.blade.php ENDPATH**/ ?>