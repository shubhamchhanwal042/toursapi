<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class MainModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }

    function registerUser($data)
    {
        return $this->db->insert("users", $data);
    }

    function adminLogin($email,$password)
    {
        $admin = $this->db->get_where('admin',array("email"=>$email))->row_array();
        if ($admin != null) {
            if (password_verify($password, $admin->password)) {
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


}