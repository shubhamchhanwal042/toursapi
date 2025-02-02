<?php 

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("UserModel");
        $this->load->model("Packages_Api_Model");

    }
// -----------------------------------------------USER BOOKINGS APIS--------------------------------------

function AddBusBookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        $result = $this->UserModel->AddBusBookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Bus Booking Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Bus Booking Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllBus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBus();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Bus Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllBusByid($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetAllBusByid($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "Bus Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function AddHotelBookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        $result = $this->UserModel->AddHotelBookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Hotel Booking Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Hotel Booking Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetHotelByid($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetHotelByid($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "Hotel Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Hotel Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function AddCabBookings(){

    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $formdata = $this->input->post();
        $result = $this->UserModel->AddCabBookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Cab Booking Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Cab Booking Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetCabByid($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetCabByid($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "Cab Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Cab Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function PackageBookings(){
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $formdata = $this->input->post();
        $result = $this->UserModel->PackageBookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Package Booking Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Package Booking Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}
    
function GetpackageByid($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetpackageByid($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "package Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No package Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

// --------------------------------------------GET UPCOMMING TRIPS USING USER ID ---------------------------------
function GetUpcommingTrips($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetUpcommingTrips($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "Trips Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Trips Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetRecentTrips($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $bus = $this->UserModel->GetRecentTrips($id);
        if ($bus!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $bus, "message" => "Trips Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Trips Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


// ----------------------------------------------------------REIVEW TABLE -----------------------------------------
function AddReviews(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->UserModel->AddReviews($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Review Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Review Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function UpdateReviews($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllReviewsById($id);

        if ($result != null) {
            $formdata = $this->input->post();
            $result = $this->Packages_Api_Model->UpdateReviews($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Reviews Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Reviews Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Currency Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


// ---------------------------------USER ADD ENQUIRY API ------------------------------------------


function AddEnquiry(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->UserModel->AddEnquiry($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Enquiry Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Enquiry Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}




// <!--------------------------- Ganesh Views ------------------------>
// <!-------------- Get All Hotels ------------------->
public function GetAllHotels()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $this->Packages_Api_Model->GetAllHotel();
        
        if (!empty($result)) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Hotels fetched successfully", "data" => $result);
        } else {
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No hotels found");
        }
    } else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Method Not Allowed");
    }
    
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}
// <!-------------- Get All Hotels Ends Here ------------------->



// <!-------------- Get All Cabs ------------------->
public function GetAllCab()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $this->Packages_Api_Model->GetAllCab();
        
        if (!empty($result)) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Cabs fetched successfully", "data" => $result);
        } else {
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Cabs found");
        }
    } else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Method Not Allowed");
    }
    
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}
// <!-------------- Get All Cabs Ends Here ------------------->





}
?>
















