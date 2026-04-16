<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'welcome';
//$route['404_override'] = '';
$route['404_override'] = 'PageNotFound';
$route['translate_uri_dashes'] = FALSE;

// Registarsi
$route['registrasi/pilih-ctkb'] = 'registrasi/PilihCTKB';
$route['update-input-mandiri'] = 'registrasi/update_input_mandiri';

// Monitor
$route['monitor/list-tenaker-for-pbr'] = 'monitor/viewListByPBR';
$route['monitor/list-calon-tenaker'] = 'monitor/viewListTK';
$route['monitor/unscreening-by-hrd'] = 'monitor/unscreeningbyhrd';
$route['monitor/perubahan-mpp'] = 'monitor/perubahanmpp';

// Blacklist
$route['blacklist/list-tenaker-cancel'] = 'blacklist/listTenakerCancel';
$route['blacklist/salmonella-carrier'] = 'blacklist/salmonella_carrier';
$route['blacklist/search-nama'] = 'blacklist/search_nama';

// Upload berkas
$route['upload-berkas/list-for-upload-doc'] = 'UploadBerkas/listTKforUploadDoc';

// Applicant Registration
$route['register'] = 'Applicant_registration';
$route['register-action'] = 'Applicant_registration/register_action';

$route['login-act'] = 'Applicant_registration/login';
$route['check-login'] = 'Applicant_registration/checkLogin';
$route['verify-email/(.+)'] = 'Applicant_registration/verify_email/$1';

$route['forgot-password'] = 'Applicant_registration/forgot_password';
$route['forgot-password-action'] = 'Applicant_registration/forgot_password_action';
$route['reset-password-action'] = 'Applicant_registration/reset_password_action';
$route['reset-password/(.+)'] = 'Applicant_registration/reset_password/$1';

$route['form-registration'] = 'Applicant_registration/form_registration';

$route['logout-act'] = 'Applicant_registration/logout';
$route['success'] = 'Applicant_registration/success';

// Login Sea
$route['login-sea'] = 'C_login_sea/index';
$route['login-sea/(:any)/(:any)'] = 'C_login_sea/index/$1/$2';


// Approval MPP
$route['approval-mpp/hrd'] = 'Approval_mpp/hrd';
$route['approval-mpp/dept'] = 'Approval_mpp/dept';
$route['approval-mpp/divisi'] = 'Approval_mpp/divisi';

// Print Berkas
$route['print-berkas'] = 'PrintControl/newPaging';
