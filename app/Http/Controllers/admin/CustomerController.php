<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Customer;
class CustomerController extends Controller
{
    public function __construct() {
//        parent::__construct();
         $this->middleware('admin');
    }
    
    public function index(){
        $data['header'] = array(
            'title' => 'Customer',
            'breadcrumb' => array(
                'Home' => route("admin-customer"),
                'Customer List' => 'Customer List',
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('customer.js');
        $data['funinit'] = array('Customer.init()');
        $data['css'] = array('');
        return view('admin.customer.list',$data);
    }
    
    public function ajaxCall(Request $request) {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objCustomer = new Customer();
                $demoList = $objCustomer->getData($request);
                echo json_encode($demoList);
                break;
            case 'deleteUser':
                $result = $this->deleteDemo($request->input('data'));
                break;
        }
    }
}
