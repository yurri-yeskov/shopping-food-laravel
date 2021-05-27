<?php if(Session::has('success')): ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check"></i>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Success! </strong> <?php echo e(Session::get("success")); ?>

            </div>
        </div>
    </div>

<?php elseif(Session::has('error')): ?>
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i>
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <strong>Alert ! </strong> <?php echo e(Session::get("error")); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /Users/daghan/www/localfinefoods/resources/views/layouts/message.blade.php ENDPATH**/ ?>