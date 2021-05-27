<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Category;
use App\Model\Product;
use App\Model\Slider;
use App\Model\Cart;
use App\Model\FAQQuestion;
use DB;
class HomeController extends Controller {
    
    public function index(Request $request) {
        $categories = Category::select("category.*")
            ->join('products', 'products.category_id', '=', 'category.id')
            ->join('product_variations', 'product_variations.product_id', '=', 'products.id')->where("category.status", "AC")
            ->where("products.status", "AC")
            ->where("product_variations.status", "AC")
            ->groupBy('category.id')
            ->get();
        
        
        $featured   = Product::active()->featured()->with('activevariations')
            ->whereHas('activevariations', function ($query) {return $query
            ->where('product_variations.status', 'AC');
            })
            ->get();
        
        $quickgrab  = Product::active()->quickgrab()
            ->whereHas('activevariations', function ($query) {return $query
            ->where('product_variations.status', 'AC');
            })
            ->get();
        
        $offered    = Product::active()->offered()
            ->whereHas('activevariations', function ($query) {return $query
            ->where('product_variations.status', 'AC');
            })
            ->get();
        
        $sliders    = Slider::active()->get();
        
        if (\Auth::check()) {
            $user_id =auth()->user()->id;
        }else{
            $user_id ='0';
        }
        
        

        return view('front.index',compact('categories','featured','quickgrab','offered','sliders'));
    }
    public function showCategory($id) {
        
        $category = Category::active()->with('activeproducts')->findOrFail($id);
        
        return view('front.category',compact('category'));
    }
    
    public function showProduct($id) {
        
        $product    = Product::active()->with('activevariations','category')->findOrFail($id);
        $suggested  = Product::active()->where('category_id',$product->category_id)->inRandomOrder()->limit(8)->get();
        return view('front.product',compact('product','suggested'));
    }
    public function showCart() {
        
        $items = Cart::where('user_id',auth()->user()->id)->whereNull('order_id')->with('variation','product')
            ->whereHas('product', function($query) {$query->where('status','AC'); })
            ->whereHas('variation', function($query) {$query->where('status','AC'); })
            ->get();
        
        return view('front.cart',compact('items'));
    }
    
    public function showFaq() {
        
        $faqs = FAQQuestion::where('status', 'AC')->get();
        
        return view('front.faq',compact('faqs'));

    }
}