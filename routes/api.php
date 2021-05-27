<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("login", "ApiController@login");
Route::post("isMobileNumberExist", "ApiController@isMobileNumberExist");
Route::post("userRegister", "ApiController@userRegister");
Route::get("categoryList", "ApiController@categoryList");
Route::get("featuredList", "ApiController@featuredList");
Route::get("couponList", "ApiController@couponList");
Route::post("driverRegister", "ApiController@driverRegister");
Route::post("changePassword", "ApiController@changePassword");
Route::post("updatePassword", "ApiController@updatePassword");
Route::get("logout", "ApiController@logout");
Route::get("productList", "ApiController@productList");
Route::get("search", "ApiController@search");
Route::post("rescheduleOrderItem", "ApiController@rescheduleOrderItem");
Route::get("singleproductList", "ApiController@singleproductList");
Route::get("updateDeviceToken", "ApiController@updateDeviceToken");
Route::post("addToCart", "ApiController@addToCart");
Route::post("updateCart", "ApiController@updateCart");
Route::post("getCartItems", "ApiController@getCartItems");
Route::post("deleteCartItems", "ApiController@deleteCartItems");
Route::get("checkOut", "ApiController@checkOut");
Route::post("CreateOrder", "ApiController@CreateOrder");
Route::get("getUserAddress", "ApiController@getUserAddress");
Route::post("createNewAddress", "ApiController@createNewAddress");
Route::post("updateAddress", "ApiController@updateAddress");
Route::get("setDefaultAddress", "ApiController@setDefaultAddress");
Route::get("deleteAddress", "ApiController@deleteAddress");
Route::get("getOrders", "ApiController@getOrders");
Route::get("pastOrders", "ApiController@pastOrders");

Route::post("addErrorLog", "ApiController@addErrorLog");

Route::post("createNotification", "ApiController@createNotification");
Route::get("getNotification", "ApiController@getNotification");
Route::post("addFavouriteProduct", "ApiController@addFavouriteProduct");
Route::get("getFavouriteProduct", "ApiController@getFavouriteProduct");
Route::Post("deleteFavouriteProduct", "ApiController@deleteFavouriteProduct");

Route::get("getFaqs", "ApiController@getFaqs");
Route::get("getSliders", "ApiController@getSliders");
Route::get("getReasons", "ApiController@getReasons");
Route::get("getOrderDelivery", "ApiController@getOrderDelivery");
Route::get("getCurrentdateOrders", "ApiController@getCurrentdateOrders");
Route::get("completedOrders", "ApiController@completedOrders");
Route::get("getOrderDetails", "ApiController@getOrderDetails");
Route::get("deliveryStatus", "ApiController@deliveryStatus");
Route::get("updateDate", "ApiController@updateDate");
Route::get("undeliverOrder", "ApiController@undeliverOrder");
Route::get("getAreas", "ApiController@getAreas");
Route::get("getLocations", "ApiController@getLocations");
Route::get("getUpcomingOrders", "ApiController@getUpcomingOrders");
Route::get("getPastOrders", "ApiController@getPastOrders");
Route::post("uploadFile", "ApiController@uploadFile");
Route::get("getCartCount", "ApiController@getCartCount");

// New Api
Route::post("getUserDetail", "ApiController@getUserDetail");
Route::post("updateProfile", "ApiController@updateProfile");
Route::post("uploadDocuments", "ApiController@uploadDocuments");
Route::post("forgotPassword", "ApiController@forgotPassword");
Route::post("countryList", "ApiController@countryList");
Route::post("stateList", "ApiController@stateList");
Route::post("cityList", "ApiController@cityList");
Route::get("cityList", "ApiController@cityList");
Route::post("sendTestNotification", "ApiController@sendTestNotification");

//paytm configure
Route::get('/payment_success', ['uses' => 'TransactionsController@paymentSuccess'])->name('generateCheckSum');
Route::get('/payment_failed', ['uses' => 'TransactionsController@paymentFailed'])->name('generateCheckSum');
Route::get('/paypalConfigure', ['uses' => 'TransactionsController@paypalWebview'])->name('paypalWebview');

Route::get('/getDeliveryCharges', ['uses' => 'ApiController@getDeliveryCharges'])->name('getDeliveryCharges');
Route::get('/verifyPhoneNumber', ['uses' => 'ApiController@verifyPhoneNumber'])->name('verifyPhoneNumber');
Route::post("phoneRegister", "ApiController@phoneRegister");



