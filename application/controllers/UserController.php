<?php 

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("UserModel");
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
    
}





?>