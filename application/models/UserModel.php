<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }

    function bookPackage()
    {
        return $this->db->insert("package_bookings");
    }

    function registerUser($data)
    {
        return $this->db->insert("users", $data);
    }

    function getAllUsers()
    {
        $data = $this->db->get("users")->result_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

    function getUserById($id)
    {
        $data = $this->db->get_where("users", array("id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }


    function deleteUserById($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete("users");
    }

    function updateUser($id, $toupdatdata)
    {
        $this->db->where("id", $id);
        return $this->db->update("users", $toupdatdata);
    }


    function getStudentByEmail($email)
    {
        $data = $this->db->get_where("users", array("email" => $email))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

}