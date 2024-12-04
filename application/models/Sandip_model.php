<?php
class Sandip_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function insert_data($data) {
        $this->db->insert('faculty_data', $data);
    if ($this->db->affected_rows() > 0) {
        return true;
    } else {
        return false;
    }
    }
// [-----------------------Admin Registration Model-----------------------------------]
    function register_admin_model($data){
        $this->db->insert('admin_registration', $data);
    }

function get_admin_by_emp_id($emp_id) {
    $this->db->where('emp_id', $emp_id);
    $query = $this->db->get('admin_registration');
    return $query->row_array();
}



















    public function get_records_by_school_department($school_name, $department) {
        $this->db->where('school_name', $school_name);
        $this->db->where('department', $department);
        $query = $this->db->get('sandip_table_form');
        return $query->result_array();
    }

    // public function update_action_taken($id, $remark) {
    //     $this->db->where('id', $id);
    //     $this->db->update('faculty_data', array('action_taken' => $remark));
    // }
    public function update_action_taken($id, $remark) {
        $this->db->where('id', $id);
        $this->db->update('sandip_table_form', array('action_taken' => $remark));
    }

    // public function update_scrutiny_status($id, $status) {
    //     $this->db->where('id', $id);
    //     $this->db->update('faculty_data', array('scrutiny_status' => $status));
    // }
    public function update_scrutiny_status($id, $status) {
        $this->db->where('id', $id);
        $this->db->update('sandip_table_form', array('scrutiny_status' => $status));
    }
     // Updated function to update both Action Taken/Remark and Scrutiny/Approval Status
    //  public function update_action_and_scrutiny($id, $remark, $status) {
    //     $this->db->where('id', $id);
    //     $this->db->update('faculty_data', array(
    //         'action_taken' => $remark,
    //         'scrutiny_status' => $status
    //     ));
    // }
    public function update_action_and_scrutiny($id, $remark, $status) {
        $this->db->where('id', $id);
        $this->db->update('sandip_table_form', array(
            'action_taken' => $remark,
            'scrutiny_status' => $status
        ));
    }

  // Register a new user
  public function register_user($data) {
    return $this->db->insert('user_registration', $data);
}
public function check_user_exists($email) {
    $this->db->where('email', $email);
    $query = $this->db->get('user_registration'); 

    return $query->num_rows() > 0;
}


// Check login credentials
public function login_user($emp_id) {
    $this->db->where('emp_id', $emp_id);
    $query = $this->db->get('user_registration');

    if ($query->num_rows() === 1) {
        return $query->row_array(); 
    } else {
        return false; 
    }
}





 // Fetch all school names
 public function get_schools() {
    $this->db->distinct(); // Ensure distinct school names
    $query = $this->db->get('admin_registration');  // Table where school_name is stored
    return $query->result(); // Return the result
}

// Fetch departments by school name
public function get_departments_by_school($school_name) {
    $this->db->where('school_name', $school_name);
    $query = $this->db->get('admin_registration');  // Table where departments are linked to school_name
    $departments = $query->result();

    // Fetch only distinct department names
    $department_names = array();
    foreach ($departments as $department) {
        $department_names[] = $department->department;
    }
    
    return array_unique($department_names); // Return distinct department names
}











 // Method to check if user exists by email
 public function check_user_by_emp_id($emp_id) {
    $this->db->where('emp_id', $emp_id);
    $query = $this->db->get('user_registration'); 
    return $query->num_rows() > 0;
}

// Fetch records based on email
public function get_records_by_emp_id($emp_id) {
    $this->db->where('emp_id', $emp_id);  
    $query = $this->db->get('sandip_table_form'); 
    return $query->result_array();
}


// ---------fetch register data ----------]
public function fetch_register_data_model() {
    return $this->db->get('user_registration')->result_array();
}

// [------------------Register Data Approvaal Code Here-----------------------]

public function update_user_status($user_id, $status) {
    $this->db->where('id', $user_id);
    $this->db->update('user_registration', ['status' => $status]);
}













//[ ---------data of form submit code here ----------------]

 // Insert data into the table
 public function insert_datas($data) {
    $this->db->insert('sandip_table_form', $data);
}

// Update form data by emp_id
public function update_form_data($emp_id, $form_data) {
    $this->db->where('emp_id', $emp_id);
    $this->db->update('sandip_table_form', $form_data);
}

// Get form data by emp_id
public function get_form_data_by_emp_id($emp_id) {
    $this->db->where('emp_id', $emp_id);
    $query = $this->db->get('sandip_table_form');
    return $query->row_array(); // Return a single row if found, otherwise return NULL
}


}
