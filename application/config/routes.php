<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// CodeIgniter
$route['default_controller'] = "news";
$route['404_override'] = 'error';

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
$route['profile/(:any)'] = "profile/index/$1";
$route['messages/page/(:any)'] = "messages/index/$1";
$route['messages/read/(:num)'] = "messages/read/index/$1";
$route['messages/create/(:num)'] = "messages/create/index/$1";

// Armory
$route['character/(:any)'] = "character/index/$1";
$route['guild/(:any)'] = "guild/index/$1";
$route['tooltip/(:any)'] = "tooltip/index/$1";
$route['item/(:any)'] = "item/index/$1";

// Admin
$route['admin/edit/save/(:any)'] = "admin/edit/save/$1";
$route['admin/edit/saveSource/(:any)'] = "admin/edit/saveSource/$1";
$route['admin/edit/(:any)'] = "admin/edit/index/$1";

// Vote
$route['vote/callback/(:any)'] = "vote/callback/index/$1";

/* End of file routes.php */
/* Location: ./application/config/routes.php */