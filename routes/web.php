<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'LoginController@index');
//Route::get('/login', 'LoginController@index');
Route::match(['get', 'post'], 'login', ['as' => 'login', 'uses' => 'LoginController@index']);
Route::match(['get', 'post'], 'createPassword', ['as' => 'createPassword', 'uses' => 'LoginController@createPassword']);
Route::match(['get', 'post'], 'logout', ['as' => 'logout', 'uses' => 'LoginController@getLogout']);
Route::match(['get', 'post'], 'forgot-password', ['as' => 'forgot-password', 'uses' => 'LoginController@forgotpassword']);

//admin-dashboard
//admin-users
Route::match(['get', 'post'], 'admin-dashboard', ['as' => 'admin-dashboard', 'uses' => 'admin\DashboardController@index']);
Route::match(['get', 'post'], 'admin-users', ['as' => 'admin-users', 'uses' => 'admin\UsersController@index']);
Route::match(['get', 'post'], 'add-users', ['as' => 'add-users', 'uses' => 'admin\UsersController@add']);
Route::match(['get', 'post'], 'userList-ajaxAction', ['as' => 'userList-ajaxAction', 'uses' => 'admin\UsersController@ajaxCall']);
Route::match(['get', 'post'], 'edit-users/{id}', ['as' => 'edit-users', 'uses' => 'admin\UsersController@edit']);

Route::match(['get', 'post'], 'admin-forgot-password', ['as' => 'admin-forgot-password', 'uses' => 'LoginController@forgotpassword']);
Route::match(['get', 'post'], 'admin-change-password', ['as' => 'admin-change-password', 'uses' => 'admin\UpdateProfileController@changepassword']);
Route::match(['get', 'post'], 'admin-update-profile', ['as' => 'admin-update-profile', 'uses' => 'admin\UpdateProfileController@editProfile']);

Route::match(['get', 'post'], 'admin-customer', ['as' => 'admin-customer', 'uses' => 'admin\CustomerController@index']);
Route::match(['get', 'post'], 'customer-ajaxAction', ['as' => 'customer-ajaxAction', 'uses' => 'admin\CustomerController@ajaxCall']);


Route::match(['get', 'post'], 'admin-product', ['as' => 'admin-product', 'uses' => 'admin\ProductController@index']);
Route::match(['get', 'post'], 'product-ajaxAction', ['as' => 'product-ajaxAction', 'uses' => 'admin\ProductController@ajaxCall']);

Route::match(['get', 'post'], 'admin-invoice', ['as' => 'admin-invoice', 'uses' => 'admin\InvoiceController@index']);
Route::match(['get', 'post'], 'admin-invoice-create', ['as' => 'admin-invoice-create', 'uses' => 'admin\InvoiceController@createInvoice']);
Route::match(['get', 'post'], 'invoice-ajaxAction', ['as' => 'invoice-ajaxAction', 'uses' => 'admin\InvoiceController@ajaxCall']);

Route::match(['get', 'post'], 'quickbook-start', ['as' => 'quickbook-start', 'uses' => 'admin\QuickbookApiController@quickbookstart']);
Route::match(['get', 'post'], 'quickbook-callback', ['as' => 'quickbook-callback', 'uses' => 'admin\QuickbookApiController@quickbookcallback']);
Route::match(['get', 'post'], 'get-company-info', ['as' => 'get-company-info', 'uses' => 'admin\QuickbookApiController@getcompanyinfo']);
Route::match(['get', 'post'], 'get-invoice-list', ['as' => 'get-invoice-list', 'uses' => 'admin\QuickbookApiController@getinvoicelist']);
Route::match(['get', 'post'], 'get-product-list', ['as' => 'get-product-list', 'uses' => 'admin\QuickbookApiController@getproductlist']);
Route::match(['get', 'post'], 'get-customer-list', ['as' => 'get-customer-list', 'uses' => 'admin\QuickbookApiController@getcustomerlist']);
Route::match(['get', 'post'], 'create-invoice', ['as' => 'create-invoice', 'uses' => 'admin\QuickbookApiController@createInvoice']);

//Api
Route::match(['get','post'],'api/login',(['as'=>'api-login','uses'=>'api\ApiController@login']));
Route::match(['get','post'],'api/customerlist',(['as'=>'api-customerlist','uses'=>'api\ApiController@customerlist']));

Route::match(['get','post'],'api/getproductwithsku',(['as'=>'api-getproductwithsku','uses'=>'api\ApiController@getproductwithsku']));
Route::match(['get','post'],'api/getproductquantity',(['as'=>'api-getproductquantity','uses'=>'api\ApiController@getproductquantity']));
Route::match(['get','post'],'api/getinvoiceid',(['as'=>'api-getinvoiceid','uses'=>'api\ApiController@getinvoiceid']));
Route::match(['get','post'],'api/saveproduct',(['as'=>'api-saveproduct','uses'=>'api\ApiController@saveproduct']));
Route::match(['get','post'],'api/createinvoice',(['as'=>'api-createinvoice','uses'=>'api\ApiController@createinvoice']));


Route::match(['get','post'],'api/testPostman',(['as'=>'api-testPostman','uses'=>'api\ApiController@testPostman']));