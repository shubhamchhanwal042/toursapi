<?php 

defined("BASEPATH") or exit("No Direct Script Access Aloowed");

class UserController extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("UserModel");
        $this->load->library("session");
    }
   
    function UserForm()
    {
        $this->load->view("userform");
    }

    function AddUser()
    {
        $config['upload_path']          = 'uploads/';
        $config['allowed_types']        = 'jpeg|jpg|png|pdf';
        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $formdata=$this->input->post();
       
        if ( ! $this->upload->do_upload('img'))
        {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
        }
        else
        {
                $data = array('upload_data' => $this->upload->data());
                $formdata["img"]=$data["upload_data"]["file_name"]; 

        }
        $this->UserModel->createUser($formdata);

            redirect("UserController/ShowAllUsers");
       
       
    }


    function ShowAllUsers()
    {
        $data['users']=$this->UserModel->getData();
        $this->load->view("UsersList",$data);
    }

    function GetUserById($id)
    {
        $data=$this->UserModel->getDataById($id);
        print_r($data);
    }

    function DeleteById($id)
    {
        $this->UserModel->deleteDataById($id);
        redirect("UserController/ShowAllUsers");

    }
    
    function UpdateUser($id)
    {
        $user["user"]=$this->UserModel->getDataById($id);
        $this->load->view("UpdateUserform",$user);
    }

    function UpdateUserPost($id)
    {
        $formdata=$this->input->post();
        $this->UserModel->updateData($id,$formdata);
        redirect("UserController/ShowAllUsers");
    }
// UserController/Logout

    function Logout()
    {
        $loggedin=$this->session->userdata("isloggedin");
        if($loggedin)
        {
            $this->session->session_destroy();
        }

    }


    
}





?>