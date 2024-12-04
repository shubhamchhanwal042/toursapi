<?php
class packages_api_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
// ---------------------------------------------PACKAGES API-----------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------
    public function AddPackages($data) {
        $this->db->insert('packages', $data);
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
    }

    function GetAllPackages()
    {
        $this->db->order_by('id', 'DESC');
        $data = $this->db->get_where("packages")->result_array();
        
        if ($data != null) {
            return $data;
        }
}

function GetAllPackagesById($id)
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("packages",array("id"=>$id))->result_array();
    
    if ($data != null) {
        return $data;
    }
}

function UpdatePackages($id,$formdata)
{
    $this->db->where("id",$id);
    return $this->db->update("packages",$formdata);
}

function DeletePackages($id)
{
    $this->db->where("id",$id);
    return $this->db->delete("packages");
}

// ------------------------------------------------BOOKING API--------------------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------
function AddBookings($formdata){
    $this->db->insert('booking',$formdata);
    return true;
}

 function GetAllBookings($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("booking",array("id"=>$id))->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateBooking($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('booking', $formdata);
    return true;
}

function DeleteBooking($id){
    $this->db->where("id",$id);
    return $this->db->delete("booking");
}
}
?>