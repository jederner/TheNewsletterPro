<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	
    public function details()
    {
        if ( ! file_exists(APPPATH.'/views/profile/home.php')) {
            show_404();
        }
        
        $id = $_SESSION["UserID"];
        
        if(!is_numeric($id)) {
            show_404();
        }

        $data['siteTitle'] = "The NewsletterPro";
        $data['title'] = "Profile"; // Capitalize the first letter
        $data['assets'] = asset_url();

        $this->load->model('Profile_model');
        
        $data["arrProfile"] = $this->Profile_model->getProfileById($id);

        $this->load->view('templates/header', $data);
        $this->load->view('profile/home', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function update() {
        $first_name = trim($_POST["first_name"]);
        $last_name = trim($_POST["last_name"]);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $password = trim($_POST["password"]);
        
        $this->load->model("Profile_model");
        $this->Profile_model->setFirst_name($first_name);
        $this->Profile_model->setLast_name($last_name);
        $this->Profile_model->setEmail($email);
        $this->Profile_model->setPhone($phone);
        $this->Profile_model->setPassword($password);
        
        $this->Profile_model->updateProfile();
        
        $_SESSION["DisplayMessage"] = "Profile update successful.";

	redirect("profile/details");

        exit;
    }
}