<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {
	public function view($page = 'home')
	{
		if ( ! file_exists(APPPATH.'/views/categories/'.$page.'.php'))
		{
			show_404();
		}

		$data['siteTitle'] = "The NewsletterPro";
		$data['title'] = "Categories - " . ucfirst($page); // Capitalize the first letter
		$data['assets'] = asset_url();

		$this->load->model('Categories_model');

		$data['categories'] = $this->Categories_model->getCategoriesArray();

		$this->load->view('templates/header', $data);
		$this->load->view('categories/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function edit($id) {
		if(!is_numeric($id)) {
			show_404();
		}

		$this->load->model('Categories_model');

		$data['arrCategory']= $this->Categories_model->getCategoryArray($id);
		$data['category']	= $this->Categories_model->getCategoryNameById($id);
		$data['siteTitle']	= "The NewsletterPro";
		$data['title']		= "Categories - Edit - " . $data['category'];
		$data['assets']		= asset_url();

		$this->load->view('templates/header', $data);
		$this->load->view('categories/edit', $data);
		$this->load->view('templates/footer', $data);

	}

	public function add() {

		$this->load->model('Categories_model');

		$data['siteTitle']	= "The NewsletterPro";
		$data['title']		= "Categories - Add";
		$data['assets']		= asset_url();

		$this->load->view('templates/header', $data);
		$this->load->view('categories/add', $data);
		$this->load->view('templates/footer', $data);

	}

	public function update($id) {
		if(!is_numeric($id)) {
			show_404();
		}

		$newLabel = $_POST["Label"];
		
		$data = array(
			'Label' => $newLabel
		);

		if($id==="0") { // new entry
			$this->db->insert('categories', $data);
		}
		else { // update
			$this->db->where('UID', $id);
			$this->db->update('categories', $data);
		}

		$_SESSION["DisplayMessage"] = "Record updated successfully.";

		redirect("Categories/view");
	}
}