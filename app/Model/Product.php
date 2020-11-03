<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Config;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['productId'];
    public function addProduct($productData){
          for($i=0; $i < count($productData); $i++){
              if($productData[$i]->Active == 'true' || $productData[$i]->Active == true){
                  $isactive = "yes";
              }else{
                   $isactive = "no";
              }
            $arr = explode(':', $productData[$i]->FullyQualifiedName);
           
            $objProduct = Product::updateOrCreate(array('productId' => $productData[$i]->Id));
            $objProduct->productname=$productData[$i]->Name;
            $objProduct->sku=$productData[$i]->Sku;
            $objProduct->category=$arr[0];
            $objProduct->type=$productData[$i]->Type;
            $objProduct->quantityonhand=$productData[$i]->QtyOnHand;
            if($productData[$i]->InvStartDate != null || $productData[$i]->InvStartDate != ""){
                $objProduct->quantityonhanddate=date("Y-m-d",strtotime($productData[$i]->InvStartDate));
            }
            
            $objProduct->reorderpoint=$productData[$i]->ReorderPoint;
            $objProduct->inventoryassetaccount=$productData[$i]->AssetAccountRef;
            $objProduct->description=$productData[$i]->Description;
            $objProduct->price=$productData[$i]->UnitPrice;
            $objProduct->incomeaccount=$productData[$i]->IncomeAccountRef;
            $objProduct->purchasinginformation=$productData[$i]->PurchaseDesc;
            $objProduct->cost=$productData[$i]->UnitPrice;
            $objProduct->expenseaccount=$productData[$i]->PurchaseCost;
            $objProduct->vendor=$productData[$i]->PrefVendorRef;
            $objProduct->isactive=$isactive;
            $objProduct->created_at=date("Y-m-d h:i:s");
            $objProduct->updated_at=date("Y-m-d h:i:s");
            $objProduct->save();
          }
          return true;
    }
    
    public function getData() {
        $requestData = $_REQUEST;
        $columns = array(
            // datatable column index  => database column name
            0 => 'product.id',
            1 => 'product.productname',
            2 => 'product.sku',
            3 => 'product.category',
            4 => 'product.type',
            5 => 'product.quantityonhand',
            6 => 'product.price',
            7 => 'product.description',
        );

        $query = Customer::from('product')->where('isactive','yes');

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
                ->select('productname','sku','category','type','quantityonhand','price','description')->get();
        $data = array();
        
        
        $i =0;
        foreach ($resultArr as $row) {
            $i++;
            
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row["productname"];
            $nestedData[] = $row["sku"];
            $nestedData[] = $row["category"];
            $nestedData[] = $row["type"];
            $nestedData[] = $row["quantityonhand"];
            $nestedData[] = $row["price"];
            $nestedData[] = $row["description"];
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
    
    
    public function productdetails($skuid){
        $res = Product::select("productId","productname","category","type","quantityonhand","price","description")
               ->where('sku',$skuid)
               ->where('isactive',"yes")
               ->get()->toarray();
        
       if(count($res) == 0){
          return 2; 
       }else{
           return $res[0];
       }
        
    }
    
    public function getproductquantity($productId){
        $res = Product::select("quantityonhand","productId")
               ->where('productId',$productId)
               ->where('isactive',"yes")
               ->get()->toarray();
       
        if($res[0]['quantityonhand'] == null || $res[0]['quantityonhand'] == ''){
           $res[0]['quantityonhand'] = 0;
        }
        return $res[0];
    }
}
