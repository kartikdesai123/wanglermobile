<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Config;
use App\Model\Invoiceproduct;

class Myinvoice extends Model
{
    protected $table = 'invoice';
    
    function __construct() {
        
    }
    
    public function addInvoice($request){
       
        for($i=0; $i < count($request); $i++){
            $metadata= $request[$i]->MetaData;
            $taxDetails= $request[$i]->TxnTaxDetail;
            if($taxDetails->TotalTax){
               $totalTax = $taxDetails->TotalTax; 
            }else{
                $totalTax = 0;
            }
            
            $id =  $request[$i]->Id;
            
            $objInvoice = Myinvoice::updateOrCreate(array('invoiceId' => $id));
            $objInvoice->invoiceId = $id;
            $objInvoice->customerId = $request[$i]->CustomerRef;
          
            $objInvoice->invoice_date = date("Y-m-d", strtotime(substr($metadata->CreateTime, 0, 10)));
//            $objInvoice->invoice_date = date("Y-m-d");
            $objInvoice->due_date = date("Y-m-d", strtotime($request[$i]->DueDate));
//            $objInvoice->due_date = date("Y-m-d");
            
            $objInvoice->status = 'Invoice';
            $objInvoice->type = "Paid";
            $objInvoice->message_on_invoice = null;
            $objInvoice->message_on_statement = null;
            
            $objInvoice->total = $request[$i]->TotalAmt;
            $objInvoice->discount = $request[$i]->DiscountAmt;
            $objInvoice->balance = $request[$i]->Balance;
            $objInvoice->taxable_subtotal = $totalTax + $request[$i]->TotalAmt;
            $objInvoice->created_at = date('Y-m-d h:i:s');
            $objInvoice->updated_at = date('Y-m-d h:i:s');
            if($objInvoice->save()){
                $invoiceId = $id ;
                 $result = Invoiceproduct::where('invoice_id', $invoiceId)->delete();
                 for($j = 0; $j <count($request[$i]->Line) ; $j++){
                     $productDetails = $request[$i]->Line;
                        if($productDetails[$j]->Id != null || $productDetails[$j]->Id != '' ) {
                            $salesItemLineDetail= $productDetails[$j]->SalesItemLineDetail;
                            if($salesItemLineDetail->Qty != null || $salesItemLineDetail->Qty != '' ) {
                                if($salesItemLineDetail->TaxCodeRef == 'NON'){
                                $TaxCodeRef = "No";
                                }else{
                                     $TaxCodeRef = "Yes";
                                }
                                $objMyinvoice = new Invoiceproduct();
                                $objMyinvoice->invoice_id = $invoiceId;
                                $objMyinvoice->product_name = $salesItemLineDetail->ItemRef;
                                $objMyinvoice->description = null;
                                $objMyinvoice->qty = $salesItemLineDetail->Qty;
                                $objMyinvoice->rate = null;
                                $objMyinvoice->amout = $productDetails[$j]->Amount;
                                $objMyinvoice->tax = $TaxCodeRef;
                                $objMyinvoice->created_at = date('Y-m-d H:i:s');
                                $objMyinvoice->updated_at = date('Y-m-d H:i:s');
                                $objMyinvoice->save();
                            }
                            
                        }
                 }
            }else{
                return false;
            }
            
        }
        return true;
    }
    
    
//    public function getData(){
//        $result = Myinvoice::select('*')->get();
//        print_r($result);
//        exit;
//                    
//    }
    
     public function getData() {
        $requestData = $_REQUEST;
        $columns = array(
            // datatable column index  => database column name
            0 => 'invoice.id',
            1 => 'customer.displayname',
            2 => 'customer.email',
            3 => 'invoice.invoice_date',
            3 => 'invoice.due_date',
        );

        $query = Myinvoice::join('customer','invoice.customerId','=','customer.customerId')
                    ->where('customer.isactive','yes');
        
        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function($query) use ($columns, $searchVal, $requestData) {
                        $flag = 0;
                        foreach ($columns as $key => $value) {
                            $searchVal = $requestData['search']['value'];
                            if ($requestData['columns'][$key]['searchable'] == 'true') {
                                if ($flag == 0) {
                                    $query->where($value, 'like', '%' . $searchVal . '%');
                                    $flag = $flag + 1;
                                } else {
                                    $query->orWhere($value, 'like', '%' . $searchVal . '%');
                                }
                            }
                        }
                    });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
                    ->take($requestData['length'])
                    ->select('customer.displayname','customer.email','invoice.id','invoice.type','invoice.invoice_date','invoice.due_date','invoice.total','invoice.discount','invoice.taxable_subtotal')->get();
        $data = array();
       
        
        $i =0;
        foreach ($resultArr as $row) {
            $i++;
             $discount='';
            if($row["discount"] == NULL || $row["user_image"] == ''){
                $discount = 0;
            }else{
                 $discount = $row["discount"];
            }
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row["displayname"];
            $nestedData[] = $row["email"];
            $nestedData[] = $row["total"];
            $nestedData[] = $row["type"];
            $nestedData[] = $discount;
            $nestedData[] = $row["taxable_subtotal"] - $row["total"];
            $nestedData[] = $row["taxable_subtotal"];
            $nestedData[] = date("d-m-Y",strtotime($row["invoice_date"]));
            $nestedData[] = date("d-m-Y",strtotime($row["due_date"]));
            $data[] = $nestedData;
        }
       // echo "<pre>";print_r($data);exit;

        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );

        return $json_data;
    }
}
