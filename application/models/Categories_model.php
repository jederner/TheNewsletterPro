<?php
class Categories_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		if(empty($_SESSION["UserLoggedIn"])) {
			redirect(base_url()."index.php/Pages/view/home");
		}
	}

	public function getCategoryNameById($id) {
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

	public function getCategoriesArray() {
		$arrCategories = array();
		$sql = "SELECT UID, Label FROM `categories` where ParentID IS NULL AND active='1'";
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