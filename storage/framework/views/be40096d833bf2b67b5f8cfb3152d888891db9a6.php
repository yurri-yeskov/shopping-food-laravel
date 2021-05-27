<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="<?php echo e(asset('front/front/img/logo.svg')); ?>">
    <title>Local Fine Foods - Diamond Creek</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('front/vendor/slick/slick.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('front/vendor/slick/slick-theme.min.css')); ?>" />
    <link href="<?php echo e(asset('front/vendor/icons/icofont.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('front/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('front/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('front/vendor/sidebar/demo.css')); ?>" rel="stylesheet">
    <?php echo $__env->yieldPushContent('header-script'); ?>
</head>
   

<body class="fixed-bottom-padding">
<?php echo $__env->make('layouts.grace._mobileheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.grace._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="theme-switch-wrapper">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider round"></div>
            <i class="icofont-moon"></i>
        </label>
        <em>Enable Dark Mode!</em>
    </div>


    

    <nav aria-label="breadcrumb" class="breadcrumb mb-0 d-none">
        <div class="container">
            <ol class="d-flex align-items-center mb-0 p-0">
                <li class="breadcrumb-item"><a href="#" class="text-success">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"></li>
            </ol>
        </div>
    </nav>
    <section class="py-4 osahan-main-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="osahan-home-page">

                        <div class="osahan-body">
 <?php echo $__env->yieldContent('content'); ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<?php echo $__env->make('layouts.grace._mobilemenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.grace._modal-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.grace._modal-filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="modal fade right-modal" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <nav class="schedule w-100">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active col-5 py-4" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                <p class="mb-0 font-weight-bold">Sign in</p>
                            </a>
                            <a class="nav-link col-5 py-4" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <p class="mb-0 font-weight-bold">Sign up</p>
                            </a>
                            <a class="nav-link col-2 p-0 d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
                                <h1 class="m-0 h4 text-dark"><i class="icofont-close-line"></i></h1>
                            </a>
                        </div>
                    </nav>
                </div>
                <div class="modal-body p-0">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="osahan-signin p-4 rounded">
                                <div class="p-2">
                                    <h2 class="my-0">Welcome Back</h2>
                                    <p class="small mb-4">Sign in to Continue.</p>
                                    <form action="verification.html">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input placeholder="Enter Email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input placeholder="Enter Password" type="password" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <button type="submit" class="btn btn-success btn-lg rounded btn-block">Sign in</button>
                                    </form>
                                    <p class="text-muted text-center small m-0 py-3">or</p>
                                    <a href="verification.html" class="btn btn-dark btn-block rounded btn-lg btn-apple">
                                        <i class="icofont-brand-apple mr-2"></i> Sign up with Apple
                                    </a>
                                    <a href="verification.html" class="btn btn-light border btn-block rounded btn-lg btn-google">
                                        <i class="icofont-google-plus text-danger mr-2"></i> Sign up with Google
                                    </a>
                                    <p class="text-center mt-3 mb-0"><a href="signup.html" class="text-dark">Don't have an account? Sign up</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="osahan-signup bg-white p-4">
                                <div class="p-2">
                                    <h2 class="my-0">Let's get started</h2>
                                    <p class="small mb-4">Create account to see our top picks for you!</p>
                                    <form action="verification.html">
                                        <div class="form-group">
                                            <label for="exampleInputName1">Name</label>
                                            <input placeholder="Enter Name" type="text" class="form-control" id="exampleInputName1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputNumber1">Phone Number</label>
                                            <input placeholder="Enter Phone Number" type="number" class="form-control" id="exampleInputNumber1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input placeholder="Enter Email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input placeholder="Enter Password" type="password" class="form-control" id="exampleInputPassword1">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword2">Confirmation Password</label>
                                            <input placeholder="Enter Confirmation Password" type="password" class="form-control" id="exampleInputPassword2">
                                        </div>
                                        <button type="submit" class="btn btn-success rounded btn-lg btn-block">Create Account</button>
                                    </form>
                                    <p class="text-muted text-center small py-2 m-0">or</p>
                                    <a href="verification.html" class="btn btn-dark btn-block rounded btn-lg btn-apple">
                                        <i class="icofont-brand-apple mr-2"></i> Sign up with Apple
                                    </a>
                                    <a href="verification.html" class="btn btn-light border btn-block rounded btn-lg btn-google">
                                        <i class="icofont-google-plus text-danger mr-2"></i> Sign up with Google
                                    </a>
                                    <p class="text-center mt-3 mb-0"><a href="signin.html" class="text-dark">Already have an account! Sign in</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-0 border-0">
                    <div class="col-6 m-0 p-0">
                        <a href="#" class="btn border-top border-right btn-lg btn-block" data-dismiss="modal">Close</a>
                    </div>
                    <div class="col-6 m-0 p-0">
                        <a href="help_support.html" class="btn border-top btn-lg btn-block">Help</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('layouts.grace._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?php echo e(asset('front/vendor/jquery/jquery.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('front/vendor/slick/slick.min.js')); ?>" type="text/javascript" ></script>
    <script src="<?php echo e(asset('front/vendor/sidebar/hc-offcanvas-nav.js')); ?>" type="text/javascript" ></script>
    <script src="<?php echo e(asset('front/js/osahan.js')); ?>" type="text/javascript"></script>
    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="|49" defer=""></script>
<?php echo $__env->yieldPushContent('footer-scripts'); ?>

</body>

</html><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/layouts/grace.blade.php ENDPATH**/ ?>