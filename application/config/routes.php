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

$route['admin/addpackage'] = 'PackagesController/AddPackages';
$route['admin/getpackages'] = 'PackagesController/GetAllPackages';
$route['admin/updatepackage/(:num)'] = 'PackagesController/UpdatePackages/$1';
$route['admin/getpackagebyid/(:num)'] = 'PackagesController/GetAllPackagesById/$1';
$route['admin/deletepackage/(:num)'] = 'PackagesController/DeletePackages/$1';


// ---------------------------BOOKING SECTION -------------------------------------
$route['admin/addbooking'] = 'PackagesController/AddBookings';
$route['admin/getbooking'] = 'PackagesController/GetAllBooking';
$route['admin/updatebooking/(:num)'] = 'PackagesController/UpdateBooking/$1';
$route['admin/getbookingbyid/(:num)'] = 'PackagesController/GetAllBookingById/$1';
$route['admin/deletebooking/(:num)'] = 'PackagesController/DeleteBooking/$1';


// ---------------------------INQUIRES SECTION -------------------------------------
$route['admin/addinquires'] = 'PackagesController/AddInquires';
$route['admin/getinquires'] = 'PackagesController/GetAllInquires';
$route['admin/updateinquires/(:num)'] = 'PackagesController/UpdateInquires/$1';
$route['admin/getinquiresbyid/(:num)'] = 'PackagesController/GetAllInquiresById/$1';
$route['admin/deleteinquires/(:num)'] = 'PackagesController/DeleteInquires/$1';

// ---------------------------SERVICES SECTION -------------------------------------
$route['admin/addservices'] = 'PackagesController/AddServices';
$route['admin/getservices'] = 'PackagesController/GetAllServices';
$route['admin/updateservices/(:num)'] = 'PackagesController/UpdateServices/$1';
$route['admin/getservicesbyid/(:num)'] = 'PackagesController/GetAllServicesById/$1';
$route['admin/deleteservices/(:num)'] = 'PackagesController/DeleteServices/$1';

// ---------------------------CURRENCY SECTION -------------------------------------
$route['admin/addcurrency'] = 'PackagesController/AddCurrency';
$route['admin/getcurrency'] = 'PackagesController/GetAllCurrency';
$route['admin/updatecurrency/(:num)'] = 'PackagesController/UpdateCurrency/$1';
$route['admin/getcurrencybyid/(:num)'] = 'PackagesController/GetAllCurrencyById/$1';
$route['admin/deletecurrency/(:num)'] = 'PackagesController/DeleteCurrency/$1';

// ---------------------------BUS SECTION -------------------------------------
$route['admin/addbus'] = 'PackagesController/AddBus';
$route['admin/getbus'] = 'PackagesController/GetAllBus';
$route['admin/updatebus/(:num)'] = 'PackagesController/UpdateBus/$1';
$route['admin/getbusbyid/(:num)'] = 'PackagesController/GetAllBusById/$1';
$route['admin/deletebus/(:num)'] = 'PackagesController/DeleteBus/$1';

// ---------------------------Cab SECTION -------------------------------------
$route['admin/addcab'] = 'PackagesController/AddCab';
$route['admin/getcab'] = 'PackagesController/GetAllCab';
$route['admin/updatecab/(:num)'] = 'PackagesController/UpdateCab/$1';
$route['admin/getcabbyid/(:num)'] = 'PackagesController/GetAllCabById/$1';
$route['admin/deletecab/(:num)'] = 'PackagesController/DeleteCab/$1';

// ---------------------------HOTEL SECTION -------------------------------------
$route['admin/addhotel'] = 'PackagesController/AddHotel';
$route['admin/gethotel'] = 'PackagesController/GetAllHotel';
$route['admin/updatehotel/(:num)'] = 'PackagesController/UpdateHotel/$1';
$route['admin/gethotelbyid/(:num)'] = 'PackagesController/GetAllHotelById/$1';
$route['admin/deletehotel/(:num)'] = 'PackagesController/DeleteHotel/$1';




// ------------------------------------------- USER SIDE ROUTES-----------------------------
// ---------------------------TO CHANGE BOOKING STATUS -------------------------------------
$route['admin/bookpackage'] = 'PackagesController/AddPackage_Bookings';
$route['admin/changebookingstatus/(:any)/(:any)'] = 'PackagesController/ChangeBookingStatus/$1/$2';

// ----------------------------------------BUS BOOKING ROUTES----------------------------

// -------------------------------------TO CHANGE BUS BOOKING STATUS----------------------------
$route['admin/bookbus'] = 'PackagesController/AddBus_Bookings';
$route['admin/busbookingstatus/(:any)/(:any)'] = 'PackagesController/ChangeBusStatus/$1/$2';

// -------------------------------------TO CHANGE CAB BOOKING STATUS----------------------------
$route['admin/bookcap'] = 'PackagesController/AddCab_Bookings';
$route['admin/capbookingstatus/(:any)/(:any)'] = 'PackagesController/ChangeCapStatus/$1/$2';

// -------------------------------------TO CHANGE HOTEL BOOKING STATUS----------------------------
$route['admin/bookcap'] = 'PackagesController/AddHotel_Bookings';
$route['admin/hotelbookingstatus/(:any)/(:any)'] = 'PackagesController/ChangeHotelStatus/$1/$2';

// -------------------------------------------TO CHANGE PACKAGE BOOKING STATUS ----------------------
// $route['admin/bookcap'] = 'PackagesController/AddHotel_Bookings';
$route['admin/packagebookingbookingstatus/(:any)/(:any)'] = 'PackagesController/ChangePackageBookingStatus/$1/$2';

// --------------------------------------------ROUTES TO GET THE COUNTS ON DASHBOARD---------------------------------
$route['user/dashboardcounts'] = 'PackagesController/GetAllCounts';
$route['admin/dashboardcount'] = 'PackagesController/DashboardCount';


// ----------------------------------------- ROUTES TO GET ALL USERS---------------------------------------------------
$route['admin/getusers'] = 'PackagesController/GetAllUsers';
$route['admin/userstatus/(:any)/(:any)'] = 'PackagesController/ChangeUserStatus/$1/$2';


// ------------------------------------------- USER CONTROLLER ROUTS-------------------------------------------------
$route['user/addbus'] = 'UserController/AddBusBookings';
$route['user/getbus/(:any)'] = 'UserController/GetAllBusByid/$1';

$route['user/addhotel'] = 'UserController/AddHotelBookings';
$route['user/gethotel/(:any)'] = 'UserController/GetHotelByid/$1';


$route['user/addcap'] = 'UserController/AddCabBookings';
$route['user/getcab/(:any)'] = 'UserController/GetCabByid/$1';

$route['user/addpackage'] = 'UserController/PackageBookings';
$route['user/getpackage/(:any)'] = 'UserController/GetpackageByid/$1';

// ------------------------------------------- Ganesh  (Get All Hotel) ROUTS-------------------------------------------------
$route['user/getallhotels'] = 'UserController/GetAllHotels';

// -------------------------------------SINGUP CONTROLLER---------------------------------------

$route['AdminLogin'] = 'Main/AdminLogin';

// Ganesh Routes
$route['login'] = 'Main/Login';
$route['signup'] = 'Main/Signup';
$route['sendOtp'] = 'Main/SendOtp';  
$route['IsEmailAlreadyExists'] = 'Main/IsEmailAlreadyExists';

// -------------------------------------------------BANNER ROUTES PACKAGES CONTROLLER--------------

$route['banner'] = 'PackagesController/AddBanner';
$route['admin/getbanner'] = 'PackagesController/GetAllBanner';
$route['admin/updatebanner/(:num)'] = 'PackagesController/UpdateBanner/$1';
$route['admin/getbannerbyid/(:num)'] = 'PackagesController/GetAllBannerById/$1';
$route['admin/deletebanner/(:num)'] = 'PackagesController/DeleteBanner/$1';

// ----------------------------------USER LOGIN API----------------------------------------------------
$route['userlogin'] = 'Main/Login';


// -------------------------------GET UPCOMMING TRIPS -----------------------------------
$route['user/gettrips/(:any)'] = 'UserController/GetUpcommingTrips/$1';
$route['user/getrecenttrips/(:any)'] = 'UserController/GetRecentTrips/$1';

$route['addreview'] = 'UserController/AddReviews';

 // ---------------------------------------------GET BOOKINGS DATA ------------------------------- -->
$route['admin/getbusbookings'] = 'PackagesController/GetAllBusBooking';
$route['admin/getcabbookings'] = 'PackagesController/GetAllCabBooking';
$route['admin/gethotelbookings'] = 'PackagesController/GetAllHotelBooking';
$route['admin/getpackagebookings'] = 'PackagesController/GetAllPackageBooking';

// ------------------------------------ADD REVIEWS -------------------------------------
 $route['admin/review'] = 'PackagesController/GetAllReviews';
 $route['admin/reviewstatus/(:any)/(:any)'] = 'PackagesController/ChangeReviewStatus/$1/$2';
 $route['admin/deletereview/(:any)'] = 'PackagesController/DelteReviewsByid/$1';


//  -----------------------------------------  ENQUIRY API ------------------------------------

$route['user/addenquiry'] = 'UserController/AddEnquiry';


