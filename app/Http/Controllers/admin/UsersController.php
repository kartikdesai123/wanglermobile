<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use Config;
class UsersController extends Controller
{
    //
     public function __construct() {
//        parent::__construct();
         $this->middleware('admin');
    }
    
    public function index(Request $request){
       
        
         $data['header'] = array(
            'title' => 'Users',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                'Users' => 'Users'
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('user.js');
        $data['funinit'] = array('User.init()');
        $data['css'] = array('');
        return view('admin.user.user-list',$data);
    }
    
    public function add(Request $request){
        if ($request->isMethod('post')) {
            $objNewUser = new Users();
            $result = $objNewUser->addUser($request);
            if ($result == 1) {
                $return['status'] = 'success';
                $return['message'] = 'User created successfully.';
                $return['redirect'] = route('admin-users');
            } 
            if ($result == 0) {
                $return['status'] = 'error';
                $return['message'] = 'something will be wrong.';
            }
            if ($result == 2) {
                $return['status'] = 'error';
                $return['message'] = 'Email address already exist';
            }
            echo json_encode($return);
            exit;
        }
         $data['header'] = array(
            'title' => 'Users',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                'Users' => 'Users'
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('user.js', 'ajaxfileupload.js', 'jquery.form.min.js', );
        $data['funinit'] = array('User.add()');
        $data['css'] = array('');
        return view('admin.user.add',$data);
    }
    public function edit(Request $request,$id){
        $objUsers= new Users();
        $data['editDetails'] = $objUsers->getDetails($id);
        if ($request->isMethod('post')) {
            $objNewUser = new Users();
            $result = $objNewUser->editUser($request);
            if ($result == 1) {
                $return['status'] = 'success';
                $return['message'] = 'User details updated successfully.';
                $return['redirect'] = route('admin-users');
            } 
            if ($result == 0) {
                $return['status'] = 'error';
                $return['message'] = 'something will be wrong.';
            }
            if ($result == 2) {
                $return['status'] = 'error';
                $return['message'] = 'Email address already exist';
            }
            echo json_encode($return);
            exit;
        }
         $data['header'] = array(
            'title' => 'Users',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                'Users' => 'Users'
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('user.js', 'ajaxfileupload.js', 'jquery.form.min.js', );
        $data['funinit'] = array('User.edit()');
        $data['css'] = array('');
        return view('admin.user.edit',$data);
    }
    
     public function deleteDemo($postData) {
        if ($postData) {
            if($postData['profileimage'] != NULL || $postData['profileimage'] != ''){
               unlink(public_path('/uploads/users/'.$postData['profileimage'])); 
            }
            $result = Users::where('id', $postData['id'])->delete();
            if ($result) {
                $return['status'] = 'success';
                $return['message'] = 'User deleted successfully.';
                $return['redirect'] = route('admin-users');
               
            } else {
                $return['status'] = 'error';
                $return['message'] = 'something will be wrong.';
            }
            echo json_encode($return);
            exit;
        }
    }
    public function ajaxCall(Request $request) {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objUsers = new Users();
                $demoList = $objUsers->getData($request);
                echo json_encode($demoList);
                break;
            case 'deleteUser':
                $result = $this->deleteDemo($request->input('data'));
                break;
        }
    }
}
