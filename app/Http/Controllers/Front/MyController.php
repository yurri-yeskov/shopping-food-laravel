<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Order;
class MyController extends Controller {
    
    public function Account() {
        
        
        return view('front.my.account');
    }
    
    public function Favorites() {
        
        
        return view('front.my.favorites');
    }
    
    public function Orders() {
        $orders = Order::where('user_id','42')->latest()->get();
        
        return view('front.my.orders',compact('orders'));
    }
    
    public function Addresses() {
        
        
        return view('front.my.addresses');
    }
    
    
}