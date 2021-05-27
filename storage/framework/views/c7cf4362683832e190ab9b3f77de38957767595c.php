<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <form role="search" class="input-filter navbar-form-custom" style="width:250px;" method="post" action="#">
                    <input type="text" class="form-control" placeholder="Start typing to search.." name="search">
                </form>
                
            </div>
            <div class="top-menu d-flex align-items-center"> <span>Welcome <?php echo e(Auth::user()->name); ?> </span>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="avatar" src="<?php echo e(asset('images/logo.png')); ?>" alt=""></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo e(route('changePassword')); ?>"><i class="fa fa-lock  dropdown-icon"></i> Change Password</a>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();"><i class="fa fa-power-off  dropdown-icon"></i> Logout</a>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                            <?php echo e(csrf_field()); ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/sections/header.blade.php ENDPATH**/ ?>