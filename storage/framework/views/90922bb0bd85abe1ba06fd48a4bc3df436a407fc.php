<div class="app-sidebar colored">
                    <div class="sidebar-header">
                        <a class="header-brand" href="<?php echo e(url('/admin')); ?>">
                            <span class="text">Local Fine Foods</span>
                        </a>
                        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
                        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
                    </div>
                    
                    <div class="sidebar-content">
                        <div class="nav-container">
                            <nav id="main-menu-navigation" class="navigation-main">
                                <div class="nav-item">
                                    <a href="<?php echo e(route('dashboard')); ?>"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo e(route('orders.index')); ?>"><i class="ik ik-shopping-cart"></i><span>Orders</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo e(route('product.index')); ?>"><i class="ik ik-shopping-bag"></i><span>Products</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo e(route('category.index')); ?>"><i class="ik ik-grid"></i><span>Categories</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo e(route('users')); ?>"><i class="ik ik-users"></i><span>Users</span></a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?php echo e(route('notifications')); ?>"><i class="ik ik-message-circle"></i><span>Notifications</span></a>
                                </div>
                                
                                <div class="nav-item">
                                        <a href="<?php echo e(route('setting')); ?>"><i class="ik ik-codepen"></i><span>Setting</span></a>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div><?php /**PATH /Users/daghan/www/localfinefoods/resources/views/sections/menu.blade.php ENDPATH**/ ?>