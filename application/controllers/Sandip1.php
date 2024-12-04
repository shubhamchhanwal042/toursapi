<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sandip1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sandip_model');
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function wizard_step_1() {
        if ($this->session->userdata('step_completed') >= 1) {
            redirect('Sandip1/wizard_step_2');
        }
        $this->load->view('wizard_step_1');
    }

    public function wizard_step_2() {
        if ($this->session->userdata('step_completed') < 1) {
            redirect('Sandip1/wizard_step_1');
        }
        $this->load->view('wizard_step_2');
    }

    public function wizard_step_3() {
        if ($this->session->userdata('step_completed') < 2) {
            redirect('Sandip1/wizard_step_2');
        }
        $this->load->view('wizard_step_3');
    }

    public function wizard_step_4() {
        if ($this->session->userdata('step_completed') < 3) {
            redirect('Sandip1/wizard_step_3');
        }
        $this->load->view('wizard_step_4');
    }

    public function submit_step($step) {
        $data = $this->input->post();

        // Fetch the logged-in user's details from session
        $logged_in_emp_id = $this->session->userdata('user_emp_id');
        $logged_in_school_name = $this->session->userdata('user_school_name');
        $logged_in_department = $this->session->userdata('user_department');

        // Initialize an array to hold file upload results
        $files = [];

        // Define file input keys with count
        $file_keys = [
            'file_sci', 'file_ugc', 'file_scopus', 'sec_file_sci', 'sec_file_ugc', 'sec_file_scopus',
            'file_invited_talks', 'file_fdp_seminars', 'file_first_workshop','second_file_workshops','second_file_fdp_seminars', 'second_file_conference',
            'consultancy_received_files','grant_received_files', 'file_research_grant', 'file_mou',
            'file_awards', 'file_professional_memberships'
        ];

        // Process each file input
        foreach ($file_keys as $key) {
            $file_count = 0;
            while (isset($_FILES["{$key}_file_" . ($file_count + 1)])) {
                if (!empty($_FILES["{$key}_file_" . ($file_count + 1)]['name'])) {
                    $_FILES['file'] = $_FILES["{$key}_file_" . ($file_count + 1)];

                    // Attempt file upload
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png|pdf|doc|docx';
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('file')) {
                        $error = $this->upload->display_errors();
                        log_message('error', 'File upload error: ' . $error);
                        $this->session->set_flashdata('error', $error);
                        redirect('Sandip1/wizard_step_' . $step);
                    }
                    // Save the file name in the $files array
                    $files[$key][] = $this->upload->data('file_name');
                }
                $file_count++;
            }
            if (isset($files[$key])) {
                $files[$key] = implode(',', $files[$key]); // Convert array to string
            } else {
                $files[$key] = null; // No files uploaded
            }
        }
        // Merge the data and files
        $form_data = array_merge($data, $files);
        $form_data['emp_id'] = $logged_in_emp_id;
        $form_data['school_name'] = $logged_in_school_name;
        $form_data['department'] = $logged_in_department;

        // Check if the user has completed all steps and is submitting again
        $existing_data = $this->Sandip_model->get_form_data_by_emp_id($logged_in_emp_id);
       
        if ($existing_data) {
            // If data already exists and user is submitting new data for step 1
            if ($step == 1) {
                // Insert new row for step 1 and then update steps 2, 3, and 4
                $this->Sandip_model->insert_datas($form_data);  // Insert new record for step 1
                $this->session->set_userdata('step_completed', 1);  // Mark step 1 as completed in session

                // Update data for steps 2, 3, and 4
                $this->Sandip_model->update_form_data($logged_in_emp_id, $form_data);

                redirect('Sandip1/wizard_step_2'); // Go to step 2
            }
        } else {
            // If no data exists for the user, insert new data (this happens when they start fresh)
            if ($step == 1) {
                $this->Sandip_model->insert_datas($form_data); // Insert new data for step 1
                $this->session->set_userdata('step_completed', 1);  // Mark step 1 as completed
                redirect('Sandip1/wizard_step_2'); // Move to step 2
            }
        }

        // Check if all steps are completed
        if ($step == 4) {
            print_r($form_data);die;
            // If the user completes all steps, redirect to the view page
            redirect('view_data');
        } else {
            // Otherwise, move to the next step
            $this->session->set_userdata('step_completed', $step + 1);
            print_r($form_data);die;

            redirect('Sandip1/wizard_step_' . ($step + 1));
        }
    }
}
