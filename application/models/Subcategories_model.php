<?php
class Subcategories_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		if(empty($_SESSION["UserLoggedIn"])) {
			redirect(base_url()."index.php/Pages/view/home");
		}
	}

	public function getCategoryNameById($id) {
		if(!is_numeric($id)) {
			show_404();
		}
		$name = "Default";
		$sql = "SELECT Label FROM `categories` where UID = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$name = $row->Label;
			}
		}
		return $name;
	}

	public function getCategoryArray($id) {
		if(!is_numeric($id)) {
			show_404();
		}
		$arrCategory = array();
		$sql = "SELECT UID, Label FROM `categories` where UID=$id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"UID"	=>$row->UID,
								"Label"	=>$row->Label
							);
				array_push($arrCategory,$arrCurrent);
			}
		}
		return $arrCategory;
	}

	public function getSubcategoriesArray($parentID) {
		if(!is_numeric($parentID)) {
			show_404();
		}
		$arrCategories = array();
		$sql = "SELECT UID, Label FROM `categories` where ParentID=$parentID AND active='1'";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"UID"	=>$row->UID,
								"Label"	=>$row->Label
							);
				array_push($arrCategories,$arrCurrent);
			}
		}
		return $arrCategories;
	}

	public function getSubcategories($categoryId,$json=false) {
		$arrSubTypes = array();
		$sql = "SELECT * FROM `categories` where active='1' and ParentID=$categoryId";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$arrCurrent = array(
								"UID"	=>$row->UID,
								"Label"	=>$row->Label
							);
				array_push($arrSubTypes,$arrCurrent);
			}
		}
		if(!$json) {
			return $arrSubTypes;
		}
		else {
			echo json_encode($arrSubTypes);
		}
	}
}
?>