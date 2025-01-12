<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['auth/login'] = 'auth/login_view'; // For the user login form
$route['auth/admin-login'] = 'auth/admin_login_view'; // For the admin login form
$route['auth/login_action'] = 'auth/login_action'; // For handling the login action
$route['auth/logout'] = 'auth/logout'; 
$route['user/dashboard'] = 'UserController/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/users'] = 'admin/users';
$route['admin/products'] = 'admin/products';
$route['admin/receipts'] = 'ReceiptController/index';
$route['admin/invoices'] = 'InvoiceController/index';
$route['user/invoices/(:num)'] = 'InvoiceController/user_index/$1';
$route['user/receipts/(:num)'] = 'ReceiptController/user_index/$1';
$route['products'] = 'ProductController/index';
$route['api/products'] = 'ProductController/fetch_products';
$route['api/add_products'] = 'ProductController/add_products';
$route['api/users'] = 'UserController/fetch_users';
$route['api/add_users'] = 'UserController/add_users';
$route['checkout'] = 'checkout/index';        
$route['checkout/process'] = 'CheckoutController/process';
$route['checkout/success'] = 'CheckoutController/success'; 
$route['checkout/cancel'] = 'CheckoutController/cancel';   
$route['checkout/complete'] = 'CheckoutController/complete';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
