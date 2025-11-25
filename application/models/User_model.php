<?php
class User_model extends CI_Model {


     public function fetchUsers() {

        $this->db->select("
            users.id,
            users.name,
            users.email,
            users.mobile,
            users.gender,
            users.state,
            state_master.state_name,
            users.created_on,
            users.record_status
        ");

        $this->db->from("users");
        $this->db->join("state_master", "state_master.state_code = users.state", "left");
        $this->db->order_by("users.id", "DESC");
        $query = $this->db->get();
        $result = $query->result_array();

        $data = [];
        $sl = 1;

        foreach ($result as $row) {

           
            $buttons = '';
            if ($row['record_status'] == 1) {
                $buttons = '<button class="btn btn-sm btn-primary editUserBtn" data-id="'.$row['id'].'">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row['id'].'">Delete</button>';
            }

            $data[] = [
                "sl_no"      => $sl++,
                "id"         => $row['id'],
                "name"       => $row['name'],
                "email"      => $row['email'],
                "mobile"     => $row['mobile'],
                "gender"     => $row['gender'],
                "state_name" => $row['state_name'],
                "created_on" => $row['created_on'],
                "action"     => $buttons
            ];
        }

        return $data;
    }
     public function deleteUser($id) {
            $this->db->where('id', $id);
            return $this->db->delete('users'); 
        }
        public function get_states() {
        $query = $this->db->select('state_code, state_name')
                          ->from('state_master')
                          ->order_by('state_name', 'ASC')
                          ->get();
        return $query->result_array(); // return as array for JSON
    }
    public function insert_user($data) {
       
        return $this->db->insert('users', $data); 
    }
    public function get_user_by_id($id){
        return $this->db->where('id',$id)->get('users')->row_array();
    }
     public function check_duplicate($email, $mobile, $excludeId = null) {
        $this->db->group_start()
                 ->where('email', $email)
                 ->or_where('mobile', $mobile)
                 ->group_end();

        if ($excludeId !== null) {
            $this->db->where('id !=', $excludeId);
        }

        return $this->db->get('users')->row();
    }

    public function update_user($id, $data) {
       
        return $this->db->where('id', $id)->update('users', $data);
    }
}
