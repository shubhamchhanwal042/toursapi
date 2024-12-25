<?php
class Packages_Api_Model extends CI_Model {

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
    $data = $this->db->get_where("packages",array("id"=>$id))->row_array();
    
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

 function GetAllBookingsById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("booking",array("id"=>$id))->row_array();
    if ($data != null) {
        return $data;
    }
}

function GetAllBooking()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("booking")->result_array();
    
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


// -------------------------------------INQUIRES API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddInquires($formdata){
    $this->db->insert('inquiries',$formdata);
    return true;
}

 function GetAllInquiresById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("inquiries",array("id"=>$id))->row_array();
    
    if ($data != null) {
        return $data;
    }
}

function GetAllInquires()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("inquiries")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateInquires($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('inquiries', $formdata);
    return true;
}

function DeleteInquires($id){
    $this->db->where("id",$id);
    return $this->db->delete("inquiries");
}

// -------------------------------------SERVICES API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddServices($formdata){
    $this->db->insert('services',$formdata);
    return true;
}

 function GetAllServicesById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("services",array("id"=>$id))->row_array();
    if ($data != null) {
        return $data;
    }
}

function GetAllServices()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("services")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateServices($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('services', $formdata);
    return true;
}

function DeleteServices($id){
    $this->db->where("id",$id);
    return $this->db->delete("services");
}


// -------------------------------------Currency API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddCurrency($formdata){
    $this->db->insert('currencyconverter',$formdata);
    return true;
}

 function GetAllCurrencyById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("currencyconverter",array("id"=>$id))->row_array();
    
    if ($data != null) {
        return $data;
    }
}

function GetAllCurrency()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("currencyconverter")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateCurrency($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('currencyconverter', $formdata);
    return true;
}

function DeleteCurrency($id){
    $this->db->where("id",$id);
    return $this->db->delete("currencyconverter");
}

// -------------------------------------Bus API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddBus($formdata){
    $this->db->insert('bus',$formdata);
    return true;
}

 function GetAllBusById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("bus",array("id"=>$id))->row_array();
    
    if ($data != null) {
        return $data;
    }
}

function GetAllBus()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("bus")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateBus($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('bus', $formdata);
    return true;
}

function DeleteBus($id){
    $this->db->where("id",$id);
    return $this->db->delete("bus");
}


// -------------------------------------Hotel API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddHotel($formdata){
    $this->db->insert('hotel',$formdata);
    return true;
}

 function GetAllHotelById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("hotel",array("id"=>$id))->row_array();
    
    if ($data != null) {
        return $data;
    }
}

function GetAllHotel()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("hotel")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateHotel($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('hotel', $formdata);
    return true;
}

function DeleteHotel($id){
    $this->db->where("id",$id);
    return $this->db->delete("hotel");
}


// -----------------------------------CHANGE BOOKING STATUS--------------------------------------

function ChangeBookingStatus($id,$status)
{
    $data=$this->db->get_where("package_bookings",array("id"=>$id))->row_array();
    if($data!=null)
    {
        if ($status == "Completed") {
            $this->db->set("status", "Completed")->where("id", $id)->update("package_bookings");
        } elseif ($status == "Pending") {
            $this->db->set("status", "Pending")->where("id", $id)->update("package_bookings");
        } else {
            $this->db->set("status", "Cancelled")->where("id", $id)->update("package_bookings");
        }

        return true;
    }

    return false;
  
}

    function AddPackage_Bookings($formdata){
        $this->db->insert('package_bookings',$formdata);
        return true;
    }

    
// -----------------------------------CHANGE BUS STATUS--------------------------------------

function ChangeBusStatus($id,$status)
{
    $data=$this->db->get_where(" bus_booking",array("id"=>$id))->row_array();
    if($data!=null)
    {
        if ($status == "Completed") {
            $this->db->set("status", "Completed")->where("id", $id)->update(" bus_booking");
        } elseif ($status == "Pending") {
            $this->db->set("status", "Pending")->where("id", $id)->update(" bus_booking");
        } else {
            $this->db->set("status", "Cancelled")->where("id", $id)->update(" bus_booking");
        }

        return true;
    }

    return false;
  
}

    function AddBus_Bookings($formdata){
        $this->db->insert('bus_booking',$formdata);
        return true;
    }

    // -----------------------------------CHANGE AddCab_Bookings STATUS--------------------------------------

function ChangeCapStatus($id,$status)
{
    $data=$this->db->get_where(" cab_booking",array("id"=>$id))->row_array();
    if($data!=null)
    {
        if ($status == "Completed") {
            $this->db->set("status", "Completed")->where("id", $id)->update("cab_booking");
        } elseif ($status == "Pending") {
            $this->db->set("status", "Pending")->where("id", $id)->update("cab_booking");
        } else {
            $this->db->set("status", "Cancelled")->where("id", $id)->update("cab_booking");
        }

        return true;
    }

    return false;
  
}

    function AddCab_Bookings($formdata){
        $this->db->insert('cab_booking',$formdata);
        return true;
    }

    // ------------------------------------------HOTEL STATUS API MODEL-----------------------------
    function ChangeHotelStatus($id,$status)
{
    $data=$this->db->get_where(" hotel_bookings",array("id"=>$id))->row_array();
    if($data!=null)
    {
        if ($status == "Completed") {
            $this->db->set("status", "Completed")->where("id", $id)->update("hotel_bookings");
        } elseif ($status == "Pending") {
            $this->db->set("status", "Pending")->where("id", $id)->update("hotel_bookings");
        } else {
            $this->db->set("status", "Cancelled")->where("id", $id)->update("hotel_bookings");
        }

        return true;
    }

    return false;
  
}

    function AddHotel_Bookings($formdata){
        $this->db->insert('hotel_bookings',$formdata);
        return true;
    }
// --------------------------------------------API TO GET THE COUNTS ON DASHBOARD---------------------------------

public function GetAllCounts() {
    // Select count(*) for each table
    $this->db->select('
        (SELECT COUNT(*) FROM bus_booking) AS bus_count,
        (SELECT COUNT(*) FROM cab_booking) AS cab_count,
        (SELECT COUNT(*) FROM hotel_bookings) AS hotel_count,
        (SELECT COUNT(*) FROM package_bookings) AS package_count,
    ');

    // Execute the query and return the result
    $query = $this->db->get();

    return $query->row(); // Returns a single row with counts
}

function GetAllUsers(){
   $data = $this->db->get_where('users')->result_array();
    return $data;
}

function ChangeUserStatus($id,$status){
    $data=$this->db->get_where(" users",array("id"=>$id))->row_array();
    if($data!=null)
    {
        if ($status == "Blocked") {
            $this->db->set("account_status", "Blocked")->where("id", $id)->update("users");
        } elseif ($status == "Unblocked") {
            $this->db->set("account_status", "Unblocked")->where("id", $id)->update("users");
        } else {
            $this->db->set("account_status", "Cancelled")->where("id", $id)->update("users");
        }

        return true;
    }

    return false;
}


// --------------------------------------------------------BANNER APIS--------------------------------------
function AddBanner($formdata){
    $this->db->insert('banner',$formdata);
    return true;
}

function GetAllBannerById($id){
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("banner",array("id"=>$id))->row_array();
    
    if ($data != null) {
        return $data;
    }
}

function GetAllBanner()
{
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get_where("banner")->result_array();
    
    if ($data != null) {
        return $data;
    }
}


function UpdateBanner($id,$formdata){
    $this->db->where('id', $id);
    $this->db->update('banner', $formdata);
    return true;
}

function DeleteBanner($id){
    $this->db->where("id",$id);
    return $this->db->delete("banner");
}


}
?>