<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Model\Sendmail;
use App\Model\Qbtoken;
class LoginController extends Controller
{

    protected $redirectTo = '/';

    public function __construct() {
       
    }
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
           $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);
           
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'type' => 'ADMIN'])) {
                
                $loginData = array(
                    'firstname' => Auth::guard()->user()->firstname,
                    'lastname' => Auth::guard()->user()->lastname,
                    'email' => Auth::guard()->user()->email,
                    'type' => Auth::guard()->user()->type,
                    'user_image' => Auth::guard()->user()->user_image,
                    'id' => Auth::guard()->user()->id
                );
                
                 Session::push('logindata', $loginData);
                 return redirect()->route('admin-dashboard');
            }else if (Auth::guard('employee')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'type' => 'USER'])) {
                
                 $loginData = array(
                    'name' => Auth::guard('employee')->user()->name,
                    'email' => Auth::guard('employee')->user()->email,
                    'type' => Auth::guard('employee')->user()->type,
                    'user_image' => Auth::guard('employee')->user()->user_image,
                    'id' => Auth::guard('employee')->user()->id
                );
                 Session::push('logindata', $loginData);
                 return redirect()->route('employee-dashboard');
            }else{
               $request->session()->flash('session_error', 'Your username and password are wrong. Please login with correct credential...!!');
               return redirect()->route('login');
           }
        }
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('login.js');
        $data['funinit'] = array('Login.init()');
        $data['css'] = array('');
        return view('login',$data);
    }
    
    
    public function getLogout() {
        $this->resetGuard();
        return redirect()->route('login');
    }

    public function resetGuard() {
        Auth::logout();
        Auth::guard('admin')->logout();
        Auth::guard('employee')->logout();
        Session::forget('logindata');
    }
    
    
  

        public function createPassword(){
        print_r(Hash::make('123'));
    }
}
