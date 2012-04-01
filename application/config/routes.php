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

$route['default_controller'] = "static_content";
$route['404_override'] = '';

/*
| -------------------------------------------------------------------------
| MOZHUNT ROUTES
| -------------------------------------------------------------------------
*/

// legal documents
$route['legal'] 			= 'static_content/legal/landing';
$route['legal/tos'] 		= 'static_content/legal/tos';
$route['legal/privacy'] 	= 'static_content/legal/privacy';
$route['legal/disclaimers'] = 'static_content/legal/disclaimers';

// about pages
$route['about'] = 'static_content/about';

// contact pages
$route['contact'] = 'static_content/contact';

// user pages
$route['user'] 					= 'userPanel';
$route['user/account/(:any)'] 	= 'userPanel/$1';
$route['logout'] 				= 'static_content';

// admin pages
$route['admin'] 			= 'static_content/admin';
$route['admin/issue'] 		= 'static_content/issue';
$route['admin/user'] 		= 'userAdmin';
$route['admin/user/(:any)'] = 'userAdmin/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
