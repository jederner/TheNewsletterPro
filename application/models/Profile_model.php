<?php
class Profile_model extends CI_Model {
    
    private $first_name = "default";     
    private $last_name = "default";
    private $email = "default@email.com";
    private $phone = "123-456-7890";
    private $password = "";

    public function __construct() {
        $this->load->database();
    }
    
    function getFirst_name() {
        return $this->first_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPhone() {
        return $this->phone;
    }

    function getPassword() {
        return $this->password;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }

    function setPassword($password) {
        if(!empty($password)) {
            $this->password = md5($password);
        }
    }

    public function setProfileById($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $sql = "SELECT "
                . "first_name, "
                . "last_name, "
                . "email, "
                . "phone "
                . "FROM `users` where id = $id";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $this->setFirst_name($row->first_name);
                $this->setLast_name($row->last_name);
                $this->setEmail($row->email);
                $this->setPhone($row->phone);
            }
        }
    }
    
    public function getProfileById($id) {
        if(!is_numeric($id)) {
            show_404();
        }
        $this->setProfileById($id);
        $arrProfile = array(
            "first_name" => $this->getFirst_name(),
            "last_name" => $this->getLast_name(),
            "phone" => $this->getPhone(),
            "email" => $this->getEmail()
        );
        return $arrProfile;
    }
    
    public function updateProfile() {
        $data = array(
            'first_name' => $this->getFirst_name(),
            'last_name' => $this->getLast_name(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail()
        );
        
        $chkPass = $this->getPassword();
        if(!empty($chkPass)) {
            $data['password'] = $chkPass;
        }
        
        $this->db->where('id', $_SESSION["UserID"]);
        $this->db->update('users', $data);
    }
    
}