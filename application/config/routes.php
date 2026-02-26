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
|	https://codeigniter.com/userguide3/general/routing.html
*/

// CodeIgniter reserved routes
$route['default_controller'] = "news";
$route['404_override'] = 'errors';
$route['translate_uri_dashes'] = FALSE;

//Auth
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
//$route['register'] = 'auth/register';
$route['register/activate/(:any)'] = 'register/activate/$1';
$route['password_recovery'] = 'auth/password_recovery';
$route['password_recovery/create_request'] = 'auth/password_recovery/create_request';
$route['password_recovery/reset_password'] = 'auth/password_recovery/reset_password';

// News
$route['news/(:num)'] = "news/index/$1";

// Pages
$route['page/admin/(:any)'] = "page/admin/$1";
$route['page/admin'] = "page/admin/index";
$route['page/(:any)'] = "page/index/$1";

// Comments
$route['news/comments/get/(:num)'] = "news/comments/get/$1";
$route['news/comments/add/(:num)'] = "news/comments/add/$1";

// Profile
$route['profile/(:num)'] = "profile/index/$1";

// Armory
$route['character/(:num)'] = "character/index/$1";
$route['character/(:num)/(:any)'] = "character/index/$1/$2";
$route['guild/(:num)/(:num)'] = "guild/index/$1/$2";
$route['tooltip/(:num)/(:num)'] = "tooltip/index/$1/$2";
$route['item/(:num)/(:num)'] = "item/index/$1/$2";

// Admin
$route['admin/edit/save/(:any)'] = "admin/edit/save/$1";
$route['admin/edit/saveSource/(:any)'] = "admin/edit/saveSource/$1";
$route['admin/edit/(:any)'] = "admin/edit/index/$1";

// Vote
$route['vote/callback/(:any)'] = "vote/callback/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */
