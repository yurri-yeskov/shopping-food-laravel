 <div class="osahan-account bg-white rounded shadow-sm overflow-hidden">
     <div class="p-4 profile text-center border-bottom">
         <img src="img/user.png" class="img-fluid rounded-pill">
         <h6 class="font-weight-bold m-0 mt-2"><?php echo e(auth()->user()->name); ?></h6>
     </div>
     <div class="account-sections">
         <ul class="list-group">
             <a href="<?php echo e(route('my.account')); ?>" class="text-decoration-none text-dark">
                 <li class="border-bottom bg-white d-flex align-items-center p-3">
                     <i class="icofont-user osahan-icofont bg-danger"></i>My Account
                     <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
                 </li>
             </a>
             <a href="<?php echo e(route('my.favorites')); ?>" class="text-decoration-none text-dark">
                 <li class="border-bottom bg-white d-flex align-items-center p-3">
                     <i class="icofont-address-book osahan-icofont bg-dark"></i>My Favorites
                     <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
                 </li>
             </a>
                          <a href="<?php echo e(route('my.orders')); ?>" class="text-decoration-none text-dark">
                 <li class="border-bottom bg-white d-flex align-items-center p-3">
                     <i class="icofont-address-book osahan-icofont bg-success"></i>My Orders
                     <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
                 </li>
             </a>

             <a href="<?php echo e(route('my.addresses')); ?>" class="text-decoration-none text-dark">
                 <li class="border-bottom bg-white d-flex align-items-center p-3">
                     <i class="icofont-address-book osahan-icofont bg-info"></i>My Addresses
                     <span class="badge badge-success p-1 badge-pill ml-auto"><i class="icofont-simple-right"></i></span>
                 </li>
             </a>
             <a href="#" class="text-decoration-none text-dark" onclick="event.preventDefault(); document.getElementById('logout-form2').submit();">
                 <li class="border-bottom bg-white d-flex  align-items-center p-3">
                     <i class="icofont-lock osahan-icofont bg-warning"></i> Logout
                 </li>
             </a>
             <form id="logout-form2" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                 <?php echo e(csrf_field()); ?>

             </form>

         </ul>
     </div>
 </div><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/front/my/_sidemenu.blade.php ENDPATH**/ ?>