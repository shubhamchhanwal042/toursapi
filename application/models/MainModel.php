<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class MainModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
        
    }

    function createAdmin()
    {
        $data = $this->db->get("admin")->row_array();
        if ($data != null) {
            return null;
        } else {
            $password = password_hash("admin", PASSWORD_BCRYPT);
            $data = array(
                "email" => "admin",
                "password" => $password,
            );
            return $this->db->insert("admin", $data);
        }
    }

    function registerUser($data)
    {
        // print_r($data);die;

        return $this->db->insert("users", $data);
    }

    function adminLogin($email, $password)
    {
        $admin = $this->db->get_where('admin', array("email" => $email))->row_array();
        if ($admin != null) {
            if (password_verify($password, $admin["password"])) {
                return $admin;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    // Ganesh Functions

    function login($email, $password)
    {
        $user = $this->db->get_where('users', array("email" => $email))->row_array();

        if ($user && password_verify($password, $user["password"])) {
            return [
                "id" => $user["id"],
                "email" => $user["email"],
                "name" => $user["name"]
            ];
        }

        return false;
    }




    public function checkEmailExists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        return ($query->num_rows() > 0);
    }

    


    public function sendOtp($email, $otp)
    {
        // var_dump($email,$otp);die;
        // Email configuration
        $config['protocol']    = 'smtp';
        $config['smtp_host']   = 'smtp.gmail.com';
        $config['smtp_port']   = 587;
        $config['smtp_user']   = 'ganeshgodse1902@gmail.com'; // Your Gmail ID
        $config['smtp_pass']   = 'ijny qqlh hojz vxhs'; // Your App Password
        $config['smtp_crypto'] = 'tls'; // Use 'ssl' for port 465
        $config['mailtype']    = 'html';
        $config['charset']     = 'utf-8';
        $config['newline']     = "\r\n";
        $config['wordwrap']    = TRUE;

        // Load the email library with the configuration
        $this->load->library('email', $config);

        // Set email details
        $this->email->from('ganeshgodse1902@gmail.com', 'Hari_Om_Dhaba');
        $this->email->to($email);
        $this->email->subject('Password Reset OTP');

        // Create the email message with the OTP
        $message = "<p>Your OTP for password reset is: <b>$otp</b></p>";
        $this->email->message($message);

        // Send email and check for success or failure
        if ($this->email->send()) {
            return true;
        } else {
            // Log the error details
            $error_message = $this->email->print_debugger();
            log_message('error', 'Email failed to send. Debugger output: ' . $error_message);
            return false;
        }
    }
}
