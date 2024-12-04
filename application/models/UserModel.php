<?php

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserModel extends CI_Model
{
    function __construct()
    {
        $this->load->database();
    }

    function createUser($data)
    {
       return $this->db->insert("user",$data);
    }

    function getData()
    {
        $data=$this->db->get("user")->result_array();
        if($data!=null)
        {
            return $data;
        }
        return null;
    }

    function getDataById($id)
    {
        // $this->db->where("id",$id);
        // $data=$this->db->get("user")->row_array();

        $data=$this->db->get_where("user",array("id"=>$id))->row_array();
        if($data!=null)
        {
            return $data;
        }
        return null;
    }


    function deleteDataById($id)
    {
        $this->db->where("id",$id);
        return $this->db->delete("user");
    }

    function updateData($id,$toupdatdata)
        {
            $this->db->where("id",$id);
            $this->db->update("user",$toupdatdata);
        }

    function updateSpecificData($id,$name)
        {
            $this->db->set("name","Shubham");
            $this->db->where("id",1);
            $this->db->update("user");
        }


}