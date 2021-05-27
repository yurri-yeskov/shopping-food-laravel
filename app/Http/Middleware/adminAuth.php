<?php

namespace App\Http\Middleware;
use App\Model\BusRuleRef;
use App\Model\City;
use App\Model\State;
use Auth;
use Closure;
use Config;
use Session;

class adminAuth {
	public function handle($request, Closure $next) {

		if (Auth::check()) {
			if (Auth::user()->role[0]->role != 'admin') { 
				Auth::logout();
				$request->session()->flash('error', "You don't have permission to access this panel");
				return redirect()->route('index');
			}

			//update config variable for states and cities to be managed in complete admin panel
			$cities = [];
			if (Session::get('globalState') != "" && Session::get('globalState') != "all") {
				$cities = City::whereHas('state', function ($query) {
					$query->where('states.name', Session::get('globalState'));
				})->pluck('name');
			}
			$configData = [
				'states' => State::whereHas('country', function ($query) use ($request) {
					$query->where('name', 'India');
				})->pluck('name'),
				'cities' => $cities,
			];
			config(['statecity' => $configData]);

			$currency = BusRuleRef::where('rule_name', 'currency')->first()->rule_value;
			config(['constants.currency' => $currency]);
			Session::put('currency', config('constants.currency'));
		}
		if (Session::get('lastlogin') && (time() - Session::get('lastlogin')) > (Config::get('session.lifetime') * 60 * 1000)) {
			$request->session()->flush();
			Auth::logout();
			$request->session()->flash('error', 'Your session timeout. Please login again.');
		}
		return $next($request);
	}
}
