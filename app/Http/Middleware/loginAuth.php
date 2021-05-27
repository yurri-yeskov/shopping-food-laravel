<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Config;
use Illuminate\Support\Facades\Session;

class loginAuth {
	//add an array of Routes to skip login check
	//protected $except_urls = ['/', '/forgot-password', '/reset-password'];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if (!Session::get('lastlogin')) {
			$request->session()->flush();
			Auth::logout();
			$request->session()->flash('error', 'Your session timeout. Please login again.');
		}
		if ((time() - Session::get('lastlogin')) > (Config::get('session.lifetime') * 60 * 1000)) {
			$request->session()->flush();
			Auth::logout();
			$request->session()->flash('error', 'Your session timeout. Please login again.');
		}
		return $next($request);
	}
}
