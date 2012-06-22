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

$route['default_controller'] = 'main_controller';
$route['index'] = 'main_controller';
$route['404_override'] = 'filenotfound_controller';
$route['message'] = 'main_controller/message';
$route['message\#contact-form'] = 'main_controller/message#contact-form';
//$route['galleries/(:any)'] = 'main_controller/galleries/$1';
$route['galleries'] = 'main_controller/galleries';
$route['photo/(:any)'] = 'main_controller/photo/$1';
$route['photo'] = 'main_controller/photo';
$route['gallery/(:any)'] = 'main_controller/gallery/$1';
$route['galleries/(:any)'] = 'main_controller/galleries/$1';
$route['product_info'] = 'main_controller/product_info';
$route['proven_by_science'] = 'main_controller/proven_by_science';
$route['exceeding_standards'] = 'main_controller/exceeding_standards';
$route['using_product'] = 'main_controller/using_product';
$route['frequently_asked_questions'] = 'main_controller/frequently_asked_questions';
$route['architectural_details'] = 'main_controller/architectural_details';
$route['build_locations'] = 'main_controller/build_locations';
$route['colorbox/(:any)'] = 'main_controller/colorbox/$1';
//$route['user'] = 'user';
//$route['user/login'] = 'user/login';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
