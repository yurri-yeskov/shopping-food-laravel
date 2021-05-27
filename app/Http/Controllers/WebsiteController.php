<?php

namespace App\Http\Controllers\Auth;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class WebsiteController extends Controller {
    public function index(Request $request) {
        
     $suburbs = DB::table('cities')->where('status','AC')
            ->orderBy('name', 'asc')
            ->get();
        
        return view('website.index',compact('suburbs'));
    }
    
    public function waitPage(Request $request) {
        return view('website.wait');
    }

}