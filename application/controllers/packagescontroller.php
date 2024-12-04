<?php
defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class packagescontroller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("packages_api_model");
        $this->load->library("session");
    }
    function AddPackages() {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formdata = $this->input->post();
    
            // Upload configuration for both images
            $config['upload_path'] = 'uploads/Packages/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 102400;  // Max file size in KB (100MB)
            
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            $uploaded_hotel_files = []; // To store the names of successfully uploaded hotel images
            $uploaded_tour_files = [];  // To store the names of successfully uploaded tour images
    
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
                    if (!$this->upload->do_upload('hotel_image')) {
                        $error = $this->upload->display_errors();
                        log_message('error', 'Hotel Image Upload Error: ' . $error);
                        $response = array("status" => "error", "message" => "Hotel image upload error", "error" => $error);
                        $this->output->set_status_header(400);  // Bad Request
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    } else {
                        // Hotel image uploaded successfully
                        $upload_data = $this->upload->data();
                        $uploaded_hotel_files[] = $upload_data['file_name'];  // Add the file name to the array
                    }
                }
            }
    
            // Handle tour_image upload (single or multiple)
            if (!empty($_FILES['tours_images']['name'][0])) {
                $files = $_FILES['tours_images']; // 'tours_images' is the key you send from Postman
                
                for ($i = 0; $i < count($files['name']); $i++) {
                    // Set the $_FILES global array for the current file
                    $_FILES['tours_images']['name'] = $files['name'][$i];
                    $_FILES['tours_images']['type'] = $files['type'][$i];
                    $_FILES['tours_images']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['tours_images']['error'] = $files['error'][$i];
                    $_FILES['tours_images']['size'] = $files['size'][$i];
    
                    // Perform the file upload for tour images
                    if (!$this->upload->do_upload('tours_images')) {
                        $error = $this->upload->display_errors();
                        log_message('error', 'Tour Image Upload Error: ' . $error);
                        $response = array("status" => "error", "message" => "Tour image upload error", "error" => $error);
                        $this->output->set_status_header(400);  // Bad Request
                        $this->output->set_content_type("application/json")->set_output(json_encode($response));
                        return;
                    } else {
                        // Tour image uploaded successfully
                        $upload_data = $this->upload->data();
                        $uploaded_tour_files[] = $upload_data['file_name'];  // Add the file name to the array
                    }
                }
            }
    
            // If files were uploaded successfully, save the data
            if (!empty($uploaded_hotel_files) || !empty($uploaded_tour_files)) {
                // Save the uploaded image file names as comma-separated strings
                if (!empty($uploaded_hotel_files)) {
                    $formdata['hotel_image'] = implode(',', $uploaded_hotel_files);  // Save hotel images as comma-separated string
                }
                if (!empty($uploaded_tour_files)) {
                    $formdata['tours_images'] = implode(',', $uploaded_tour_files);  // Save tour images as comma-separated string
                }
                
                // Call the model function to add the package with images
                $result = $this->packages_api_model->AddPackages($formdata);
                
                if ($result) {
                    $this->output->set_status_header(200);  // Success
                    $response = array("status" => "success", "message" => "Event and Gallery uploaded successfully", "data" => [
                        'hotel_images' => $uploaded_hotel_files, 
                        'tours_images' => $uploaded_tour_files
                    ]);
                } else {
                    $this->output->set_status_header(404);  // Not Found
                    $response = array("status" => "error", "message" => "Error uploading Event and Gallery");
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
    


    function GetAllPackages()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $events = $this->packages_api_model->GetAllPackages();
            if ($events!=null) {
                $this->output->set_status_header(200);
                $response = array("status" => "success", "data" => $events, "message" => "Events Fetched Successfully");
            } else {
                $this->output->set_status_header(404);

                $response = array("status" => "error", "message" => "No Events Found");
            }
        } else {
            $this->output->set_status_header(405);

            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }


    function GetAllPackagesById($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $event = $this->packages_api_model->GetAllPackagesById($id);
            if ($event != null) {
                $this->output->set_status_header(200);
                $response = array("status" => "success", "data" => $event, "message" => "Event Fetched Successfully");
            } else {
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "No Event Found");
            }
        } else {
            $this->output->set_status_header(405);

            $response = array("status" => "error", "message" => "Bad Request");
        }
        $this->output->set_content_type("application/json")->set_output(json_encode($response));
    }


    public function UpdatePackages($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the existing package details by ID
            $event = $this->packages_api_model->GetAllPackagesById($id);
    
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
                $result = $this->packages_api_model->UpdatePackages($id, $formdata);
    
                if ($result == true) {
                    $this->output->set_status_header(200);
                    $response = array("status" => "success", "message" => "Event Data Updated Successfully");
                } else {
                    $this->output->set_status_header(500);
                    $response = array("status" => "error", "message" => "Some Error Occurred While Updating Event Data");
                }
            } else {
                // No event found for the given ID
                $this->output->set_status_header(404);
                $response = array("status" => "error", "message" => "No Event Found");
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
            $package = $this->packages_api_model->GetAllPackagesById($id);  // Assuming you have a method to get the package by ID
    
            if ($package) {
                // If package exists, delete it
                $result = $this->packages_api_model->DeletePackages($id);
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
            $result = $this->packages_api_model->AddBookings($formdata);
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
            $result = $this->packages_api_model->GetAllBookings($id);

            if ($result != null) {
                $formdata = $this->input->post();
                $result = $this->packages_api_model->UpdateBooking($id,$formdata);
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

    function DeleteBooking($id){

        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                // Check if the package exists before attempting to delete
                $package = $this->packages_api_model->GetAllBookings($id);  // Assuming you have a method to get the package by ID
        
                if ($package) {
                    // If package exists, delete it
                    $result = $this->packages_api_model->DeleteBooking($id);
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
}
}
?>