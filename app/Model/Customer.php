<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;
use Config;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['customerId'];
    public function addCustomer($customerdata){
        
        for($i=0; $i < count($customerdata); $i++){
            
            $objCustomer = Customer::updateOrCreate(array('customerId' => $customerdata[$i]->Id));

            $emailData=$customerdata[$i]->PrimaryEmailAddr;
            $phoneData=$customerdata[$i]->PrimaryPhone;   
            $mobiledata=$customerdata[$i]->Mobile;
            $billingAdd=$customerdata[$i]->BillAddr;
            
            $objCustomer->title=$customerdata[$i]->Title;
            $objCustomer->customerId=$customerdata[$i]->Id;
            $objCustomer->firstname=$customerdata[$i]->GivenName;
            $objCustomer->middlename=$customerdata[$i]->MiddleName;
            $objCustomer->lastname=$customerdata[$i]->FamilyName;
            $objCustomer->suffix=$customerdata[$i]->Suffix;
            $objCustomer->companyname=$customerdata[$i]->CompanyName;
            $objCustomer->displayname=$customerdata[$i]->DisplayName;
            $objCustomer->printname=$customerdata[$i]->PrintOnCheckName;
            $objCustomer->note=$customerdata[$i]->Notes;
            $objCustomer->exemptiondetails=$customerdata[$i]->ResaleNum;
            $objCustomer->paymentmethode=$customerdata[$i]->PaymentMethodRef;
            $objCustomer->deliverymethode=$customerdata[$i]->PreferredDeliveryMethod;
            $objCustomer->terms=$customerdata[$i]->SalesTermRef;
            $objCustomer->openingbalance=$customerdata[$i]->Balance;
            $objCustomer->openingbalancedate=date("Y-m-d",strtotime($customerdata[$i]->OpenBalanceDate));
            $objCustomer->attachments=$customerdata[$i]->AttachableRef;
            $objCustomer->customertype=$customerdata[$i]->CustomerTypeRef;
            if($customerdata[$i]->Taxable == 'true'){
                $taxable='yes';
            }else{
                $taxable='no';
            }
            
            if($customerdata[$i]->Active == 'true'){
                $objCustomer->isactive='yes';
            }else{
                $objCustomer->isactive='no';
            }
            if(isset($emailData->Address)){
                $objCustomer->email=$emailData->Address;
            }
            if(isset($phoneData->FreeFormNumber)){
                $objCustomer->phone=$phoneData->FreeFormNumber;
            }
            if(isset($mobiledata->FreeFormNumber)){
                $objCustomer->mobile=$mobiledata->FreeFormNumber;
            }
            
            if(isset($customerdata[$i]->Fax->FreeFormNumber)){
               $objCustomer->fax=$customerdata[$i]->Fax->FreeFormNumber;
            }
            if(isset($customerdata[$i]->AlternatePhone->FreeFormNumber)){
               $objCustomer->other=$customerdata[$i]->AlternatePhone->FreeFormNumber;
            }
            if(isset($customerdata[$i]->WebAddr->URI)){
               $objCustomer->website=$customerdata[$i]->WebAddr->URI;
            }
            
            if(isset($customerdata[$i]->BillAddr->Line1)){
               $objCustomer->billingaddstreet=$customerdata[$i]->BillAddr->Line1.' '.$customerdata[$i]->BillAddr->Line2.' '.$customerdata[$i]->BillAddr->Line3.' '.$customerdata[$i]->BillAddr->Line4.' '.$customerdata[$i]->BillAddr->Line5;
               $objCustomer->billingaddcity=$customerdata[$i]->BillAddr->City;
               $objCustomer->billingaddstate=$customerdata[$i]->BillAddr->CountrySubDivisionCode;
               $objCustomer->billingaddzip=$customerdata[$i]->BillAddr->PostalCode;
               $objCustomer->billingaddcountry=$customerdata[$i]->BillAddr->Country;
            }
            
            if(isset($customerdata[$i]->ShipAddr->Line1)){
               $objCustomer->shippingaddstreet=$customerdata[$i]->ShipAddr->Line1.' '.$customerdata[$i]->ShipAddr->Line2.' '.$customerdata[$i]->ShipAddr->Line3.' '.$customerdata[$i]->ShipAddr->Line4.' '.$customerdata[$i]->ShipAddr->Line5;
               $objCustomer->shippingaddcity=$customerdata[$i]->ShipAddr->City;
               $objCustomer->shippingaddstate=$customerdata[$i]->ShipAddr->CountrySubDivisionCode;
               $objCustomer->shippingaddzip=$customerdata[$i]->ShipAddr->PostalCode;
               $objCustomer->shippingaddcountry=$customerdata[$i]->ShipAddr->Country;
            }
            
            $objCustomer->save();
            
        }
        
        return true;
       
    }
    
    public function getData($request) {
        $requestData = $_REQUEST;
        $columns = array(
            // datatable column index  => database column name
            0 => 'customer.id',
            1 => 'customer.title',
            2 => 'customer.firstname',
            3 => 'customer.middlename',
            4 => 'customer.lastname',
            5 => 'customer.companyname',
            6 => 'customer.email',
            7 => 'customer.mobile',
        );

        $query = Customer::from('customer')
                ->where('isactive','yes');

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
                ->select('title','firstname','middlename','lastname','companyname','email','mobile')->get();
        $data = array();
        
        
        $i =0;
        foreach ($resultArr as $row) {
            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row["title"];
            $nestedData[] = $row["firstname"];
            $nestedData[] = $row["middlename"];
            $nestedData[] = $row["lastname"];
            $nestedData[] = $row["companyname"];
            $nestedData[] = $row["email"];
            $nestedData[] = $row["mobile"];
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }
    
    public function customerlist(){
        return Customer::from('customer')
                        ->where('isactive','yes')
                        ->select('id','firstname','middlename','lastname','email')
                        ->get()
                        ->toArray();
    }
}
