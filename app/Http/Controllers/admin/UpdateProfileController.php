<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use Auth;
use Session;
use route;
use config;

class UpdateProfileController extends Controller {

    public function __construct() {
        
    }

    public function editProfile(Request $request) {

        $data['detail'] = $request->session()->get('logindata');
        if ($request->isMethod('post')) {
            $findUser = Users::where('id', $data['detail'][0]['id'])->first();
            $edituserinfo = $findUser->saveEditUserInfo($request, $findUser->id);

            if ($edituserinfo) {
                $return['status'] = 'success';
                $return['message'] = 'Your profile has been edited successfully.';
                if (Auth::guard('employee')->check()) {
                    $return['redirect'] = route('employee-dashboard');
                } else {
                    $return['redirect'] = route('admin-dashboard');
                }
            }
            echo json_encode($return);
            exit;
        }

        $objUsers = new Users();
        $data['user'] = $objUsers->getUserDetails($data['detail'][0]['id']);

        $data['header'] = array(
            'title' => 'Employee',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                'Update Profile' => 'Update Profile'));
        $data['css'] = array('plugins/jasny/jasny-bootstrap.min.css');
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js',
        );
        $data['js'] = array('admin/updateprofile.js', 'ajaxfileupload.js', 'jquery.form.min.js');
        $data['css_plugin'] = array(
            'bootstrap-fileinput/bootstrap-fileinput.css',
        );
        $data['funinit'] = array('Updateprofile.edit_init()');
        return view('admin.profile.user-edit', $data);
    }

    public function changepassword(Request $request) {
        if ($request->isMethod('post')) {
            $data['detail'] = $request->session()->get('logindata');
            $findUser = Users::where('id', $data['detail'][0]['id'])->first();
            $result = $findUser->updatePassword($request, $data['detail'][0]['id']);

            if ($result) {
                $return['status'] = 'success';
                $return['message'] = 'Your password has been changed successfully.';
                if (Auth::guard('employee')->check()) {
                    $return['redirect'] = route('login');
                } else {
                    $return['redirect'] = route('login');
                }
            } else {
                $return['status'] = 'error';
                $return['message'] = $result;
            }
            echo json_encode($return);
            exit;
        }

        $data['detail'] = $request->session()->get('logindata');

        $objUsers = new Users();
        $data['user'] = $objUsers->getUserPassword($data['detail'][0]['id']);

        $data['css'] = array('plugins/jasny/jasny-bootstrap.min.css');
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js',
        );
        $data['js'] = array('admin/updateprofile.js', 'ajaxfileupload.js', 'jquery.form.min.js');
        $data['css_plugin'] = array('bootstrap-fileinput/bootstrap-fileinput.css');
        $data['funinit'] = array('Updateprofile.change_password_init()');

        $data['header'] = array(
            'title' => 'Change Password',
            'breadcrumb' => array(
                'Change Password' => 'Change Password'));

        return view('admin.profile.change-password', $data);
    }
}
