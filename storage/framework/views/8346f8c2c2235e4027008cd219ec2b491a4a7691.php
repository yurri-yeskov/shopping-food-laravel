<?php $__env->startPush('header-script'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="title d-flex align-items-center py-3">
    <h5 class="m-0">Categories</h5>
</div>
<div class="pick_today">
    <div class="row">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-2 mb-3 text-center">
            <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                <div class="list-card-image">
                    <a href="<?php echo e(route('front.category',$cat->id)); ?>" class="text-dark">
                        <div class="p-3">
                            <img src="<?php echo e($cat->categoryimage); ?>" class="img-fluid item-img w-100 mb-3 rounded">
                            <h6><?php echo e($cat->name); ?></h6>
                            
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php if(count($sliders) > 3): ?>
<div class="py-3 osahan-promos">
    <div class="promo-slider pb-0 mb-0">
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="osahan-slider-item mx-2">
            <a href="#"><img src="<?php echo e(asset('uploads/sliders/'.$slider->image)); ?>" class="img-fluid mx-auto rounded" alt="Responsive image"></a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>
<div class="col-lg-12">
    <div class="osahan-vegan">

        <div class="fresh-vegan pb-2">
            <div class="d-flex align-items-center mb-2">
                <h5 class="m-0">Featured Products <?php echo e($featured->count()); ?></h5>
                <a href="#" class="ml-auto text-success">See more</a>
            </div>
            <div class="trending-slider">
             <?php $__currentLoopData = $featured; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"></div>
                            <a href="<?php echo e(route('front.product',$f->id)); ?>" class="text-decoration-none text-dark">
                                <img src="<?php echo e($f->productimage); ?>" class="img">
                                <h5 class="text-success"><?php echo e($f->name); ?></h5>
                                <div class="d-flex align-items-center">
                                    <div class="btn-group osahan-radio btn-group-toggle" data-toggle="buttons">
                                        <?php $__currentLoopData = $f->activevariations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $var): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="btn btn-secondary active">
                                            <input type="radio" name="variation" id="<?php echo e($var->id); ?>"> <?php echo e($var->weight.' '.$var->unit->name.' $'.$var->price); ?>

                                        </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <a class="ml-auto" href="#">
                                        <form id='myform' class="cart-items-number d-flex" method='POST' action='#'>
                                            <input type='number' name='quantity' value='1' class='qty form-control' />
                                        </form>
                                    </a>
                                    <a href="#" class="btn btn-warning rounded  d-flex align-items-center justify-content-center"><i class="icofont-plus m-0 mr-2"></i></a>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="d-flex align-items-center mt-4 mb-2">
                <h5 class="m-0">Quick Grab</h5>
            </div>
            <div class="trending-slider">
                <?php $__currentLoopData = $quickgrab; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"><span class="badge badge-success">10%</span></div>
                            <a href="<?php echo e(route('front.product',$q->id)); ?>" class="text-decoration-none text-dark">
                                <img src="<?php echo e($q->productimage); ?>" class="img">
                                <h5 class="text-success"><?php echo e($q->name); ?></h5>
                                <h6 class="mb-1 font-weight-bold">$0.14 <del class="small">$0.22</del></h6>
                                <p class="text-gray mb-0 small"><?php echo $q->description; ?></p>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="d-flex align-items-center mt-4 mb-2">
                <h5 class="m-0">Offered Products</h5>
            </div>
            <div class="trending-slider">
                <?php $__currentLoopData = $offered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="osahan-slider-item m-2">
                    <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                        <div class="list-card-osahan-2 p-3">
                            <div class="member-plan position-absolute"><span class="badge badge-dark">10%</span></div>
                            <a href="<?php echo e(route('front.product',$o->id)); ?>" class="text-decoration-none text-dark">
                                <img src="<?php echo e($o->productimage); ?>" class="img">
                                <h5 class="text-success"><?php echo e($f->name); ?></h5>
                                <h6 class="mb-1 font-weight-bold">$0.14 <del class="small">$0.22</del></h6>
                                <p class="text-gray mb-0 small"><?php echo $o->description; ?></p>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footer-script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.grace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/front/index.blade.php ENDPATH**/ ?>