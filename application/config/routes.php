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
$route['about'] = 'Welcome/About';
$route['translate_uri_dashes'] = FALSE;

$route['display'] = 'blog/display';
$route['blog/read_more/(:num)'] = 'blog/read_more/$1';


// ------------------------PACKAGES CONTROLLER APIS  USER SIDE-------------------------------

// ---------------------------PACKAGES SECTION -------------------------------------

$route['admin/addpackage'] = 'packagescontroller/AddPackages';
$route['admin/getpackages'] = 'packagescontroller/GetAllPackages';
$route['admin/updatepackage/(:num)'] = 'packagescontroller/UpdatePackages/$1';
$route['admin/getpackagebyid/(:num)'] = 'packagescontroller/GetAllPackagesById/$1';
$route['admin/deletepackage/(:num)'] = 'packagescontroller/DeletePackages/$1';


// ---------------------------BOOKING SECTION -------------------------------------
$route['admin/addbooking'] = 'packagescontroller/AddBookings';
$route['admin/getbooking'] = 'packagescontroller/GetAllBooking';
$route['admin/updatebooking/(:num)'] = 'packagescontroller/UpdateBooking/$1';
$route['admin/getbookingbyid/(:num)'] = 'packagescontroller/GetAllBookingById/$1';
$route['admin/deletebooking/(:num)'] = 'packagescontroller/DeleteBooking/$1';


// ---------------------------INQUIRES SECTION -------------------------------------
$route['admin/addinquires'] = 'packagescontroller/AddInquires';
$route['admin/getinquires'] = 'packagescontroller/GetAllInquires';
$route['admin/updateinquires/(:num)'] = 'packagescontroller/UpdateInquires/$1';
$route['admin/getinquiresbyid/(:num)'] = 'packagescontroller/GetAllInquiresById/$1';
$route['admin/deleteinquires/(:num)'] = 'packagescontroller/DeleteInquires/$1';

// ---------------------------SERVICES SECTION -------------------------------------
$route['admin/addservices'] = 'packagescontroller/AddServices';
$route['admin/getservices'] = 'packagescontroller/GetAllServices';
$route['admin/updateservices/(:num)'] = 'packagescontroller/UpdateServices/$1';
$route['admin/getservicesbyid/(:num)'] = 'packagescontroller/GetAllServicesById/$1';
$route['admin/deleteservices/(:num)'] = 'packagescontroller/DeleteServices/$1';

// ---------------------------CURRENCY SECTION -------------------------------------
$route['admin/addcurrency'] = 'packagescontroller/AddCurrency';
$route['admin/getcurrency'] = 'packagescontroller/GetAllCurrency';
$route['admin/updatecurrency/(:num)'] = 'packagescontroller/UpdateCurrency/$1';
$route['admin/getcurrencybyid/(:num)'] = 'packagescontroller/GetAllCurrencyById/$1';
$route['admin/deletecurrency/(:num)'] = 'packagescontroller/DeleteCurrency/$1';

// ---------------------------BUS SECTION -------------------------------------
$route['admin/addbus'] = 'packagescontroller/AddBus';
$route['admin/getbus'] = 'packagescontroller/GetAllBus';
$route['admin/updatebus/(:num)'] = 'packagescontroller/UpdateBus/$1';
$route['admin/getbusbyid/(:num)'] = 'packagescontroller/GetAllBusById/$1';
$route['admin/deletebus/(:num)'] = 'packagescontroller/DeleteBus/$1';

// ---------------------------HOTEL SECTION -------------------------------------
$route['admin/addhotel'] = 'packagescontroller/AddHotel';
$route['admin/gethotel'] = 'packagescontroller/GetAllHotel';
$route['admin/updatehotel/(:num)'] = 'packagescontroller/UpdateHotel/$1';
$route['admin/gethotelbyid/(:num)'] = 'packagescontroller/GetAllHotelById/$1';
$route['admin/deletehotel/(:num)'] = 'packagescontroller/DeleteHotel/$1';




// ------------------------------------------- USER SIDE ROUTES-----------------------------
// ---------------------------TO CHANGE BOOKING STATUS -------------------------------------
$route['admin/bookpackage'] = 'packagescontroller/AddPackage_Bookings';
$route['admin/changebookingstatus/(:any)/(:any)'] = 'packagescontroller/ChangeBookingStatus/$1/$2';

// ----------------------------------------BUS BOOKING ROUTES----------------------------

// -------------------------------------TO CHANGE BUS BOOKING STATUS----------------------------
$route['admin/bookbus'] = 'packagescontroller/AddBus_Bookings';
$route['admin/busbookingstatus/(:any)/(:any)'] = 'packagescontroller/ChangeBusStatus/$1/$2';

// -------------------------------------TO CHANGE CAB BOOKING STATUS----------------------------
$route['admin/bookcap'] = 'packagescontroller/AddCab_Bookings';
$route['admin/capbookingstatus/(:any)/(:any)'] = 'packagescontroller/ChangeCapStatus/$1/$2';

// -------------------------------------TO CHANGE HOTEL BOOKING STATUS----------------------------
$route['admin/bookcap'] = 'packagescontroller/AddHotel_Bookings';
$route['admin/hotelbookingstatus/(:any)/(:any)'] = 'packagescontroller/ChangeHotelStatus/$1/$2';

// --------------------------------------------ROUTES TO GET THE COUNTS ON DASHBOARD---------------------------------
$route['admin/dashboardcounts'] = 'packagescontroller/GetAllCounts';

// ----------------------------------------- ROUTES TO GET ALL USERS---------------------------------------------------
$route['admin/getusers'] = 'packagescontroller/GetAllUsers';
$route['admin/userstatus/(:any)/(:any)'] = 'packagescontroller/ChangeUserStatus/$1/$2';


// ------------------------------------------- USER CONTROLLER ROUTS-------------------------------------------------
$route['user/addbus'] = 'UserController/AddBusBookings';
$route['user/addhotel'] = 'UserController/AddHotelBookings';
$route['user/addcap'] = 'UserController/AddCabBookings';
$route['user/addpackage'] = 'UserController/PackageBookings';

// -------------------------------------SINGUP CONTROLLER---------------------------------------
$route['signup'] = 'Main/Signup';
$route['AdminLogin'] = 'Main/AdminLogin';

