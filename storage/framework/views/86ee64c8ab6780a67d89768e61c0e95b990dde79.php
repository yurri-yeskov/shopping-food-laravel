<?php $__env->startPush('header-script'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<nav aria-label="breadcrumb" class="breadcrumb mb-0">
        <div class="container">
            <ol class="d-flex align-items-center mb-0 p-0">
                <li class="breadcrumb-item"><a href="<?php echo e(url('')); ?>" class="text-success">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($category->name); ?></li>
            </ol>
        </div>
    </nav>
<section class="py-4 osahan-main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="osahan-listing">
                        <div class="d-flex align-items-center mb-3">
                            <h4><?php echo e($category->name); ?> <small><?php echo e($category->activeproducts->count()); ?> Products</small></h4>
                            <div class="m-0 text-center ml-auto">
                                <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn text-muted bg-white mr-2"><i class="icofont-filter mr-1"></i> Filter</a>
                                <a href="#" data-toggle="modal" data-target="#exampleModal" class="btn text-muted bg-white"><i class="icofont-signal mr-1"></i> Sort</a>
                            </div>
                        </div>
                        <div class="row">
                            <?php $__currentLoopData = $category->activeproducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-md-3 mb-3">
                                <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                                    <div class="list-card-image">
                                        <a href="<?php echo e(route('front.product',$product->id)); ?>" class="text-dark">
                                            <div class="member-plan position-absolute"><span class="badge m-3 badge-danger">10%</span></div>
                                            <div class="p-3">
                                                <img src="<?php echo e($product->productimage); ?>" class="img-fluid item-img w-100 mb-3 rounded">
                                                <h6><?php echo e($product->name); ?></h6>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="price m-0 text-success">$0.8/kg</h6>
                                                    <a data-toggle="collapse" href="#product<?php echo e($product->id); ?>" role="button" aria-expanded="false" aria-controls="product<?php echo e($product->id); ?>" class="btn btn-success btn-sm ml-auto">+</a>
                                                    <div class="collapse qty_show" id="product<?php echo e($product->id); ?>">
                                                        <div>
                                                            <span class="ml-auto" href="#">
                                                                <form id='myform' class="cart-items-number d-flex" method='POST' action='#'>
                                                                    <input type='button' value='-' class='qtyminus btn btn-success btn-sm' field='quantity' />
                                                                    <input type='text' name='quantity' value='1' class='qty form-control' />
                                                                    <input type='button' value='+' class='qtyplus btn btn-success btn-sm' field='quantity' />
                                                                </form>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footer-script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.grace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/front/category.blade.php ENDPATH**/ ?>