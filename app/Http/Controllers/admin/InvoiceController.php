<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Myinvoice;

class InvoiceController extends Controller
{
    public function __construct() {
         $this->middleware('admin');
    }
    
    public function index(){
        $data['header'] = array(
            'title' => 'Invoice List',
            'breadcrumb' => array(
                'Home' => route("admin-invoice"),
                'Invoice List' => 'Invoice List',
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('invoice.js');
        $data['funinit'] = array('Invoice.init()');
        $data['css'] = array('');
        return view('admin.invoice.list',$data);
    }
    
    public function ajaxCall(Request $request) {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objInvoice = new Myinvoice();
                $demoList = $objInvoice->getData();
                echo json_encode($demoList);
                break;
            
        }
    }
}
