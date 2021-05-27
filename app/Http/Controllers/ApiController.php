<?php

namespace App\Http\Controllers;

use App\Library\Helper;
use App\Library\ResponseMessages;
use App\Library\SendMail;
use App\Model\Cart;
use App\Model\Category;
use App\Model\City;
use App\Model\Country;
use App\Model\Coupon;
use App\Model\DeliveryCharge;
use App\Model\DeliveryReason;
use App\Model\FAQQuestion;
use App\Model\FavouriteProduct;
use App\Model\Location;
use App\Model\Notification;
use App\Model\Order;
use App\Model\OrderDelivery;
use App\Model\OTP;
use App\Model\Product;
use App\Model\ProductVariation;
use App\Model\Slider;
use App\Model\State;
use App\Model\User;
use App\Model\UserAddress;
use App\Model\UserRole;
use App\Model\UserView;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends MyController {

    // function called to check mobile number exist or not
    public function isMobileNumberExist(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("mobile_number", "user_type"));
        try {
            // check mobile number exist or not
            if (!$user = UserView::where("mobile_number", $request->mobile_number)->first()) {
                // generate random number
                $otp_number = rand(1111, 9999);
                // Call send_sms to send sms otp
                // $this->send_sms($request->mobile_number, $otp_number);
                $otp = new OTP();
                $otp->mobile_number = $request->mobile_number;
                $otp->otp           = $otp_number;
                $otp->save();
                $this->response     = array(
                    "status"        => 218,
                    "message"       => ResponseMessages::getStatusCodeMessages(218),
                    "otp"           => $otp_number,
                    "mobile_number" => $request->mobile_number,
                );
            } else {
                // check user role is not same as given role
                if ($request->user_type == $user->role) {
                    $this->response     = array(
                        "status"        => 217,
                        "message"       => ResponseMessages::getStatusCodeMessages(217),
                        "mobile_number" => $request->mobile_number,
                    );
                } else {
                    // if role is driver then give driver error message
                    if ($user->role == "driver") {
                        $this->response = array(
                            "status"    => 320,
                            "message"   => ResponseMessages::getStatusCodeMessages(320),
                        );
                    } else {
                        $this->response = array(
                            "status"    => 319,
                            "message"   => ResponseMessages::getStatusCodeMessages(319),
                        );
                    }
                }
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    // function called if user wants to reset password
    public function forgotPassword(Request $request) {
        // check keys exist
        $this->checkKeys(array_keys($request->all()), array("email"));
        try {
        	// check email exists or not
	        if ($user              = User::where("email", $request->email)->first()) {
	            $user->forgot_key  = base64_encode($user->email);
	            $user->save();
	            $data              = array('resetpassword' => route('resetGetApp') . '?id=' . base64_encode($user->email), 'email' => $user->email, 'first_name' => $user->first_name, 'last_name' => $user->last_name);
	            //SendMail::sendMails('emails.forgot_password', $data, 'Forgot Password');
	            $this->response    = array(
	                "status"       => 200,
	                "message"      => ResponseMessages::getStatusCodeMessages(9),
	            );
	        } else {
	            $this->response    = array(
	                "status"       => 321,
	                "message"      => ResponseMessages::getStatusCodeMessages(321),
	            );
	        }
		} catch (\Exception $ex) {
			$this->response = array(
			"status"             => 501,
			"message"            => ResponseMessages::getStatusCodeMessages(501),
			);
		}
        $this->shut_down();
    }

    // function called to login
    public function login(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("mobile_number", "password", "user_type", "device_id", "device_token", "device_type"));
        try {
                $credentials =[
                    "mobile_number" => substr($request->mobile_number,-9),
                    "password"      => $request->password
                    ];

            if (Auth::attempt($credentials)) {
                // check user role same as given role
                if (Auth::user()->user_role[0]->role == $request->user_type) {
                    $user = Auth::user();
                    $user->device_id        = $request->device_id;
                    $user->device_token     = $request->device_token;
                    $user->device_type      = $request->device_type;
                    $user->save();
                    // get user data
                    //DB::enableQueryLog();
                    $userData = User::select("users.*", 'user_addresses.address_type', 
                    DB::raw("COALESCE((select ROUND(AVG(ratings.rating)) from ratings where parent_id = users.id),0) as rating"), 
                    DB::raw("CONCAT('" . url("uploads/profiles") . "/', profile_picture) profile_picture"), DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state, user_addresses.pincode) as full_address"))
                        ->leftjoin('user_addresses', 'users.id', '=', 'user_addresses.user_id')->where("users.id", Auth::user()->id)->first();
                    // print_r(DB::getQueryLog());

                    $useraddress = UserAddress::select(DB::raw("CONCAT_WS(', ',house_no, apartment_name, street_details, landmark_details, area_details, city, state, pincode) as full_address"), 'mobile_number')->where(['user_id' => Auth::user()->id, 'default_address' => 1])->first();

                    // check if role is driver
                    if (Auth::user()->user_role[0]->role == "driver") {
                        // check user is verified or not
                        if (Auth::user()->is_verified) {

                            if (Auth::user()->status == 'AC') {
                                $this->response = array(
                                    "status" => 200,
                                    "message" => ResponseMessages::getStatusCodeMessages(107),
                                    'user_address' => $useraddress,
                                    'refer_message' => $this->getBusRuleRef("order_message"),
                                    'data' => $userData,
                                );
                            } else {
                                $this->response = array(
                                    "status" => 34,
                                    "message" => ResponseMessages::getStatusCodeMessages(34),
                                );
                            }
                        } else {
                            $this->response = array(
                                "status" => 106,
                                "message" => ResponseMessages::getStatusCodeMessages(106),
                            );
                        }

                    } else {
                        // check user is verified or not
                        if (Auth::user()->is_verified) {
                            if (Auth::user()->status == 'AC') {

                                $usercartcount  = Cart::where('cart.user_id', $user->id)->where('cart.status', 'AC')->count();
                                $favouritecount = FavouriteProduct::where('favourite_products.user_id', $user->id)->where('favourite_products.status', 'AC')->count();
                                $this->response = array(
                                    "status" => 200,
                                    "message" => ResponseMessages::getStatusCodeMessages(107),
                                    'user_address' => $useraddress,
                                    'refer_message' => $this->getBusRuleRef("order_message"),
                                    'data' => $userData,
                                    "cart_count" => $usercartcount,
                                    "fav_count" => $favouritecount,
                                );
                            } else {
                                $this->response = array(
                                    "status" => 34,
                                    "message" => ResponseMessages::getStatusCodeMessages(34),
                                    'cart_count' => 0,
                                    'fav_count' => 0,
                                );
                            }
                        } else {
                            $this->response = array(
                                "status" => 106,
                                "message" => ResponseMessages::getStatusCodeMessages(106),
                            );
                        }
                    }
                } else {
                    // check role is driver or not
                    if (Auth::user()->user_role[0]->role == "driver") {
                        $this->response = array(
                            "status" => 320,
                            "message" => ResponseMessages::getStatusCodeMessages(320),
                        );
                    } else {
                        $this->response = array(
                            "status" => 319,
                            "message" => ResponseMessages::getStatusCodeMessages(319),
                        );
                    }
                }
            } else {
                $this->response = array(
                    "status" => 108,
                    "message" => ResponseMessages::getStatusCodeMessages(108),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to register user
    public function userRegister(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("name", "email", "mobile_number", "password", "device_id", "device_type", "country", "state", "city"));
//         try {
            $validate = Validator($request->all(), [
                'email' => 'required|email',

            ]);
            if (!$validate->fails()) {
                // check moobile number exist or not
                if (!User::where("email", $request->email)->first()) {
                    $filename = "";
                    // check profile_picture key exist or not
                    // if ($request->hasfile('profile_picture')) {
                    //     $file = $request->file('profile_picture');
                    //     $extension = $file->getClientOriginalExtension();
                    //     $filename = time() . '.' . $extension;
                    //     $file->move('uploads/profiles/', $filename);
                    // }
                    $user                   = new User();
                    $user->referral_code    = Helper::generateNumber("users", "referral_code");
                    $user->name             = $request->name;
                    $user->email            = $request->email;
                    $user->mobile_number    = rand(111111111, 999999999);
                    $user->password         = bcrypt($request->password);
                    $user->device_id        = $request->device_id;
                    $user->device_token     = $request->device_token;
                    $user->device_type      = $request->device_type;
                    $user->country          = $request->country;
                    $user->state            = $request->state;
                    $user->city             = $request->city;
                    // $user->profile_picture = $filename;
                    $user->forgot_key       = "";
                    $user->is_verified      = 1;
                    $user->save();
                    $user_role              = new UserRole();
                    $user_role->role_id     = 2;
                    $user_role->user_id     = $user->id;
                    $user_role->save();

                    // when user registered then send an welcome email to user
                    //SendMail::sendWelcomeMail("Welcome User - Local Fine Foods", $user, null, "emails.user_registration");

                    $this->response = array(
                        "status"    => 200,
                        "message"   => ResponseMessages::getStatusCodeMessages(200),
                        'refer_message' => "",
                        "data"      => User::select("*", DB::raw("CONCAT('" . url("uploads/profiles") . "/', profile_picture) profile_picture"))->where("id", $user->id)->first(),
                    );
                } else {
                    $this->response = array(
                        "status"    => 104,
                        "message"   => ResponseMessages::getStatusCodeMessages(104),
                    );
                }
            } else {
                $this->response     = array(
                    "status"        => 40,
                    "message"       => ResponseMessages::getStatusCodeMessages(40),
                );
            }
/*
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
*/

        $this->shut_down();
    }

    // function called to register driver
    public function driverRegister(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("name", "email", "mobile_number", "password", "state", "city", "device_id", "device_token", "device_type", "profile_picture"));
        try {
            // check mobile_number is exist or not
            if (!User::where("mobile_number", $request->mobile_number)->first()) {
                $filename = "";
                // check profile_picture key exist or not
                // if ($request->hasfile('profile_picture')) {
                //     $file = $request->file('profile_picture');
                //     $extension = $file->getClientOriginalExtension();
                //     $filename = time() . '.' . $extension;
                //     $file->move('uploads/profiles/', $filename);
                // }
                $user                   = new User();
                $user->referral_code    = Helper::generateNumber("users", "referral_code");
                $user->name             = $request->name;
                $user->email            = $request->email;
                $user->mobile_number    = $request->mobile_number;
                $user->password         = bcrypt($request->password);
                $user->device_id        = $request->device_id;
                $user->device_token     = $request->device_token;
                $user->device_type      = $request->device_type;
                $user->state            = $request->state;
                $user->city             = $request->city;
                //$user->profile_picture = $filename;
                $user->identity_verification = 1;
                $user->forgot_key       = "";
                //$user->is_verified = 1; // To be removed, harry
                $user->save();
                $user_role              = new UserRole();
                $user_role->role_id     = 3;
                $user_role->user_id     = $user->id;
                $user_role->save();
                // send welcome to to driver when registered
                SendMail::sendWelcomeMail("Welcome Driver - Local Fine Foods", $user, null, "emails.driver_registration");

                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    "data"      => User::select("*", DB::raw("(select ROUND(AVG(ratings.rating)) from ratings where parent_id = users.id) as rating"), DB::raw("CONCAT('" . url("uploads/profiles") . "/', profile_picture) profile_picture"))->where("id", $user->id)->first(),
                );
            } else {
                $this->response = array(
                    "status" => 105,
                    "message" => ResponseMessages::getStatusCodeMessages(105),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to get category list
    public function categoryList(Request $request) {
        // check keys are exist
        // try {
        // get city list based on state
        $Category          = Category::select("category.*", DB::raw("CONCAT('" . url("uploads/categories") . "/', category.image) image"))->join('products', 'products.category_id', '=', 'category.id')->join('product_variations', 'product_variations.product_id', '=', 'products.id')->where("category.status", "AC")->where("products.status", "AC")->where("product_variations.status", "AC")->groupBy('category.id')->get();

        $sliders           = Slider::select('id', DB::raw("CONCAT('" . url("uploads/sliders") . "/', image) image"))->where('status', 'AC')->get();

        $user_id           = $request->user_id;
        $featured_products = Product::select("products.*", DB::raw("COALESCE(cart.quantity,0) as cart_quantity"),DB::raw("COALESCE(cart.id,0) as cart_id"), DB::raw("(0) as selected_index"), DB::raw("(0) as SecondLoad"), DB::raw("(0) as checkPickerLoad"), DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"), DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"), DB::raw("(select product_variations.weight from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as weight"), DB::raw("(select product_units.name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as unit"), DB::raw("(select product_units.h_name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as h_unit"), DB::raw("(select product_variations.special_price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as special_price"), DB::raw("(select round((product_variations.price - product_variations.special_price)*100 / product_variations.price) from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as discount"))->join('product_variations', 'product_variations.product_id', '=', 'products.id')->leftJoin("cart", function ($join) use ($user_id) {
            $join->on("cart.product_id", "=", "products.id");
            $join->where(["cart.user_id" => $user_id, "cart.status" => "AC"]);
        })->with(['get_product_variations' => function ($q) {
            $q->with(['product_units' => function ($q) {
                $q->select('id', 'name', 'h_name');
            }])->where('status', 'AC');
        }, 'product_brand' => function ($query) {
            $query->select('id', 'name as brand_name');
        }])->where(['products.status' => 'AC', 'is_featured' => 1, 'product_variations.status' => 'AC'])->groupBy('products.id')->get();

        $quick_products     = Product::select("products.*", DB::raw("COALESCE(cart.quantity,0) as cart_quantity"), DB::raw("COALESCE(cart.id,0) as cart_id"), DB::raw("(0) as selected_index"), DB::raw("(0) as SecondLoad"), DB::raw("(0) as checkPickerLoad"), DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"), DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"), DB::raw("(select product_variations.weight from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as weight"), DB::raw("(select product_units.name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as unit"), DB::raw("(select product_units.h_name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as h_unit"), DB::raw("(select product_variations.special_price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as special_price"), DB::raw("(select round((product_variations.price - product_variations.special_price)*100 / product_variations.price) from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as discount"))->join('product_variations', 'product_variations.product_id', '=', 'products.id')->leftJoin("cart", function ($join) use ($user_id) {
            $join->on("cart.product_id", "=", "products.id");
            $join->where(["cart.user_id" => $user_id, "cart.status" => "AC"]);
        })->with(['get_product_variations' => function ($q) {
            $q->with(['product_units' => function ($q) {
                $q->select('id', 'name', 'h_name');
            }])->where('status', 'AC');
        }, 'product_brand' => function ($query) {
            $query->select('id', 'name as brand_name');
        }])->where(['products.status' => 'AC', 'is_quick_grab' => 1, 'product_variations.status' => 'AC'])->groupBy('products.id')->get();

        $offered_products = Product::select("products.*", 
            DB::raw("COALESCE(cart.quantity,0) as cart_quantity"), 
            DB::raw("COALESCE(cart.id,0) as cart_id"), 
            DB::raw("(0) as selected_index"), 
            DB::raw("(0) as SecondLoad"), 
            DB::raw("(0) as checkPickerLoad"), 
            DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"), 
            DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 
            DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"), 
            DB::raw("(select product_variations.weight from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as weight"), 
            DB::raw("(select product_units.name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as unit"), 
            DB::raw("(select product_units.h_name from product_variations join product_units on product_variations.unit_id = product_units.id where product_variations.product_id = products.id and product_variations.status='AC' and product_units.status='AC' limit 1) as h_unit"), 
            DB::raw("(select product_variations.special_price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as special_price"), 
            DB::raw("(select round((product_variations.price - product_variations.special_price)*100 / product_variations.price) from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as discount"))->join('product_variations', 'product_variations.product_id', '=', 'products.id')->leftJoin("cart", function ($join) use ($user_id) {
            $join->on("cart.product_id", "=", "products.id");
            $join->where(["cart.user_id" => $user_id, "cart.status" => "AC"]);
        })->with(['get_product_variations' => function ($q) {
            $q->with(['product_units' => function ($q) {
                $q->select('id', 'name', 'h_name');
            }])->where('status', 'AC');
        }, 'product_brand' => function ($query) {
            $query->select('id', 'name as brand_name');
        }])->where(['products.status' => 'AC', 'is_offered' => 1, 'product_variations.status' => 'AC'])->groupBy('products.id')->get();

        //$Category = Category::select("category.*", DB::raw("CONCAT('" . url("uploads/categories") . "/', category.image) image"))->where("category.status", "AC")->groupBy('category.id')->get();
        $usercartcount = 0;
        $favouritecount = 0;
        if (isset($request->user_id)) {

            $usercartcount = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
        }

        if ($Category->count() > 0) {
            $this->response = array(
                "status"         => 200,
                "message"        => ResponseMessages::getStatusCodeMessages(200),
                "data"           => $Category,
                "sliders"        => $sliders,
                "featured"       => $featured_products,
                "quick_products" => $quick_products,
                "offered_products" => $offered_products,
                "cart_count" => $usercartcount,
                "fav_count" => $favouritecount,
                'delivery_charges' => $this->getBusRuleRef("delivery_charges"),
                'minimum_order_amount' => $this->getBusRuleRef("minimum_order_amount"),
            );
        } else {
            $this->response = array(
                "status" => 28,
                "message" => ResponseMessages::getStatusCodeMessages(28),
                "cart_count" => $usercartcount,
                "fav_count" => $favouritecount,
            );
        }
        // } catch (\Exception $ex) {
        //     $this->response = array(
        //         "status" => 501,
        //         "message" => ResponseMessages::getStatusCodeMessages(501),
        //     );
        // }

        $this->shut_down();
    }

    // function called to get call product list
    public function productList(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("category_id"));
        try {
            //DB::enableQueryLog();
            $user_id  = $request->user_id;
            $products = Product::select("products.*",
            DB::raw("COALESCE(cart.quantity,0) as cart_quantity"),
            DB::raw("COALESCE(cart.id,0) as cart_id"),
            DB::raw("(0) as SecondLoad"),
            DB::raw("(0) as checkPickerLoad"),
            DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"),
            DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"),
            DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"),
            DB::raw("(select product_variations.special_price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as special_price"),
            DB::raw("(select round((product_variations.price - product_variations.special_price)*100 / product_variations.price) from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as discount"))
            ->join('product_variations', 'product_variations.product_id', '=', 'products.id')
            ->leftJoin("cart", function ($join) use ($user_id) {
                $join->on("cart.product_id", "=", "products.id");
                $join->where(["cart.user_id" => $user_id, "cart.status" => "AC"]);
            })->with(['get_product_variations' => function ($q) {
                $q->with(['product_units' => function ($q) {
                    $q->select('id', 'name', 'h_name');
                }])->where('status', 'AC');
            }, 'product_brand' => function ($query) {
                $query->select('id', 'name as brand_name');
            }])
            ->where(['products.status' => 'AC', 'category_id' => $request->category_id, 'product_variations.status' => 'AC'])
            ->groupBy('products.id')
            ->orderBy('products.name')
            ->get();
            // print_r(DB::getQueryLog());
            //die;
            if ($products->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $products,
                );
            } else {
                $this->response = array(
                    "status" => 21,
                    "message" => ResponseMessages::getStatusCodeMessages(21),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    // function called to get call featured product list
    public function featuredList(Request $request) {
        try {
            //DB::enableQueryLog();
            $user_id = $request->user_id;
            $products = Product::select("products.*", DB::raw("COALESCE(cart.quantity,0) as cart_quantity"), DB::raw("(0) as selected_index"), DB::raw("(0) as SecondLoad"), DB::raw("(0) as checkPickerLoad"), DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"), DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"))->join('product_variations', 'product_variations.product_id', '=', 'products.id')->leftJoin("cart", function ($join) use ($user_id) {
                $join->on("cart.product_id", "=", "products.id");
                $join->where(["cart.user_id" => $user_id, "cart.status" => "AC"]);
            })->with(['get_product_variations' => function ($q) {
                $q->with(['product_units' => function ($q) {
                    $q->select('id', 'name');
                }])->where('status', 'AC');
            }, 'product_brand' => function ($query) {
                $query->select('id', 'name as brand_name');
            }])->where(['products.status' => 'AC', 'is_featured' => 1, 'product_variations.status' => 'AC'])->groupBy('products.id')->get();
            // print_r(DB::getQueryLog());
            // die;
            if ($products->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $products,
                );
            } else {
                $this->response = array(
                    "status" => 21,
                    "message" => ResponseMessages::getStatusCodeMessages(21),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    // function called to get call coupon list
    public function couponList(Request $request) {
        try {
            // DB::enableQueryLog();
            $coupon = Coupon::whereStatus("AC")->where('end_date', '>=', date('Y-m-d'))->get();
            // print_r(DB::getQueryLog());
            // die;
            if ($coupon->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $coupon,
                );
            } else {
                $this->response = array(
                    "status" => 44,
                    "message" => ResponseMessages::getStatusCodeMessages(44),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    // function called to search product list
    public function search(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("text"));
        try {
            $user_id = $request->user_id;
            $Category = Product::select("products.*", DB::raw("(0) as selected_index"), DB::raw("(0) as SecondLoad"), DB::raw("(0) as checkPickerLoad"), DB::raw("IF ((select count(favourite_products.product_id) from favourite_products where favourite_products.product_id = products.id and favourite_products.user_id='$user_id' and favourite_products.status='AC') > 0,'Favourites_selected.png','Favourites.png') as favourite"), DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), DB::raw("(select product_variations.price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as price"), DB::raw("(select product_variations.special_price from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as special_price"), DB::raw("(select round((product_variations.price - product_variations.special_price)*100 / product_variations.price) from product_variations where product_variations.product_id = products.id and product_variations.status='AC' limit 1) as discount"))->join('product_variations', 'product_variations.product_id', '=', 'products.id')->join('category', 'category.id', '=', 'products.category_id')->join('brands', 'brands.id', '=', 'products.brand_id')
                ->with(['get_product_variations' => function ($q) {
                    $q->with(['product_units' => function ($q) {
                        $q->select('id', 'name');
                    }])->where('status', 'AC');
                }, 'product_brand' => function ($query) {
                    $query->select('id', 'name as brand_name');
                }])->where(['products.status' => 'AC', 'product_variations.status' => 'AC', 'category.status' => 'AC', 'brands.status' => 'AC'])->where(function ($q) use ($request) {

                $q->where('category.name', 'LIKE', "%$request->text%")->orWhere('products.name', 'LIKE', "%$request->text%")->orWhere('brands.name', 'LIKE', "%$request->text%");
            })
                ->where('products.status', "AC")->groupBy('products.id')->get();
            if ($Category->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $Category,
                );
            } else {
                $this->response = array(
                    "status" => 21,
                    "message" => ResponseMessages::getStatusCodeMessages(21),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    // function called to get product description
    public function singleproductList(Request $request) {

        $this->checkKeys(array_keys($request->all()), array("product_id"));

        try {

            // $products = DB::table('products')->select('products.id', 'products.name', 'products.description', 'products.image', 'products.price', 'products.quantity', 'products.cgst', 'products.sgst', 'products.igst', 'product_variations.weight', 'product_units.name as unit_name', 'product_units.code as unit_code', 'brands.name as brand_name')
            // ->join('product_variations', 'product_variations.product_id', '=', 'products.id')->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')
            // ->join('brands', 'brands.id', '=', 'products.brand_id')->where(['products.status' => 'AC', 'product_variations.status' => 'AC', 'product_units.status' => 'AC', 'brands.status' => 'AC', 'products.id' => $id])
            // ->first();
            $products = Product::select("*", DB::raw("CONCAT('" . url("uploads/products") . "/', image) image"))->with(['get_product_variations' => function ($q) {

                $q->with(['product_units' => function ($q) {
                    $q->select('id', 'name');
                }])->where('status', 'AC');
            }, 'product_brand' => function ($query) {
                $query->select('id', 'name as brand_name');
            }])->where('id', $request->product_id)->first();

            if ($products) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $products,
                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    // function called to get cart items
    public function getCartItems(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try {
            //$usercartsitem = Cart::where('user_id',$request->user_id)->where('status','AC')->get();
            $usercartsitem = Cart::select('cart.id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', 'products.name as product_name', 'products.price as product_price', 'products.quantity as product_quantity', 'product_variations.weight', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')->where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->get();

            if ($usercartsitem->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $usercartsitem,

                );
            } else {
                $this->response = array(
                    "status" => 23,
                    "message" => ResponseMessages::getStatusCodeMessages(23),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    // function called to delete cart item
    public function deleteCartItems(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("cart_id", "product_id", "user_id"));
        try {
            $usercartsitem = Cart::where(["product_id" => $request->product_id, "status" => "AC"])->first();
            $usercartsitem->status = 'IN';
            $usercartsitem->save();
            $allcartitem = Cart::select('cart.id', 'cart.product_id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', DB::raw("(cart.cgst+cart.sgst) as gst"), DB::raw("(products.cgst+products.sgst) as product_gst"), 'products.igst as product_igst', 'cart.total_without_tax', 'cart.total_with_tax', 'products.name as product_name', 'products.quantity as product_quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'product_variations.weight', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')->where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->get();

            $usercartcount = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();

            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
            if ($allcartitem->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(12),
                    'data' => $allcartitem,
                    'cart_count' => $usercartcount,
                    'fav_count' => $favouritecount,

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(30),
                    'cart_count' => $usercartcount,
                    'fav_count' => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    // function called to add product to cart
    public function addToCart(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "product_id", "product_variation_id", "quantity", "scheduled", "from_date", "to_date"));
        try {
            if ($addcart = Cart::where(['user_id' => $request->user_id, 'product_id' => $request->product_id, 'status' => 'AC'])->first()) {
                $addcart->user_id               = $request->user_id;
                $addcart->product_id            = $request->product_id;
                $addcart->product_variation_id  = $request->product_variation_id;
                $addcart->quantity              = $request->quantity;
                $addcart->scheduled             = $request->scheduled;
                $addcart->from_date             = date("Y-m-d");
                $addcart->to_date               = date("Y-m-d");
                $addcart->save();

            } else {
                $order_id = null;
                if ($order              = Order::where(["status"=>"PN","user_id"=>$request->user_id])->first()) {
                    $order_id           = $order->id;
                } else {
                    $order              = new Order();
                    $order->order_code  = Helper::generateNumber("orders", "order_code");
                    $order->user_id     = $request->user_id;
                    $order->save();
                    $order_id           = $order->id;
                }
                $addcart                        = new Cart();
                $addcart->user_id               = $request->user_id;
                $addcart->product_id            = $request->product_id;
                $addcart->product_variation_id  = $request->product_variation_id;
                $addcart->quantity              = $request->quantity;
                $addcart->scheduled             = $request->scheduled;
                $addcart->from_date             = date("Y-m-d");
                $addcart->to_date               = date("Y-m-d");
                $addcart->save();
            }
            $usercartsitem = Cart::select('cart.id', 'cart.product_id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', DB::raw("(cart.cgst+cart.sgst) as gst"), DB::raw("(products.cgst+products.sgst) as product_gst"), 'products.igst as product_igst', 'cart.total_without_tax', 'cart.total_with_tax', 'products.name as product_name', 'products.quantity as product_quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'product_variations.weight', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')->where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->get();

            $usercartcount = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();

            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
            if ($addcart->id) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(11),
                    "data" => $usercartsitem,
                    "cart_count" => $usercartcount,
                    "fav_count" => $favouritecount,

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                    'cart_count' => $usercartcount,
                    'fav_count' => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    public function updateCart(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("product_id", "user_id","cart_id", "update_type"));
        try {
            if ($addcart = Cart::where(['id' => $request->cart_id, 'status' => 'AC'])->first()) {
                if ($request->update_type == "quantity") {
                    $addcart->quantity = $request->quantity;
                    $productvariation = ProductVariation::find($addcart->product_variation_id);
                    $product = Product::find($addcart->product_id);
                    $cart_item = Cart::where('id', $addcart->id)->first();
                    if ($productvariation->special_price == null || $productvariation->special_price == "") {
                        $cart_item->sgst = (($request->quantity * $productvariation->price) * $product->sgst) / 100;
                        $cart_item->cgst = (($request->quantity * $productvariation->price) * $product->cgst) / 100;
                        $cart_item->igst = (($request->quantity * $productvariation->price) * $product->igst) / 100;
                        $cart_item->total_without_tax = $request->quantity * $productvariation->price;
                        $cart_item->total_with_tax = ($cart_item->total_without_tax + $cart_item->sgst + $cart_item->cgst);
                    } else {
                        $cart_item->sgst = (($request->quantity * $productvariation->special_price) * $product->sgst) / 100;
                        $cart_item->cgst = (($request->quantity * $productvariation->special_price) * $product->cgst) / 100;
                        $cart_item->igst = (($request->quantity * $productvariation->special_price) * $product->igst) / 100;
                        $cart_item->total_without_tax = $request->quantity * $productvariation->special_price;
                        $cart_item->total_with_tax = ($cart_item->total_without_tax + $cart_item->sgst + $cart_item->cgst);
                    }

                    $cart_item->save();
                } elseif ($request->update_type == "from_date") {
                    $addcart->from_date = $request->from_date;
                } elseif ($request->to_date == "to_date") {
                    $addcart->from_date = $request->from_date;
                }
                $addcart->save();
            }
            $usercartsitem = Cart::select('cart.id', 'cart.product_id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', DB::raw("(cart.cgst+cart.sgst) as gst"), DB::raw("(products.cgst+products.sgst) as product_gst"), 'products.igst as product_igst', 'cart.total_without_tax', 'cart.total_with_tax', 'products.name as product_name', 'products.quantity as product_quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'product_variations.weight', 'product_variations.price as product_price', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')->where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->get();

            $usercartcount = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();

            if ($addcart->id) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(11),
                    "data" => $usercartsitem,
                    "cart_count" => $usercartcount,
                    "fav_count" => $favouritecount,

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                    'cart_count' => $usercartcount,
                    'fav_count' => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function checkOut(Request $request) {
        
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        // try {
        $curr = date('Y-m-d');
        // DB::enableQueryLog();
        
        $isCartExist = Cart::where(["user_id" => $request->user_id, "status" => "AC"])->first();
        
        if ($isCartExist == null) {
            $this->response = array(
                "status" => 244,
                "message" => ResponseMessages::getStatusCodeMessages(244),
            );
        } 
        else 
        {
            // $a = Cart::where('from_date',"<",$curr)->where("to_date","<",$curr)->where(['user_id' => $request->user_id, 'status' => 'AC'])->first();
            // print_r(DB::getQueryLog());

            $DeliveryCharges    =       DeliveryCharge::where('status', 'AC')->get();
            
            if ( $a = Cart::where('from_date', "<=", $curr)->where("to_date", "<=", $curr)->where(['user_id' => $request->user_id, 'status' => 'AC'])->first()) 
            {
                $a->from_date = date('Y-m-d');
                $a->to_date = date('Y-m-d');
                $a->save();
                OrderDelivery::where("cart_id", $a->id)->delete();
            } 
            elseif ( 
            
            $a = Cart::where('from_date', "<=", $curr)->where("to_date", ">=", $curr)->where(['user_id' => $request->user_id, 'status' => 'AC'])->first()) 
            {
            $a->from_date = date('Y-m-d');
            $a->save();
            
            OrderDelivery::where("cart_id", $a->id)->delete();
            }

            $allcartitem = Cart::where(['user_id' => $request->user_id, 'status' => 'AC'])->get();

            foreach ($allcartitem as $item) {
                
                $productvariation = ProductVariation::find($item->product_variation_id);

                $product    = Product::find($item->product_id);
                $cart_item  = Cart::find($item->id);

                $from       = \Carbon\Carbon::parse($cart_item->from_date);
                $to         = \Carbon\Carbon::parse($cart_item->to_date);
                $days       = $to->diffInDays($from);
                //$daysCart = $days+1;
                $daysCart = 1;

                if (isset($productvariation->special_price)) {

                    $cart_item->sgst    = (($item->quantity * $productvariation->special_price * $daysCart) * $product->sgst) / 100;
                    $cart_item->cgst    = (($item->quantity * $productvariation->special_price * $daysCart) * $product->cgst) / 100;
                    $cart_item->igst    = (($item->quantity * $productvariation->special_price * $daysCart) * $product->igst) / 100;
                    $cart_item->total_without_tax = $item->quantity * $productvariation->special_price * $daysCart;
                    $cart_item->total_with_tax  = ($cart_item->total_without_tax + $cart_item->sgst + $cart_item->cgst);

                } else {
                    $cart_item->sgst = (($item->quantity * $productvariation->price * $daysCart) * $product->sgst) / 100;
                    $cart_item->cgst = (($item->quantity * $productvariation->price * $daysCart) * $product->cgst) / 100;
                    $cart_item->igst = (($item->quantity * $productvariation->price * $daysCart) * $product->igst) / 100;
                    $cart_item->total_without_tax = $item->quantity * $productvariation->price * $daysCart;
                    $cart_item->total_with_tax = ($cart_item->total_without_tax + $cart_item->sgst + $cart_item->cgst);
                
                
                }
                // $from = \Carbon\Carbon::parse($cart_item->from_date);
                // $to = \Carbon\Carbon::parse($cart_item->to_date);
                // $days = $to->diffInDays($from);
                OrderDelivery::where("cart_id", $cart_item->id)->delete();
                if ($days) {
                    for ($i = 0; $i <= $days; $i++) {
                        if ($i) {
                            $day = 1;
                        } else {
                            $day = 0;
                        }
                        $orderdeliver = new OrderDelivery();
                        // $newDate = $from->addDays($day);
                        $newDate = date("Y-m-d");
                        $orderdeliver->cart_id = $cart_item->id;
                        $orderdeliver->order_date = $newDate;
                        $orderdeliver->save();
                    }
                } else {
                    // $newDate = $from->addDays(0);
                    $newDate = date("Y-m-d");
                    $orderdeliver = new OrderDelivery();
                    $orderdeliver->cart_id = $cart_item->id;
                    $orderdeliver->order_date = $newDate;
                    $orderdeliver->save();
                }
                $cart_item->save();
            }

            $usercartsitem  = Cart::select('cart.id', 'cart.id as cart_id', 'cart.product_id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', DB::raw("(cart.cgst+cart.sgst) as gst"), DB::raw("(products.cgst+products.sgst) as product_gst"), 'products.igst as product_igst', 'cart.total_without_tax', 'cart.total_with_tax', 'products.name as product_name', 'products.h_name as h_product_name', 'products.quantity as product_quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'product_variations.weight', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.h_name as h_unit_name', 'product_variations.price as product_price', 'product_variations.special_price', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')->where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->get();

            $user_aderss    = UserAddress::select('id', 'address_type', 'default_address', DB::raw("CONCAT_WS(', ',house_no, apartment_name, street_details, landmark_details, area_details, city, state, pincode) as full_address"), 'mobile_number')->where(['user_id' => $request->user_id, 'status' => 'AC'])->where("status", "AC")->first();

            $usercartcount  = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();

            $deliveryCharge = $this->getBusRuleRef("delivery_charges");
            $cart = Cart::select("id", DB::raw("SUM(cart.total_with_tax) as cart_total"), DB::raw("(SUM(cart.total_with_tax) + $deliveryCharge) as cost "))->where(['user_id' => $request->user_id, 'status' => 'AC'])->groupBy("user_id")->first();
            $promo_amount   = "0.00";
            $total_amount   = "0.00";
            $cost = "0.00";
            $coupon_code_id = "";
            $coupon_code    = "";
            $order          = Order::whereStatus("PN")->where("user_id", $request->user_id)->first();
            if ($order!=null) {
	            foreach ($DeliveryCharges as $value) {
	                if ($cart->cart_total > $value->from_amount && $cart->cart_total < $value->to_amount) {
	                    $deliveryCharge = $value->delivery_charge;
	                } else if ($cart->cart_total > $value->from_amount && $cart->cart_total < $value->to_amount) {
	                    $deliveryCharge = $value->delivery_charge;
	                } else if ($cart->cart_total > $value->from_amount && $cart->cart_total < $value->to_amount) {
	                    $deliveryCharge = $value->delivery_charge;
	                }
	            }
	            $order->delivery_charges = $deliveryCharge;
                $order->cost             = round(($cart->cart_total + $deliveryCharge));
                $order->total_amount     = $cart->cart_total;
                $order->save();

                if ($coupon = Coupon::where(["status" => "AC", "id" => $order->coupon_code_id])->first()) {
                    $coupon_code_id = $coupon->id;
                    $coupon_code    = $coupon->coupon_code;
                    $order->promo_amount = round(($order->total_amount * $coupon->discount_value) / 100);
                    $order->cost    = ($order->cost - $order->promo_amount);
                    $order->save();
                    $promo_amount   = $order->promo_amount;
                    $cost = $order->cost;
                    $total_amount   = $order->total_amount;
                } else {
                    $promo_amount   = $order->promo_amount;
                    $cost = $order->cost;
                    $total_amount   = $order->total_amount;
                }
            } else {
                $cost = $cart->cost;
                $total_amount = $cart->cart_total;
            }
            if ($allcartitem->count() > 0) {
                $this->response = array(
                    "status"                => 200,
                    "message"               => ResponseMessages::getStatusCodeMessages(200),
                    "cart_count"            => $usercartcount,
                    "fav_count"             => $favouritecount,
                    "promo_amount"          => $promo_amount,
                    "total_amount"          => $total_amount,
                    "cost"                  => $cost,
                    "coupon_code_id"        => $coupon_code_id,
                    "coupon_code"           => $coupon_code,
                    'delivery_charges'      => $deliveryCharge,
                    'intrec_id'             => $this->getBusRuleRef("intrec_id"),
                    'intrec_message'        => $this->getBusRuleRef("intrec_message"),
                    'minimum_order_amount'  => $this->getBusRuleRef("minimum_order_amount"),
                    'is_delivery_time'      => $this->getBusRuleRef("is_delivery_time"),
                    "data" => array('cart_data' => $usercartsitem, 'user_address' => $user_aderss),
                );
            } else {
                $this->response = array(
                    "status" => 25,
                    "message" => ResponseMessages::getStatusCodeMessages(25),
                    'cart_count' => $usercartcount,
                    'fav_count' => $favouritecount,
                );
            }
        }
        // } catch (\Exception $ex) {
        //     $this->response = array(
        //         "status" => 501,
        //         "message" => ResponseMessages::getStatusCodeMessages(501),
        //     );
        // }
        $this->shut_down();
    }
    public function CreateOrder(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "address_id", "payment_method"));
        try
        {
            $delivery_charges       = $this->getBusRuleRef("delivery_charges");
            $cart                   = Cart::select("id", DB::raw("SUM(cart.total_with_tax) as cart_total"))->where(['user_id' => $request->user_id, 'status' => 'AC'])->groupBy("user_id")->first();
            $order                  = Order::where(["status" => "PN", 'user_id' => $request->user_id])->first();
            if ($order == null) {
                $order = new Order();
                $order->order_code      = Helper::generateNumber("orders", "order_code");
            }
            $order->delivery_pickup     = $request->delivery_pickup;
            $order->address_id          = $request->address_id;
            $order->user_id             = $request->user_id;
            $order->coupon_code_id      = $request->coupon_code_id;
            $order->payment_method      = $request->payment_method;
            $order->date                = $request->dp_date;
            $order->comment             = $request->order_comment;
            $order->cost                = ($cart->cart_total + $delivery_charges);
            $order->delivery_charges    = $delivery_charges;
            if ($request->payment_method == "cod" or $request->payment_method == "eft") {
                $order->status = "CM";
            } else {
                $order->status = "PN";
            }
            $order->save();
            if ($order->id) {
                if ($request->payment_method == "cod" or $request->payment_method == "eft") {
                    Cart::where(['user_id' => $request->user_id, 'status' => 'AC'])->update(["order_id" => $order->id, "status" => "CM"]);
                    $notification                    = new Notification();
                    $notification->user_id           = $request->user_id;
                    $notification->title             = "Order Placed";
                    $notification->description       = "Your Order #" . $order->order_code . " has been placed successfully";
                    $notification->notification_type = "Order";
                    $notification->save();
                    $notification                    = new Notification();
                    $notification->user_id           = 1;
                    $notification->title             = "Order Placed";
                    $notification->description       = "Order #" . $order->order_code . " has been placed successfully";
                    $notification->notification_type = "NewOrder";
                    $notification->save();
            
            $user       = User::where("id", $order->user_id)->first();
            
            \Mail::to($user->email)->send(new \App\Mail\SendInvoice($order));
            \Mail::to('order@localfinefoods.com')->send(new \App\Mail\SendInvoice($order));

            SendMail::sendOrderMail("Order #" . $order->order_code, $user, null, "emails.invoice", $order, $cart);
            SendMail::sendUserInvoiceMail("Local Fine Foods Order #" . $order->order_code, $user, null, "emails.invoice", $order, $cart);

                } else {
                    
                    //Cart::where(['user_id' => $request->user_id, 'status' => 'AC'])->update(["order_id" => $order->id, "status" => "CM"]);
                    Cart::where(['user_id' => $request->user_id, 'status' => 'AC'])->update(["order_id" => $order->id, "status" => "AC"]);
                }

                $usercartcount      = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
                $favouritecount     = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
                $this->response     = array(
                    "status"        => 200,
                    "message"       => ResponseMessages::getStatusCodeMessages(14),
                    "cart_count"    => $usercartcount,
                    "fav_count"     => $favouritecount,
                    "order_id"      => $order->id,
                    "amount"        => $order->cost,
                );
            } else {
                $usercartcount      = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
                $favouritecount     = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
                $this->response = array(
                    "status"        => 220,
                    "message"       => ResponseMessages::getStatusCodeMessages(220),
                    'cart_count'    => $usercartcount,
                    'fav_count'     => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getUserAddress(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $address = UserAddress::select('id', 'name', 'mobile_number', 'address_type', 'default_address', 'house_no', 'street_details', 'apartment_name', 'landmark_details', 'area_details', 'city', 'state', 'country', 'pincode', DB::raw("CONCAT_WS(', ',house_no, apartment_name, street_details, landmark_details, area_details, city, state,country, pincode) as full_address"))->where(['user_id' => $request->user_id, 'status' => 'AC'])->get();

            if ($address) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    "data"      => $address,
                );
            } else {
                $this->response = array(
                    "status"    => 220,
                    "message"   => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"        => 501,
                "message"       => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function createNewAddress(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "name", "mobile_number", "address_type", "default_address", "street_details", "house_no", "apartment_name", "landmark_details", "area_details", "city", "pincode"));
        // try
        // {
        if ($request->default_address == 1) {
            UserAddress::where('default_address', '1')->update(['default_address' => '0']);
        }
        $address                    = new UserAddress();
        $address->user_id           = $request->user_id;
        $address->name              = $request->name;
        $address->mobile_number     = $request->mobile_number;
        $address->address_type      = $request->address_type;
        $address->default_address   = $request->default_address;
        $address->house_no          = $request->house_no;
        $address->apartment_name    = $request->apartment_name;
        $address->landmark_details  = $request->landmark_details;
        $address->area_details      = $request->area_details;
        $address->street_details    = $request->street_details;
        $address->city              = $request->city;
        $address->state             = $request->state;
        $address->country           = $request->country;
        $address->pincode           = $request->pincode;
        $address->save();

        if ($address->id) {
            $this->response = array(
                "status"    => 200,
                "message"   => ResponseMessages::getStatusCodeMessages(15),

            );
        } else {
            $this->response = array(
                "status"    => 220,
                "message"   => ResponseMessages::getStatusCodeMessages(220),
            );
        }
        // } catch (\Exception $ex) {
        //     $this->response = array(
        //         "status" => 501,
        //         "message" => ResponseMessages::getStatusCodeMessages(501),
        //     );
        // }
        $this->shut_down();
    }
    public function updateAddress(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("id", "name", "mobile_number", "address_type", "default_address", "house_no", "apartment_name", "street_details", "landmark_details", "area_details", "city", "pincode"));
        try
        {
            if ($request->default_address == 1) {
                UserAddress::where('default_address', '1')->update(['default_address' => '0']);
            }
            $address                    = UserAddress::where(['id' => $request->id, 'status' => 'AC'])->first();
            $address->name              = $request->name;
            $address->mobile_number     = $request->mobile_number;
            $address->address_type      = $request->address_type;
            $address->default_address   = $request->default_address;
            $address->house_no          = $request->house_no;
            $address->apartment_name    = $request->apartment_name;
            $address->landmark_details  = $request->landmark_details;
            $address->area_details      = $request->area_details;
            $address->city              = $request->city;
            $address->state             = $request->state;
            $address->country           = $request->country;
            $address->pincode           = $request->pincode;
            $address->street_details    = $request->street_details;

            $address->save();
            if ($address->id) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(16),

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function rescheduleOrderItem(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("cart_id", "order_delivery_id", 'date'));
        try
        {
            if (OrderDelivery::where(['id' => $request->order_delivery_id, 'status' => 'AC'])->update(['status' => 'IN'])) {
                $date = date('Y-m-d', strtotime($request->date));
                Cart::where(['id' => $request->cart_id])->update(['to_date' => $date]);
                $OrderDelivery              = new OrderDelivery();
                $OrderDelivery->order_date  = $date;
                $OrderDelivery->cart_id     = $request->cart_id;
                $OrderDelivery->save();
                $orderdelivery              = OrderDelivery::select('id', 'cart_id', 'order_date', 'status', DB::raw("IF (status = 'AC','True','False') as IsVisible"))->where(['cart_id' => $request->cart_id, "status" => "AC"])->get();
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $orderdelivery,

                );
            } else {
                $this->response = array(
                    "status" => 37,
                    "message" => ResponseMessages::getStatusCodeMessages(37),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function setDefaultAddress(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("address_id", "user_id"));
        try
        {
            // DB::enableQueryLog();
            UserAddress::where('user_id', $request->user_id)->update(['default_address' => '0']);
            UserAddress::where('id', $request->address_id)->update(['default_address' => '1']);

            $address = UserAddress::select('id', 'name', 'mobile_number', 'address_type', 'default_address', 'house_no', 'street_details', 'apartment_name', 'landmark_details', 'area_details', 'city', 'state', 'country', 'pincode', DB::raw("CONCAT_WS(', ',house_no, apartment_name, street_details, landmark_details, area_details, city, state,country,country, pincode) as full_address"))->where(['user_id' => $request->user_id, 'status' => 'AC'])->get();
            //$address->save();
            //print_r(DB::getQueryLog());
            if ($address->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(16),
                    "data" => $address,

                );
            } else {
                $this->response = array(
                    "status" => 31,
                    "message" => ResponseMessages::getStatusCodeMessages(31),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function deleteAddress(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("address_id"));
        try
        {
            $address = UserAddress::where(['id' => $request->address_id, 'status' => 'AC'])->first();
            $address->status = 'IN';
            $address->save();
            if ($address->id) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(17),

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getOrders(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $orders     = Order::select('cart.id as cart_id', 'cart.from_date', 'cart.to_date', 'cart.total_with_tax as item_total', 'orders.id', 'products.name as product_name', 'brands.name as brand_name')
                ->join('cart', 'cart.order_id', '=', 'orders.id')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->where(['orders.user_id' => $request->user_id, 'orders.status' => 'AC'])->get();
            if ($orders->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $orders,

                );
            } else {
                $this->response = array(
                    "status" => 22,
                    "message" => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function createNotification(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "title", "description", "notification_type"));
        try
        {
            $notification                       = new Notification();
            $notification->user_id              = $request->user_id;
            $notification->title                = $request->title;
            $notification->description          = $request->description;
            $notification->notification_type    = $request->notification_type;
            $notification->save();

            if ($notification->id) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(18),

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getNotification(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $notifications = Notification::select('title', 'description', 'notification_type')->where(['user_id' => $request->user_id, 'status' => 'AC'])->get();

            if ($notifications) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    'data' => $notifications,

                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function addFavouriteProduct(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "product_id"));
        try
        {
            $status = 1;
            if ($favouriteproduct   = FavouriteProduct::where(['user_id' => $request->user_id, 'product_id' => $request->product_id, 'status' => 'AC'])->first()) {
                $favouriteproduct->status = 'IN';
                $favouriteproduct->save();
                $status = 0;
            } else {
                $favouriteproduct               = new FavouriteProduct();
                $favouriteproduct->user_id      = $request->user_id;
                $favouriteproduct->product_id   = $request->product_id;
                $favouriteproduct->save();
            }
            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
            if ($favouriteproduct->id) {
                if ($status == 1) {
                    $this->response = array(
                        "status" => 200,
                        "favourite_status" => $status,
                        "message" => ResponseMessages::getStatusCodeMessages(19),
                        "fav_count" => $favouritecount,
                    );
                } else {
                    $this->response = array(
                        "status" => 200,
                        "favourite_status" => $status,
                        "message" => ResponseMessages::getStatusCodeMessages(24),
                        "fav_count" => $favouritecount,
                    );
                }
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                    "fav_count" => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getFavouriteProduct(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
                $favouriteproducts = FavouriteProduct::select('products.id', 'products.name as product_name', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'brands.name as brand_name', 'products.price')
                    ->where('products.status','AC')
                    ->join('products', 'favourite_products.product_id', '=', 'products.id')
                    ->join('brands', 'brands.id', '=', 'products.brand_id')->where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->orderBy('products.name')->get();

            $favouritecount     = count($favouriteproducts)FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
            if ($favouriteproducts->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $favouriteproducts,
                    'fav_count' => $favouritecount,

                );
            } else {
                $this->response = array(
                    "status"    => 27,
                    "message"   => ResponseMessages::getStatusCodeMessages(27),
                    "fav_count" => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function deleteFavouriteProduct(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id", "product_id"));
        try
        {
            $favouriteproduct     = FavouriteProduct::where(['user_id' => $request->user_id, 'product_id' => $request->product_id, 'status' => 'AC'])->first();

            if ($favouriteproduct) {
                $favouriteproduct->status = 'IN';
                $favouriteproduct->save();
                $favouriteproducts = FavouriteProduct::select('products.id', 'products.name as product_name', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'brands.name as brand_name', 'products.price')->join('products', 'favourite_products.product_id', '=', 'products.id')
                    ->join('brands', 'brands.id', '=', 'products.brand_id')->where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->get();

                $favouritecount     = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
                $this->response     = array(
                    "status"        => 200,
                    "message"       => ResponseMessages::getStatusCodeMessages(26),
                    'data'          => $favouriteproducts,
                    'fav_count'     => $favouritecount,

                );
            } else {
                $favouritecount     = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
                $this->response     = array(
                    "status"        => 27,
                    "message"       => ResponseMessages::getStatusCodeMessages(27),
                    "fav_count"     => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response     = array(
                "status"        => 501,
                "message"       => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getFaqs(Request $request) {
        // $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $faqQuestion = FAQQuestion::select('question', 'answer')->where('status', 'AC')->get();

            if ($faqQuestion->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $faqQuestion,
                );
            } else {
                $this->response = array(
                    "status"    => 32,
                    "message"   => ResponseMessages::getStatusCodeMessages(32),
                );
            }
        } catch (\Exception $ex) {
            $this->response     = array(
                "status"        => 501,
                "message"       => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getSliders(Request $request) {
        // $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $Sliders = Slider::select('id', DB::raw("CONCAT('" . url("uploads/sliders") . "/', image) image"))->where('status', 'AC')->get();
            $usercartcount  = 0;
            $favouritecount = 0;
            if (isset($request->user_id)) {

                $usercartcount  = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
                $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();
            }
            if ($Sliders->count() > 0) {
                $this->response = array(
                    "status"     => 200,
                    "message"    => ResponseMessages::getStatusCodeMessages(200),
                    'data'       => $Sliders,
                    "fav_count"  => $favouritecount,
                    "cart_count" => $usercartcount,
                );
            } else {
                $this->response = array(
                    "status"     => 38,
                    "message"    => ResponseMessages::getStatusCodeMessages(38),
                    "fav_count"  => $favouritecount,
                    "cart_count" => $usercartcount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getReasons(Request $request) {
        // $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            $faqQuestion = DeliveryReason::select('id', 'reason')->where('status', 'AC')->get();

            if ($faqQuestion->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $faqQuestion,
                );
            } else {
                $this->response = array(
                    "status"    => 33,
                    "message"   => ResponseMessages::getStatusCodeMessages(33),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getOrderDelivery(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("cart_id", 'status'));
        try
        {
            if ($request->status == "completed") {
                $orderdelivery  = OrderDelivery::select('id', 'cart_id', 'order_date', 'status', DB::raw("IF (status = 'AC','True','False') as IsVisible"))->where(['cart_id' => $request->cart_id])->whereIn("status", array("CM", "FL", "CL"))->get();
            } else {
                $orderdelivery = OrderDelivery::select('id', 'cart_id', 'order_date', 'status', DB::raw("IF (status = 'AC','True','False') as IsVisible"))->where(['cart_id' => $request->cart_id, "status" => "AC"])->get();
            }

            if ($orderdelivery->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $orderdelivery,
                );
            } else {
                $this->response = array(
                    "status"    => 22,
                    "message"   => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response     = array(
                "status"        => 501,
                "message"       => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getCurrentdateOrders(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            // DB::enableQueryLog();
            // $upcoming_orders = Order::select('orders.order_code','orders.id as order_id','user_addresses.name','orders.cost as order_total',DB::raw('group_concat(products.name) as names'),DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state, user_addresses.pincode) as full_address"))
            // ->join('cart','cart.order_id','=','orders.id')
            // ->join('products','cart.product_id','=','products.id')
            // ->join('brands','products.brand_id','=','brands.id')
            // ->join('user_addresses','orders.address_id','=','user_addresses.id')
            // ->where(['orders.driver_id' => $request->user_id, 'orders.status' => 'CM','cart.status' => 'CM'])->whereDate('cart.from_date','<=' ,DB::raw('CURDATE()'))->whereDate('cart.to_date','>=' ,DB::raw('CURDATE()'))->groupBy('orders.id')->get();

            $upcoming_orders    = Order::select('orders.order_code', 'orders.delivery_status', 'orders.id as order_id', 'user_addresses.name',
                'user_addresses.mobile_number', 'orders.cost as order_total', DB::raw('group_concat(products.name) as names'), DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state, user_addresses.country, user_addresses.pincode) as full_address"))
                ->join('cart', 'cart.order_id', '=', 'orders.id')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
                ->where(['orders.driver_id' => $request->user_id, 'orders.status' => 'CM', 'cart.status' => 'CM',"orders.delivery_status"=>"Pending"])
                ->groupBy('orders.id')->get();
            //    print_r(DB::getQueryLog());
            if ($upcoming_orders->count() > 0) {
                $this->response     = array(
                    "status"        => 200,
                    "message"       => ResponseMessages::getStatusCodeMessages(200),
                    'data'          => $upcoming_orders,
                );
            } else {
                $this->response     = array(
                    "status"        => 22,
                    "message"       => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function completedOrders(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {

            $upcoming_orders = Order::select('orders.order_code', 'orders.delivery_status', 'orders.id as order_id', 'user_addresses.mobile_number', 'user_addresses.name', 'orders.cost as order_total', DB::raw('group_concat(products.name) as names'), DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state, user_addresses.country, user_addresses.pincode) as full_address"))
                ->join('cart', 'cart.order_id', '=', 'orders.id')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
                ->where(['orders.driver_id' => $request->user_id, 'orders.status' => 'CM', 'cart.status' => 'CM'])
                ->whereIn("orders.delivery_status",["Delivered","Failed"])->groupBy('orders.id')->get();
            if ($upcoming_orders->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $upcoming_orders,
                );
            } else {
                $this->response = array(
                    "status"    => 22,
                    "message"   => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getPastOrders(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        // try
        // {
        // DB::enableQueryLog();

        $upcoming_orders = Order::select('product_variations.weight', 'product_units.name as unit_name', 'product_units.h_name as h_unit_name', 'orders.order_code','orders.delivery_status', 'orders.status as order_status',
            DB::raw("(Case
                        When orders.status = 'PN' Then 'Pending'
                        When orders.status = 'CM' Then 'Completed'
                        When orders.status = 'FL' Then 'Failed'
                        When orders.status = 'CL' Then 'Canceled'
                        End) as order_status"), 'orders.cost as order_total', 'cart.id as cart_id', 'cart.from_date', 'cart.total_without_tax', 'cart.total_with_tax', 'cart.to_date', 'products.name as product_name', 'products.h_name as h_product_name', 'cart.product_id', 'cart.product_variation_id', 'cart.quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'brands.name as brand_name', DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state,user_addresses.country, user_addresses.pincode) as full_address"))
            ->join('cart', 'cart.order_id', '=', 'orders.id')
            ->join('products', 'cart.product_id', '=', 'products.id')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('product_variations', 'product_variations.id', '=', 'cart.product_variation_id')
            ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')
            ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
            ->where(['orders.user_id' => $request->user_id])->whereIn('orders.status', array('CM', 'CL'))->where('orders.delivery_status',"!=" ,'Pending')->whereIn('cart.status', array('CM', 'CL'))->orderBy('orders.id', 'desc')->get();
        // print_r(DB::getQueryLog());
        if ($upcoming_orders->count() > 0) {
            $this->response = array(
                "status"    => 200,
                "message"   => ResponseMessages::getStatusCodeMessages(200),
                'data'      => $upcoming_orders,
            );
        } else {
            $this->response = array(
                "status"    => 22,
                "message"   => ResponseMessages::getStatusCodeMessages(22),
            );
        }
        // } catch (\Exception $ex) {
        //     $this->response = array(
        //         "status" => 501,
        //         "message" => ResponseMessages::getStatusCodeMessages(501),
        //     );
        // }
        $this->shut_down();
    }
    public function getUpcomingOrders(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try
        {
            // DB::enableQueryLog();

            // $upcoming_orders = Order::select('orders.*')->with(['cartitem_upcoming'=>function($q){
            //    $q->with(['product_items'=>function($q){
            //        $q->select('id','name','brand_id', DB::raw("CONCAT('" . url("uploads/products") . "/', image) image"));
            //        $q->with('product_brand');

            //    }]);
            // },'useraddress'])->join('cart','cart.order_id','=','orders.id')->where(['orders.user_id' => $request->user_id, 'orders.status' => 'CM','cart.status' => 'CM'])->whereDate('cart.to_date','>' ,DB::raw('CURDATE()'))->groupBy('orders.id')->get();
            //
            $upcoming_orders = Order::select('product_variations.weight', 'product_units.name as unit_name', 'product_units.h_name as h_unit_name', 'orders.order_code','orders.delivery_status', 'orders.status as order_status',
                DB::raw("(Case
                        When orders.status = 'PN' Then 'Pending'
                        When orders.status = 'CM' Then 'Completed'
                        When orders.status = 'FL' Then 'Failed'
                        When orders.status = 'CL' Then 'Canceled'
                        End) as order_status"), 'orders.cost as order_total', 'cart.id as cart_id', 'cart.from_date', 'cart.total_without_tax', 'cart.total_with_tax', 'cart.to_date', 'products.name as product_name', 'products.h_name as h_product_name', 'cart.product_id', 'cart.product_variation_id', 'cart.quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'brands.name as brand_name', DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state,user_addresses.country, user_addresses.pincode) as full_address"))
                ->join('cart', 'cart.order_id', '=', 'orders.id')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('brands', 'products.brand_id', '=', 'brands.id')
                ->join('product_variations', 'product_variations.id', '=', 'cart.product_variation_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')
                ->join('user_addresses', 'orders.address_id', '=', 'user_addresses.id')
                ->where(['orders.user_id' => $request->user_id, 'orders.status' => 'CM', 'cart.status' => 'CM'])->where('orders.delivery_status','Pending')->orderBy('orders.id', 'desc')->get();
            //   print_r(DB::getQueryLog());
            //   die;
            if ($upcoming_orders->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $upcoming_orders,
                );
            } else {
                $this->response = array(
                    "status"    => 22,
                    "message"   => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function getOrderDetails(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("order_id", "type"));
        try
        {
            //DB::enableQueryLog();

            //  $orders = Order::select('cart.id as cart_id', 'cart.from_date', 'cart.to_date', 'cart.total_with_tax as item_total', 'orders.id', 'products.name as product_name', 'brands.name as brand_name')
            //  ->join('cart', 'cart.order_id', '=', 'orders.id')
            //  ->join('products', 'cart.product_id', '=', 'products.id')
            //  ->join('brands', 'brands.id', '=', 'products.brand_id')
            //  ->where(['orders.id' => $request->order_id, 'orders.status' => 'CM'])->get();

            $orders = Cart::select('cart.id', "order_delivery.id as order_delivery_id", "orders.delivery_status", 'cart.product_id', 'cart.quantity', 'cart.scheduled', 'cart.from_date', 'cart.to_date', DB::raw("(cart.cgst+cart.sgst) as gst"), DB::raw("(products.cgst+products.sgst) as product_gst"), 'products.igst as product_igst', 'cart.total_without_tax', 'cart.total_with_tax', 'products.name as product_name', 'products.quantity as product_quantity', DB::raw("CONCAT('" . url("uploads/products") . "/', products.image) image"), 'product_variations.weight', 'brands.name as brand_name', 'product_units.name as unit_name', 'product_units.code as unit_code')
                ->join('products', 'cart.product_id', '=', 'products.id')
                ->join('product_variations', 'cart.product_variation_id', '=', 'product_variations.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('product_units', 'product_units.id', '=', 'product_variations.unit_id')
                ->join('orders', 'orders.id', '=', 'cart.order_id')
                ->join("order_delivery", "order_delivery.cart_id", "=", "cart.id")
                ->where('orders.id', $request->order_id)->where('cart.status', 'CM')->where('orders.status', 'CM');
            $visible = false;
            $delivery_status = "Pending";
            if ($order = Order::select("delivery_status")->where("id", $request->order_id)->first()) {
                $delivery_status = $order->delivery_status;
            }
            if ($request->type == "completed") {
                $visible = false;

                $orders = $orders->addSelect(DB::raw("'false' as visible"))
                ->whereIn("orders.delivery_status",["Delivered","Failed"])
                ->groupBy("cart.product_id")->get();
                // $orders = $orders->whereDate('cart.to_date','<' ,DB::raw('CURDATE()'))->groupBy("cart.id")->get();
            } else {
                $visible = true;
                //$orders = $orders->whereRaw("(select count(1) from order_delivery where order_delivery.cart_id=cart.id and order_delivery.status='AC' and order_delivery.order_date=CURDATE()) > 0")->get();
                $orders = $orders->addSelect(DB::raw("'true' as visible"));
                $orders = $orders->where("order_delivery.status", "AC")->get();
            }
            //  print_r(DB::getQueryLog());

            if ($orders->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'visible'   => $visible,
                    "delivery_status" => $delivery_status,
                    'data' => $orders,
                );
            } else {
                $this->response = array(
                    "status"    => 22,
                    "message"   => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function deliveryStatus(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("order_delivery_id", 'status'));
        // try
        // {
            if ($order = Order::where(['id' => $request->order_delivery_id, 'delivery_status' => 'Pending'])->first()) {
                //$cartdata = Cart::where("id", $order->cart_id)->first();
                $orderdata = Order::where("id", $request->order_delivery_id)->first();
                $user = User::where("id", $order->user_id)->first();
                if ($request->status == "Delivered") {
                    $order->delivery_status = $request->status;
                    $notification = new Notification();
                    $notification->user_id = $order->user_id;
                    $notification->order_id = $order->id;
                    $notification->notification_type = "Order Status";
                    $notification->title = 'Order Completed';
                    $notification->description = "You have Completed a new #" . $orderdata->order_code . " order";
                    $notification->save();
                    $msgarray = array(
                        'title' => 'Order Completed',
                        'msg' => "Your Order #" . $orderdata->order_code . " has been delivered",
                        'type' => 'OrderCompleted',
                    );
                    $fcmData = array(
                        'message' => $msgarray['msg'],
                        'body' => $msgarray['title'],
                    );
                    $this->sendFirebaseNotification($user, $msgarray, $fcmData);
                } else {
                    //$order->status = $request->status;
                    $order->delivery_status = $request->status;
//                     $order->reason_id = $request->reason_id;
                    $notification = new Notification();
                    $notification->user_id = $order->user_id;
                    $notification->order_id = $order->order_id;
                    $notification->notification_type = "Order Status";
                    $notification->title = 'Order Failled';
                    $notification->description = "Your Order #" . $orderdata->order_code . " undelivered";
                    $notification->save();

                    $msgarray = array(
                        'title' => 'Order Failed',
                        'msg'   => "Your Order #" . $orderdata->order_code . " undelivered",
                        'type'  => 'OrderFailed',
                    );
                    $fcmData = array(
                        'message'   => $msgarray['msg'],
                        'body'      => $msgarray['title'],
                    );
                    $this->sendFirebaseNotification($user, $msgarray, $fcmData);
                }
                $order->save();
                if ($order->count() > 0) {
                    $this->response = array(
                        "status"    => 200,
                        "message"   => ResponseMessages::getStatusCodeMessages(20),

                    );
                } else {
                    $this->response = array(
                        "status"    => 22,
                        "message"   => ResponseMessages::getStatusCodeMessages(22),
                    );
                }
            } else {
                $this->response = array(
                    "status"    => 22,
                    "message"   => ResponseMessages::getStatusCodeMessages(22),
                );
            }
        // } catch (\Exception $ex) {
        //     $this->response = array(
        //         "status" => 501,
        //         "message" => ResponseMessages::getStatusCodeMessages(501),
        //     );
        // }
        $this->shut_down();
    }
    public function updateDate(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("cart_id", 'type', 'date', 'user_id'));
        try
        {
            $date = date("Y-m-d", strtotime($request->date));
            if ($order = Cart::where(['id' => $request->cart_id])->update([$request->type => $date])) {
                $allcartitem = Cart::where(['user_id' => $request->user_id, 'status' => 'AC'])->get();
                foreach ($allcartitem as $item) {
                    $productvariation = ProductVariation::find($item->product_variation_id);
                    $product = Product::find($item->product_id);
                    $cart_item = Cart::find($item->id);

                    $from = \Carbon\Carbon::parse($cart_item->from_date);
                    $to = \Carbon\Carbon::parse($date);
                    $days = $to->diffInDays($from);
                    //$daysCart = $days+1;
                    $daysCart = 1;

                    $cart_item->sgst = (($item->quantity * $productvariation->price * $daysCart) * $product->sgst) / 100;
                    $cart_item->cgst = (($item->quantity * $productvariation->price * $daysCart) * $product->cgst) / 100;
                    $cart_item->igst = (($item->quantity * $productvariation->price * $daysCart) * $product->igst) / 100;
                    $cart_item->total_without_tax = $item->quantity * $productvariation->price * $daysCart;
                    $cart_item->total_with_tax = ($cart_item->total_without_tax + $cart_item->sgst + $cart_item->cgst);
                    //dd($cart_item);
                    // echo $cart_item->from_date;
                    // echo "-1-";
                    // echo $cart_item->to_date;
                    if (($cart_item->from_date) < ($cart_item->to_date)) {
                        // $from = \Carbon\Carbon::parse($cart_item->from_date);
                        // $to = \Carbon\Carbon::parse($cart_item->to_date);
                        // echo $days = $to->diffInDays($from);
                        if ($days) {
                            OrderDelivery::where("cart_id", $cart_item->id)->delete();
                            for ($i = 0; $i <= $days; $i++) {
                                if ($i) {
                                    $day = 1;
                                } else {
                                    $day = 0;
                                }
                                $orderdeliver = new OrderDelivery();
                                $newDate = $from->addDays($day);
                                $orderdeliver->cart_id = $cart_item->id;
                                $orderdeliver->order_date = $newDate;
                                $orderdeliver->save();
                            }
                        } else {
                            OrderDelivery::where("cart_id", $cart_item->id)->delete();
                            $newDate = $from->addDays(0);
                            $orderdeliver = new OrderDelivery();
                            $orderdeliver->cart_id = $cart_item->id;
                            $orderdeliver->order_date = $newDate;
                            $orderdeliver->save();
                        }
                    } else {
                        $from = \Carbon\Carbon::parse($cart_item->from_date);
                        $to = \Carbon\Carbon::parse($cart_item->to_date);
                        OrderDelivery::where("cart_id", $cart_item->id)->delete();
                        $newDate = $from->addDays(0);
                        $orderdeliver = new OrderDelivery();
                        $orderdeliver->cart_id = $cart_item->id;
                        $orderdeliver->order_date = $newDate;
                        $orderdeliver->save();
                    }
                    $cart_item->save();
                }

                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(35),

                );

            } else {
                $this->response = array(
                    "status"    => 36,
                    "message"   => ResponseMessages::getStatusCodeMessages(36),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }
    public function undeliverOrder(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("order_id", "reason"));
        try
        {
            $order = Order::where(['id' => $request->order_id, 'status' => 'AC'])->first();
            $order->status = 'CM';
            $address->save();
            if ($order->id) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(20),

                );
            } else {
                $this->response = array(
                    "status"    => 220,
                    "message"   => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    public function getAreas(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("city_id"));
        try
        {
            $Location = Location::select('id', 'name')->where(['city_id' => $request->city_id, 'status' => 'AC'])->get();

            if ($Location) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    'data'      => $Location,
                );
            } else {
                $this->response = array(
                    "status"    => 220,
                    "message"   => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    public function getLocations(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("prnt_id"));
        try
        {
            $Location = Location::select('id', 'name')->where(['prnt_id' => $request->prnt_id, 'status' => 'AC'])->get();

            if ($Location) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    'data' => $Location,
                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    public function uploadFile(Request $request) {
        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/profiles/', $filename);
        }

        $this->shut_down();

    }
    // function called to update user/driver profile
    public function updateProfile(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try {
            // cehck user exist or not
            if ($user = User::find($request->user_id)) {
                $filename = "";
                // check profile_picture key exist or not
                if ($request->hasfile('profile_picture')) {
                    $file = $request->file('profile_picture');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/profiles/', $filename);
                }
                if ($request->name) {
                    $user->name = $request->name;
                }
                if ($request->email) {
                    $validate = Validator($request->all(), [
                        'email' => 'required|email',

                    ]);
                    if (!$validate->fails()) {
                        $user->email = $request->email;
                    } else {
                        $this->response = array(
                            "status" => 40,
                            "message" => ResponseMessages::getStatusCodeMessages(40),
                        );

                    }
                }

                if ($filename != "") {
                    $user->profile_picture = $filename;
                }
                $user->save();
                //Flo DB::enableQueryLog();
                $userData = User::select("users.*", 'user_addresses.address_type', DB::raw("COALESCE((select ROUND(AVG(ratings.rating)) from ratings where parent_id = users.id),0) as rating"), DB::raw("CONCAT('" . url("uploads/profiles") . "/', profile_picture) profile_picture"), DB::raw("CONCAT_WS(', ',user_addresses.house_no, user_addresses.apartment_name, user_addresses.street_details, user_addresses.landmark_details, user_addresses.area_details, user_addresses.city, user_addresses.state,user_addresses.country, user_addresses.pincode) as full_address"))
                    ->leftjoin('user_addresses', 'users.id', '=', 'user_addresses.user_id')->where("users.id", $request->user_id)->first();
                // print_r(DB::getQueryLog());

                $useraddress = UserAddress::select(DB::raw("CONCAT_WS(', ',house_no, apartment_name, street_details, landmark_details, area_details, city, state,country, pincode) as full_address"), 'mobile_number')->where(['user_id' => $request->user_id, 'default_address' => 1])->first();
                // print_r(DB::getQueryLog());
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(119),
                    //'refer_message' => $this->getReferMessage($request->user_id),
                    "data" => $userData,
                    'user_address' => $useraddress,
                );
            } else {
                $this->response = array(
                    "status" => 214,
                    "message" => ResponseMessages::getStatusCodeMessages(214),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    public function updateDeviceToken(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("user_id", "device_token"));
        try {
            // cehck user exist or not
            if ($user = User::find($request->user_id)) {
                $user->device_token = $request->device_token;
                $user->save();
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(39),
                );
            } else {
                $this->response = array(
                    "status" => 214,
                    "message" => ResponseMessages::getStatusCodeMessages(214),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to get country list
    public function countryList() {
        try {
            // get country
            $CountryStates = Country::select("id", "name")->get();
            if ($CountryStates->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    "data"      => $CountryStates,
                );
            } else {
                $this->response = array(
                    "status"    => 219,
                    "message"   => ResponseMessages::getStatusCodeMessages(219),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to get state list
    public function stateList(Request $request) {
        try {
            // check keys are exist
            $this->checkKeys(array_keys($request->all()), array("country_id"));
            // get state list based on country
            $CountryStates = State::select("id", "name")->where("country_id", $request->country_id)->get();
            if ($CountryStates->count() > 0) {
                $this->response = array(
                    "status"    => 200,
                    "message"   => ResponseMessages::getStatusCodeMessages(200),
                    "data"      => $CountryStates,
                );
            } else {
                $this->response = array(
                    "status"    => 219,
                    "message"   => ResponseMessages::getStatusCodeMessages(219),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to get city list
    public function cityList(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("state_id"));
        try {
            // get city list based on state
            $StateCities = City::select("id", "name")->where(["state_id" => $request->state_id, 'status' => 'AC'])->orderBy('name','ASC')->get();
            if ($StateCities->count() > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "data" => $StateCities,
                );
            } else {
                $this->response = array(
                    "status" => 220,
                    "message" => ResponseMessages::getStatusCodeMessages(220),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to change password
    public function changePassword(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("user_id", "password", "new_password"));
        try {
            // check single signon of driver
            //$this->checkSingleSignOn($request->user_id, $request->device_id);
            // check user id or password correct or not
            if (Auth::attempt(["id" => $request->user_id, "password" => $request->password])) {
                // check password is not same as old password that is in DB
                if (!Hash::check($request->new_password, Auth::user()->password)) {
                    Auth::user()->update(["password" => bcrypt($request->new_password)]);
                    $this->response = array(
                        "status" => 200,
                        "message" => ResponseMessages::getStatusCodeMessages(29),
                    );
                } else {
                    $this->response = array(
                        "status" => 324,
                        "message" => ResponseMessages::getStatusCodeMessages(324),
                    );
                }
            } else {
                $this->response = array(
                    "status" => 215,
                    "message" => ResponseMessages::getStatusCodeMessages(215),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to update password
    public function updatePassword(Request $request) {
        date_default_timezone_set("Asia/Kolkata");
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("mobile_number", "password", "re_password"));
        try {
            // password should be same as repeat password
            if ($request->password == $request->re_password) {
                // check mobile number exist or not
                if ($user = User::where(["mobile_number" => $request->mobile_number])->first()) {
                    // password has not same as old password
                    if (!Hash::check($request->password, $user->password)) {
                        $user->update(["password" => bcrypt($request->password)]);
                        $this->response = array(
                            "status" => 200,
                            "message" => ResponseMessages::getStatusCodeMessages(240),
                        );
                    } else {
                        $this->response = array(
                            "status" => 324,
                            "message" => ResponseMessages::getStatusCodeMessages(324),
                        );
                    }
                } else {
                    $this->response = array(
                        "status" => 239,
                        "message" => ResponseMessages::getStatusCodeMessages(239),
                    );
                }
            } else {
                $this->response = array(
                    "status" => 238,
                    "message" => ResponseMessages::getStatusCodeMessages(238),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to logout user
    public function logout(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try {
            // check user exist or not
            if ($user = User::find($request->user_id)) {
                //$user->is_visible = 0;
                $user->device_token = "";
                $user->save();
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                );
            } else {
                $this->response = array(
                    "status" => 214,
                    "message" => ResponseMessages::getStatusCodeMessages(214),
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        $this->shut_down();
    }

    // function called to get user detail
    public function getUserDetail(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("user_id", "user_type", "device_id"));
        try {
            // check user active or not
            $this->checkUserActive($request->user_id);
            if ($request->user_type == "driver") {
                // check single signon of driver
                $this->checkSingleSignOn($request->user_id, $request->device_id);
            }
            // check user exist or not
            if ($user = User::find($request->user_id)) {
                $driver_status = "";
                $booking_detail = "";
                // get users last booking
                $last_booking = $this->getLastBooking($request->user_id, $request->user_type);
                // get application information data like app version
                $app_info = $this->getAppInfo();
                // check user type is user
                if ($request->user_type == "user") {
                    // get driver status
                    $driver_status = $this->driverStatus($request->user_id, "user");
                    // get user status
                    $user_status = $this->userStatus($request->user_id);
                } else {
                    // get driver status
                    $driver_status = $this->userStatus($request->user_id);
                    // get user status
                    $user_status = $this->driverStatus($request->user_id, "driver");
                    // get booking detail
                    $booking_detail = $this->bookingDetail($request->user_id);
                }
                $this->response = array(
                    "status"        => 200,
                    "message"       => ResponseMessages::getStatusCodeMessages(200),
                    "user_detail"   => $user_status,
                    "driver_detail" => $driver_status,
                    "last_booking"  => $last_booking,
                    "booking_detail" => $booking_detail,
                    "app_info"      => $app_info,
                    'refer_message' => $this->getReferMessage($request->user_id),
                );
            } else {
                $this->response = array(
                    "status"    => 214,
                    "message"   => ResponseMessages::getStatusCodeMessages(214),
                    "data"      => $user,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"    => 501,
                "message"   => ResponseMessages::getStatusCodeMessages(501),
            );
        }

        //$this->shut_down();
    }

    // function called to count cart items for user
    public function getCartCount(Request $request) {
        $this->checkKeys(array_keys($request->all()), array("user_id"));
        try {
            $usercartcount = Cart::where('cart.user_id', $request->user_id)->where('cart.status', 'AC')->count();
            $favouritecount = FavouriteProduct::where('favourite_products.user_id', $request->user_id)->where('favourite_products.status', 'AC')->count();

            if ($usercartcount > 0) {
                $this->response = array(
                    "status" => 200,
                    "message" => ResponseMessages::getStatusCodeMessages(200),
                    "cart_count" => $usercartcount,
                    "fav_count" => $favouritecount,

                );
            } else {
                $this->response = array(
                    "status" => 23,
                    "message" => ResponseMessages::getStatusCodeMessages(23),
                    'cart_count' => $usercartcount,
                    "fav_count" => $favouritecount,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
                "message" => ResponseMessages::getStatusCodeMessages(501),
            );
        }
        $this->shut_down();
    }

    // function called to add errorlog
    public function addErrorLog(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("method_name", "error", "exception_error"));
        try {
            // check mobile number exist or not
            $log = $this->addErrorLogEntry($request->method_name, $request->error, $request->exception_error);
            echo $log;
            if ($log > 0) {
                $this->response = array(
                    "status" => 200,
                );
            } else {
                $this->response = array(
                    "status" => 200,
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status" => 501,
            );
        }
        $this->shut_down();
    }

    public function verifyPhoneNumber(Request $request){
		try {
			$phone = substr($request->phone,-9);
            // check mobile number exist or not
            $user = User::where("mobile_number",$phone)->first();
            if (isset($user)) {
	            $user->is_verified = "1";
	            $user->save();
                $this->response = array(
                    "status"    => 200,
                );
            } else {
                $this->response = array(
                    "status"    => 202,
                    "message"   => "Mobile number does not exist"
                );
            }
        } catch (\Exception $ex) {
            $this->response = array(
                "status"        => 501,
                "message"       => "Something went wrong"
            );
        }
        $this->shut_down();
    }


    public function phoneRegister(Request $request) {
        // check keys are exist
        $this->checkKeys(array_keys($request->all()), array("email","mobile"));
        try {
			$mobile = substr($request->mobile,-9);
        	// check email exists or not
	        if ($user = User::where("email", $request->email)->first()) {
		        if(!$phone = User::where("mobile_number", $mobile)->first())
		        {
		            $user->mobile_number = $mobile;
		            $user->is_verified   = 1;
		            $user->save();
		            $this->response = array(
		                "status" => 200,
		                "message" => ResponseMessages::getStatusCodeMessages(332),
		            );
	            }else{
		            $this->response = array(
		                "status" => 105,
		                "message" => ResponseMessages::getStatusCodeMessages(105),
		            );
	            }
	        } else {
	            $this->response = array(
	                "status" => 321,
	                "message" => ResponseMessages::getStatusCodeMessages(321),
	            );
	        }
		} catch (\Exception $ex) {
			$this->response = array(
			"status" => 501,
			"message" => ResponseMessages::getStatusCodeMessages(501),
			);
		}
        $this->shut_down();
    }
}
