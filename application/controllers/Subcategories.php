<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subcategories extends CI_Controller {
	public function view($catID) {
		if ( ! file_exists(APPPATH.'/views/subcategories/home.php'))
		{
			show_404();
		}

		$this->load->model('Subcategories_model');

		$data['subcategory_title']	= $this->Subcategories_model->getCategoryNameById($catID);
		$data['parentID']			= $catID;
		$data['siteTitle']			= "The NewsletterPro";
		$data['title'] 				= "Subcategories - " . $data['subcategory_title'];
		$data['assets']				= asset_url();
		$data['subcategories'] 		= $this->Subcategories_model->getSubcategoriesArray($catID);

		$this->load->view('templates/header', $data);
		$this->load->view('subcategories/home', $data);
		$this->load->view('templates/footer', $data);
	}

	public function edit($id,$parentID=null) {
		if(!is_numeric($id)) {
			show_404();
		}

		$this->load->model('Subcategories_model');

		$data['parentID']		= $parentID;
		$data['arrSubcategory']	= $this->Subcategories_model->getCategoryArray($id);
		$data['subcategory']	= $this->Subcategories_model->getCategoryNameById($id);
		$data['siteTitle']		= "The NewsletterPro";
		$data['title']			= "Subcategories - Edit - " . $data['subcategory'];
		$data['assets']			= asset_url();

		$this->load->view('templates/header', $data);
		$this->load->view('subcategories/edit', $data);
		$this->load->view('templates/footer', $data);

	}

	public function add($parentID) {

		$this->load->model('Subcategories_model');

		$data['parentName']	= $this->Subcategories_model->getCategoryNameById($parentID);
		$data['parentID']	= $parentID;
		$data['siteTitle']	= "The NewsletterPro";
		$data['title']		= "Subcategories - Add to " . $data['parentName'];
		$data['assets']		= asset_url();

		$this->load->view('templates/header', $data);
		$this->load->view('subcategories/add', $data);
		$this->load->view('templates/footer', $data);

	}

	public function update($id,$parentID) {
		if(!is_numeric($id)) {
			show_404();
		}

		$newLabel = $_POST["Label"];
		
		$data = array(
			'Label' => $newLabel
		);

		if($id==="0") { // new entry, override data
			$data = array(
				'Label' 	=> $newLabel,
				'ParentID'	=> $parentID
			);
			$this->db->insert('categories', $data);
		}
		else { // update
			$this->db->where('UID', $id);
			$this->db->update('categories', $data);
		}

		$_SESSION["DisplayMessage"] = "Record updated successfully.";

		redirect("Subcategories/view/$parentID");
	}

}