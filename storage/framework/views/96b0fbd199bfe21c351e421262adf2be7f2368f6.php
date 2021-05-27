<?php $__env->startPush('header-script'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="col-lg-8 mx-auto p-4 bg-white rounded shadow-sm">
    <h4 class="mb-4 profile-title">Frequently Asked Questions</h4>
    <div id="basics">

        <div id="basicsAccordion">

            <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="box border rounded mb-1 bg-white">
                <div id="basicsHeading<?php echo e($faq->id); ?>">
                    <h5 class="mb-0">
                        <button class="shadow-none btn btn-block d-flex align-items-center justify-content-between card-btn p-3 collapsed" data-toggle="collapse" data-target="#basicsCollapse<?php echo e($faq->id); ?>" aria-expanded="false" aria-controls="basicsCollapse<?php echo e($faq->id); ?>">
                            <strong><?php echo e($faq->question); ?></strong> <i class="icofont-simple-down"></i>
                        </button>
                    </h5>
                </div>
                <div id="basicsCollapse<?php echo e($faq->id); ?>" class="collapse" aria-labelledby="basicsHeading<?php echo e($faq->id); ?>" data-parent="#basicsAccordion" style="">
                    <div class="card-body border-top p-3 text-muted">
                       <?php echo $faq->answer; ?>

                    </div>
                </div>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footer-script'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.grace', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/front/faq.blade.php ENDPATH**/ ?>