<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class Main extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("MainModel");
        $this->MainModel->createAdmin();
    }



    function Signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formdata = $this->input->post();
            $password = password_hash($formdata["password"], PASSWORD_BCRYPT);
            $formdata["password"] = $password;
            // print_r($formdata);die;

            $result = $this->MainModel->registerUser($formdata);
            // print_r($result);die;
            if ($result != null) {
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

    function AdminLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            // print_r($email);die;
            $result = $this->MainModel->adminLogin($email, $password);
            if ($result != null && $result != false) {
                $this->output->set_status_header(200);
                $response = array("status" => "success", "message" => "Admin Loggedin Successfully");
            } elseif ($result == false) {
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Wrong Credentials");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Logging in");
            }
        } else {
            $this->output->set_status_header(405);

            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }

    function Login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $result = $this->MainModel->login($email, $password);
            if ($result) {
                $this->output->set_status_header(200);
                $response = array("status" => "success", "message" => "User Loggedin Successfully");
            } elseif ($result == false) {
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Wrong Credentials");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Logging in");
            }
        } else {
            $this->output->set_status_header(405);

            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }


    // Ganesh APIS
    public function IsEmailAlreadyExists()
    {
        $email = $this->input->post('email');

        if (!$email) {
            $response = ["status" => "error", "message" => "Email is required."];
            error_log(json_encode($response));
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($response));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response = ["status" => "error", "message" => "Invalid email format."];
            error_log(json_encode($response));
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($response));
        }

        // Check if email exists
        $exists = $this->MainModel->checkEmailExists($email);
        error_log("Email Exists Check: " . var_export($exists, true));

        // Ensure `exists` is always present in the response
        $response = [
            "status" => $exists ? "error" : "success",
            "exists" => (bool) $exists, // Ensure `exists` is always a boolean
            "message" => $exists ? "Email already exists." : "Email is available."
        ];

        error_log("Final API Response: " . json_encode($response));

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($exists ? 409 : 200)
            ->set_output(json_encode($response));
    }
}
