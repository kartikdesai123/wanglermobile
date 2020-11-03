<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Users;
use App\Model\Product;
use App\Model\Customer;
use App\Model\Qbtoken;
use App\Model\Invoicedraft;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Invoice;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use \Validator;

class ApiController extends Controller {

    public function __construct() {
        
    }

    public function login(Request $request) {
        if ($request->isMethod('post')) {
            $validator = validator::make($request->all(), [
                        'email' => 'required',
                        'password' => 'required'
            ]);
            if ($validator->fails()) {
                $result['status'] = 'fail';
                $result['message'] = 'Username and password is required.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            }
            $email = $request['email'];
            $password = $request['password'];
            if (Auth::guard()->attempt(['email' => $email, 'password' => $password, 'type' => 'USER'])) {
                $result['status'] = 'success';
                $result['message'] = 'Login Successfully.';
                $result['data'] = Auth()->guard()->user();
                echo json_encode($result);
                exit;
            } else {
                $result['status'] = 'fail';
                $result['message'] = 'Login not Successfully.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            }
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function customerlist() {
        $objCustomer = new Customer();
        $customerlist = $objCustomer->customerlist();

        if (!empty($customerlist)) {
            $result['status'] = 'success';
            $result['message'] = 'Customer details found.';
            $result['data'] = $customerlist;
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Data not found.';
            $result['data'] = json_decode("{}");
        }
        echo json_encode($result);
        exit;
    }

    public function getproductwithsku(Request $request) {
        if ($request->isMethod('post')) {

            $validator = validator::make($request->all(), [
                        'sku' => 'required',
            ]);
            if ($validator->fails()) {
                $result['status'] = 'fail';
                $result['message'] = 'SKU Code is required.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            } else {
                $objProduct = new Product();
                $res = $objProduct->productdetails($request->input('sku'));
                $res['quantityonhand'] = (int)$res['quantityonhand'];
                $res['productId'] = (int)$res['productId'];
                if ($res) {
                    if ($res == 2) {
                        $result['status'] = 'fail';
                        $result['message'] = 'Product Not found';
                        $result['data'] = $request->input('sku');
                    } else {
                        $result['status'] = 'success';
                        $result['message'] = 'Product matched';
                        $result['data'] = $res;
                    }
                } else {
                    $result['status'] = 'fail';
                    $result['message'] = 'No data found';
                    $result['data'] = array();
                }
                echo json_encode($result);
                exit;
            }
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function getproductquantity(Request $request) {
        if ($request->isMethod('post')) {
            $validator = validator::make($request->all(), [
                        'productId' => 'required',
            ]);
            if ($validator->fails()) {
                $result['status'] = 'fail';
                $result['message'] = 'Product Id is required.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            } else {
                $objProduct = new Product();
                $res = $objProduct->getproductquantity($request->input('productId'));
                if ($res) {
                    $result['status'] = 'success';
                    $result['message'] = 'Product matched';
                    $result['data'] = $res;
                } else {
                    $result['status'] = 'fail';
                    $result['message'] = 'No data found';
                    $result['data'] = $request->input('productId');
                }
                echo json_encode($result);
                exit;
            }
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function getinvoiceid(Request $request) {
        if ($request->isMethod('post')) {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            $tempId = substr(str_shuffle($data), 0, 4);
            $result['status'] = 'success';
            $result['message'] = 'Invoice Id Genrated';
            $result['data'] = time() . $tempId;
            echo json_encode($result);
            exit;
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function saveproduct(Request $request) {
        if ($request->isMethod('post')) {
            $validator = validator::make($request->all(), [
                        'invoiceid' => 'required',
                        'productid' => 'required',
                        'customerid' => 'required',
                        'quantity' => 'required',
                        'note' => 'required',
                        'userid' => 'required',
            ]);
            if ($validator->fails()) {
                $result['status'] = 'fail';
                $result['message'] = 'provide required data.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            } else {
                $objinvoiceproductdraft = new Invoicedraft();
                $res = $objinvoiceproductdraft->saveproduct($request);
                if ($res) {
                    $result['status'] = 'success';
                    $result['message'] = 'Product save successfully.';
                    $result['data'] = $res;
                } else {
                    $result['status'] = 'fail';
                    $result['message'] = 'Product not saved.please try again.';
                    $result['data'] = array();
                }
                echo json_encode($result);
                exit;
            }
        } else {
            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function apicreateInvoice($invoicedata) {

        session_start();

        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => env('QBBASEURL', "development")
        ));
        $accessToken = $_SESSION['sessionAccessToken'];
        $dataService->updateOAuth2Token($accessToken);

        /* Get Customer Detail */

//        $customerName = 'Mr Parth Hareshbhai Khunt fdf';
//        $customerArray = $dataService->Query("select * from Customer where DisplayName='" . $customerName . "'");
//        
//        
//        echo "<pre/>"; print_r($customerArray); exit(); 

        $customerRef = $this->getCustomerObj($dataService);
        $itemRef = $this->getItemObj($dataService);

        $invoiceObj = Invoice::create([
                    "Line" => [
                        "Amount" => 100.00,
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "Qty" => 2,
                            "ItemRef" => [
                                "value" => $itemRef->Id
                            ]
                        ]
                    ],
                    "CustomerRef" => [
                        "value" => $customerRef->Id
                    ],
                    "BillEmail" => [
                        "Address" => "author@intuit.com"
                    ]
        ]);

        $resultingInvoiceObj = $dataService->Add($invoiceObj);
        $invoiceId = $resultingInvoiceObj->Id;

        if ($invoiceId) {
            $return['status'] = 'success';
            $return['message'] = 'Invoice created successfully.';
            $return['redirect'] = route('admin-invoice');
        } else {
            $return['status'] = 'error';
            $return['message'] = 'something will be wrong.';
        }
        echo json_encode($return);
        exit;
    }

    public function testPostman() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sandbox-quickbooks.api.intuit.com/v3/company/123146096252559/invoice?minorversion=14",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"Line\": [\n    {\n      \"Amount\": 100.00,\n      \"DetailType\": \"SalesItemLineDetail\",\n      \"SalesItemLineDetail\": {\n        \"ItemRef\": {\n          \"value\": \"1\",\n          \"name\": \"Services\"\n        }\n      }\n    }\n  ],\n  \"CustomerRef\": {\n    \"value\": \"1\"\n  }\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Bearer eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..MKDlRcZ2SfxOnqxK84QXTQ.IAaVvFtqphQwfjvTxJqmrZa6oWBW7M_ls959sXIfi1EK8UH986X0c2qS9ZC7iXjDVQmNPZ_deRI-jPRtKua-u_gCdSDvwo_14V8HPbHije4xHPz9FuSrjcyxzIlzUeOBpePJOfIjvziVyqyux0yOmnX_eZ9fYjjFn83Y5M9TkSDFE2sm-gjLx2g4nQnnzSuoWnphuY3ODLI3IHOgm28SAR0JRrlmPPH3s2dIF3fSsBr3aLqvd6NLKwLHHuKZ0mCacwXebkBhq1wDd5tKVMffSi0kK-mn-myWNnT98QtPgzmRbRpkoOmVSTMbBEpasQnF0pFxW6BII_TMAb9R4FZfHQ-2TgovGbUIqhSyr9XnfrvMjMKc23i7EtSyQMs7t7q2r72twxjHNUfOE6IYQgeaCsFk9yGwx5ww72cD-TOgDnKYSBPEkd9d90O15Xg-7NjuWRrixlkjA0dVq_ZA_hlHfLMSFZVnMvuwZB-SAFMDET7UspvVbvIgpgm1EzbQMY4wP0WdZHRJH4n6LNfTXxRAnTMXwi1xkFM5kHXCJ9Po8H-VVJkcnAbDtGTDL0dnfd0omkvIlgI5SL42Fo1G-ieFDhOVBJdN3QC7_CoTg1VRVvzSaO8hsWhm-XsHVJ-DS0I1teQCBpvI-JSMDfhFBqI_9VNnZcQtBLZsyC6Jlxb8xdQzF6JvMbPTUnSE3-Ml3CrMrHUQnMZDVfzjBSYrZdu2L4exgiXZU0T_JdELXBJC1f9-mn940_wYxBIN8B4-sIF3YZPveg1valwsy4AcssyHyRKIbmCFSGiw--zXGhzb_89rx8oMswT8zi8dyFOhaDtJ.ax7XPldS6DNfeq7VH_eWDw",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 262",
                "Content-Type: application/json",
                "Cookie: UserLocale=en-US; s_fid=2DC73892353B68ED-00661D728D307071; ivid_b=47d6a94d-d4af-4526-922f-0d2515636f80; ivid=f0779934-dbf1-4f0e-b80c-284064bfa38a; did=SHOPPER2_581fffbeab30a99cf48fad36b07a810d7138abae2b84d058ca766ae8dcff63244af60d0b2387c0984f4a5348b611fb3a; qbn.glogin=kartikdesai123%40gmail.com; websdk_swiper_flags=first_sc_hit%2Cwait_for_sc; propertySegments=1568722610766%7cAC%3a3%3a%3a; qboeuid=d95fa778.592bebc4192a0",
                "Host: sandbox-quickbooks.api.intuit.com",
                "Postman-Token: 39a12df3-6258-4e0b-8443-88da3661ccfc,b89e5580-5278-48eb-afe5-8d1e6bf1d926",
                "User-Agent: QBOV3-OAuth2-Postman-Collection",
                "cache-control: no-cache"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    public function createinvoice(Request $request) {

        
        if ($request->isMethod('post')) {
            $validator = validator::make($request->all(), [
                        'invoiceid' => 'required',
            ]);
            if ($validator->fails()) {
                $result['status'] = 'fail';
                $result['message'] = 'Invoiceid  is required.';
                $result['data'] = array();
                echo json_encode($result);
                exit;
            } else {

                $objcreateinvoice = new Invoicedraft();
                $res = $objcreateinvoice->getinvoicedetails($request);
                
                $objQbtoken = new Qbtoken();
                //$token = $objQbtoken->gettoken();
                $accessToken = $objQbtoken->getsessiontoken();
               
                $getrealmId = $objQbtoken->getrealmId();
               

                $ClientID = $accessToken->getClientID();
                $ClientSecret = $accessToken->getClientSecret();
                $theRefreshTokenValue = $accessToken->getRefreshToken();
                //  echo $theRefreshTokenValue;exit;
                $oauth2LoginHelper = new OAuth2LoginHelper($ClientID, $ClientSecret);
                // print_r($oauth2LoginHelper);exit;
                $accessTokenObj = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($theRefreshTokenValue);
                $objQbtoken->insertToken($accessTokenObj,$getrealmId);

                $token = $accessTokenValue = $accessTokenObj->getAccessToken();

                if (count($res) > 0) {
                    for ($i = 0; $i < count($res); $i++) {
                        $requestData['Line'][] = [
                            "Amount" => $res[$i]['price'],
                            "Description" => $res[$i]['note'],
                            "DetailType" => "SalesItemLineDetail",
                            "SalesItemLineDetail" => [
                                "Qty" => $res[$i]['quantity'],
                                "ItemRef" => [
                                    "value" => $res[$i]['productid']
                                ]
                            ]
                        ];
                    }

                    $requestData['CustomerRef']['value'] = $res[0]['qbcustomerid'];
                    $requestData['BillEmail']['Address'] = 'author@intuit.com';
//print_r($requestData);exit;
                    $requestDataJson = json_encode($requestData);
                    
                    $development =  env('QBBASEURL', "development");
                    
                    if($development == 'development'){
                        $url = 'https://sandbox-quickbooks.api.intuit.com/';
                    }else{
                        $url = 'https://quickbooks.api.intuit.com/';
                    }
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url."v3/company/".$getrealmId."/invoice?minorversion=14",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "$requestDataJson",
                        CURLOPT_HTTPHEADER => array(
                            "Accept: application/json",
                            // "Accept-Encoding: gzip, deflate",
                            "Authorization: Bearer $token",
                            "Cache-Control: no-cache",
                            "Connection: keep-alive",
                            //    "Content-Length: 288",
                            "Content-Type: application/json",
                            "Cookie: UserLocale=en-US; s_fid=2DC73892353B68ED-00661D728D307071; ivid_b=47d6a94d-d4af-4526-922f-0d2515636f80; ivid=f0779934-dbf1-4f0e-b80c-284064bfa38a; did=SHOPPER2_581fffbeab30a99cf48fad36b07a810d7138abae2b84d058ca766ae8dcff63244af60d0b2387c0984f4a5348b611fb3a; qbn.glogin=kartikdesai123%40gmail.com; websdk_swiper_flags=first_sc_hit%2Cwait_for_sc; propertySegments=1568722610766%7cAC%3a3%3a%3a; qboeuid=d95fa778.592bebc4192a0",
                            "Host: sandbox-quickbooks.api.intuit.com",
                            "Postman-Token: 39a12df3-6258-4e0b-8443-88da3661ccfc,b89e5580-5278-48eb-afe5-8d1e6bf1d926",
                            "User-Agent: QBOV3-OAuth2-Postman-Collection",
                            "cache-control: no-cache"
                        ),
                    ));

                    $response = curl_exec($curl);
                    $responseArr = json_decode($response,true);
                   // print_r($responseArr);
                   // exit;
                    $err = curl_error($curl);
                    curl_close($curl);
                    if (isset($responseArr['Fault']['Error'][0])) {
                        $result['status'] = 'fail';
                        $result['message'] = $responseArr['Fault']['Error'][0]['Message'];
                        $result['data'] = array("invoiceid" => $request->input('invoiceid'));
                        echo json_encode($result);
                        exit;
                        //                    echo "cURL Error #:" . $err;
                    } else {
                        $objInvoiceDraft = new Invoicedraft();
                        $res = $objInvoiceDraft->updatestatus($request->input('invoiceid'));
                        
                        $resultReturn = $this->updateproductlist();
                        
                        if($resultReturn['status'] == 'success'){
                                $result['status'] = 'success';
                                $result['message'] = 'Invoice created successfully.';
                                $result['data'] = array("invoiceid" => $request->input('invoiceid'));
                                echo json_encode($result);
                                exit;
                        }else{
                            $result['status'] = 'fail';
                            $result['message'] = $resultReturn['message'];
                            $result['data'] = array("invoiceid" => $request->input('invoiceid'));
                            echo json_encode($result);
                            exit;
                        }
                        
                        //                    echo $response;
                    }
                } else {
                    $result['status'] = 'fail';
                    $result['message'] = 'Invaild Invoice Id';
                    $result['data'] = array("invoiceid" => $request->input('invoiceid'));
                    echo json_encode($result);
                    exit;
                }
            }
        } else {

            $result['status'] = 'fail';
            $result['message'] = 'Invaild Call.';
            $result['data'] = array();
            echo json_encode($result);
            exit;
        }
    }

    public function updateproductlist() {

        $objQbtoken = new Qbtoken();
        $accessToken = $objQbtoken->getsessiontoken();
        $getrealmId = $objQbtoken->getrealmId();
        
        $ClientID = $accessToken->getClientID();
        $ClientSecret = $accessToken->getClientSecret();
        $theRefreshTokenValue = $accessToken->getRefreshToken();

        $oauth2LoginHelper = new OAuth2LoginHelper($ClientID, $ClientSecret);

        $accessTokenObj = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($theRefreshTokenValue);

        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    // 'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    // 'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => "development",
                    'QBORealmID' => $getrealmId,
                    'accessTokenKey' => $accessTokenObj->getAccessToken(),
                    'refreshTokenKey' => $accessTokenObj->getRefreshToken(),
        ));


        $productArray = $dataService->Query("select * from Item");

//        $error = $dataService->getLastError();
//if ($error) {
//    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
//    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
//    echo "The Response message is: " . $error->getResponseBody() . "\n";
//}
//        var_dump($productArray);exit;
        if ($productArray) {
            $objProduct = new Product();
            $result = $objProduct->addProduct($productArray);
            if ($result) {
                $return['status'] = 'success';
                $return['message'] = 'Productlist Updated successfully.';
               // $return['redirect'] = route('admin-product');
            } else {
                $return['status'] = 'error';
                $return['message'] = 'Product data not found.';
            }
            
        } else {
            $error = $dataService->getLastError();
            $return['status'] = 'error';
            $return['message'] = $error;
               
        }
        
        return $return;
//        return json_encode($customerArray,JSON_PRETTY_PRINT);
    }
}
