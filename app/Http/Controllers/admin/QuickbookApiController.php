<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Invoice;
use App\Model\Customer;
use App\Model\Product;
use App\Model\Myinvoice;
use App\Model\Qbtoken;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;

class QuickbookApiController extends Controller {

    public function __construct() {
//        parent::__construct();
//         $this->middleware('admin');
    }

    public function getAuthorizationCodeURL() {
        $parameters = array(
            'client_id' => $this->getClientID(),
            'scope' => $this->getScope(),
            'redirect_uri' => $this->getRedirectURL(),
            'response_type' => 'code',
            'state' => $this->getState()
        );
        $authorizationRequestUrl = CoreConstants::OAUTH2_AUTHORIZATION_REQUEST_URL;
        $authorizationRequestUrl .= '?' . http_build_query($parameters, null, '&', PHP_QUERY_RFC1738);
        return $authorizationRequestUrl;
    }

    public function quickbookstart() {
        session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => env('QBBASEURL', "development")
        ));


        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        $data['authUrl'] = $authUrl;

        // Store the url in PHP Session Object;
        $_SESSION['authUrl'] = $authUrl;

        //set the access token using the auth object
        if (isset($_SESSION['sessionAccessToken'])) {

            $accessToken = $_SESSION['sessionAccessToken'];
            $accessTokenJson = array('token_type' => 'bearer',
                'access_token' => $accessToken->getAccessToken(),
                'refresh_token' => $accessToken->getRefreshToken(),
                'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
                'expires_in' => $accessToken->getAccessTokenExpiresAt()
            );
            $dataService->updateOAuth2Token($accessToken);
            $oauthLoginHelper = $dataService->getOAuth2LoginHelper();
            $CompanyInfo = $dataService->getCompanyInfo();
            $data['accessTokenJson'] = $accessTokenJson;
        }

        return view('quickbook/quickbooklogin', $data);
    }

    public function quickbookcallback() {
        // Create SDK instance
       // session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => env('QBBASEURL', "development")
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $parseUrl = $this->parseAuthRedirectUrl($_SERVER['QUERY_STRING']);

        /*
         * Update the OAuth2Token
         */
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($parseUrl['code'], $parseUrl['realmId']);

        $objQbtoken = new Qbtoken();
        $result = $objQbtoken->insertToken($accessToken,$parseUrl['realmId']);

 //       $dataService->updateOAuth2Token($accessToken);

        /*
         * Setting the accessToken for session variable
         */
  //      $_SESSION['sessionAccessToken'] = $accessToken;
    }

    public function parseAuthRedirectUrl($url) {
        parse_str($url, $qsArray);
        return array(
            'code' => $qsArray['code'],
            'realmId' => $qsArray['realmId']
        );
    }

    public function getcompanyinfo() {
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
                    'baseUrl' => env('QBBASEURL', "development"),
                    'QBORealmID' => $getrealmId,
                    'accessTokenKey' => $accessTokenObj->getAccessToken(),
                    'refreshTokenKey' => $accessTokenObj->getRefreshToken(),
        ));
        
        $CompanyInfo = $dataService->getCompanyInfo();
        return json_encode($CompanyInfo, JSON_PRETTY_PRINT);
    }
    
    public function getcompanyinfoold() {
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
        $CompanyInfo = $dataService->getCompanyInfo();
        return json_encode($CompanyInfo, JSON_PRETTY_PRINT);
    }

    public function getinvoicelist() {
               
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
                    'baseUrl' => env('QBBASEURL', "development"),
                    'QBORealmID' => $getrealmId,
                    'accessTokenKey' => $accessTokenObj->getAccessToken(),
                    'refreshTokenKey' => $accessTokenObj->getRefreshToken(),
        ));
        
        $invoiceArray = $dataService->Query("select * from Invoice");

        $objMyinvoice = new Myinvoice();
        $result = $objMyinvoice->addInvoice($invoiceArray);
        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'Invoicelist Updated successfully.';
            $return['redirect'] = route('admin-invoice');
        } else {
            $return['status'] = 'error';
            $return['message'] = 'something will be wrong.';
        }
        echo json_encode($return);
        exit;
        $error = $dataService->getLastError();
        return json_encode($customerArray, JSON_PRETTY_PRINT);
    }

    public function getinvoicelistold() {
        session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => env('QBBASEURL', "development"),
        ));
        $accessToken = $_SESSION['sessionAccessToken'];
        $dataService->updateOAuth2Token($accessToken);
        $invoiceArray = $dataService->Query("select * from Invoice");

        $objMyinvoice = new Myinvoice();
        $result = $objMyinvoice->addInvoice($invoiceArray);
        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'Invoicelist Updated successfully.';
            $return['redirect'] = route('admin-invoice');
        } else {
            $return['status'] = 'error';
            $return['message'] = 'something will be wrong.';
        }
        echo json_encode($return);
        exit;
        $error = $dataService->getLastError();
        return json_encode($customerArray, JSON_PRETTY_PRINT);
    }

    public function getproductlist() {

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
                    'baseUrl' => env('QBBASEURL', "development"),
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
                $return['redirect'] = route('admin-product');
            } else {
                $return['status'] = 'error';
                $return['message'] = 'something will be wrong.';
            }
            echo json_encode($return);
            exit;
        } else {
            $error = $dataService->getLastError();
        }


//        return json_encode($customerArray,JSON_PRETTY_PRINT);
    }

    public function getproductlistold() {

        session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => "development"
        ));
        $accessToken = $_SESSION['sessionAccessToken'];
        $dataService->updateOAuth2Token($accessToken);

        $productArray = $dataService->Query("select * from Item");
        if ($productArray) {
            $objProduct = new Product();
            $result = $objProduct->addProduct($productArray);
            if ($result) {
                $return['status'] = 'success';
                $return['message'] = 'Productlist Updated successfully.';
                $return['redirect'] = route('admin-product');
            } else {
                $return['status'] = 'error';
                $return['message'] = 'something will be wrong.';
            }
            echo json_encode($return);
            exit;
        } else {
            $error = $dataService->getLastError();
        }


//        return json_encode($customerArray,JSON_PRETTY_PRINT);
    }

    public function getcustomerlist() {

//        session_start();
//        $dataService = DataService::Configure(array(
//                    'auth_mode' => 'oauth2',
//                    'ClientID' => env('CLIENTID', ''),
//                    'ClientSecret' => env('CLIENTSECRET', ''),
//                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
//                    'scope' => env('OAUTHSCOPE', 'mysql'),
//                    'baseUrl' => "development"
//        ));
//        $accessToken = $_SESSION['sessionAccessToken'];
//        $dataService->updateOAuth2Token($accessToken);
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
                    'baseUrl' => env('QBBASEURL', "development"),
                    'QBORealmID' => $getrealmId,
                    'accessTokenKey' => $accessTokenObj->getAccessToken(),
                    'refreshTokenKey' => $accessTokenObj->getRefreshToken(),
        ));
        
        $customerArray = $dataService->Query("select * from Customer");

        $objCustomer = new Customer();
        $result = $objCustomer->addCustomer($customerArray);
        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'Customerlist updated successfully.';
            $return['redirect'] = route('admin-customer');
        } else {
            $return['status'] = 'error';
            $return['message'] = 'something will be wrong.';
        }
        echo json_encode($return);
        exit;
        $error = $dataService->getLastError();
//        return json_encode($customerArray,JSON_PRETTY_PRINT);
    }

    public function getcustomerlistold() {

        session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => "development"
        ));
        $accessToken = $_SESSION['sessionAccessToken'];
        $dataService->updateOAuth2Token($accessToken);
        $customerArray = $dataService->Query("select * from Customer");

        $objCustomer = new Customer();
        $result = $objCustomer->addCustomer($customerArray);
        if ($result) {
            $return['status'] = 'success';
            $return['message'] = 'Customerlist updated successfully.';
            $return['redirect'] = route('admin-customer');
        } else {
            $return['status'] = 'error';
            $return['message'] = 'something will be wrong.';
        }
        echo json_encode($return);
        exit;
        $error = $dataService->getLastError();
//        return json_encode($customerArray,JSON_PRETTY_PRINT);
    }

    public function createInvoice() {
        session_start();

        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => "development"
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

    public function getCustomerObj($dataService) {
        $customerName = 'Mr Parth Hareshbhai Khunt fdf';
        $customerArray = $dataService->Query("select * from Customer where DisplayName='" . $customerName . "'");

        $error = $dataService->getLastError();
        if ($error) {
            logError($error);
        } else {
            if (sizeof($customerArray) > 0) {
                return current($customerArray);
            }
        }
    }

    public function getItemObj($dataService) {
        $itemName = 'Concrete';
        $itemArray = $dataService->Query("select * from Item WHERE Name='" . $itemName . "'");

        $error = $dataService->getLastError();
        if ($error) {
            logError($error);
        } else {
            if (sizeof($itemArray) > 0) {
                return current($itemArray);
            }
        }
    }

}
