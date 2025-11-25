<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

 public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->database();   // <- ADD THIS IF NOT AUTOLOADED
    }
    public function index() {
        $this->load->view('user_list');
    }

    public function getUsers() {
        $data = $this->User_model->fetchUsers();
        
        echo json_encode(["data" => $data]); // DataTables expects "data"
    }
    public function deleteUser() {
        $id = $this->input->post('id');

        if($id) {
            $this->load->model('User_model');
            $deleted = $this->User_model->deleteUser($id);

            if($deleted) {
                echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete user"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid user ID"]);
        }
    }
    public function get_user_by_id($id){
        $id = (int)$id;
        if ($id <= 0) {
        echo json_encode(['status'=>'error','message'=>'Invalid User ID']);
        return;
        }
        $user = $this->User_model->get_user_by_id($id);
        if($user){
            echo json_encode(['status'=>'success','data'=>$user]);
        } else {
            echo json_encode(['status'=>'error','message'=>'User not found']);
        }
    }
    public function get_states() {
            $states = $this->User_model->get_states();
            echo json_encode($states); // Send JSON to AJAX
    }
    public function save_application_data() {
            $data = $this->input->post();

            // Server-side validation
            if(!isset($data['name']) || empty(trim($data['name']))) {
                echo json_encode(['status'=>'error','message'=>'Name is required']); return;
            }
            if(strlen(trim($data['name'])) < 3) {
                echo json_encode(['status'=>'error','message'=>'Name must be at least 3 characters']); return;
            }

            if(!isset($data['email']) || empty(trim($data['email']))) {
                echo json_encode(['status'=>'error','message'=>'Email is required']); return;
            }
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['status'=>'error','message'=>'Invalid email format']); return;
            }

            if(!isset($data['mobile']) || empty(trim($data['mobile']))) {
                echo json_encode(['status'=>'error','message'=>'Mobile number is required']); return;
            }
            if(!preg_match('/^[0-9]{10}$/', $data['mobile'])) {
                echo json_encode(['status'=>'error','message'=>'Mobile must be 10 digits']); return;
            }

            if(!isset($data['gender']) || empty(trim($data['gender']))) {
                echo json_encode(['status'=>'error','message'=>'Please select gender']); return;
            }

            if(!isset($data['state']) || empty(trim($data['state']))) {
                echo json_encode(['status'=>'error','message'=>'Please select state']); return;
            }

            // Optional: Check duplicate email/mobile
            $exists = $this->db->where('email', $data['email'])
                            ->or_where('mobile', $data['mobile'])
                            ->get('users')
                            ->row();
            if($exists) {
                echo json_encode(['status'=>'error','message'=>'Email or Mobile already exists']); return;
            }

            // Insert data
            $insertData = [
                'name'         => trim($data['name']),
                'email'        => trim($data['email']),
                'mobile'       => trim($data['mobile']),
                'gender'       => trim($data['gender']),
                'state'        => trim($data['state']),
                'created_on'   => date('Y-m-d H:i:s'),
                'created_by' => 'System',
                'record_status'=> 1
            ];

            $inserted = $this->User_model->insert_user($insertData);

            if($inserted){
                echo json_encode(['status'=>'success','message'=>'User inserted successfully']);
            } else {
                echo json_encode(['status'=>'error','message'=>'Failed to insert user']);
            }
    }

    public function update_user_details() {
        $data = $this->input->post();
        $id = (int)$data['id'];

        // Validate here...
        // (same as you already wrote)

        // Check if user exists
        $userExists = $this->User_model->get_user_by_id($id);
        if (!$userExists) {
            echo json_encode(['status'=>'error','message'=>'User not found']); 
            return;
        }

        // Check duplicates using model
        $duplicate = $this->User_model->check_duplicate($data['email'], $data['mobile'], $id);
        if ($duplicate) {
            echo json_encode(['status'=>'error','message'=>'Email or Mobile already exists']); 
            return;
        }

        // Update
        $updateData = [
            'name'       => trim($data['name']),
            'email'      => trim($data['email']),
            'mobile'     => trim($data['mobile']),
            'gender'     => trim($data['gender']),
            'state'      => trim($data['state']),
            'updated_on' => date('Y-m-d H:i:s'),
            'updated_by' => 'System'
        ];


        $updated = $this->User_model->update_user($id, $updateData);

        echo json_encode([
            'status'  => $updated ? 'success' : 'error',
            'message' => $updated ? 'User updated successfully' : 'Update failed'
        ]);
    }


}
