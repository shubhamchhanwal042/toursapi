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
                $this->output->set_status_header(201);
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
                $this->output->set_status_header(201);
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


}
