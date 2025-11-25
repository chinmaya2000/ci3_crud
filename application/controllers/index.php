<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class index extends CI_Controller {

    public function index()
    {
        $this->load->view('application_form');

       // echo "This is the Home controller default index method.";
    }
     public function user_list() {
        $this->load->view('user_list');
    }

    public function getUsers() {
        $data = $this->User_model->fetchUsers();
        echo json_encode(["data" => $data]); // DataTables expects "data"
    }
}
