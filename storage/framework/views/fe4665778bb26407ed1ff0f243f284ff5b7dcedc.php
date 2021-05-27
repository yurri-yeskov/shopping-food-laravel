<?php $__env->startPush('header-script'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="breadcrumb mb-0">
    <div class="container">
        <ol class="d-flex align-items-center mb-0 p-0">
            <li class="breadcrumb-item"><a href="<?php echo e(url('')); ?>" class="text-success">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Favorites</li>
        </ol>
    </div>
</nav>
<section class="py-4 osahan-main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                   <?php echo $__env->make('front.my._sidemenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-8 p-4 bg-white rounded shadow-sm">
                    
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footer-script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.grace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/front/my/favorites.blade.php ENDPATH**/ ?>