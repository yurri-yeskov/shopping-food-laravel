<?php

namespace App\Http\Controllers\Auth;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Library\SendMail;
use App\Model\BlockReason;
use App\Model\City;
use App\Model\Notification;
use App\Model\User;
use App\Model\UserDocument;
use App\Model\UserRole;
use App\Rules\PhoneNumber;
use DB;
use Newsletter;

class UserController extends Controller {
    public $user;
    public $city;
    public $state;

    public function __construct() {
        
        parent::__construct();
        $this->user     = new User;
        $this->city     = Session::get('globalCity');
        $this->state    = Session::get('globalState');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if (strpos($request->path(), 'user') !== false) {
            $usertype = 'user';
        }
        else {
            $usertype = 'driver';
        }
        $users     = $this->user->fetchUsers($usertype);
        $usercount = User::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');
        $totaluser = User::where('status','AC')->count();
        $totalios  = User::where('status','AC')->where('device_type','ios')->count();
        $totalandroid  = User::where('status','AC')->where('device_type','android')->count();

        Newsletter::subscribe('daghaner@gmail.com', ['FNAME'=>'Daghan Erdogdu']);

        return view('users.index', compact('users', 'usertype','usercount','totaluser','totalandroid','totalios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id = null) {
        if (strpos($request->path(), 'user') !== false) {
            $usertype = 'user';
        }else {
            $usertype = 'driver';
        }
        if (strpos($request->path(), 'edit') !== false) {
            $type = 'edit';
        } else {
            $type = 'view';
        }
        if (isset($id) && $id != null) {
            $user = User::find($id);

            if (isset($user->id)) {

                if ($user->user_role[0]->role != $usertype) {
                    return redirect()->route('view' . ucfirst($user->user_role[0]->role), ['id' => $id]);
                }

                $city = City::where('name', $user->city)->first();

                $blockReason = BlockReason::where('user_id', $user->id)->orderBy('created_at', 'desc')->limit(1)->first();
                return view('users.view', compact('user', 'city', 'blockReason', 'type'));
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->route($usertype . 's');
            }

        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route($usertype . 's');
        }
    }

    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        //block/unblock user
        if (strpos($request->path(), 'user') !== false) {
            $usertype = 'user';
        } else {
            $usertype = 'driver';
        }
        // dd($usertype);
        $user = User::find($request->post('val-id'));
        if (isset($user->id)) {
            $user->status = $request->post('val-status');
            if ($user->save()) {
                $blockData = array(
                    'user_id' => $request->post('val-id'),
                    'block_status' => $request->post('val-status'),
                    'reason' => $request->post('val-reason'),
                );
                $insert = BlockReason::insert($blockData);
                if ($insert) {
                    if ($user->status == 'AC') {

                        $request->session()->flash('success', ucfirst($user->user_role[0]->role) . ' unblocked successfully.');
                    } else {
                        SendMail::sendOrdercancelMail(ucfirst($user->user_role[0]->role) . "-" . ucfirst($user->name) . "-Local Fine Foods", $user, null, "emails.user_block", $request->post('val-reason'));
                        $request->session()->flash('success', ucfirst($user->user_role[0]->role) . ' blocked successfully.');
                    }

                    return redirect()->back();
                } else {
                    $request->session()->flash('error', 'Unable to update ' . $user->user_role[0]->role . ' status. Please try again later.');
                    return redirect()->back();
                }
            } else {
                $request->session()->flash('error', 'Unable to update ' . $user->user_role[0]->role . ' status. Please try again later.');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->route($usertype . 's');
        }

    }

    public function updateStatus(Request $request, $id = null) {
        if (strpos($request->path(), 'user') !== false) {
            $usertype = 'user';
        }else {
            $usertype = 'driver';
        }

        if (isset($id) && $id != null) {
            //update user status(verified, blocked)
            $user = User::find($id);

            if (isset($user->id)) {
                $user->status = ($request->post('val-block') == 'on') ? 'IN' : 'AC';
                // $user->is_verified = ($request->post('val-verify') == 'on') ? 1 : 0;

                if ($user->user_role[0]->role == 'driver') {
                    $user->is_verified = ($request->post('val-verify') == 'on') ? 1 : 0;
                    $user->identity_verification = ($request->post('val-idverify') == 'on') ? 1 : 0;
                    $user->vehicle_verification = ($request->post('val-vhverify') == 'on') ? 1 : 0;
                    $user->document_verification = ($request->post('val-docverify') == 'on') ? 1 : 0;
                }

                $status = ($request->post('val-block') == 'on') ? 'IN' : 'AC';
                if ($user->save()) {
                    $blockData = array(
                        'user_id' => $id,
                        'block_status' => $status,
                        'reason' => $request->post('val-msg'),
                    );
                    $insert = BlockReason::insert($blockData);
                    if ($insert) {
                        $request->session()->flash('success', ucfirst($user->user_role[0]->role) . ' updated successfully.');
                        return redirect()->back();
                    } else {
                        $request->session()->flash('error', 'Unable to update ' . $user->user_role[0]->role . '. Please try again later.');
                        return redirect()->back();
                    }
                } else {
                    $request->session()->flash('error', 'Unable to update ' . $user->user_role[0]->role . '. Please try again later.');
                    return redirect()->back();
                }
            } else {
                $request->session()->flash('error', 'Invalid Data');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->back();
        }

    }

    public function destroy($id) {
        //
    }
    public function clear(Request $request) {
        if (Notification::where('user_id', 1)->update(['status' => 'RD'])) {
            $request->session()->flash('success', 'All Notifications clear successfully');
            return redirect()->back();
        } else {
            $request->session()->flash('error', 'Invalid Data rrtyyy');
            return redirect()->back();
        }
    }

    public function deleteall(Request $request) {
        $action_match = $request->action;
        $modal = '';
        switch ($action_match) {
        case 'category':
            $modal = 'category';
            break;
        case 'apartments':
            $modal = 'locations';
            break;
        case 'areas':
            $modal = 'locations';
            break;
        case 'products':
            $modal = 'products';
            break;
        case 'product-variations':
            $modal = 'product_variations';
            break;
        case 'brands':
            $modal = 'brands';
            break;
        case 'units':
            $modal = 'product_units';
            break;
        case 'sliders':
            $modal = 'sliders';
            break;

        }

        if ($request->all_ids) {
            parse_str($request->all_ids, $allids);
            foreach ($allids['all_ids'] as $id) {
                DB::table($modal)->where('id', $id)->update(['status' => 'DL']);
                //$delete = RequestQuote::find($id);
                //$delete->deleted_at = date('Y-m-d H:i:s');
                //$delete->save();
            }

        }

        return response()->json(['status' => 'success', 'message' => 'All Selected records deleted successfully']);
    }
    // function called to change password
    public function changePassword() {
        return view("users.change_password");
    }

    public function updatePassword(Request $request, $id = null) {

        $validateData = $request->validate([
            "new_password" => 'required|min:6',
            "old_password" => 'required',
        ]);
        if ($validateData) {
            $credentials = ["email" => Auth::user()->email, "password" => $request->old_password];
            if (Auth::attempt($credentials)) {

                if ($request->new_password == $request->change_password) {
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($request->new_password);
                    $user->save();
                    $request->session()->flash("success", "Password has been changed");

                    return redirect()->route('changePassword');

                } else {

                    $request->session()->flash("error", "Password did not match");
                    return redirect()->route('changePassword');

                }
            } else {
                $request->session()->flash("error", "Incorrect old password");
                return redirect()->route('changePassword');

            }
        }
        return redirect()->route('changePassword');

    }
    
    public function changeDriverPassword() {
        return view("users.change_driver_password");
    }


    public function createDriver(Request $request) {

        if ($request->isMethod('post')) {
            $validate = Validator($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'mobile_number' => ['required', new PhoneNumber],
                'password' => 'required|min:6',
            ]);
            $validate->setAttributeNames(['name' => 'Driver Name']);
            $validate->setAttributeNames(['mobile_number' => 'Mobile Number']);
            if ($validate->fails()) {
                return redirect()->route('addnewDriver')->withInput($request->all())->withErrors($validate);
            }
            if (!User::where("mobile_number", $request->mobile_number)->first()) {

                $user = new User();
                //$user->referral_code = Helper::generateNumber("users", "referral_code");
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_number = $request->mobile_number;
                $user->password = bcrypt($request->password);
                //$user->device_id = $request->device_id;
                //$user->device_token = $request->device_token;
                //$user->device_type = $request->device_type;
                $user->state = 'Rajashan';
                $user->city = 'jaipur';
                //$user->profile_picture = $filename;
                $user->identity_verification = 1;
                $user->forgot_key = "";
                $user->is_verified = 1; // To be remove, harry
                $user->save();
                $user_role = new UserRole();
                $user_role->role_id = 3;
                $user_role->user_id = $user->id;
                $user_role->save();
                // send welcome to to driver when registered
                SendMail::sendWelcomeMail("Welcome Driver-Local Fine Foods", $user, null, "emails.driver_registration");

            } else {
                $request->session()->flash('error', 'Phone number is already used');
                return redirect()->route('addnewDriver');
            }
            $request->session()->flash('success', 'Driver added successfully');
            return redirect()->route('addnewDriver');

        }

        return view('users.addnew');

    }
    public function updateDriverPassword(Request $request, $id = null) {

        if (isset($id) && $id != null) {

            //add document to user account as Other type
            $user = User::find($id);

            $validateData = $request->validate([
                "new_password" => 'required|min:6',
                "change_password" => 'required',
            ]);
            if ($validateData) {
                if ($request->new_password == $request->change_password) {
                    $user->password = bcrypt($request->new_password);
                    $user->save();
                    $request->session()->flash("success", "Password has been changed");
                    return redirect()->back();
                } else {
                    $request->session()->flash("error", "Password did not match");
                    return redirect()->back();
                }

            }
            // return redirect()->route('drivers');
        } else {
            $request->session()->flash('error', 'Invalid Data');
            return redirect()->back();
        }

    }
}
