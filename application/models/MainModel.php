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
        $data=$this->db->get("admin")->row_array();
        if($data!=null)
        {
            return null;
        }
        else{
            $password = password_hash("admin", PASSWORD_BCRYPT);
            $data=array(
                "email"=>"admin",
                "password"=>$password,
            );
            return $this->db->insert("admin",$data);
        }
    }

    function registerUser($data)
    {
                    // print_r($data);die;

        return $this->db->insert("users", $data);
    }

    function adminLogin($email,$password)
    {
        $admin = $this->db->get_where('admin',array("email"=>$email))->row_array();
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

    function login($email, $password)
    {
        $user = $this->db->get_where('users',array("email"=>$email))->row_array();
        if ($user != null) {
            if (password_verify($password, $user["password"])) {
                return $user;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }


    // Ganesh Functions
    
    public function checkEmailExists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');

        return ($query->num_rows() > 0); 
    }


}