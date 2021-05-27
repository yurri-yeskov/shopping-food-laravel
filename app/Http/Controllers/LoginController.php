<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Model\User;
use Config;
use Auth;
use Mail;
use DB;

class LoginController extends Controller
{
    public function index(Request $request)
    {
            if (Auth::check()) {
            if (Auth::user()->user_role[0]->role == 'admin') {
                $orders = Order::where("status","CM")->get();
                $completedOrder = Order::where('status', 'CM')->get();
                $pendingOrder = Order::where('status', 'AC')->get();
                $Cancelledorder = Order::where('status', 'CL')->get();
                $user = new User();
                $Product = new Product();
                $users = $user->fetchUsers('user')->take(5);
                $userCount = $user->fetchUsers('user')->count();
                $products = $Product->get_all_products();
                $products = $products->count();
                $drivers = $user->fetchUsers('driver')->take(5);
                $orders = $orders->count();
                $orderList = Order::where("status","CM")->orderBy('id','desc')->take(8)->get();
//                 dd($orderList);
                $category_count = Category::count();
                return view('dashboard')->with(['orders'=>$orders, 'users'=>$users, 'drivers'=>$drivers, 'products'=>$products, 'completedOrder'=>$completedOrder, 'pendingOrder'=>$pendingOrder,'Cancelledorder'=>$Cancelledorder,'category_count'=>$category_count,'orderList'=>$orderList,'userCount'=>$userCount ]);
            } else {
                $request->session()->flash('error', "You don't have permission to access this panel");
                return view('index');
            }
        }
        return view('index');

    }

    public function login(Request $request)
    {
        $credentials = ['email' => $request->post('val-email'), 'password' => $request->post('val-pass')];
        $udetail = User::with('user_role')->where('email', $request->post('val-email'))->first();
        if (isset($udetail->user_role) && count($udetail->user_role) > 0) {
            $remember = ($request->post('val-remember') == "on") ? true : false;
            if ($udetail->user_role[0]->role == 'admin') {
                if (Auth::attempt($credentials, $remember)) {
                    Session::put('globalCity', 'all');
                    Session::put('globalState', 'all');
                    Session::put('lastlogin', time());
                    Session::put('currency', config('constants.currency'));
                    $request->session()->flash('success', 'You are logged In.');
                    return redirect()->route('home')    ;
                } else {
                    $request->session()->flash('error', 'Fill correct credentials');
                    return redirect()->route('home');
                }
            } else {
                $request->session()->flash('error', "You don't have permission to access this panel");
                return redirect()->route('home');
            }
        } else {
            $request->session()->flash('error', 'Email ID does not exists.');
            return redirect()->route('home');
        }
    }

    public function sendPasswordMail(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('email', $request->post('val-email'))->first();
            if ($user) {
                $user->forgot_key = base64_encode($user->email);
                $user->save();
                $sender_id = Config::get('constants.MAIL_SENDER_ID');
                $data = array('resetpassword' => route('resetGet') . '?id=' . base64_encode($user->email));
                Mail::send('emails.forgot_password', $data, function ($message) use ($user, $sender_id) {
                    $message->to($user->email, $user->name)->subject('Forgot Password');
                    $message->from($sender_id, 'Local Fine Foods');
                });
                $request->session()->flash('success', 'Password Reset Link sent on your mail id.');
                return redirect()->route('home');
            } else {
                $request->session()->flash('error', 'Email ID does not exists.');
                return view('forgot');
            }
        }
        return view('forgot');
    }

    public function resetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::where('email', $request->post('val-email'))->first();
            if ($user) {
                if ($request->post('val-password') == $request->post('val-confirm-password')) {
                    $user->password = bcrypt($request->post('val-password'));
                    $user->forgot_key = "";
                    if ($user->save()) {
                        $request->session()->flash('success', 'Password changed successfully.');
                        return redirect()->route('home');
                    } else {
                        $request->session()->flash('error', 'Password not changed! Try again later.');
                        return view('reset');
                    }
                } else {
                    $request->session()->flash('error', 'Passwords do not match.');
                    return view('reset');
                }
            } else {
                $request->session()->flash('error', 'Email ID does not exists.');
                return view('reset');
            }
        }
        $id = $request->get('id');
        if (isset($id) && $id != "") {
            $user = User::where('email', base64_decode($request->get('id')))->first();

            if ($user) {
                if ($user->forgot_key != "" && $user->forgot_key == base64_encode($user->email)) {
                    $email = base64_decode($request->get('id'));
                    return view('reset', compact('email'));
                } else {
                    $request->session()->flash('error', 'Reset Link expired.');
                    return view('forgot');
                }

            } else {
                $request->session()->flash('error', 'Email ID does not exists.');
                return view('forgot');
            }
        } else {
            $request->session()->flash('error', 'Email ID does not exists.');
            return view('forgot');
        }
    }
	
	public function resetPasswordApp(Request $request) {
		if ($request->isMethod('post')) {
			$user = User::where('email', $request->post('email'))->first();

			if ($user) {

				if ($request->post('pass') == $request->post('confirm-pass')) {
					$user->password = bcrypt($request->post('pass'));
					$user->forgot_key = "";
					if ($user->save()) {
						$request->session()->flash('success', 'Password changed successfully.');
						return redirect()->route('appIndex');
					} else {
						$request->session()->flash('error', 'Password not changed! Try again later.');
						return redirect()->back();
					}
				} else {
					$request->session()->flash('error', 'Passwords do not match.');
					return redirect()->back();
				}
			} else {
				$request->session()->flash('error', 'Email ID does not exists.');
				return redirect()->back();
			}
		}
		$id = $request->get('id');
		if (isset($id) && $id != "") {
			$user = User::where('email', base64_decode($request->get('id')))->first();

			if ($user) {
				if ($user->forgot_key != "" && $user->forgot_key == base64_encode($user->email)) {
					$email = base64_decode($request->get('id'));
					$url = route('resetPostApp');
					return view('reset', compact('email', 'url'));
				} else {
					$request->session()->flash('error', 'Reset Link expired.');
					return view('forgot');
				}
			} else {
				$request->session()->flash('error', 'Email ID does not exists.');
				return view('forgot');
			}
		} else {
			$request->session()->flash('error', 'Email ID does not exists.');
			return view('forgot');
		}
	}

	public function changePassword(Request $request) {
		if ($request->isMethod('post')) {
			$user = Auth::user();

			if ($user) {

				if ($request->post('pass') == $request->post('confirm-pass')) {
					$user->password = bcrypt($request->post('pass'));
					$user->forgot_key = "";
					if ($user->save()) {
						Auth::logout();
						$request->session()->flash('success', 'Password changed successfully. Please login again.');
						return redirect('/admin');
					} else {
						$request->session()->flash('error', 'Password not changed! Try again later.');
						return view('changepassword');
					}
				} else {
					$request->session()->flash('error', 'Passwords do not match.');
					return view('changepassword');
				}
			} else {
				$request->session()->flash('error', 'Access Denied');
				return view('changepassword');
			}
		}

		if (Auth::check()) {
			$user = Auth::user();
			if ($user) {
				return view('changepassword');
			} else {
				$request->session()->flash('error', 'Access Denied');
				return redirect('/admin');
			}
		} else {
			$request->session()->flash('error', 'Access Denied');
			return redirect('/admin');
		}
	}
	public function afterAppReset(Request $request) {
		return view('app_index');
	}
}
