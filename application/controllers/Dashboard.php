<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
    public function view($page="home")
    {
        if ( ! file_exists(APPPATH.'/views/dashboard/'.$page.'.php'))
        {
            show_404();
        }

        $data['siteTitle'] = "The NewsletterPro";
        $data['title'] = "Dashboard";// - " . ucfirst($page); // Capitalize the first letter
        $data['assets'] = asset_url();

        $this->load->model('Dashboard_model');
        $this->Dashboard_model->checkAdmin();
        $this->Dashboard_model->fillClientList();
        
        $data["clients"] = $this->Dashboard_model->getClientList();
        $data["menu"] = $this->Dashboard_model->getMenuList();
        
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}