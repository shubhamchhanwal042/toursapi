<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class Main extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
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
    // ------------------ SEND OTP  ------------------ 
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


    public function SendOtp()
    {
        $email = $this->input->get('email');

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email is required'
            ]);
            return;
        }

        $otp = rand(1000, 9999); // Generate 4-digit OTP

        // Store email in session (so user doesn't have to re-enter)
        $this->session->set_userdata('otp_email', $email);

        // Set the expiration time to 15 minutes from now
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        // Save OTP in the database
        $data = [
            'email' => $email,
            'otp' => $otp,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => $expires_at // Store expiration time
        ];
        $this->db->insert('otp_verification', $data);

        // Send OTP via email
        if ($this->MainModel->sendOtp($email, $otp)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send OTP. Please try again later.'
            ]);
        }
    }
    // ------------------ SEND OTP ENDS HERE  ------------------ 


   // ------------------ VERIFY OTP   ------------------ 
    public function VerifyOtp()
    {
        $otp = $this->input->post('otp');
        $email = $this->session->userdata('otp_email'); // Retrieve email from session

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Session expired. Please request OTP again.'
            ]);
            return;
        }

        // Fetch the latest OTP for this email from the database
        $this->db->where('email', $email);
        $this->db->where('expires_at >', date('Y-m-d H:i:s')); // Ensure OTP has not expired
        $this->db->order_by('created_at', 'DESC'); // Get the latest OTP
        $otpRecord = $this->db->get('otp_verification')->row();

        if ($otpRecord && $otpRecord->otp == $otp) {
            // OTP is correct, remove it from the database for security
            $this->db->where('email', $email);
            $this->db->delete('otp_verification');

            // Remove email from session (to prevent reusing OTP)
            $this->session->unset_userdata('otp_email');

            echo json_encode([
                'status' => 'success',
                'message' => 'OTP verified successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid OTP or OTP expired'
            ]);
        }
    }
    // ------------------ VERIFY OTP ENDS HERE  ------------------ 


     // ------------------ SET NEW PASSSOWRD ------------------ 
     public function SetNewPassword() {
        $email = $this->session->userdata('otp_email'); // Retrieve email from session
        $new_password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Session expired. Please request OTP again.'
            ]);
            return;
        }

        if (!$new_password || !$confirm_password) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Both password fields are required.'
            ]);
            return;
        }

        if ($new_password !== $confirm_password) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Passwords do not match.'
            ]);
            return;
        }

        // Update the password in the database
        if ($this->AuthModel->updatePassword($email, $new_password)) {
            // Remove email from session after success
            $this->session->unset_userdata('otp_email');

            echo json_encode([
                'status' => 'success',
                'message' => 'Password reset successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update password. Try again.'
            ]);
        }
    }
    // ------------------ SET NEW PASSSOWRD ENDS HERE ------------------ 
}
