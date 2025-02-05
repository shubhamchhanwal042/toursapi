<?php
defined("BASEPATH") or exit("No Direct Script Access Alowed");

class PackagesController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Packages_Api_Model");
        $this->load->library("session");
    }

    public function AddPackages() {
        $this->load->helper('file');
        $this->load->model('Packages_Api_Model');  // Load the model
    
        // Get all form data
        $formdata = $this->input->post();  
        // print_r($formdata);die;
    
        // Handle hotel_image upload (single or multiple)
        if (!empty($_FILES['hotel_image']['name'][0])) {
            // Multiple files uploaded for hotel_image
            $hotel_images = [];
            foreach ($_FILES['hotel_image']['name'] as $key => $file) {
                if ($_FILES['hotel_image']['error'][$key] == 0) {
                    // Add the file path or name instead of CURLFile
                    $hotel_images[] = $_FILES['hotel_image']['name'][$key];
                }
            }
            // Convert the array to a string (comma-separated)
            $formdata['hotel_image'] = implode(',', $hotel_images);
        } elseif (!empty($_FILES['hotel_image']['name'])) {
            // Single file uploaded for hotel_image
            if ($_FILES['hotel_image']['error'] == 0) {
                // Add the file path or name instead of CURLFile
                $formdata['hotel_image'] = $_FILES['hotel_image']['name'];
            }
        } else {
            // If no file uploaded, don't include 'hotel_image' in the form data
            $formdata['hotel_image'] = null;
        }
    
        // Handle tours_images upload (single or multiple)
        if (!empty($_FILES['tours_images']['name'][0])) {
            // Multiple files uploaded for tours_images
            $tours_images = [];
            foreach ($_FILES['tours_images']['name'] as $key => $file) {
                if ($_FILES['tours_images']['error'][$key] == 0) {
                    // Add the file path or name instead of CURLFile
                    $tours_images[] = $_FILES['tours_images']['name'][$key];
                }
            }
            // Convert the array to a string (comma-separated)
            $formdata['tours_images'] = implode(',', $tours_images);
        } elseif (!empty($_FILES['tours_images']['name'])) {
            // Single file uploaded for tours_images
            if ($_FILES['tours_images']['error'] == 0) {
                // Add the file path or name instead of CURLFile
                $formdata['tours_images'] = $_FILES['tours_images']['name'];
            }
        } else {
            // If no file uploaded, don't include 'tours_images' in the form data
            $formdata['tours_images'] = null;
        }
    
        // Handle spots and activities - Ensure these are passed correctly as arrays
        if (!empty($formdata['activities']) && is_array($formdata['activities'])) {
            $formdata['activities'] = implode(',', $formdata['activities']);  // Convert array to comma-separated string
        }
        if (!empty($formdata['spots']) && is_array($formdata['spots'])) {
            $formdata['spots'] = implode(',', $formdata['spots']);  // Convert array to comma-separated string
        }
    
        // Call the model method to insert the data
        $inserted_id = $this->Packages_Api_Model->AddPackages($formdata);
    
        // Check the insertion result and send a JSON response
        if ($inserted_id) {
            // Respond with a success status and data
            $response = array(
                'status' => 'success',
                'message' => 'Package Added Successfully',
                'data' => array('inserted_id' => $inserted_id)
            );
            $this->output->set_status_header(200);  // Set status code to 200 (OK)
        } else {
            // Respond with an error message
            $response = array(
                'status' => 'error',
                'message' => 'Package Add Failed'
            );
            $this->output->set_status_header(500);  // Set status code to 500 (Internal Server Error)
        }
    
        // Return JSON response
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
     
    


    public function UpdatePackages($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the existing package details by ID
            $event = $this->Packages_Api_Model->GetAllPackagesById($id);
    
            if ($event != null) {
                // Fetch the data sent from the client
                $formdata = $this->input->post();
    
                // Upload configuration for image(s)
                $config['upload_path'] = 'uploads/Packages/';
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size'] = 102400;  // Max file size (100MB)
    
                // Load the upload library and initialize
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
    
                // Initialize the arrays to hold new file names
                $uploaded_hotel_files = [];
                $uploaded_tour_files = [];
    
                // Handle hotel_image upload (single or multiple)
                if (!empty($_FILES['hotel_image']['name'][0])) {
                    $files = $_FILES['hotel_image']; // 'hotel_image' is the key you send from Postman
                    
                    for ($i = 0; $i < count($files['name']); $i++) {
                        // Set the $_FILES global array for the current file
                        $_FILES['hotel_image']['name'] = $files['name'][$i];
                        $_FILES['hotel_image']['type'] = $files['type'][$i];
                        $_FILES['hotel_image']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['hotel_image']['error'] = $files['error'][$i];
                        $_FILES['hotel_image']['size'] = $files['size'][$i];
    
                        // Perform the file upload for hotel images
                        if ($this->upload->do_upload('hotel_image')) {
                            $upload_data = $this->upload->data();
                            $uploaded_hotel_files[] = $upload_data['file_name'];  // Add uploaded file name to the array
                        } else {
                            $error = $this->upload->display_errors();
                            $this->output->set_status_header(400);
                            $response = array("status" => "error", "message" => "Hotel image upload error: " . $error);
                            $this->output->set_content_type("application/json")->set_output(json_encode($response));
                            return;
                        }
                    }
                } else {
                    // If no files are uploaded for hotel_image, keep the old images
                    $uploaded_hotel_files = explode(',', $event['hotel_image']);  // Keep old image(s) if no new image is uploaded
                }
    
                // Handle tour_images upload (single or multiple)
                if (!empty($_FILES['tours_images']['name'][0])) {
                    $files = $_FILES['tours_images']; // 'tour_images' is the key you send from Postman
                    
                    for ($i = 0; $i < count($files['name']); $i++) {
                        // Set the $_FILES global array for the current file
                        $_FILES['tours_images']['name'] = $files['name'][$i];
                        $_FILES['tours_images']['type'] = $files['type'][$i];
                        $_FILES['tours_images']['tmp_name'] = $files['tmp_name'][$i];
                        $_FILES['tours_images']['error'] = $files['error'][$i];
                        $_FILES['tours_images']['size'] = $files['size'][$i];
    
                        // Perform the file upload for tour images
                        if ($this->upload->do_upload('tours_images')) {
                            $upload_data = $this->upload->data();
                            $uploaded_tour_files[] = $upload_data['file_name'];  // Add uploaded file name to the array
                        } else {
                            $error = $this->upload->display_errors();
                            $this->output->set_status_header(400);
                            $response = array("status" => "error", "message" => "Tour image upload error: " . $error);
                            $this->output->set_content_type("application/json")->set_output(json_encode($response));
                            return;
                        }
                    }
                } else {
                    // If no files are uploaded for tour_images, keep the old images
                    $uploaded_tour_files = explode(',', $event['tours_images']);  // Keep old image(s) if no new image is uploaded
                }
    
                // Update formdata with the new or old image(s)
                if (!empty($uploaded_hotel_files)) {
                    $formdata['hotel_image'] = implode(',', $uploaded_hotel_files);  // Store hotel images as comma-separated values
                }
                if (!empty($uploaded_tour_files)) {
                    $formdata['tours_images'] = implode(',', $uploaded_tour_files);  // Store tour images as comma-separated values
                }
    
                // Update the package in the database
                $result = $this->Packages_Api_Model->UpdatePackages($id, $formdata);
    
                if ($result == true) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Packages Data Updated Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Updating Packages Data");
                }
            } else {
                // No event found for the given ID
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "No Packages Found");
            }
        } else {
            // Invalid request method
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Bad Request");
        }
    
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
    


    function DeletePackages($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllPackagesById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeletePackages($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Package Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Package");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Package Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
     


    // --------------------------------------------------------BOOKING SECTION--------------------------------
    function AddBookings(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $formdata = $this->input->post();
            $result = $this->Packages_Api_Model->AddBookings($formdata);
            if($result == true){
                $this->output->set_status_header(200);
                $response = array("status" => "success", "message" => "Booking Data Added Successfully");
            }else{
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occurred While Adding Booking Data");
            }
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }

    function UpdateBooking($id){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $result = $this->Packages_Api_Model->GetAllBookingsById($id);

            if ($result != null) {
                $formdata = $this->input->post();
                $result = $this->Packages_Api_Model->UpdateBooking($id,$formdata);
                if ($result ==true) {
                    $this->output->set_status_header(200 );
                    $response = array("status" => "success", "message" => "Booking Data Updated Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occured While Updating Booking Data");
                }
            }
            else{
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "No Booking Found");
            } 
        }
        else {
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }


    
function GetAllBooking()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBooking();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Bookings Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bookings Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllBookingById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBookingsById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Bookings Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bookings Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



    function DeleteBooking($id){

        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Check if the package exists before attempting to delete
                $package = $this->Packages_Api_Model->GetAllBookingsById($id);  // Assuming you have a method to get the package by ID
        
                if ($package) {
                    // If package exists, delete it
                    $result = $this->Packages_Api_Model->DeleteBooking($id);
                    if ($result) {
                        $this->output->set_status_header(200);
                        $response = array("status" => "success", "message" => "Bookings Deleted Successfully");
                    } else {
                        $this->output->set_status_header(500);
                        $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Bookings");
                    }
                } else {
                    // If package does not exist
                    $this->output->set_status_header(404);
                    $response = array("status" => "error", "message" => "Bookings Not Found");
                }
            } else {
                // Invalid HTTP request method (only GET is allowed for deletion in this case)
                $this->output->set_status_header(405);
                $response = array("status" => "error", "message" => "Method Not Allowed");
            }
        
            // Send the response as JSON
            $this->output->set_content_type("application/json")->set_output(json_encode($response));
        }
}


// -------------------------------------INQUIRES API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------

function AddInquires(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        $result = $this->Packages_Api_Model->AddInquires($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Inquires Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Inquires Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllInquires()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllInquires();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Inquires Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Inquires Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllInquiresById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllInquiresById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Inquires Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Inquires Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function UpdateInquires($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllInquiresById($id);

        if ($result != null) {
            $formdata = $this->input->post();
            $result = $this->Packages_Api_Model->UpdateInquires($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Inquires Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Inquires Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Inquires Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteInquires($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllInquires($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteInquires($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Inquires Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Inquires");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Inquires Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}


// -------------------------------------SERVICES API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------


function AddServices(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddServices($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Services Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Services Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllServices()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllServices();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Services Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Services Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function GetAllServicesById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllServicesById($id);
        if ($events!=null) {
            // print_r($events);die;

            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Services Fetched Successfully");
            // print_r($response);die;
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Services Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));

}



function UpdateServices($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllServicesById($id);

        if ($result != null) {
            $formdata = $this->input->post();
            $result = $this->Packages_Api_Model->UpdateServices($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Services Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Services Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Services Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteServices($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllServicesById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteServices($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Services Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Services");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Services Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}

// -------------------------------------Currency API---------------------------------------------------
// -------------------------------------------------------------------------------------------------------


function AddCurrency(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddCurrency($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Currency Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Currency Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllCurrency()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllCurrency();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Currency Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Currency Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllCurrencyById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllCurrencyById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Currency Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Currency Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function UpdateCurrency($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllCurrencyById($id);

        if ($result != null) {
            $formdata = $this->input->post();
            $result = $this->Packages_Api_Model->UpdateCurrency($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Currency Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Currency Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Currency Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteCurrency($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllCurrencyById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteCurrency($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Currency Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Currency");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Currency Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}

// ----------------------------------------------- CLIENTS SIDE API ---------------------------------------

// -------------------------------------------------- BUS API-------------------------------------------------



function AddBus() {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formdata = $this->input->post();

        // Upload configuration for both images
        $config['upload_path'] = 'uploads/bus/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 102400;  // Max file size in KB (100MB)
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        

        $uploaded_Bus_files = []; // To store the names of successfully uploaded hotel images

        // Handle hotel_image upload (single or multiple)
        if (!empty($_FILES['photos']['name'][0])) {
            $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
            
            for ($i = 0; $i < count($files['name']); $i++) {
                // Set the $_FILES global array for the current file
                $_FILES['photos']['name'] = $files['name'][$i];
                $_FILES['photos']['type'] = $files['type'][$i];
                $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['photos']['error'] = $files['error'][$i];
                $_FILES['photos']['size'] = $files['size'][$i];

                // Perform the file upload for hotel images
                if (!$this->upload->do_upload('photos')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Hotel Image Upload Error: ' . $error);
                    $response = array("status" => "error", "message" => "photos image upload error", "error" => $error);
                    $this->output->set_status_header(400);  // Bad Request
                    $this->output->set_content_type("application/json")->set_output(json_encode($response));
                    return;
                } else {
                    // Hotel image uploaded successfully
                    $upload_data = $this->upload->data();
                    $uploaded_Bus_files[] = $upload_data['file_name'];  // Add the file name to the array
                }
            }
        }


      
        // If files were uploaded successfully, save the data
        if (!empty($uploaded_Bus_files)) {
            // Save the uploaded image file names as comma-separated strings
            if (!empty($uploaded_Bus_files)) {
                $formdata['photos'] = implode(',', $uploaded_Bus_files);  // Save hotel images as comma-separated string
            }
            
            // Call the model function to add the package with images
            $result = $this->Packages_Api_Model->AddBus($formdata);
            
            if ($result) {
                $this->output->set_status_header(200);  // Success
                $response = array("status" => "success", "message" => "Bus uploaded successfully", "data" => [
                    'photos' => $formdata['photos'], 
                ]);
            } else {
                $this->output->set_status_header(404);  // Not Found
                $response = array("status" => "error", "message" => "Error uploading Bus");
            }
        } else {
            $this->output->set_status_header(400);  // Bad Request
            $response = array("status" => "error", "message" => "No files uploaded");
        }
    } else {
        // Invalid request method
        $this->output->set_status_header(405);  // Method Not Allowed
        $response = array("status" => "error", "message" => "Bad Request");
    }

    // Set the response to JSON and send it
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function GetAllBus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBus();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Bus Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllBusById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBusById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Bus Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function UpdateBus($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllBusById($id);

        if ($result != null) {
            $formdata = $this->input->post();

            $config['upload_path'] = 'uploads/bus/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size (100MB)

            // Load the upload library and initialize
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Initialize the arrays to hold new file names
            $uploaded_photos = [];

            // Handle hotel_image upload (single or multiple)
            if (!empty($_FILES['photos']['name'][0])) {
                $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['photos']['name'] = $files['name'][$i];
                    $_FILES['photos']['type'] = $files['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['photos']['error'] = $files['error'][$i];
                    $_FILES['photos']['size'] = $files['size'][$i];

                    // Perform the file upload for hotel images
                    if ($this->upload->do_upload('photos')) {
                        $upload_data = $this->upload->data();
                        $uploaded_photos[] = $upload_data['file_name'];  // Add uploaded file name to the array
                    } else {
                        $error = $this->upload->display_errors();
                        $this->output->set_status_header(400);
                        $response = array("status" => "error", "message" => "Hotel image upload error: " . $error);
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    }
                }
            } 
            

            // Update formdata with the new or old image(s)
            if (!empty($uploaded_photos)) {
                $formdata['photos'] = implode(',', $uploaded_photos);  // Store hotel images as comma-separated values
            }
           



            $result = $this->Packages_Api_Model->UpdateBus($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Bus Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Bus Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Bus Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteBus($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllBusById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteBus($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Bus Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Bus");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Bus Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}


// ------------------------------------------------ADD CAP APIS -----------------------------------------

function AddCab() {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formdata = $this->input->post();

        // Upload configuration for both images
        $config['upload_path'] = 'uploads/cab/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 102400;  // Max file size in KB (100MB)
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        

        $uploaded_Bus_files = []; // To store the names of successfully uploaded hotel images

        // Handle hotel_image upload (single or multiple)
        if (!empty($_FILES['photos']['name'][0])) {
            $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
            
            for ($i = 0; $i < count($files['name']); $i++) {
                // Set the $_FILES global array for the current file
                $_FILES['photos']['name'] = $files['name'][$i];
                $_FILES['photos']['type'] = $files['type'][$i];
                $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['photos']['error'] = $files['error'][$i];
                $_FILES['photos']['size'] = $files['size'][$i];

                // Perform the file upload for hotel images
                if (!$this->upload->do_upload('photos')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Hotel Image Upload Error: ' . $error);
                    $response = array("status" => "error", "message" => "photos image upload error", "error" => $error);
                    $this->output->set_status_header(400);  // Bad Request
                    $this->output->set_content_type("application/json")->set_output(json_encode($response));
                    return;
                } else {
                    // Hotel image uploaded successfully
                    $upload_data = $this->upload->data();
                    $uploaded_Bus_files[] = $upload_data['file_name'];  // Add the file name to the array
                }
            }
        }


      
        // If files were uploaded successfully, save the data
        if (!empty($uploaded_Bus_files)) {
            // Save the uploaded image file names as comma-separated strings
            if (!empty($uploaded_Bus_files)) {
                $formdata['photos'] = implode(',', $uploaded_Bus_files);  // Save hotel images as comma-separated string
            }
            
            // Call the model function to add the package with images
            $result = $this->Packages_Api_Model->Addcab($formdata);
            
            if ($result) {
                $this->output->set_status_header(200);  // Success
                $response = array("status" => "success", "message" => "Cab uploaded successfully", "data" => [
                    'photos' => $formdata['photos'], 
                ]);
            } else {
                $this->output->set_status_header(404);  // Not Found
                $response = array("status" => "error", "message" => "Error uploading Cab");
            }
        } else {
            $this->output->set_status_header(400);  // Bad Request
            $response = array("status" => "error", "message" => "No files uploaded");
        }
    } else {
        // Invalid request method
        $this->output->set_status_header(405);  // Method Not Allowed
        $response = array("status" => "error", "message" => "Bad Request");
    }

    // Set the response to JSON and send it
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function GetAllCab()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllCab();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Cab Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Cab Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllCabById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllCabById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Cab Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Cab Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function UpdateCab($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllCabById($id);

        if ($result != null) {
            $formdata = $this->input->post();

            $config['upload_path'] = 'uploads/cab/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size (100MB)

            // Load the upload library and initialize
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Initialize the arrays to hold new file names
            $uploaded_photos = [];

            // Handle hotel_image upload (single or multiple)
            if (!empty($_FILES['photos']['name'][0])) {
                $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['photos']['name'] = $files['name'][$i];
                    $_FILES['photos']['type'] = $files['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['photos']['error'] = $files['error'][$i];
                    $_FILES['photos']['size'] = $files['size'][$i];

                    // Perform the file upload for hotel images
                    if ($this->upload->do_upload('photos')) {
                        $upload_data = $this->upload->data();
                        $uploaded_photos[] = $upload_data['file_name'];  // Add uploaded file name to the array
                    } else {
                        $error = $this->upload->display_errors();
                        $this->output->set_status_header(400);
                        $response = array("status" => "error", "message" => "Hotel image upload error: " . $error);
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    }
                }
            } 
            

            // Update formdata with the new or old image(s)
            if (!empty($uploaded_photos)) {
                $formdata['photos'] = implode(',', $uploaded_photos);  // Store hotel images as comma-separated values
            }
           



            $result = $this->Packages_Api_Model->UpdateCab($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Cab Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Cab Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Cab Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteCab($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllCabById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteCab($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Cab Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Cab");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Cab Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}


// -----------------------------------------HOTEL APIS-------------------------------------------------


function AddHotel() {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $formdata = $this->input->post();

        // Upload configuration for both images
        $config['upload_path'] = 'uploads/hotel/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 102400;  // Max file size in KB (100MB)
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        

        $uploaded_Bus_files = []; // To store the names of successfully uploaded hotel images

        // Handle hotel_image upload (single or multiple)
        if (!empty($_FILES['photos']['name'][0])) {
            $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
            
            for ($i = 0; $i < count($files['name']); $i++) {
                // Set the $_FILES global array for the current file
                $_FILES['photos']['name'] = $files['name'][$i];
                $_FILES['photos']['type'] = $files['type'][$i];
                $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['photos']['error'] = $files['error'][$i];
                $_FILES['photos']['size'] = $files['size'][$i];

                // Perform the file upload for hotel images
                if (!$this->upload->do_upload('photos')) {
                    $error = $this->upload->display_errors();
                    log_message('error', 'Hotel Image Upload Error: ' . $error);
                    $response = array("status" => "error", "message" => "photos image upload error", "error" => $error);
                    $this->output->set_status_header(400);  // Bad Request
                    $this->output->set_content_type("application/json")->set_output(json_encode($response));
                    return;
                } else {
                    // Hotel image uploaded successfully
                    $upload_data = $this->upload->data();
                    $uploaded_Bus_files[] = $upload_data['file_name'];  // Add the file name to the array
                }
            }
        }


      
        // If files were uploaded successfully, save the data
        if (!empty($uploaded_Bus_files)) {
            // Save the uploaded image file names as comma-separated strings
            if (!empty($uploaded_Bus_files)) {
                $formdata['photos'] = implode(',', $uploaded_Bus_files);  // Save hotel images as comma-separated string
            }
            
            // Call the model function to add the package with images
            $result = $this->Packages_Api_Model->AddHotel($formdata);
            
            if ($result) {
                $this->output->set_status_header(200);  // Success
                $response = array("status" => "success", "message" => "Hotel uploaded successfully", "data" => [
                    'photos' => $formdata['photos'], 
                ]);
            } else {
                $this->output->set_status_header(404);  // Not Found
                $response = array("status" => "error", "message" => "Error uploading Hotel");
            }
        } else {
            $this->output->set_status_header(400);  // Bad Request
            $response = array("status" => "error", "message" => "No files uploaded");
        }
    } else {
        // Invalid request method
        $this->output->set_status_header(405);  // Method Not Allowed
        $response = array("status" => "error", "message" => "Bad Request");
    }

    // Set the response to JSON and send it
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function GetAllHotel()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllHotel();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Hotel Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Hotel Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function GetAllHotelById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllHotelById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Hotel Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Hotel Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function UpdateHotel($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllHotelById($id);

        if ($result != null) {
            $formdata = $this->input->post();

            $config['upload_path'] = 'uploads/hotel/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size (100MB)

            // Load the upload library and initialize
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Initialize the arrays to hold new file names
            $uploaded_photos = [];

            // Handle hotel_image upload (single or multiple)
            if (!empty($_FILES['photos']['name'][0])) {
                $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['photos']['name'] = $files['name'][$i];
                    $_FILES['photos']['type'] = $files['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['photos']['error'] = $files['error'][$i];
                    $_FILES['photos']['size'] = $files['size'][$i];

                    // Perform the file upload for hotel images
                    if ($this->upload->do_upload('photos')) {
                        $upload_data = $this->upload->data();
                        $uploaded_photos[] = $upload_data['file_name'];  // Add uploaded file name to the array
                    } else {
                        $error = $this->upload->display_errors();
                        $this->output->set_status_header(400);
                        $response = array("status" => "error", "message" => "Hotel image upload error: " . $error);
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    }
                }
            }
            

            // Update formdata with the new or old image(s)
            if (!empty($uploaded_photos)) {
                $formdata['photos'] = implode(',', $uploaded_photos);  // Store hotel images as comma-separated values
            }
           



            $result = $this->Packages_Api_Model->UpdateHotel($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Hotel Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Hotel Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Hotel Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteHotel($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllHotelById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteHotel($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Hotel Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Hotel");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Hotel Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}


// ----------------------------------------PACKAGE BOOKING APIS----------------------------

// -------------------------------------TO CHANGE BOOKING STATUS----------------------------

function ChangeBookingStatus($id,$status)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // print_r($status);die;
        $Data = $this->Packages_Api_Model->ChangeBookingStatus($id,$status);
        if ($Data==true) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Data, "message" => "BOOKING Status Updated Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function AddPackage_Bookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddPackage_Bookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Package_Bookings Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Package_Bookings Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



// ----------------------------------------BUS BOOKING APIS----------------------------

// -------------------------------------TO CHANGE BUS BOOKING STATUS----------------------------

function ChangeBusStatus($id,$status)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Data = $this->Packages_Api_Model->ChangeBusStatus($id,$status);
        if ($Data==true) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Data, "message" => "BOOKING Status Updated Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function AddBus_Bookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddBus_Bookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Bus_Bookings Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Bus_Bookings Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


// -------------------------------------TO CHANGE CAB BOOKING STATUS----------------------------

function ChangeCapStatus($id,$status)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Data = $this->Packages_Api_Model->ChangeCapStatus($id,$status);
        if ($Data==true) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Data, "message" => "Cab_Bookings Status Updated Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function AddCab_Bookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddCab_Bookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Cab_Bookings Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Cab_Bookings Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

// --------------------------------HOTEL BOOKING API-------------------------------------------------------------
function ChangeHotelStatus($id,$status)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Data = $this->Packages_Api_Model->ChangeHotelStatus($id,$status);
        if ($Data==true) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Data, "message" => "Hotel Status Updated Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function AddHotel_Bookings(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->AddHotel_Bookings($formdata);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Hotel Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding Hotel Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


// --------------------------------------------API TO GET THE COUNTS ON DASHBOARD---------------------------------

function GetAllCounts()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $counts = $this->Packages_Api_Model->GetAllCounts();
        if ($counts!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $counts, "message" => "Counts Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Counts Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function DashboardCount()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $counts = $this->Packages_Api_Model->DashboardCount();
        if ($counts!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $counts, "message" => "Counts Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Counts Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

// -----------------------------------------TO GET ALL USERS---------------------------------------------------
function GetAllUsers()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $user = $this->Packages_Api_Model->GetAllUsers();
        if ($user!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $user, "message" => "User Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No User Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



// ------------------------------------TO CHANGE USER STATUS-------------------------------------
function ChangeUserStatus($id,$status){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->ChangeUserStatus($id,$status);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "account_status Data Added Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Adding account_status Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}




// -------------------------------------------BANNER APIS--------------------------------------------
    function AddBanner() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formdata = $this->input->post();

            // Upload configuration for both images
            $config['upload_path'] = 'uploads/banner/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size in KB (100MB)
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            

            $uploaded_Bus_files = []; // To store the names of successfully uploaded hotel images

            // Handle hotel_image upload (single or multiple)
            if (!empty($_FILES['photos']['name'][0])) {
                $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['photos']['name'] = $files['name'][$i];
                    $_FILES['photos']['type'] = $files['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['photos']['error'] = $files['error'][$i];
                    $_FILES['photos']['size'] = $files['size'][$i];

                    // Perform the file upload for hotel images
                    if (!$this->upload->do_upload('photos')) {
                        $error = $this->upload->display_errors();
                        log_message('error', 'Hotel Image Upload Error: ' . $error);
                        $response = array("status" => "error", "message" => "photos image upload error", "error" => $error);
                        $this->output->set_status_header(400);  // Bad Request
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    } else {
                        // Hotel image uploaded successfully
                        $upload_data = $this->upload->data();
                        $uploaded_Bus_files[] = $upload_data['file_name'];  // Add the file name to the array
                    }
                }
            }


        
            // If files were uploaded successfully, save the data
            if (!empty($uploaded_Bus_files)) {
                // Save the uploaded image file names as comma-separated strings
                if (!empty($uploaded_Bus_files)) {
                    $formdata['photos'] = implode(',', $uploaded_Bus_files);  // Save hotel images as comma-separated string
                }
                
                // Call the model function to add the package with images
                $result = $this->Packages_Api_Model->AddBanner($formdata);
                
                if ($result) {
                    $this->output->set_status_header(200);  // Success
                    $response = array("status" => "success", "message" => "Bus uploaded successfully", "data" => [
                        'photos' => $formdata['photos'], 
                    ]);
                } else {
                    $this->output->set_status_header(404);  // Not Found
                    $response = array("status" => "error", "message" => "Error uploading Bus");
                }
            } else {
                $this->output->set_status_header(400);  // Bad Request
                $response = array("status" => "error", "message" => "No files uploaded");
            }
        } else {
            // Invalid request method
            $this->output->set_status_header(405);  // Method Not Allowed
            $response = array("status" => "error", "message" => "Bad Request");
        }

        // Set the response to JSON and send it
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }

    
function GetAllBanner()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBanner();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Banner Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllBannerById($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBannerById($id);
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Banner Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Banner Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}



function UpdateBanner($id){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $result = $this->Packages_Api_Model->GetAllBannerById($id);

        if ($result != null) {
            $formdata = $this->input->post();

            $config['upload_path'] = 'uploads/Packages/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size (100MB)

            // Load the upload library and initialize
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Initialize the arrays to hold new file names
            $uploaded_photos = [];

            // Handle hotel_image upload (single or multiple)
            if (!empty($_FILES['photos']['name'][0])) {
                $files = $_FILES['photos']; // 'hotel_image' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['photos']['name'] = $files['name'][$i];
                    $_FILES['photos']['type'] = $files['type'][$i];
                    $_FILES['photos']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['photos']['error'] = $files['error'][$i];
                    $_FILES['photos']['size'] = $files['size'][$i];

                    // Perform the file upload for hotel images
                    if ($this->upload->do_upload('photos')) {
                        $upload_data = $this->upload->data();
                        $uploaded_photos[] = $upload_data['file_name'];  // Add uploaded file name to the array
                    } else {
                        $error = $this->upload->display_errors();
                        $this->output->set_status_header(400);
                        $response = array("status" => "error", "message" => "Banner image upload error: " . $error);
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    }
                }
            } 

            

            // Update formdata with the new or old image(s)
            if (!empty($uploaded_photos)) {
                $formdata['photos'] = implode(',', $uploaded_photos);  // Store hotel images as comma-separated values
            }
           



            $result = $this->Packages_Api_Model->UpdateBanner($id,$formdata);
            if ($result ==true) {
                $this->output->set_status_header(200 );
                $response = array("status" => "success", "message" => "Banner Data Updated Successfully");
            } else {
                $this->output->set_status_header(500);
                $response = array("status" => "error", "message" => "Some Error Occured While Updating Banner Data");
            }
        }
        else{
            $this->output->set_status_header(404);
            $response = array("status" => "error", "message" => "No Banner Found");
        } 
    }
    else {
        $this->output->set_status_header(405);
        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function DeleteBanner($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllBannerById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DeleteBanner($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Banner Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting Banner");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "Banner Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}


// -------------------------------------------REMAINED-ADDING GET ALL BOOKING FUNCTION --------------------------

function GetAllBusBooking()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllBusBooking();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "bus booking Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Bus booking Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllCabBooking()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllCabBooking();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Cab booking Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Cab booking Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllHotelBooking()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllHotelBooking();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Hotel booking Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Hotel booking Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function GetAllPackageBooking()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllPackageBooking();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Package booking Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Package booking Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

function ChangePackageBookingStatus($id,$status)
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $Data = $this->Packages_Api_Model->ChangePackageBookingStatus($id,$status);
        if ($Data==true) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $Data, "message" => "PackageBooking Status Updated Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Data Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

// -------------------------------------------ADMIN SIDE GET REVIEWS --------------------------------
function GetAllReviews()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $events = $this->Packages_Api_Model->GetAllReviews();
        if ($events!=null) {
            $this->output->set_status_header(200);
            $response = array("status" => "success", "data" => $events, "message" => "Reviews booking Fetched Successfully");
        } else {
            $this->output->set_status_header(404);

            $response = array("status" => "error", "message" => "No Reviews booking Found");
        }
    } else {
        $this->output->set_status_header(405);

        $response = array("status" => "error", "message" => "Bad Request");
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}


function DelteReviewsByid($id){

    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Check if the package exists before attempting to delete
            $package = $this->Packages_Api_Model->GetAllReviewsyId($id);  // Assuming you have a method to get the package by ID
            if ($package) {
                // If package exists, delete it
                $result = $this->Packages_Api_Model->DelteReviewsByid($id);
                if ($result) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "AllReview Deleted Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Deleting AllReview");
                }
            } else {
                // If package does not exist
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "AllReview Not Found");
            }
        } else {
            // Invalid HTTP request method (only GET is allowed for deletion in this case)
            $this->output->set_status_header(405);
            $response = array("status" => "error", "message" => "Method Not Allowed");
        }
    
        // Send the response as JSON
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }
}



function ChangeReviewStatus($id,$status){
// print_r($id);die;
print_r($status);die;
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $formdata = $this->input->post();
        // print_r($formdata);die;
        $result = $this->Packages_Api_Model->ChangeReviewStatus($id,$status);
        if($result == true){
            $this->output->set_status_header(200);
            $response = array("status" => "success", "message" => "Review Data Updated Successfully");
        }else{
            $this->output->set_status_header(500);
            $response = array("status" => "error", "message" => "Some Error Occurred While Review account_status Data");
        }
    }
    $this->output->set_content_type("application/json")->set_output(json_encode($response));
}

}
?>