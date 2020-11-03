<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invoicedraft extends Model
{
    protected $table = 'invoicedraft';
    function __construct() {
        
    }
    
    public function saveproduct($request){
        $objinvoicedraft = new Invoicedraft();
        $objinvoicedraft->userid = $request->input('userid');
        $objinvoicedraft->invoiceid =$request->input('invoiceid');
        $objinvoicedraft->productid =$request->input('productid');
        $objinvoicedraft->customerid =$request->input('customerid');
        $objinvoicedraft->quantity =$request->input('quantity');
        $objinvoicedraft->note =$request->input('note');
        $objinvoicedraft->created_at = date("Y-m-d h:i:s");
        $objinvoicedraft->updated_at = date("Y-m-d h:i:s");
        if($objinvoicedraft->save()){
            $data= Invoicedraft::select("*")
                    ->where("id",$objinvoicedraft->id)
                    ->get()->toArray();
           
            return $data[0];
        }else{
            return 0;
        }
    }
    
    public function getinvoicedetailsold($request){
        $invoiceId = $request->input('invoiceid');
        $invoiceList = Invoicedraft::select("invoicedraft.id","product.price","invoicedraft.productid","invoicedraft.customerid","invoicedraft.quantity","invoicedraft.note")
                    ->join('product','invoicedraft.productid','=','product.id')
                    ->where("invoicedraft.invoiceid",$invoiceId)
                    ->where("invoicedraft.invoicecreated","No")
                    ->get()
                    ->toArray();
        return $invoiceList ;
    }
    
     public function getinvoicedetails($request){
        $invoiceId = $request->input('invoiceid');
        $invoiceList = Invoicedraft::select("invoicedraft.id","product.price","invoicedraft.productid","customer.customerId as qbcustomerid","invoicedraft.customerid","invoicedraft.quantity","invoicedraft.note")
                    ->join('product','invoicedraft.productid','=','product.productId')
                    ->join('customer','invoicedraft.customerid','=','customer.id')
                    ->where("invoicedraft.invoiceid",$invoiceId)
                    ->where("invoicedraft.invoicecreated","No")
                    ->get()
                    ->toArray();
        return $invoiceList ;
    }
    
    public function cretedInvoice($id){
        $onjInvoicedraft = Invoicedraft::find($id);
        $onjInvoicedraft->invoicecreated ="Yes";
        $onjInvoicedraft->save();
    }
    
    public function updatestatus($invoiceid){
        
        $getproductid =  Invoicedraft::select('productid','quantity')
                                ->where('invoiceid',$invoiceid)
                                ->get()
                                ->toArray();
       // print_r($getproductid);
//        die();
//        for($i = 0 ; $i < count($getproductid) ; $i++){
//            $quantityonhand = Product::select('quantityonhand')
//                                ->where('id',$getproductid[$i]['productid'])
//                                ->get()
//                                ->toArray();
//          
//            $remainingquantity = $quantityonhand[0]['quantityonhand'] - $getproductid[$i]['quantity'];
//         
//            $onjInvoicedraft = Product::where('id',$getproductid[$i]['productid'])
//                            ->update(['quantityonhand' => $remainingquantity]);
//            
//        }
        
        $onjInvoicedraft = Invoicedraft::where('invoiceid', $invoiceid)
                                    ->update(['invoicecreated' => "Yes"]);
        
    }
    
    
}
