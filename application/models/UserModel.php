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

    function AddBusBookings($formdata){
        $this->db->insert('bus_booking',$formdata);
        return true;
    }
    function AddHotelBookings($formdata){
    $this->db->insert('hotel_bookings',$formdata);
    return true;
     }

    function AddCabBookings($formdata){
        $this->db->insert('cab_booking',$formdata);
        return true;  
    }

    function PackageBookings($formdata){
        $this->db->insert('package_bookings',$formdata);
        return true;
    }

    function GetAllBusByid($id)
    {
        $data = $this->db->get_where("bus_booking", array("user_id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

    // function AddCabBookings($id)
    // {
    //     $data = $this->db->get_where("bus_booking", array("id" => $id))->row_array();
    //     if ($data != null) {
    //         return $data;
    //     }
    //     return null;
    // }

    function GetHotelByid($id)
    {
        $data = $this->db->get_where("hotel_bookings", array("user_id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

    function GetCabByid($id)
    {
        $data = $this->db->get_where("cab_booking", array("user_id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

    function GetpackageByid($id)
    {
        $data = $this->db->get_where("package_booking", array("user_id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }


    // ------------------------------------FOR UPCOMMING TRIPS DATA -----------------------------------
    public function GetUpcommingTrips($user_id) {
        // Fetch upcoming trips for a specific user from cab, hotel, package, and bus tables using CURDATE()
        $query = $this->db->query("
            (SELECT id, user_id, booked_date, date_completed,status,'cab_booking' AS source_table FROM cab_booking WHERE user_id = ? AND booked_date >= CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date, date_completed,status, 'hotel_bookings' AS source_table FROM hotel_bookings WHERE user_id = ? AND booked_date >= CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date,  date_completed,status,'package_bookings' AS source_table FROM package_bookings WHERE user_id = ? AND booked_date >= CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date,  date_completed,status,'bus_booking' AS source_table FROM bus_booking WHERE user_id = ? AND booked_date >= CURDATE())
            ORDER BY booked_date ASC
        ", array($user_id, $user_id, $user_id, $user_id));
    
        return $query->result();
    }

    public function GetRecentTrips($user_id) {
        // Fetch trips for a specific user from cab, hotel, package, and bus tables using CURDATE() to get previous trips
        $query = $this->db->query("
            (SELECT id, user_id, booked_date, date_completed, status, 'cab_booking' AS source_table FROM cab_booking WHERE user_id = ? AND booked_date < CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date, date_completed, status, 'hotel_bookings' AS source_table FROM hotel_bookings WHERE user_id = ? AND booked_date < CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date, date_completed, status, 'package_bookings' AS source_table FROM package_bookings WHERE user_id = ? AND booked_date < CURDATE())
            UNION ALL
            (SELECT id, user_id, booked_date, date_completed, status, 'bus_booking' AS source_table FROM bus_booking WHERE user_id = ? AND booked_date < CURDATE())
            ORDER BY booked_date DESC
        ", array($user_id, $user_id, $user_id, $user_id));
    
        return $query->result();
    }
    
    

    // ---------------------------------------------ADDING REVIEWS APIS -----------------------------
  
    function AddReviews($formdata){
        $this->db->insert('reviews',$formdata);
        return true;  
    }
    

    function GetAllReviewsById($id){
        $data = $this->db->get_where("reviews", array("id" => $id))->row_array();
        if ($data != null) {
            return $data;
        }
        return null;
    }

    function UpdateCurrency($id,$formdata){
        $this->db->where('id', $id);
        $this->db->update('reviews', $formdata);
        return true;
    }


    // ---------------------------------------------- ENQUIRY FORM ---------------------------------
    
    function AddEnquiry($formdata){
        $this->db->insert('enquires',$formdata);
        return true;  
    }

    // --------------------------- cab details------------------------------------
    function CabDetail($id){
// print_r($id);die;
$data = $this->db->get_where("cab", array("id" => $id))->row_array();

        return $data;
    }

}