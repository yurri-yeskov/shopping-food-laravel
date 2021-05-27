<?php
use Illuminate\Support\Facades\Route;

Auth::routes([
  'register' => true,
  'reset' => true,
  'verify' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', 'Front\HomeController@showCart')->name('front.cart');
    Route::get('/my/addresses', 'Front\MyController@Addresses')->name('my.addresses');
    Route::get('/my/orders', 'Front\MyController@Orders')->name('my.orders');
    Route::get('/my/favorites', 'Front\MyController@Favorites')->name('my.favorites');
    Route::get('/my/account', 'Front\MyController@Account')->name('my.account');

});
Route::get('/product/{id}', 'Front\HomeController@showProduct')->name('front.product');
Route::get('/products', 'Front\HomeController@showProducts')->name('front.products');
Route::get('/faq', 'Front\HomeController@showFaq')->name('front.faq');
Route::get('/category/{id}', 'Front\HomeController@showCategory')->name('front.category');
Route::get('/', 'Front\HomeController@index')->name('home');
Route::get('/home', 'WebsiteController@index')->name('home');
Route::get('/testfirebase', 'OrderController@testfirebase')->name('testfirebase');

Route::get('/payment', ['uses' => 'TransactionsController@payment'])->name('payment');
Route::post('/ccavRequestHandler', ['uses' => 'TransactionsController@ccavRequestHandler'])->name('ccavRequestHandler');
Route::post('/ccavResponseHandler', ['uses' => 'TransactionsController@ccavResponseHandler'])->name('ccavResponseHandler');

    Route::get('/forgot-password', ['uses' => 'LoginController@sendPasswordMail'])->name('forgotGet');
    Route::post('/forgot-password', ['uses' => 'LoginController@sendPasswordMail'])->name('forgotPost');
    Route::get('/reset-password', ['uses' => 'LoginController@resetPassword'])->name('resetGet');
    Route::post('/reset-password', ['uses' => 'LoginController@resetPassword'])->name('resetPost');



Route::group(['prefix' => 'admin','middleware' => ['auth','admin']], function () {

        Route::get('/', ['uses' => 'DashboardController@index']);
        Route::get('/dashboard', ['uses' => 'DashboardController@index'])->name('dashboard');
        Route::any('/change-password', ['uses' => 'UserController@changePassword'])->name('changePassword');
        Route::any('/update-password', ['uses' => 'UserController@updatePassword'])->name('resetPassword');

        //Product category Module
        Route::get('/category', ['uses' => 'CategoryController@index'])->name('category');
        Route::get('/suburbs', ['uses' => 'StateCityController@suburbs'])->name('suburbs');

        //Location  Module
        Route::get('/apartments', ['uses' => 'LocationController@index'])->name('locations');
        Route::any('/apartment/addnew', ['uses' => 'LocationController@create'])->name('createLocation');
        Route::any('/area/addnew', ['uses' => 'LocationController@create'])->name('createArea');
        Route::get('/apartment/{id?}', ['uses' => 'LocationController@show'])->name('viewLocation');
        Route::get('/area/{id?}', ['uses' => 'LocationController@show'])->name('viewArea');
        Route::any('/apartment/edit/{id?}', ['uses' => 'LocationController@show'])->name('editLocation');
        Route::any('/area/edit/{id?}', ['uses' => 'LocationController@show'])->name('editArea');
        Route::any('apartment/destroy/{id?}', ['uses' => 'LocationController@destroy']);
        Route::any('area/destroy/{id?}', ['uses' => 'LocationController@destroy']);
        Route::any('apartment/destroy/{id?}', ['uses' => 'LocationController@destroy']);
        Route::get('/areas', ['uses' => 'LocationController@index'])->name('areas');

        //Product Module
        
        
        //Status Changes

        Route::post('changeSuburbStatus/{status?}', ['uses' => 'StateCityController@changeSuburbStatus'])->name('changeSuburbStatus');
        Route::post('changeFaqStatus/{status?}', ['uses' => 'FaqController@changeFaqStatus'])->name('changeFaqStatus');
        Route::post('changeUnitStatus/{status?}', ['uses' => 'UnitController@changeUnitStatus'])->name('changeUnitStatus');
        Route::post('changeVariationStatus/{status?}', ['uses' => 'ProductController@changeVariationStatus'])->name('changeVariationStatus');
        Route::post('changeProductStatus/{status?}', ['uses' => 'ProductController@changeProductStatus'])->name('changeProductStatus');
        Route::post('changeProductFeaturedStatus/{status?}', ['uses' => 'ProductController@changeProductFeaturedStatus'])->name('changeProductFeaturedStatus');
        Route::post('changeQuickGrabStatus/{status?}', ['uses' => 'ProductController@changeQuickGrabStatus'])->name('changeQuickGrabStatus');
        Route::post('changeOfferedStatus/{status?}', ['uses' => 'ProductController@changeOfferedStatus'])->name('changeOfferedStatus');
        Route::post('changeCouponStatus/{status?}', ['uses' => 'CouponController@changeCouponStatus'])->name('changeCouponStatus');
        Route::post('changeSliderStatus/{status?}', ['uses' => 'SliderController@changeSliderStatus'])->name('changeSliderStatus');
        Route::post('changeCategoryStatus/{status?}', ['uses' => 'CategoryController@changeCategoryStatus'])->name('changeCategoryStatus');

    
        //Product Brand Module
        Route::get('/brands', ['uses' => 'BrandController@index'])->name('brands');
        Route::any('/brand/addnew', ['uses' => 'BrandController@create'])->name('addnewBrand');
        Route::get('/brand/{id?}', ['uses' => 'BrandController@show'])->name('viewBrand');
        Route::any('/brand/edit/{id?}', ['uses' => 'BrandController@show'])->name('editBrand');
        Route::any('brand/destroy/{id?}', ['uses' => 'BrandController@destroy']);
        
    
        //Delivery Charges Module
        Route::get('/deliverycharges', ['uses' => 'DeliveryChargeController@index'])->name('deliverycharges');
        Route::any('/deliverycharge/addnew', ['uses' => 'DeliveryChargeController@create'])->name('addnewDeliveryCharge');
        Route::get('/deliverycharge/{id?}', ['uses' => 'DeliveryChargeController@show'])->name('viewDeliveryCharge');
        Route::any('/deliverycharge/edit/{id?}', ['uses' => 'DeliveryChargeController@show'])->name('editDeliveryCharge');


        Route::any('/coupons/addnew', ['uses' => 'CouponController@create'])->name('addCoupon');
        Route::any('/coupons/edit/{id?}', ['uses' => 'CouponController@show'])->name('editCoupon');
        Route::any('/coupons/destroy/{id?}', ['uses' => 'CouponController@destroy']);
        

        //Setting Module
        Route::any('/setting', ['uses' => 'SettingController@show'])->name('setting');

        //Users Module
        Route::get('/user/clear-notification', ['uses' => 'UserController@clear'])->name('clearNotifications');
        Route::get('/users', ['uses' => 'UserController@index'])->name('users');
        Route::get('/user/{id?}', ['uses' => 'UserController@show'])->name('viewUser');
        Route::get('/user/edit/{id?}', ['uses' => 'UserController@show'])->name('editUser');
        Route::post('/user/update/{id?}', ['uses' => 'UserController@updateStatus'])->name('updateUser');
        Route::post('/user/block', ['uses' => 'UserController@update'])->name('blockUser');

        //Notification Module
        Route::get('/notifications', ['uses' => 'NotificationController@index'])->name('notifications');
        Route::get('/notification/add', ['uses' => 'NotificationController@create'])->name('createNotification');
        Route::post('/notification/single', ['uses' => 'NotificationController@create'])->name('singleNotification');
        Route::get('/notification/store', ['uses' => 'NotificationController@store'])->name('storeNotification');

        //Drivers Module
        Route::get('/drivers', ['uses' => 'UserController@index'])->name('drivers');
        Route::any('/driver/addnew', ['uses' => 'UserController@createDriver'])->name('addnewDriver');
        Route::get('/driver/{id?}', ['uses' => 'UserController@show'])->name('viewDriver');
        Route::get('/driver/edit/{id?}', ['uses' => 'UserController@show'])->name('editDriver');
        Route::post('/driver/update/{id?}', ['uses' => 'UserController@updateStatus'])->name('updateDriver');
        Route::post('/driver/block', ['uses' => 'UserController@update'])->name('blockDriver');
        Route::post('/driver/addDoc/{id?}', ['uses' => 'UserController@addDoc'])->name('addDoc');
        Route::post('/otherDocs/delete/{id?}', ['uses' => 'UserController@deleteDoc'])->name('deleteDoc');
        
        //Route::any('driver/change-password', ['uses' => 'UserController@changeDriverPassword'])->name('changeDriverPassword');
        Route::any('driver/update-password/{id?}', ['uses' => 'UserController@updateDriverPassword'])->name('resetDriverPassword');

        //Store state and city session throughout the admin panel
        Route::post('/getCity', ['uses' => 'StateCityController@fetch'])->name('getCity');
        Route::post('/setCitySession', ['uses' => 'StateCityController@setSession'])->name('setCitySession');

        Route::any('driver/update-password/{id?}', ['uses' => 'UserController@updateDriverPassword'])->name('resetDriverPassword');

        //CMS module
        Route::get('/cmsPages', ['uses' => 'CMSController@index'])->name('cmsPages');
        Route::get('/cmsPage/{slug?}', ['uses' => 'CMSController@show'])->name('viewCms');
        Route::get('/cmsPage/edit/{slug?}', ['uses' => 'CMSController@show'])->name('editCms');
        Route::post('/cmsPage/update/{slug?}', ['uses' => 'CMSController@update'])->name('updateCms');

    
        Route::patch('/updatevariation/{id?}', ['uses' => 'ProductController@UpdateVariation'])->name('updatevariation');
        Route::get('/editvariation/{id?}', ['uses' => 'ProductController@EditVariation'])->name('editvariation');
        Route::post('/addnewvariation', ['uses' => 'ProductController@AddNewVariation'])->name('addnewvariation');
        Route::delete('/deleteproductvariation{id?}', ['uses' => 'ProductController@DeleteProductVariation'])->name('deleteproductvariation');

        //Order  Module
        Route::get('/orders', ['uses' => 'OrderController@index'])->name('orders');
        Route::get('/order/{id?}', ['uses' => 'OrderController@show'])->name('viewOrder');
        Route::get('/order/edit/{id?}', ['uses' => 'OrderController@show'])->name('editOrder');
        Route::any('/order/assign/{id?}', ['uses' => 'OrderController@assign'])->name('assignOrder');
        Route::any('/order/status/{id?}', ['uses' => 'OrderController@status'])->name('statusOrder');
        Route::post('/order/cancel', ['uses' => 'OrderController@update'])->name('cancelOrder');
        Route::any('/order/send-invoice/{id?}', ['uses' => 'OrderController@sendinvoice'])->name('sendInvoice');
        Route::any('/order/show-invoice/{id?}', ['uses' => 'OrderController@showinvoice'])->name('showInvoice');
        
        Route::get('/orders/delivered', ['uses' => 'OrderController@delivered'])->name('deliveredOrder');
        Route::get('/orders/pending', ['uses' => 'OrderController@pending'])->name('pendingOrder');
        Route::get('/orders/cancelled', ['uses' => 'OrderController@cancelled'])->name('cancelledOrder');

        Route::post('sendsms', 'SmsController@sendSms')->name('sendsms');
        Route::post('/gettotalsmsnumber', ['uses' => 'SmsController@getTotalNumber'])->name('gettotalsmsnumber');
        Route::resource('sms', 'SmsController');


        Route::resource('orders', 'OrderController');
        Route::resource('coupons', 'CouponController');
        Route::resource('faq', 'FaqController');
        Route::resource('slider', 'SliderController');
        Route::resource('category', 'CategoryController');
        Route::resource('product', 'ProductController');
        Route::resource('quicksearch', 'QuickSearchController');
        Route::resource('coupons', 'CouponController');
        Route::resource('units', 'UnitController');

});
