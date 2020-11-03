<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Invoice;
class DashboardController extends Controller
{
    public function __construct() {
//        parent::__construct();
         $this->middleware('admin');
    }
    
    public function index(){
         session_start();
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => env('CLIENTID', ''),
                    'ClientSecret' => env('CLIENTSECRET', ''),
                    'RedirectURI' => env('OAUTHREDIRECTURI', ''),
                    'scope' => env('OAUTHSCOPE', 'mysql'),
                    'baseUrl' => "development"
        ));


        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $authUrl = $OAuth2LoginHelper->getAuthorizationCodeURL();
        $data['authUrl'] = $authUrl;
        
        // Store the url in PHP Session Object;
        $_SESSION['authUrl'] = $authUrl;

        //set the access token using the auth object
        if (isset($_SESSION['sessionAccessToken'])) {
            $accessToken = $_SESSION['sessionAccessToken'];
//                         print_r($accessToken->getAccessToken());
//            die();
            $accessTokenJson = array('token_type' => 'bearer',
                'access_token' => $accessToken->getAccessToken(),
                'refresh_token' => $accessToken->getRefreshToken(),
                'x_refresh_token_expires_in' => $accessToken->getRefreshTokenExpiresAt(),
                'expires_in' => $accessToken->getAccessTokenExpiresAt()
            );
//             print_r($accessTokenJson['access_token']);
//            die();
            $dataService->updateOAuth2Token($accessToken);
            $oauthLoginHelper = $dataService->getOAuth2LoginHelper();
            $CompanyInfo = $dataService->getCompanyInfo();
            $data['accessTokenJson'] = $accessTokenJson;
            
        }
        
        $data['header'] = array(
            'title' => 'Dashborad',
            'breadcrumb' => array(
                'Home' => route("admin-dashboard"),
                ));
        $data['pluginjs'] = array('jQuery/jquery.validate.min.js');
        $data['js'] = array('dashborad.js');
        $data['funinit'] = array('Dashborad.init()');
        $data['css'] = array('');
        return view('admin.dashborad.dashborad',$data);
    }
}
