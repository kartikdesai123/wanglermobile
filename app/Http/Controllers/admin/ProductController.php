<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
class ProductController extends Controller
{
    public function __construct() {
         $this->middleware('admin');
    }
    
    public function index(){
        $data['header'] = array(
            'title' => 'Product List',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                'Product List' => 'Product List',
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('product.js');
        $data['funinit'] = array('Product.init()');
        $data['css'] = array('');
        return view('admin.product.list',$data);
    }
    
    public function ajaxCall(Request $request) {
        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objProduct = new Product();
                $demoList = $objProduct->getData();
                echo json_encode($demoList);
                break;
            
        }
    }
}
