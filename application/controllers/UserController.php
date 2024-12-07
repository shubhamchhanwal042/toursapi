<?php 

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("UserModel");
    }



    
// Student Realted Functions
function GetAllUsers()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Users = $this->UserModel->getAllUsers();
        if ($Users!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Users, "message" => "Users Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Users Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function RegisterUser()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formdata = $this->input->post();
        $password = $this->MainModel->encryptData($formdata["password"]);
        $formdata["password"] = $password;
        $result = $this->UserModel->registerUser($formdata);
        if ($result!=null) {
            $this->output->set_status_header(201);
            $response = array("status" => "success", "message" => "User Registered Successfully");
        } else {
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occured While Registering Student");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function GetUserByID($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Student = $this->UserModel->getStudent($id);
        if ($Student != null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Student, "message" => "Student Data Fetched Successfully");
        } else {
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Student Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function UpdateUser($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $User = $this->UserModel->getUserById($id);
        if ($User!=null) {
            $formdata = $this->input->post();
            if (!empty($formdata["password"])) {
                $password = $this->MainModel->encryptData($formdata["password"]);
                $formdata["password"] = $password;
            }
            $result = $this->UserModel->updateUser($id, $formdata);
            if ($result) {
                $this->output->set_status_header(200);
                $response = array("status" => "success", "message" => "Student Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occurred While Updating Student Data");
            }
        } else {
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "User not found");
        }
    } else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }

    // Output JSON response
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function DeleteUser($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $User=$this->UserModel->getUserById($id);
                if($User!=null)
                {
                    $result = $this->UserModel->deleteUserById($id);
                    if ($result) {
                        $this->output->set_status_header(200);
                        $response = array("status" => "success", "message" => "User Deleted Successfully");
                    } else {
                        $this->output->set_status_header(500);
                        $response = array("status" => "error", "message" => "Some Error Occured While Deleting Student Data");
                    }
                }
                else{
                    $this->output->set_status_header(404);
                    $response = array("status" => "error", "message" => "No User Found");
                }
        }
        else {
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function CheckStudentEmailExists()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $email = urldecode($this->input->get("email"));
        $email = $this->UserModel->getStudentByEmail($email);
        if ($email != null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Email Found");
        } else {
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}
    
}





?>