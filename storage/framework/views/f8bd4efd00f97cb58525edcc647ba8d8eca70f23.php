<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Local Fine Foods</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/ionicons/dist/css/ionicons.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/icon-kit/dist/css/iconkit.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/toastr/toastr.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/sweetalert/sweetalert.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('dist/css/theme.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('plugins/mohithg-switchery/dist/switchery.min.css')); ?>">
        <script src="<?php echo e(asset('src/js/vendor/modernizr-2.8.3.min.js')); ?>"></script>
<?php echo $__env->yieldPushContent('head-script'); ?>
</head>
    
<body class="hold-transition sidebar-mini text-sm layout-fixed">
    <div class="wrapper">
  <?php echo $__env->make('sections.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="page-wrap">
  <?php echo $__env->make('sections.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="main-content">
                    <div class="container-fluid">

    <?php echo $__env->yieldContent('content'); ?>
                </div>
                </div>
  <?php echo $__env->make('sections.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script>window.jQuery || document.write('<script src="src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="<?php echo e(asset('plugins/popper.js/dist/umd/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/toastr/toastr.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/sweetalert/sweetalert.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/moment/moment.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('plugins/mohithg-switchery/dist/switchery.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('dist/js/search.js')); ?>"></script>
        <script type="text/javascript"><!--
            var url_search = '<?php echo e(url("admin/quicksearch")); ?>';
        </script>
        <script src="<?php echo e(asset('dist/js/theme.js')); ?>"></script>
        <script src="<?php echo e(asset('dist/js/helper.js')); ?>" defer></script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/daghan/www/localfinefoods/resources/views/layouts/leo.blade.php ENDPATH**/ ?>